<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Paypal_payments extends CI_Model
{

    function __construct()
    {
        parent::__construct();

        $this->config->load('payment_gateways');

        $config = array(
            'Sandbox' => $this->config->item('TestMode'),
            'APIUsername' => $this->config->item('APIUsername'),
            'APIPassword' => $this->config->item('APIPassword'),
            'APISignature' => $this->config->item('APISignature'),
            'APISubject' => '',
            'APIVersion' => $this->config->item('APIVersion')
        );

        // Show Errors
        if ($config['Sandbox']) {
            error_reporting(E_ALL);
            ini_set('display_errors', '1');
        }

        $this->load->library('Paypal_pro', $config);
    }

    function get_balance()
    {
        $GBFields = array('returnallcurrencies' => '1');
        $PayPalRequestData = array('GBFields' => $GBFields);
        $PayPalResult = $this->paypal_pro->GetBalance($PayPalRequestData);

        if (!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK'])) {
            $errors = array('error' => TRUE, 'message' => $PayPalResult['ERRORS']);
            return $errors;
            //$this->load->view('paypal_error', $errors);
        } else {
            $data = array('PayPalResult' => $PayPalResult);
            return array('amount' => $data['PayPalResult']['BALANCERESULTS'], 'time' => $this->sma->hrld($data['PayPalResult']['TIMESTAMP']));
            //$this->load->view('get_balance', $data);
        }
    }

    function Do_direct_payment($amount, $currency, $cc, $desc = '')
    {
        $DPFields = array(
            'paymentaction' => '', // How you want to obtain payment.  Authorization indidicates the payment is a basic auth subject to settlement with Auth & Capture.  Sale indicates that this is a final sale for which you are requesting payment.  Default is Sale.
            'ipaddress' => '', // Required.  IP address of the payer's browser.
            'returnfmfdetails' => ''      // Flag to determine whether you want the results returned by FMF.  1 or 0.  Default is 0.
        );

        $CCDetails = array(
            'creditcardtype' => $cc['type'], //'MasterCard', // Required. Type of credit card.  Visa, MasterCard, Discover, Amex, Maestro, Solo.  If Maestro or Solo, the currency code must be GBP.  In addition, either start date or issue number must be specified.
            'acct' => $cc['number'], //'5522340006063638', // Required.  Credit card number.  No spaces or punctuation.
            'expdate' => (($cc['exp_month'] < 10) ? '0' . (int)$cc['exp_month'] : $cc['exp_month']) . $cc['exp_year'], //'022016', // Required.  Credit card expiration date.  Format is MMYYYY
            'cvv2' => $cc['cvc'], // Requirements determined by your PayPal account settings.  Security digits for credit card.
            'startdate' => '', // Month and year that Maestro or Solo card was issued.  MMYYYY
            'issuenumber' => ''       // Issue number of Maestro or Solo card.  Two numeric digits max.
        );

        $PayerInfo = array(
            'email' => $desc,//'test@yahoo.com', // Email address of payer.
            'payerid' => '', // Unique PayPal customer ID for payer.
            'payerstatus' => '', // Status of payer.  Values are verified or unverified
            'business' => ''        // Payer's business name.
        );

        $PayerName = array(
            'salutation' => '', // Payer's salutation.  20 char max.
            'firstname' => '',//Tester', // Payer's first name.  25 char max.
            'middlename' => '', // Payer's middle name.  25 char max.
            'lastname' => '',//'Testerson', // Payer's last name.  25 char max.
            'suffix' => ''        // Payer's suffix.  12 char max.
        );
        $BillingAddress = array(
            'street' => '',//'707 W. Bay Drive', // Required.  First street address.
            'street2' => '', // Second street address.
            'city' => '',//'Largo', // Required.  Name of City.
            'state' => '',//'FL', // Required. Name of State or Province.
            'countrycode' => '',//'US', // Required.  Country code.
            'zip' => '',//'33770', // Required.  Postal code of payer.
            'phonenum' => ''       // Phone Number of payer.  20 char max.
        );


        $ShippingAddress = array(
            'shiptoname' => '', // Required if shipping is included.  Person's name associated with this address.  32 char max.
            'shiptostreet' => '', // Required if shipping is included.  First street address.  100 char max.
            'shiptostreet2' => '', // Second street address.  100 char max.
            'shiptocity' => '', // Required if shipping is included.  Name of city.  40 char max.
            'shiptostate' => '', // Required if shipping is included.  Name of state or province.  40 char max.
            'shiptozip' => '', // Required if shipping is included.  Postal code of shipping address.  20 char max.
            'shiptocountry' => '', // Required if shipping is included.  Country code of shipping address.  2 char max.
            'shiptophonenum' => ''     // Phone number for shipping address.  20 char max.
        );

        $PaymentDetails = array(
            'amt' => $amount, // Required.  Total amount of order, including shipping, handling, and tax.
            'currencycode' => $currency, // Required.  Three-letter currency code.  Default is USD.
            'itemamt' => '', // Required if you include itemized cart details. (L_AMTn, etc.)  Subtotal of items not including S&H, or tax.
            'shippingamt' => '', // Total shipping costs for the order.  If you specify shippingamt, you must also specify itemamt.
            'insuranceamt' => '', // Total shipping insurance costs for this order.
            'shipdiscamt' => '', // Shipping discount for the order, specified as a negative number.
            'handlingamt' => '', // Total handling costs for the order.  If you specify handlingamt, you must also specify itemamt.
            'taxamt' => '', // Required if you specify itemized cart tax details. Sum of tax for all items on the order.  Total sales tax.
            'desc' => '', // Description of the order the customer is purchasing.  127 char max.
            'custom' => '', // Free-form field for your own use.  256 char max.
            'invnum' => '', // Your own invoice or tracking number
            'buttonsource' => '', // An ID code for use by 3rd party apps to identify transactions.
            'notifyurl' => '', // URL for receiving Instant Payment Notifications.  This overrides what your profile is set to use.
            'recurring' => ''      // Flag to indicate a recurring transaction.  Value should be Y for recurring, or anything other than Y if it's not recurring.  To pass Y here, you must have an established billing agreement with the buyer.
        );

        // For order items you populate a nested array with multiple $Item arrays.
        // Normally you'll be looping through cart items to populate the $Item array
        // Then push it into the $OrderItems array at the end of each loop for an entire
        // collection of all items in $OrderItems.

        $OrderItems = array();

        /*$Item = array(
            'l_name' => 'Test Widget', // Item Name.  127 char max.
            'l_desc' => 'This is a test widget description.', // Item description.  127 char max.
            'l_amt' => '100.00', // Cost of individual item.
            'l_number' => 'ABC-123', // Item Number.  127 char max.
            'l_qty' => '1', // Item quantity.  Must be any positive integer.
            'l_taxamt' => '', // Item's sales tax amount.
            'l_ebayitemnumber' => '', // eBay auction number of item.
            'l_ebayitemauctiontxnid' => '', // eBay transaction ID of purchased item.
            'l_ebayitemorderid' => ''     // eBay order ID for the item.
        );
        array_push($OrderItems, $Item);

        $Item2 = array(
            'l_name' => 'Test Widget 2', // Item Name.  127 char max.
            'l_desc' => 'This is a test widget description.', // Item description.  127 char max.
            'l_amt' => '200.00', // Cost of individual item.
            'l_number' => 'ABC-XYZ', // Item Number.  127 char max.
            'l_qty' => '1', // Item quantity.  Must be any positive integer.
            'l_taxamt' => '', // Item's sales tax amount.
            'l_ebayitemnumber' => '', // eBay auction number of item.
            'l_ebayitemauctiontxnid' => '', // eBay transaction ID of purchased item.
            'l_ebayitemorderid' => ''     // eBay order ID for the item.
        );
        array_push($OrderItems, $Item2);*/

        $Secure3D = array(
            'authstatus3d' => '',
            'mpivendor3ds' => '',
            'cavv' => '',
            'eci3ds' => '',
            'xid' => ''
        );

        $PayPalRequestData = array(
            'DPFields' => $DPFields,
            'CCDetails' => $CCDetails,
            'PayerInfo' => $PayerInfo,
            'PayerName' => $PayerName,
            'BillingAddress' => $BillingAddress,
            'ShippingAddress' => $ShippingAddress,
            'PaymentDetails' => $PaymentDetails,
            'OrderItems' => $OrderItems,
            'Secure3D' => $Secure3D
        );

        $PayPalResult = $this->paypal_pro->DoDirectPayment($PayPalRequestData);

        if (!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK'])) {
            $errors = array('error' => TRUE, 'message' => $PayPalResult['ERRORS']);
            return $errors;
            //$this->load->view('paypal_error', $errors);
        } else {
            return $PayPalResult;
        }
    }

    function Refund_transaction()
    {
        $RTFields = array(
            'transactionid' => '', // Required.  PayPal transaction ID for the order you're refunding.
            'payerid' => '', // Encrypted PayPal customer account ID number.  Note:  Either transaction ID or payer ID must be specified.  127 char max
            'invoiceid' => '', // Your own invoice tracking number.
            'refundtype' => '', // Required.  Type of refund.  Must be Full, Partial, or Other.
            'amt' => '', // Refund Amt.  Required if refund type is Partial.
            'currencycode' => '', // Three-letter currency code.  Required for Partial Refunds.  Do not use for full refunds.
            'note' => '', // Custom memo about the refund.  255 char max.
            'retryuntil' => '', // Maximum time until you must retry the refund.  Note:  this field does not apply to point-of-sale transactions.
            'refundsource' => '', // Type of PayPal funding source (balance or eCheck) that can be used for auto refund.  Values are:  any, default, instant, eCheck
            'merchantstoredetail' => '', // Information about the merchant store.
            'refundadvice' => '', // Flag to indicate that the buyer was already given store credit for a given transaction.  Values are:  1/0
            'refunditemdetails' => '', // Details about the individual items to be returned.
            'msgsubid' => '', // A message ID used for idempotence to uniquely identify a message.
            'storeid' => '', // ID of a merchant store.  This field is required for point-of-sale transactions.  50 char max.
            'terminalid' => ''        // ID of the terminal.  50 char max.
        );

        $PayPalRequestData = array('RTFields' => $RTFields);

        $PayPalResult = $this->paypal_pro->RefundTransaction($PayPalRequestData);

        if (!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK'])) {
            $errors = array('Errors' => $PayPalResult['ERRORS']);
            $this->load->view('paypal_error', $errors);
        } else {
            // Successful call.  Load view or whatever you need to do here.
        }
    }

    function Get_transaction_details($transactionid)
    {
        $GTDFields = array(
            'transactionid' => $transactionid  // PayPal transaction ID of the order you want to get details for.
        );

        $PayPalRequestData = array('GTDFields' => $GTDFields);

        $PayPalResult = $this->paypal_pro->GetTransactionDetails($PayPalRequestData);

        if (!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK'])) {
            $errors = array('Errors' => $PayPalResult['ERRORS']);
            $this->load->view('paypal_error', $errors);
        } else {
            echo '<pre />';
            print_r($PayPalResult);
        }
    }

    function Transaction_search()
    {
        $TSFields = array(
            'startdate' => '', // Required.  The earliest transaction date you want returned.  Must be in UTC/GMT format.  2008-08-30T05:00:00.00Z
            'enddate' => '', // The latest transaction date you want to be included.
            'email' => '', // Search by the buyer's email address.
            'receiver' => '', // Search by the receiver's email address.
            'receiptid' => '', // Search by the PayPal account optional receipt ID.
            'transactionid' => '', // Search by the PayPal transaction ID.
            'invnum' => '', // Search by your custom invoice or tracking number.
            'acct' => '', // Search by a credit card number, as set by you in your original transaction.
            'auctionitemnumber' => '', // Search by auction item number.
            'transactionclass' => '', // Search by classification of transaction.  Possible values are: All, Sent, Received, MassPay, MoneyRequest, FundsAdded, FundsWithdrawn, Referral, Fee, Subscription, Dividend, Billpay, Refund, CurrencyConversions, BalanceTransfer, Reversal, Shipping, BalanceAffecting, ECheck
            'amt' => '', // Search by transaction amount.
            'currencycode' => '', // Search by currency code.
            'status' => '', // Search by transaction status.  Possible values: Pending, Processing, Success, Denied, Reversed
            'profileid' => ''       // Recurring Payments profile ID.  Currently undocumented but has tested to work.
        );

        $PayerName = array(
            'salutation' => '', // Search by payer's salutation.
            'firstname' => '', // Search by payer's first name.
            'middlename' => '', // Search by payer's middle name.
            'lastname' => '', // Search by payer's last name.
            'suffix' => ''         // Search by payer's suffix.
        );

        $PayPalRequestData = array(
            'TSFields' => $TSFields,
            'PayerName' => $PayerName
        );

        $PayPalResult = $this->paypal_pro->TransactionSearch($PayPalRequestData);

        if (!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK'])) {
            $errors = array('Errors' => $PayPalResult['ERRORS']);
            $this->load->view('paypal_error', $errors);
        } else {
            // Successful call.  Load view or whatever you need to do here.
        }
    }

}
