<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        show_404();
    }

    function paypalipn()
    {

        $this->load->admin_model('sales_model');
        $paypal = $this->sales_model->getPaypalSettings();
        $this->sma->log_payment('Paypal IPN called');

        $req = 'cmd=_notify-validate';
        foreach ($_POST as $key => $value) {
            $value = urlencode(stripslashes($value));
            $req .= "&$key=$value";
        }

        $header = "POST /cgi-bin/webscr HTTP/1.1\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Host: www.paypal.com\r\n";  // www.sandbox.paypal.com for a test site
        $header .= "Content-Length: " . strlen($req) . "\r\n";
        $header .= "Connection: close\r\n\r\n";

        //$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
        $fp = fsockopen('ssl://www.paypal.com', 443, $errno, $errstr, 30);

        if (!$fp) {

            $this->sma->log_payment('Paypal Payment Failed (IPN HTTP ERROR)', $errstr);
            $this->session->set_flashdata('error', lang('payment_failed'));

        } else {
            fputs($fp, $header . $req);
            while (!feof($fp)) {
                $res = fgets($fp, 1024);
                //log_message('error', 'Paypal IPN - fp handler -'.$res);
                if (stripos($res, "VERIFIED") !== false) {
                    $this->sma->log_payment('Paypal IPN - VERIFIED');

                    $custom = explode('__', $_POST['custom']);
                    $payer_email = $_POST['payer_email'];

                    if (($_POST['payment_status'] == 'Completed' || $_POST['payment_status'] == 'Processed' || $_POST['payment_status'] == 'Pending') &&
                        ($_POST['receiver_email'] == $paypal->account_email) &&
                        ($_POST['mc_gross'] == ($custom[1] + $custom[2]))
                    ) {

                        $invoice_no = $_POST['item_number'];
                        $reference = $_POST['item_name'];
                        if ($_POST['mc_currency'] == $this->Settings->default_currency) {
                            $amount = $_POST['mc_gross'];
                        } else {
                            $currency = $this->site->getCurrencyByCode($_POST['mc_currency']);
                            $amount = $_POST['mc_gross'] * (1 / $currency->rate);
                        }
                        if ($inv = $this->sales_model->getInvoiceByID($invoice_no)) {
                            $payment = array(
                                'date' => date('Y-m-d H:i:s'),
                                'sale_id' => $invoice_no,
                                'reference_no' => $this->site->getReference('pay'),
                                'amount' => $amount,
                                'paid_by' => 'paypal',
                                'transaction_id' => $_POST['txn_id'],
                                'type' => 'received',
                                'note' => $_POST['mc_currency'] . ' ' . $_POST['mc_gross'] . ' had been paid for the Sale Reference No ' . $reference
                            );
                            if ($this->sales_model->addPayment($payment)) {
                                $customer = $this->site->getCompanyByID($inv->customer_id);
                                $this->site->updateReference('pay');

                                $this->load->library('parser');
                                $parse_data = array(
                                    'reference_number' => $reference,
                                    'contact_person' => $customer->name,
                                    'company' => $customer->company,
                                    'site_link' => base_url(),
                                    'site_name' => $this->Settings->site_name,
                                    'logo' => '<img src="' . base_url() . 'assets/uploads/logos/' . $this->Settings->logo . '" alt="' . $this->Settings->site_name . '"/>'
                                );
                                $temp_path = is_dir('./themes/' . $this->Settings->theme . '/admin/views/email_templates/');
                                $theme = $temp_path ? $this->theme : 'default';
                                $msg = file_get_contents('./themes/' . $theme . '/admin/views/email_templates/payment.html');
                                $message = $this->parser->parse_string($msg, $parse_data);
                                $this->sma->log_payment('Payment has been made for Sale Reference #' . $_POST['item_name'] . ' via Paypal (' . $_POST['txn_id'] . ').', print_r($_POST, ture));
                                try {
                                    $this->sma->send_email($paypal->account_email, 'Payment has been made via Paypal', $message);
                                } catch (Exception $e) {
                                    $this->sma->log_payment('Email Notification Failed: ' . $e->getMessage());
                                }
                                $this->session->set_flashdata('message', lang('payment_added'));
                            }
                        }
                    } else {

                        $this->sma->log_payment('Payment failed for Sale Reference #' . $reference . ' via Paypal (' . $_POST['txn_id'] . ').', print_r($_POST, ture));
                        $this->session->set_flashdata('error', lang('payment_failed'));

                    }
                } else if (stripos($res, "INVALID") !== false) {
                    $this->sma->log_payment('INVALID response from Paypal. Payment failed via Paypal.', print_r($_POST, ture));
                    $this->session->set_flashdata('error', lang('payment_failed'));
                }
            }
            fclose($fp);
        }
        redirect('/');
        exit();

    }

    function skrillipn()
    {
        $this->load->admin_model('sales_model');
        $skrill = $this->sales_model->getSkrillSettings();
        $this->sma->log_payment('Skrill IPN called');

        $concatFields = $_POST['merchant_id'] . $_POST['transaction_id'] . strtoupper(md5($skrill->secret_word)) . $_POST['mb_amount'] . $_POST['mb_currency'] . $_POST['status'];

        if (strtoupper(md5($concatFields)) == $_POST['md5sig'] && $_POST['status'] == 2 && $_POST['pay_to_email'] == $skrill->account_email) {
            $invoice_no = $_POST['item_number'];
            $reference = $_POST['item_name'];
            if ($_POST['mb_currency'] == $this->Settings->default_currency) {
                $amount = $_POST['mb_amount'];
            } else {
                $currency = $this->site->getCurrencyByCode($_POST['mb_currency']);
                $amount = $_POST['mb_amount'] * (1 / $currency->rate);
            }
            if ($inv = $this->sales_model->getInvoiceByID($invoice_no)) {
                $payment = array(
                    'date' => date('Y-m-d H:i:s'),
                    'sale_id' => $invoice_no,
                    'reference_no' => $this->site->getReference('pay'),
                    'amount' => $amount,
                    'paid_by' => 'skrill',
                    'transaction_id' => $_POST['mb_transaction_id'],
                    'type' => 'received',
                    'note' => $_POST['mb_currency'] . ' ' . $_POST['mb_amount'] . ' had been paid for the Sale Reference No ' . $reference
                );
                if ($this->sales_model->addPayment($payment)) {
                    $customer = $this->site->getCompanyByID($inv->customer_id);
                    $this->site->updateReference('pay');

                    $this->load->library('parser');
                    $parse_data = array(
                        'reference_number' => $reference,
                        'contact_person' => $customer->name,
                        'company' => $customer->company,
                        'site_link' => base_url(),
                        'site_name' => $this->Settings->site_name,
                        'logo' => '<img src="' . base_url() . 'assets/uploads/logos/' . $this->Settings->logo . '" alt="' . $this->Settings->site_name . '"/>'
                    );
                    $temp_path = is_dir('./themes/' . $this->Settings->theme . '/admin/views/email_templates/');
                    $theme = $temp_path ? $this->theme : 'default';
                    $msg = file_get_contents('./themes/' . $theme . '/admin/views/email_templates/payment.html');
                    $message = $this->parser->parse_string($msg, $parse_data);
                    $this->sma->log_payment('Payment has been made for Sale Reference #' . $_POST['item_name'] . ' via Skrill (' . $_POST['mb_transaction_id'] . ').', print_r($_POST, ture));
                    try {
                        $this->sma->send_email($skrill->account_email, 'Payment has been made via Skrill', $message);
                    } catch (Exception $e) {
                        $this->sma->log_payment('Email Notification Failed: ' . $e->getMessage());
                    }
                    $this->session->set_flashdata('message', lang('payment_added'));
                }
            }
        } else {
            $this->sma->log_payment('Payment failed for via Skrill.', print_r($_POST, ture));
            $this->session->set_flashdata('error', lang('payment_failed'));
        }
        redirect('/');
        exit();

    }

}
