<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!doctype html>
<html>
<head>
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?= $page_title . " " . lang("no") . " " . $inv->id; ?></title>
    <style>
        * { font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif; font-size: 16px; line-height: 1.6em; margin: 0; padding: 0; } img { max-width: 100%; } body { -webkit-font-smoothing: antialiased; height: 100%; -webkit-text-size-adjust: none; width: 100% !important; } a { color: #348eda; } .btn-primary { Margin-bottom: 10px; width: auto !important; } .btn-primary td { background-color: #62cb31; border-radius: 3px; font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; font-size: 14px; text-align: center; vertical-align: top; } .btn-primary td a { background-color: #62cb31; border: solid 1px #62cb31; border-radius: 3px; border-width: 4px 20px; display: inline-block; color: #ffffff; cursor: pointer; font-weight: bold; line-height: 2; text-decoration: none; } .last { margin-bottom: 0; } .first { margin-top: 0; } .padding { padding: 10px 0; } table.body-wrap { padding: 20px; width: 100%; } table.body-wrap .container { border: 1px solid #e4e5e7; } table.footer-wrap { clear: both !important; width: 100%; } .footer-wrap .container p { color: #666666; font-size: 12px; } table.footer-wrap a { color: #999999; } h1, h2, h3 { color: #111111; font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; font-weight: 200; line-height: 1.2em; margin: 10px 0 10px; } h1 { font-size: 36px; } h2 { font-size: 28px; } h3 { font-size: 22px; } p, ul, ol {font-weight: normal;margin-bottom: 10px;} ul li, ol li {margin-left: 5px;list-style-position: inside;} .container { clear: both !important; display: block !important; Margin: 0 auto !important; max-width: 600px !important; } .body-wrap .container { padding: 20px; } .content { display: block; margin: 0 auto; max-width: 600px; } .content table { width: 100%; }
    </style>
</head>

<body bgcolor="#f7f9fa">
<table class="body-wrap" bgcolor="#f7f9fa">
    <tr>
        <td></td>
        <td class="container" bgcolor="#FFFFFF">
            <div class="content">
                <table>
                    <tr>
                        <td style="text-align:center;">
                        <h2>
                        <img src="<?= base_url('assets/uploads/logos/' . $biller->logo); ?>" alt="<?= $biller->company != '-' ? $biller->company : $biller->name; ?>">
                         </h2>
                         </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="clear:both;height:15px;"></div>
                            <!-- <strong><?= lang('receipt').' '.lang('from').' '.$Settings->site_name; ?></strong> -->
                            <div style="text-align:center;">
                                <img src="<?= admin_url('misc/barcode/'.$this->sma->base64url_encode($inv->reference_no).'/code128/74/0/1'); ?>" alt="<?= $inv->reference_no; ?>" class="bcimg" />
                                <?= $this->sma->qrcode('link', urlencode(admin_url('pos/view/' . $inv->id)), 2); ?>
                            </div>
                            <div style="clear:both;height:15px;"></div>
                                <div id="receiptData" style="border:1px solid #DDD; padding:10px; text-align:center;">

                                        <div class="text-center">
                                            <h3 style="text-transform:uppercase;"><?=$biller->company != '-' ? $biller->company : $biller->name;?></h3>
                                            <?php
                                            echo "<p>" . $biller->address . " " . $biller->city . " " . $biller->postal_code . " " . $biller->state . " " . $biller->country .
                                            "<br>" . lang("tel") . ": " . $biller->phone;

                                            // comment or remove these extra info if you don't need
                                            if (!empty($biller->cf1) && $biller->cf1 != "-") {
                                                echo "<br>" . lang("bcf1") . ": " . $biller->cf1;
                                            }
                                            if (!empty($biller->cf2) && $biller->cf2 != "-") {
                                                echo "<br>" . lang("bcf2") . ": " . $biller->cf2;
                                            }
                                            if (!empty($biller->cf3) && $biller->cf3 != "-") {
                                                echo "<br>" . lang("bcf3") . ": " . $biller->cf3;
                                            }
                                            if (!empty($biller->cf4) && $biller->cf4 != "-") {
                                                echo "<br>" . lang("bcf4") . ": " . $biller->cf4;
                                            }
                                            if (!empty($biller->cf5) && $biller->cf5 != "-") {
                                                echo "<br>" . lang("bcf5") . ": " . $biller->cf5;
                                            }
                                            if (!empty($biller->cf6) && $biller->cf6 != "-") {
                                                echo "<br>" . lang("bcf6") . ": " . $biller->cf6;
                                            }
                                            // end of the customer fields

                                            echo "<br>";
                                            if ($pos_settings->cf_title1 != "" && $pos_settings->cf_value1 != "") {
                                                echo $pos_settings->cf_title1 . ": " . $pos_settings->cf_value1 . "<br>";
                                            }
                                            if ($pos_settings->cf_title2 != "" && $pos_settings->cf_value2 != "") {
                                                echo $pos_settings->cf_title2 . ": " . $pos_settings->cf_value2 . "<br>";
                                            }
                                            echo '</p>';
                                            ?>
                                        </div>
                                        <?php
                                        if ($Settings->invoice_view == 1 || $Settings->indian_gst) {
                                            ?>
                                            <div class="col-sm-12 text-center" style="padding-top:10px;padding-bottom:10px;">
                                                <h4 style="font-weight:bold;"><?=lang('tax_invoice');?></h4>
                                            </div>
                                            <?php
                                        }
                                        echo '<div style="text-align:left;padding-bottom:10px;">';
                                        echo "<p>" .lang("date") . ": " . $this->sma->hrld($inv->date) . "<br>";
                                        echo lang("sale_no_ref") . ": " . $inv->reference_no . "<br>";
                                        if (!empty($inv->return_sale_ref)) {
                                            echo '<p>'.lang("return_ref").': '.$inv->return_sale_ref;
                                            if ($inv->return_id) {
                                                echo ' <a data-target="#myModal2" data-toggle="modal" href="'.admin_url('sales/modal_view/'.$inv->return_id).'"><i class="fa fa-external-link no-print"></i></a><br>';
                                            } else {
                                                echo '</p>';
                                            }
                                        }
                                        echo lang("sales_person") . ": " . $created_by->first_name." ".$created_by->last_name . "</p>";
                                        echo "<p>";
                                        echo lang("customer") . ": " . ($customer->company && $customer->company != '-' ? $customer->company : $customer->name) . "<br>";
                                        echo '</div>';
                                        if ($pos_settings->customer_details) {
                                            if ($customer->vat_no != "-" && $customer->vat_no != "") {
                                                echo "<br>" . lang("vat_no") . ": " . $customer->vat_no;
                                            }
                                            echo lang("tel") . ": " . $customer->phone . "<br>";
                                            echo lang("address") . ": " . $customer->address . "<br>";
                                            echo $customer->city ." ".$customer->state." ".$customer->country ."<br>";
                                            if (!empty($customer->cf1) && $customer->cf1 != "-") {
                                                echo "<br>" . lang("ccf1") . ": " . $customer->cf1;
                                            }
                                            if (!empty($customer->cf2) && $customer->cf2 != "-") {
                                                echo "<br>" . lang("ccf2") . ": " . $customer->cf2;
                                            }
                                            if (!empty($customer->cf3) && $customer->cf3 != "-") {
                                                echo "<br>" . lang("ccf3") . ": " . $customer->cf3;
                                            }
                                            if (!empty($customer->cf4) && $customer->cf4 != "-") {
                                                echo "<br>" . lang("ccf4") . ": " . $customer->cf4;
                                            }
                                            if (!empty($customer->cf5) && $customer->cf5 != "-") {
                                                echo "<br>" . lang("ccf5") . ": " . $customer->cf5;
                                            }
                                            if (!empty($customer->cf6) && $customer->cf6 != "-") {
                                                echo "<br>" . lang("ccf6") . ": " . $customer->cf6;
                                            }
                                        }
                                        echo "</p>";
                                        ?>

                                        <div style="clear:both;"></div>
                                        <table width="100%" style="margin:15px 0;">
                                            <tbody>
                                                <?php
                                                $r = 1; $category = 0;
                                                $tax_summary = array();
                                                foreach ($rows as $row) {
                                                    if ($pos_settings->item_order == 1 && $category != $row->category_id) {
                                                        $category = $row->category_id;
                                                        echo '<tr><td colspan="100%" style="text-align:left;border:0;"><strong>'.$row->category_name.'</strong></td></tr>';
                                                    }
                                                    echo '<tr><td colspan="2" style="text-align:left;border:0;">#' . $r . ': &nbsp;&nbsp;' . $row->product_name. ($row->variant ? ' (' . $row->variant . ')' : '') . '<span class="pull-right">' . ($row->tax_code ? '*'.$row->tax_code : '') . '</span></td></tr>';
                                                    if (!empty($row->second_name)) {
                                                        echo '<tr><td colspan="2" style="text-align:left;border:0;">'.$row->second_name.'</td></tr>';
                                                    }
                                                    echo '<tr><td style="text-align:left;border-bottom:1px solid #DDD;">' . $this->sma->formatQuantity($row->unit_quantity) . ' x '.$this->sma->formatMoney($row->unit_price).($row->item_tax != 0 ? ' - '.lang('tax').' <small>('.($Settings->indian_gst ? $row->tax : $row->tax_code).')</small> '.$this->sma->formatMoney($row->item_tax).' ('.lang('hsn_code').': '.$row->hsn_code.')' : '').'</td><td style="text-align:right;border-bottom:1px solid #DDD;">' . $this->sma->formatMoney($row->subtotal) . '</td></tr>';

                                                    $r++;
                                                }
                                                if ($return_rows) {
                                                    echo '<tr class="warning"><td colspan="100%" style="text-align:left;border:0;padding-top:10px;"><strong>'.lang('returned_items').'</strong></td></tr>';
                                                    foreach ($return_rows as $row) {
                                                        if ($pos_settings->item_order == 1 && $category != $row->category_id) {
                                                            $category = $row->category_id;
                                                            echo '<tr><td colspan="100%" style="text-align:left;border:0;"><strong>'.$row->category_name.'</strong></td></tr>';
                                                        }
                                                        echo '<tr><td colspan="2" style="text-align:left;border:0;">#' . $r . ': &nbsp;&nbsp;' . $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : '') . '<span class="pull-right">' . ($row->tax_code ? '*'.$row->tax_code : '') . '</span></td></tr>';
                                                        echo '<tr><td style="text-align:left;border-bottom:1px solid #DDD;">' . $this->sma->formatQuantity($row->unit_quantity) . ' x '.$this->sma->formatMoney($row->unit_price).($row->item_tax != 0 ? ' - '.lang('tax').' <small>('.($Settings->indian_gst ? $row->tax : $row->tax_code).')</small> '.$this->sma->formatMoney($row->item_tax).' ('.lang('hsn_code').': '.$row->hsn_code.')' : '').'</td><td style="text-align:right;border-bottom:1px solid #DDD;">' . $this->sma->formatMoney($row->subtotal) . '</td></tr>';

                                                        // echo '<tr><td class="no-border border-bottom">' . $this->sma->formatQuantity($row->quantity) . ' x ';
                                                        // if ($row->item_discount != 0) {
                                                        //     echo '<del>' . $this->sma->formatMoney($row->net_unit_price + ($row->item_discount / $row->quantity) + ($row->item_tax / $row->quantity)) . '</del> ';
                                                        // }
                                                        // echo $this->sma->formatMoney($row->net_unit_price + ($row->item_tax / $row->quantity)) . '</td><td class="no-border border-bottom text-right">' . $this->sma->formatMoney($row->subtotal) . '</td></tr>';
                                                        $r++;
                                                    }
                                                }

                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th style="text-align:left;border-bottom:1px solid #DDD;"><?=lang("total");?></th>
                                                    <th style="text-align:right;border-bottom:1px solid #DDD;"><?=$this->sma->formatMoney($return_sale ? (($inv->total + $inv->product_tax)+($return_sale->total + $return_sale->product_tax)) : ($inv->total + $inv->product_tax));?></th>
                                                </tr>
                                                <?php
                                                if ($inv->order_tax != 0) {
                                                    echo '<tr><th style="text-align:left;border-bottom:1px solid #DDD;">' . lang("tax") . '</th><th style="text-align:right;border-bottom:1px solid #DDD;">' . $this->sma->formatMoney($return_sale ? ($inv->order_tax+$return_sale->order_tax) : $inv->order_tax) . '</th></tr>';
                                                }
                                                if ($inv->order_discount != 0) {
                                                    echo '<tr><th style="text-align:left;border-bottom:1px solid #DDD;">' . lang("order_discount") . '</th><th style="text-align:right;border-bottom:1px solid #DDD;">' . $this->sma->formatMoney($inv->order_discount) . '</th></tr>';
                                                }

                                                if ($inv->shipping != 0) {
                                                    echo '<tr><th style="text-align:left;border-bottom:1px solid #DDD;">' . lang("shipping") . '</th><th style="text-align:right;border-bottom:1px solid #DDD;">' . $this->sma->formatMoney($inv->shipping) . '</th></tr>';
                                                }

                                                if ($return_sale) {
                                                    if ($return_sale->surcharge != 0) {
                                                        echo '<tr><th style="text-align:left;border-bottom:1px solid #DDD;">' . lang("order_discount") . '</th><th style="text-align:right;border-bottom:1px solid #DDD;">' . $this->sma->formatMoney($return_sale->surcharge) . '</th></tr>';
                                                    }
                                                }

                                                if ($Settings->indian_gst) {
                                                    if ($inv->cgst > 0) {
                                                        $cgst = $return_sale ? $inv->cgst + $return_sale->cgst : $inv->cgst;
                                                        echo '<tr><td>' . lang('cgst') .'</td><td style="text-align:right;border-bottom:1px solid #DDD;">' . ( $Settings->format_gst ? $this->sma->formatMoney($cgst) : $cgst) . '</td></tr>';
                                                    }
                                                    if ($inv->sgst > 0) {
                                                        $sgst = $return_sale ? $inv->sgst + $return_sale->sgst : $inv->sgst;
                                                        echo '<tr><td>' . lang('sgst') .'</td><td style="text-align:right;border-bottom:1px solid #DDD;">' . ( $Settings->format_gst ? $this->sma->formatMoney($sgst) : $sgst) . '</td></tr>';
                                                    }
                                                    if ($inv->igst > 0) {
                                                        $igst = $return_sale ? $inv->igst + $return_sale->igst : $inv->igst;
                                                        echo '<tr><td>' . lang('igst') .'</td><td style="text-align:right;border-bottom:1px solid #DDD;">' . ( $Settings->format_gst ? $this->sma->formatMoney($igst) : $igst) . '</td></tr>';
                                                    }
                                                }

                                                if ($pos_settings->rounding || $inv->rounding != 0) {
                                                    ?>
                                                    <tr>
                                                        <th style="text-align:left;border-bottom:1px solid #DDD;"><?=lang("rounding");?></th>
                                                        <th style="text-align:right;border-bottom:1px solid #DDD;"><?= $this->sma->formatMoney($inv->rounding);?></th>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align:left;border-bottom:1px solid #DDD;"><?=lang("grand_total");?></th>
                                                        <th style="text-align:right;border-bottom:1px solid #DDD;"><?=$this->sma->formatMoney($return_sale ? (($inv->grand_total + $inv->rounding)+$return_sale->grand_total) : ($inv->grand_total + $inv->rounding));?></th>
                                                    </tr>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <tr>
                                                        <th style="text-align:left;border-bottom:1px solid #DDD;"><?=lang("grand_total");?></th>
                                                        <th style="text-align:right;border-bottom:1px solid #DDD;"><?=$this->sma->formatMoney($return_sale ? ($inv->grand_total+$return_sale->grand_total) : $inv->grand_total);?></th>
                                                    </tr>
                                                    <?php
                                                }
                                                if ($inv->paid < ($inv->grand_total + $inv->rounding)) {
                                                    ?>
                                                    <tr>
                                                        <th style="text-align:left;border-bottom:1px solid #DDD;"><?=lang("paid_amount");?></th>
                                                        <th style="text-align:right;border-bottom:1px solid #DDD;"><?=$this->sma->formatMoney($return_sale ? ($inv->paid+$return_sale->paid) : $inv->paid);?></th>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align:left;border-bottom:1px solid #DDD;"><?=lang("due_amount");?></th>
                                                        <th style="text-align:right;border-bottom:1px solid #DDD;"><?=$this->sma->formatMoney(($return_sale ? (($inv->grand_total + $inv->rounding)+$return_sale->grand_total) : ($inv->grand_total + $inv->rounding)) - ($return_sale ? ($inv->paid+$return_sale->paid) : $inv->paid));?></th>
                                                    </tr>
                                                    <?php
                                                } ?>
                                            </tfoot>
                                        </table>
                                        <?php
                                        if ($payments) {
                                            echo '<table class="table table-striped table-condensed"><tbody>';
                                            foreach ($payments as $payment) {
                                                echo '<tr>';
                                                if (($payment->paid_by == 'cash' || $payment->paid_by == 'deposit') && $payment->pos_paid) {
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("change") . ': ' . ($payment->pos_balance > 0 ? $this->sma->formatMoney($payment->pos_balance) : 0) . '</td>';
                                                } elseif (($payment->paid_by == 'CC' || $payment->paid_by == 'ppp' || $payment->paid_by == 'stripe') && $payment->cc_no) {
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("no") . ': ' . 'xxxx xxxx xxxx ' . substr($payment->cc_no, -4) . '</td>';
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("name") . ': ' . $payment->cc_holder . '</td>';
                                                } elseif ($payment->paid_by == 'Cheque' && $payment->cheque_no) {
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("cheque_no") . ': ' . $payment->cheque_no . '</td>';
                                                } elseif ($payment->paid_by == 'gift_card' && $payment->pos_paid) {
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("no") . ': ' . $payment->cc_no . '</td>';
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("balance") . ': ' . ($payment->pos_balance > 0 ? $this->sma->formatMoney($payment->pos_balance) : 0) . '</td>';
                                                } elseif ($payment->paid_by == 'other' && $payment->amount) {
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                                    echo $payment->note ? '</tr><td colspan="2">' . lang("payment_note") . ': ' . $payment->note . '</td>' : '';
                                                }
                                                echo '</tr>';
                                            }
                                            echo '</tbody></table>';
                                        }

                                        if ($return_payments) {
                                            echo '<div style="text-align:left;padding-top:10px;"><strong>'.lang('return_payments').'</strong></div><table class="table table-striped table-condensed"><tbody>';
                                            foreach ($return_payments as $payment) {
                                                $payment->amount = (0-$payment->amount);
                                                echo '<tr>';
                                                if (($payment->paid_by == 'cash' || $payment->paid_by == 'deposit') && $payment->pos_paid) {
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("change") . ': ' . ($payment->pos_balance > 0 ? $this->sma->formatMoney($payment->pos_balance) : 0) . '</td>';
                                                } elseif (($payment->paid_by == 'CC' || $payment->paid_by == 'ppp' || $payment->paid_by == 'stripe') && $payment->cc_no) {
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("no") . ': ' . 'xxxx xxxx xxxx ' . substr($payment->cc_no, -4) . '</td>';
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("name") . ': ' . $payment->cc_holder . '</td>';
                                                } elseif ($payment->paid_by == 'Cheque' && $payment->cheque_no) {
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("cheque_no") . ': ' . $payment->cheque_no . '</td>';
                                                } elseif ($payment->paid_by == 'gift_card' && $payment->pos_paid) {
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("no") . ': ' . $payment->cc_no . '</td>';
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("balance") . ': ' . ($payment->pos_balance > 0 ? $this->sma->formatMoney($payment->pos_balance) : 0) . '</td>';
                                                } elseif ($payment->paid_by == 'other' && $payment->amount) {
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                                                    echo '<td style="text-align:left;border-bottom:1px solid #DDD;">' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                                    echo $payment->note ? '</tr><td colspan="2">' . lang("payment_note") . ': ' . $payment->note . '</td>' : '';
                                                }
                                                echo '</tr>';
                                            }
                                            echo '</tbody></table>';
                                        }
                                        ?>

                                        <div style="padding-top:10px;">
                                            <?= $Settings->invoice_view > 0 ? $this->gst->summary($rows, $return_rows, ($return_sale ? $inv->product_tax+$return_sale->product_tax : $inv->product_tax)) : ''; ?>
                                        </div>

                                        <div style="padding-top:10px;">
                                        <?= $customer->award_points != 0 && $Settings->each_spent > 0 ? '<p class="text-center">'.lang('this_sale').': '.floor(($inv->grand_total/$Settings->each_spent)*$Settings->ca_point)
                                        .'<br>'.
                                        lang('total').' '.lang('award_points').': '. $customer->award_points . '</p>' : ''; ?>
                                        <?= $inv->note ? '<p class="text-center">' . $this->sma->decode_html($inv->note) . '</p>' : ''; ?>
                                        <?= $biller->invoice_footer ? '<p class="text-center">'.$this->sma->decode_html($biller->invoice_footer).'</p>' : ''; ?>
                                        </div>
                                    </div>

                                    <div style="clear:both;"></div>
                                </div>

                            </div>
                            <div style="clear:both;height:25px;"></div>
                            <strong><?= $Settings->site_name; ?></strong>
                            <!-- <p><?= base_url(); ?></p> -->
                            <div style="clear:both;height:15px;"></div>
                            <p style="border-top:1px solid #CCC;margin-bottom:0;">This email is sent to <?= $customer->company; ?> (<?= $customer->email; ?>).</p>
                        </td>
                    </tr>
                </table>
            </div>

        </td>
        <td></td>
    </tr>
</table>

</body>
</html>
