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
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <?php if ($logo) { ?>
                <img src="<?= base_url() . 'assets/uploads/logos/' . $Settings->logo; ?>"
                     alt="<?= $Settings->site_name; ?>">
            <?php } ?>
            <div class="clearfix"></div>
            <div class="row padding10">
                <div class="col-xs-5">
                    <h2 class=""><?= $Settings->site_name; ?></h2>

                    <div class="clearfix"></div>
                </div>
            </div>
            <div style="clear: both;"></div>
            <p>&nbsp;</p>

            <div class="well">
                <table class="table table-borderless" style="margin-bottom:0;">
                    <tbody>
                    <tr>
                        <td><strong><?= lang("date"); ?></strong></td>
                        <td><strong class="text-right"><?php echo $this->sma->hrld($expense->date); ?></strong></td>
                    </tr>
                    <tr>
                        <td><strong><?= lang("reference"); ?></strong></td>
                        <td><strong class="text-right"><?php echo $expense->reference; ?></strong></td>
                    </tr>
                    <?php if ($category) { ?>
                    <tr>
                        <td><strong><?= lang("category"); ?></strong></td>
                        <td><strong class="text-right"><?php echo $category->name; ?></strong></td>
                    </tr>
                    <?php } ?>
                    <?php if ($warehouse) { ?>
                    <tr>
                        <td><strong><?= lang("warehouse"); ?></strong></td>
                        <td><strong class="text-right"><?php echo $warehouse->name; ?></strong></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td><strong><?= lang("amount"); ?></strong></td>
                        <td><strong class="text-right"><?php echo $this->sma->formatMoney($expense->amount); ?></strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><?php echo $expense->note; ?></td>
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