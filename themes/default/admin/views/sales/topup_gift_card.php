<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?= lang('topup_gift_card').' ('.$card->card_no.')'; ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo admin_form_open("sales/topup_gift_card/".$card->id, $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <div class="form-group">
                <?= lang("amount", "amount"); ?>
                <?php echo form_input('amount', '', 'class="form-control" id="amount" required="required"'); ?>
            </div>
            <div class="form-group">
                <?= lang("expiry_date", "expiry"); ?>
                <?php echo form_input('expiry', $this->sma->hrsd(date("Y-m-d", strtotime("+2 year"))), 'class="form-control date" id="expiry"'); ?>
            </div>

        </div>
        <div class="modal-footer">
            <?php echo form_submit('topup', lang('topup_gift_card'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<?= $modal_js ?>
