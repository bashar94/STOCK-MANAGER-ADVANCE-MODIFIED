<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style type="text/css">
    @media print {
        #myModal .modal-content {
            display: none !important;
        }
    }
</style>
<div class="modal-dialog modal-lg no-modal-header">
    <div class="modal-content">
        <div class="modal-body print">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i></button>
            <?php if ($logo) { ?>
                <!--<div class="text-center" style="margin-bottom:20px;">-->
                <img src="<?= base_url('assets/uploads/logos/' . $Settings->logo) ?>"
                     alt="<?= $Settings->site_name ?>">
                <!--</div>-->
            <?php } ?>
            <div class="clearfix"></div>
            <div class="row padding10">
                <div class="col-xs-5">
                    <?php echo $this->lang->line("to"); ?>:<br/>
                    <h2 class=""><?= $supplier->company ? $supplier->company : $supplier->name; ?></h2>
                    <?= $supplier->company ? "" : "Attn: " . $supplier->name ?>
                    <?php
                    echo $supplier->address . "<br />" . $supplier->city . " " . $supplier->postal_code . " " . $supplier->state . "<br />" . $supplier->country;
                    echo "<p>";
                    if ($supplier->cf1 != "-" && $supplier->cf1 != "") {
                        echo "<br>" . lang("ccf1") . ": " . $supplier->cf1;
                    }
                    if ($supplier->cf2 != "-" && $supplier->cf2 != "") {
                        echo "<br>" . lang("ccf2") . ": " . $supplier->cf2;
                    }
                    if ($supplier->cf3 != "-" && $supplier->cf3 != "") {
                        echo "<br>" . lang("ccf3") . ": " . $supplier->cf3;
                    }
                    if ($supplier->cf4 != "-" && $supplier->cf4 != "") {
                        echo "<br>" . lang("ccf4") . ": " . $supplier->cf4;
                    }
                    if ($supplier->cf5 != "-" && $supplier->cf5 != "") {
                        echo "<br>" . lang("ccf5") . ": " . $supplier->cf5;
                    }
                    if ($supplier->cf6 != "-" && $supplier->cf6 != "") {
                        echo "<br>" . lang("ccf6") . ": " . $supplier->cf6;
                    }
                    echo "</p>";
                    echo lang("tel") . ": " . $supplier->phone . "<br />" . lang("email") . ": " . $supplier->email;
                    ?>
                </div>
                <div class="col-xs-5">
                    <?php echo $this->lang->line("from"); ?>:<br/>
                    <h2 class=""><?= $Settings->site_name; ?></h2>
                    <?php
                    echo "<p>";
                    echo $warehouse->name . " (" . $warehouse->code . ")<br>" . $warehouse->address;
                    echo "</p>";
                    echo lang("tel") . ": " . $warehouse->phone . "<br />" . lang("email") . ": " . $warehouse->email;
                    ?>
                    <div class="clearfix"></div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-12">
                    <p style="font-weight:bold;"><?= lang("date"); ?>: <?= $this->sma->hrld($payment->date); ?></p>
                    <p style="font-weight:bold;"><?= lang("purchase").' '.lang('ref'); ?>: <?= $inv->reference_no; ?></p>
                    <p style="font-weight:bold;"><?= lang("reference_no"); ?>: <?= $payment->reference_no; ?></p>
                </div>
                <p>&nbsp;</p>

                <div style="clear: both;"></div>
            </div>
            <div class="well">
                <table class="table table-borderless" style="margin-bottom:0;">
                    <tbody>
                    <tr>
                        <td>
                            <strong><?= $payment->type == 'returned' ? lang("payment_returned") : lang("payment_sent"); ?></strong>
                        </td>
                        <td class="text-right"><strong
                                class="text-right"><?php echo $this->sma->formatMoney($payment->amount); ?></strong>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?= lang("paid_by"); ?></strong></td>
                        <td class="text-right"><strong class="text-right"><?php echo lang($payment->paid_by);
                                if ($payment->paid_by == 'gift_card' || $payment->paid_by == 'CC') {
                                    echo ' (' . $payment->cc_no . ')';
                                } elseif ($payment->paid_by == 'Cheque') {
                                    echo ' (' . $payment->cheque_no . ')';
                                }
                                ?></strong></td>
                    </tr>
                    <tr>
                        <td colspan="2"><?= html_entity_decode($payment->note); ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div style="clear: both;"></div>
            <div class="row">
                <div class="col-sm-4 pull-left">
                    <p>&nbsp;</p>

                    <p>&nbsp;</p>

                    <p>&nbsp;</p>

                    <p style="border-bottom: 1px solid #666;">&nbsp;</p>

                    <p><?= lang("stamp_sign"); ?></p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>