<?php
$char_per_line = ($printer ? $printer->char_per_line : 42);

if ($pos_settings->remote_printing != 1) {
    if ($Settings->invoice_view > 0) {
        $tax_summary = $this->gst->taxSummary($rows);
        $re_tax_summary = $this->gst->taxSummary($return_rows);
        $tax_summary = $tax_summary + $re_tax_summary;
    }
    ?>
    <script type="text/javascript">

        function receiptData() {

            receipt = {};
            receipt.store_name = "<?= printText(($biller->company && $biller->company != '-' ? $biller->company : $biller->name), $char_per_line);?>\n";

            receipt.header = "";
            receipt.header += "<?= printText(($biller->company && $biller->company != '-' ? $biller->company : $biller->name ), $char_per_line);?>\n";
            <?php
            if ($biller->address) { ?>
                receipt.header += "<?= printText($biller->address, $char_per_line);?>\n";
                <?php
            }
            if ($biller->city) { ?>
                receipt.header += "<?= printText($biller->city . " " . ($biller->country ? $biller->country : ''), $char_per_line);?>\n";
                <?php
            } ?>
            receipt.header += "<?= printText(lang('tel').': '.$biller->phone, $char_per_line);?>";
            <?php
            // comment or remove these extra info if you don't need
            if (!empty($biller->cf1) && $biller->cf1 != "-") {
                echo 'receipt.header += "\n" + "' . lang("bcf1") . ': ' . $biller->cf1 .'";';
            }
            if (!empty($biller->cf2) && $biller->cf2 != "-") {
                echo 'receipt.header += "\n" + "' . lang("bcf2") . ': ' . $biller->cf2 .'";';
            }
            if (!empty($biller->cf3) && $biller->cf3 != "-") {
                echo 'receipt.header += "\n" + "' . lang("bcf3") . ': ' . $biller->cf3 .'";';
            }
            if (!empty($biller->cf4) && $biller->cf4 != "-") {
                echo 'receipt.header += "\n" + "' . lang("bcf4") . ': ' . $biller->cf4 .'";';
            }
            if (!empty($biller->cf5) && $biller->cf5 != "-") {
                echo 'receipt.header += "\n" + "' . lang("bcf5") . ': ' . $biller->cf5 .'";';
            }
            if (!empty($biller->cf6) && $biller->cf6 != "-") {
                echo 'receipt.header += "\n" + "' . lang("bcf6") . ': ' . $biller->cf6 .'";';
            }
            // end of the customer fields

            echo 'receipt.header += "\n\n";';
            if ($pos_settings->cf_title1 && $pos_settings->cf_value1) { ?>
                receipt.header += "<?= printText(($pos_settings->cf_title1 . ": " . $pos_settings->cf_value1), $char_per_line);?>\n";
                <?php
            }
            if ($pos_settings->cf_title2 && $pos_settings->cf_value2) { ?>
                receipt.header += "<?= printText(($pos_settings->cf_title2 . ": " . $pos_settings->cf_value2), $char_per_line);?>\n";
                <?php
            } ?>
            receipt.header += "\n";

            receipt.info = "";
            receipt.info += "<?= lang("date") . ": " . $this->sma->hrld($inv->date); ?>" + "\n";
            receipt.info += "<?= lang("sale_no_ref") . ": " . $inv->id; ?>" + "\n";
            receipt.info += "<?= lang("sales_person") . ": " . $created_by->first_name." ".$created_by->last_name; ?>" + "\n\n";
            receipt.info += "<?= lang("customer") . ": " . ($customer->company && $customer->company != '-' ? $customer->company : $customer->name); ?>" + "\n";
            <?php
            if ($pos_settings->customer_details) {
                if ($customer->vat_no != "-" && $customer->vat_no != "") {
                    echo 'receipt.info += "' . lang("vat_no") . ': ' . $customer->vat_no .'" + "\n";';
                }
                echo 'receipt.info += "' . lang("tel") . ': ' . $customer->phone .'" + "\n";';
                echo 'receipt.info += "' . lang("address") . ': ' . $customer->address .'" + "\n";';
                echo 'receipt.info += "' . $customer->city ." ".$customer->state." ".$customer->country .'" + "\n";';

                if (!empty($customer->cf1) && $customer->cf1 != "-") {
                    echo 'receipt.info += "\n" + "' . lang("ccf1") . ': ' . $customer->cf1 .'";';
                }
                if (!empty($customer->cf2) && $customer->cf2 != "-") {
                    echo 'receipt.info += "\n" + "' . lang("ccf2") . ': ' . $customer->cf2 .'";';
                }
                if (!empty($customer->cf3) && $customer->cf3 != "-") {
                    echo 'receipt.info += "\n" + "' . lang("ccf3") . ': ' . $customer->cf3 .'";';
                }
                if (!empty($customer->cf4) && $customer->cf4 != "-") {
                    echo 'receipt.info += "\n" + "' . lang("ccf4") . ': ' . $customer->cf4 .'";';
                }
                if (!empty($customer->cf5) && $customer->cf5 != "-") {
                    echo 'receipt.info += "\n" + "' . lang("ccf5") . ': ' . $customer->cf5 .'";';
                }
                if (!empty($customer->cf6) && $customer->cf6 != "-") {
                    echo 'receipt.info += "\n" + "' . lang("ccf6") . ': ' . $customer->cf6 .'";';
                }
                echo 'receipt.info += "\n";';
            }
            ?>

            receipt.items = "";
            <?php $r = 1; foreach ($rows as $row): ?>
            receipt.items += "<?= printLine(product_name(addslashes("#".$r." ".$row->product_code." - ".$row->product_name).' '.($row->variant ? ' (' . $row->variant . ')' : ''), $char_per_line).": ".($row->tax_code ? '*'.$row->tax_code : ''), $char_per_line, ' '); ?>" + "\n";
            <?php if (!empty($row->second_name)) { ?>
                receipt.items += "<?= product_name(addslashes("    ".$row->second_name), $char_per_line); ?>" + "\n";
            <?php } ?>
            <?php if ($row->item_tax != 0) { ?>
                receipt.items += "<?= '    '.lang('tax').' ('.($Settings->indian_gst ? $row->tax : $row->tax_code).') '.$this->sma->formatMoney($row->item_tax).' ('.lang('hsn_code').': '.$row->hsn_code.')'; ?>" + "\n";
            <?php } ?>
            receipt.items += "<?= printLine("   ".($this->sma->formatQuantity($row->unit_quantity).' '.$row->product_unit_code)." x ".$this->sma->formatMoney($row->unit_price) . ":  ". $this->sma->formatMoney($row->subtotal), $char_per_line, ' '); ?>" + "\n";
            <?php $r++; endforeach; ?>
            <?php
            if ($return_rows) { ?>
                receipt.items += "\n" + "<?=lang('returned_items');?>" + "\n";
                <?php $r = 1; foreach ($return_rows as $row): ?>
                receipt.items += "<?= printLine(product_name(addslashes("#".$r." ".$row->product_code." - ".$row->product_name).' '.($row->variant ? ' (' . $row->variant . ')' : ''), $char_per_line).": ".($row->tax_code ? '*'.$row->tax_code : ''), $char_per_line, ' '); ?>" + "\n";
                <?php if (!empty($row->second_name)) { ?>
                    receipt.items += "<?= product_name(addslashes("    ".$row->second_name), $char_per_line); ?>" + "\n";
                <?php } ?>
                <?php if ($row->item_tax != 0) { ?>
                    receipt.items += "<?= '    '.lang('tax').' ('.($Settings->indian_gst ? $row->tax : $row->tax_code).') '.$this->sma->formatMoney($row->item_tax).' ('.lang('hsn_code').': '.$row->hsn_code.')'; ?>" + "\n";
                <?php } ?>
                receipt.items += "<?= printLine("   ".($this->sma->formatQuantity($row->unit_quantity).' '.$row->product_unit_code)." x ".$this->sma->formatMoney($row->unit_price) . ":  ". $this->sma->formatMoney($row->subtotal), $char_per_line, ' ') . ""; ?>" + "\n";
                <?php $r++; endforeach; ?>
                <?php
            } ?>
            receipt.totals = "";
            receipt.totals += "<?= printLine(lang("total") . ": " . $this->sma->formatMoney($return_sale ? (($inv->total + $inv->product_tax)+($return_sale->total + $return_sale->product_tax)) : ($inv->total + $inv->product_tax)), $char_per_line); ?>" + "\n";
            <?php
            if ($Settings->indian_gst) {
                if ($inv->cgst > 0) {
                    $cgst = $return_sale ? $inv->cgst + $return_sale->cgst : $inv->cgst; ?>
                    receipt.totals += "<?= printLine(lang("cgst") . ": " . ( $Settings->format_gst ? $this->sma->formatMoney($cgst) : $cgst), $char_per_line); ?>" + "\n";
                    <?php
                }
                if ($inv->sgst > 0) {
                    $sgst = $return_sale ? $inv->sgst + $return_sale->sgst : $inv->sgst; ?>
                    receipt.totals += "<?= printLine(lang("sgst") . ": " . ( $Settings->format_gst ? $this->sma->formatMoney($sgst) : $sgst), $char_per_line); ?>" + "\n";
                    <?php
                }
                if ($inv->igst > 0) {
                    $igst = $return_sale ? $inv->igst + $return_sale->igst : $inv->igst; ?>
                    receipt.totals += "<?= printLine(lang("igst") . ": " . ( $Settings->format_gst ? $this->sma->formatMoney($igst) : $igst), $char_per_line); ?>" + "\n";
                    <?php
                }
            }

            if ($inv->order_tax != 0) { ?>
                receipt.totals += "<?= printLine(lang("tax") . ": " . $this->sma->formatMoney($return_sale ? ($inv->order_tax+$return_sale->order_tax) : $inv->order_tax), $char_per_line); ?>" + "\n";
                <?php
            }
            if ($inv->total_discount != 0) { ?>
                receipt.totals += "<?= printLine(lang("discount") . ": (" . $this->sma->formatMoney($return_sale ? ($inv->product_discount+$return_sale->product_discount) : $inv->product_discount) . ") " . $this->sma->formatMoney($return_sale ? ($inv->order_discount+$return_sale->order_discount) : $inv->order_discount), $char_per_line); ?>" + "\n";
                <?php
            }
            if ($inv->shipping != 0) { ?>
                receipt.totals += "<?= printLine(lang("shipping") . ": ". $this->sma->formatMoney($inv->shipping), $char_per_line); ?>" + "\n";
                <?php
            }
            if ($pos_settings->rounding || $inv->rounding != 0) { ?>
                receipt.totals += "<?= printLine(lang("rounding") . ": " . $this->sma->formatMoney($inv->rounding), $char_per_line); ?>" + "\n";
                receipt.totals += "<?= printLine(lang("grand_total") . ": " . $this->sma->formatMoney($return_sale ? ($this->sma->roundMoney($inv->grand_total + $inv->rounding)+$return_sale->grand_total) : $this->sma->roundMoney($inv->grand_total + $inv->rounding)), $char_per_line); ?>" + "\n";
                <?php
            } else { ?>
                receipt.totals += "<?= printLine(lang("grand_total") . ": " . $this->sma->formatMoney($return_sale ? ($inv->grand_total+$return_sale->grand_total) : $inv->grand_total), $char_per_line); ?>" + "\n";
                <?php
            } ?>
            receipt.totals += "<?= printLine(lang("paid_amount") . ": " . $this->sma->formatMoney($return_sale ? ($inv->paid+$return_sale->paid) : $inv->paid), $char_per_line); ?>" + "\n";
            receipt.totals += "<?= printLine(lang("due_amount") . ": " . $this->sma->formatMoney(($return_sale ? ($inv->grand_total+$return_sale->grand_total) : $inv->grand_total) - ($return_sale ? ($inv->paid+$return_sale->paid) : $inv->paid)), $char_per_line); ?>" + "\n";

            receipt.payments = '';
            <?php
            if($payments) {

                foreach($payments as $payment) {
                    if ($payment->paid_by == 'cash'  || $payment->paid_by == 'deposit' && $payment->pos_paid) { ?>
                        receipt.payments += "<?= printLine(lang("paid_by") . ": " . lang($payment->paid_by), $char_per_line); ?>" + "\n";
                        receipt.payments += "<?= printLine(lang("amount") . ": " . $this->sma->formatMoney($payment->pos_paid), $char_per_line); ?>" + "\n";
                        receipt.payments += "<?= printLine(lang("change") . ": " . ($payment->pos_balance > 0 ? $this->sma->formatMoney($payment->pos_balance) : '0.00'), $char_per_line); ?>" + "\n";
                        <?php
                    } if (($payment->paid_by == 'CC' || $payment->paid_by == 'ppp' || $payment->paid_by == 'stripe') && $payment->cc_no) { ?>
                        receipt.payments += "<?= printLine(lang("paid_by") . ": " . lang($payment->paid_by), $char_per_line); ?>" + "\n";
                        receipt.payments += "<?= printLine(lang("amount") . ": " . $this->sma->formatMoney($payment->pos_paid), $char_per_line); ?>" + "\n";
                        receipt.payments += "<?= printLine(lang("card_no") . ": xxxx xxxx xxxx " . substr($payment->cc_no, -4), $char_per_line); ?>" + "\n";
                        <?php
                    } if ($payment->paid_by == 'gift_card') { ?>
                        receipt.payments += "<?= printLine(lang("paid_by") . ": " . lang($payment->paid_by), $char_per_line); ?>" + "\n";
                        receipt.payments += "<?= printLine(lang("amount") . ": " . $this->sma->formatMoney($payment->pos_paid), $char_per_line); ?>" + "\n";
                        receipt.payments += "<?= printLine(lang("card_no") . ": " . $payment->gc_no, $char_per_line); ?>" + "\n";
                        <?php
                    } if ($payment->paid_by == 'Cheque' && $payment->cheque_no) { ?>
                        receipt.payments += "<?= printLine(lang("paid_by") . ": " . lang($payment->paid_by), $char_per_line); ?>" + "\n";
                        receipt.payments += "<?= printLine(lang("amount") . ": " . $this->sma->formatMoney($payment->pos_paid), $char_per_line); ?>" + "\n";
                        receipt.payments += "<?= printLine(lang("cheque_no") . ": " . $payment->cheque_no, $char_per_line); ?>" + "\n";
                        <?php if ($payment->paid_by == 'other' && $payment->amount) { ?>
                            receipt.payments += "<?= printLine(lang("paid_by") . ": " . lang($payment->paid_by), $char_per_line); ?>" + "\n";
                            receipt.payments += "<?= printLine(lang("amount") . ": " . $this->sma->formatMoney($payment->amount), $char_per_line); ?>" + "\n";
                            receipt.payments += "<?= printText(lang("payment_note") . ": " . $payment->note, $char_per_line); ?>" + "\n";
                            <?php
                        }
                    }

                }
            }
            if($return_payments) {
                ?>
                receipt.payments += "\n" + "<?=printText(lang("return_payments"), $char_per_line);?>" + "\n";
                <?php
                foreach($return_payments as $payment) {
                    if ($payment->paid_by == 'cash'  || $payment->paid_by == 'deposit' && $payment->pos_paid) { ?>
                        receipt.payments += "<?= printLine(lang("paid_by") . ": " . lang($payment->paid_by), $char_per_line); ?>" + "\n";
                        receipt.payments += "<?= printLine(lang("amount") . ": " . $this->sma->formatMoney($payment->pos_paid), $char_per_line); ?>" + "\n";
                        receipt.payments += "<?= printLine(lang("change") . ": " . ($payment->pos_balance > 0 ? $this->sma->formatMoney($payment->pos_balance) : '0.00'), $char_per_line); ?>" + "\n";
                        <?php
                    } if (($payment->paid_by == 'CC' || $payment->paid_by == 'ppp' || $payment->paid_by == 'stripe') && $payment->cc_no) { ?>
                        receipt.payments += "<?= printLine(lang("paid_by") . ": " . lang($payment->paid_by), $char_per_line); ?>" + "\n";
                        receipt.payments += "<?= printLine(lang("amount") . ": " . $this->sma->formatMoney($payment->pos_paid), $char_per_line); ?>" + "\n";
                        receipt.payments += "<?= printLine(lang("card_no") . ": xxxx xxxx xxxx " . substr($payment->cc_no, -4), $char_per_line); ?>" + "\n";
                        <?php
                    } if ($payment->paid_by == 'gift_card') { ?>
                        receipt.payments += "<?= printLine(lang("paid_by") . ": " . lang($payment->paid_by), $char_per_line); ?>" + "\n";
                        receipt.payments += "<?= printLine(lang("amount") . ": " . $this->sma->formatMoney($payment->pos_paid), $char_per_line); ?>" + "\n";
                        receipt.payments += "<?= printLine(lang("card_no") . ": " . $payment->gc_no, $char_per_line); ?>" + "\n";
                        <?php
                    } if ($payment->paid_by == 'Cheque' && $payment->cheque_no) { ?>
                        receipt.payments += "<?= printLine(lang("paid_by") . ": " . lang($payment->paid_by), $char_per_line); ?>" + "\n";
                        receipt.payments += "<?= printLine(lang("amount") . ": " . $this->sma->formatMoney($payment->pos_paid), $char_per_line); ?>" + "\n";
                        receipt.payments += "<?= printLine(lang("cheque_no") . ": " . $payment->cheque_no, $char_per_line); ?>" + "\n";
                        <?php if ($payment->paid_by == 'other' && $payment->amount) { ?>
                            receipt.payments += "<?= printLine(lang("paid_by") . ": " . lang($payment->paid_by), $char_per_line); ?>" + "\n";
                            receipt.payments += "<?= printLine(lang("amount") . ": " . $this->sma->formatMoney($payment->amount), $char_per_line); ?>" + "\n";
                            receipt.payments += "<?= printText(lang("payment_note") . ": " . $payment->note, $char_per_line); ?>" + "\n";
                            <?php
                        }
                    }

                }
            }
            ?>
            receipt.footer = "";
            <?php
            if ($Settings->invoice_view > 0) {
                if (!empty($tax_summary)) {
                    ?>
                    receipt.footer += "<?=lang('tax_summary');?>" + "\n\n";
                    receipt.footer += "<?=taxLine(lang('name'), lang('code'), lang('qty'), lang('tax_excl'), lang('tax_amt'), $char_per_line);?>" + "\n";
                    receipt.footer += "<?=str_replace("\n", "", drawLine($char_per_line));?>"; + "\n";
                    <?php foreach ($tax_summary as $summary): ?>
                    receipt.footer += "<?=taxLine($summary['name'], $summary['code'], $this->sma->formatQuantity($summary['items']), $this->sma->formatMoney($summary['amt']), $this->sma->formatMoney($summary['tax']), $char_per_line);?>" + "\n";
                    <?php endforeach;?>
                    receipt.footer += "<?=str_replace("\n", "", drawLine($char_per_line));?>"; + "\n";
                    receipt.footer += "\n<?=printLine(lang("total_tax_amount") . ":" . $this->sma->formatMoney($inv->product_tax), $char_per_line);?>" + "\n";
                    receipt.footer += "<?=str_replace("\n", "", drawLine($char_per_line));?>" + "\n\n";
                    <?php
                }
            }
            if ($inv->note) { ?>
                receipt.footer += "<?= printText(strip_tags(preg_replace('/\s+/',' ', $this->sma->decode_html($inv->note))), $char_per_line); ?>" + "\n\n";
                <?php
            }
            if ($biller->invoice_footer) { ?>
                receipt.footer += "<?= printText(str_replace( array( "\n", "\r" ), array( "\\n", "\\r" ), $biller->invoice_footer), $char_per_line);?>\n\n";
                <?php
            } ?>
            return receipt;
        }

        var socket = null;

    </script>

    <?php
    if ( ! $pos_settings->remote_printing) {
        ?>
        <script type="text/javascript">
            function openCashDrawer() {
                var ocddata = {
                    'printer': <?= json_encode($printer); ?>
                };
                $.get('<?= admin_url('pos/open_drawer'); ?>', {data: JSON.stringify(ocddata)});
                return false;
            }

            function printReceipt() {
                var receipt_data = receiptData();
                var socket_data = {
                    'printer': <?= json_encode($printer); ?>,
                    'logo': '<?= !empty($biller->logo) ? $biller->logo : ''; ?>',
                    'text': receipt_data,
                    'cash_drawer': <?= isset($modal) ? 0 : 1; ?>, 'drawer_code': '<?= $pos_settings->cash_drawer_codes; ?>'
                };
                $.get('<?= admin_url('pos/p'); ?>', {data: JSON.stringify(socket_data)});
                return false;
            }
        </script>
        <?php
    } elseif ($pos_settings->remote_printing == 2) {
        ?>
        <script src="<?= $assets ?>plugins/socket.io.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            socket = io.connect('http://localhost:6440', {'reconnection': false});

            function printReceipt() {
                if (socket.connected) {
                    var receipt_data = receiptData();
                    var socket_data = {
                        'printer': <?= json_encode($printer); ?>,
                        'logo': '<?= !empty($biller->logo) ? base_url('assets/uploads/logos/'.$biller->logo) : ''; ?>',
                        'text': receipt_data,
                        'cash_drawer': <?= isset($modal) ? 0 : 1; ?>, 'drawer_code': '<?= $pos_settings->cash_drawer_codes; ?>'
                    };
                    socket.emit('print-now', socket_data);
                    return false;
                } else {
                    bootbox.alert('<?= lang('pos_print_error'); ?>');
                    return false;
                }
            }

            function openCashDrawer() {
                if (socket.connected) {
                    var ocddata = {
                        'printer': <?= json_encode($printer); ?>,
                        'cash_drawer': 1, 'drawer_code': '<?= $pos_settings->cash_drawer_codes; ?>'
                    };
                    socket.emit('open-cashdrawer', ocddata);
                    return false;
                } else {
                    bootbox.alert('<?= lang('pos_print_error'); ?>');
                    return false;
                }
            }
        </script>
        <?php

    } elseif ($pos_settings->remote_printing == 3) {

        ?>
        <script type="text/javascript">
            try {
                socket = new WebSocket('ws://127.0.0.1:6441');
                socket.onopen = function () {
                    console.log('Connected');
                    return;
                };
                socket.onclose = function () {
                    console.log('Not Connected');
                    return;
                };
            } catch (e) {
                console.log(e);
            }

            function openCashDrawer() {
                if (socket.readyState == 1) {
                    var ocddata = {
                        'printer': <?= $pos_settings->local_printers ? "''" : json_encode($printer); ?>,
                    };
                    socket.send(JSON.stringify({
                        type: 'open-cashdrawer',
                        data: ocddata
                    }));
                    return false;
                } else {
                    bootbox.alert('<?= lang('pos_print_error'); ?>');
                    return false;
                }
            }

            function printReceipt() {
                if (socket.readyState == 1) {
                    var receipt_data = receiptData();
                    var socket_data = {
                        'printer': <?= $pos_settings->local_printers ? "''" : json_encode($printer); ?>,
                        'logo': '<?= !empty($biller->logo) ? base_url('assets/uploads/logos/'.$biller->logo) : ''; ?>',
                        'text': receipt_data,
                        'cash_drawer': <?= isset($modal) ? 0 : 1; ?>, 'drawer_code': '<?= $pos_settings->cash_drawer_codes; ?>'
                    };
                    socket.send(JSON.stringify({type: 'print-receipt', data: socket_data}));
                    return false;
                } else {
                    bootbox.alert('<?= lang('pos_print_error'); ?>');
                    return false;
                }
            }
            </script>
            <?php
        }
        ?>
        <script type="text/javascript">
            <?php
            if ($pos_settings->auto_print && (!isset($modal) || empty($modal))) {
                ?>
                $(document).ready(function() {
                    setTimeout(printReceipt, 1000);
                });
                <?php
            }
            ?>
        </script>
        <?php
    }
    ?>
