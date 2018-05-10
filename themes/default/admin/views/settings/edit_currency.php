<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?= lang('edit_currency'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo admin_form_open("system_settings/edit_currency/" . $id, $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <div class="form-group">
                <?= lang('currency_code', 'code'); ?>
                <?= form_input('code', set_value('code', $currency->code), 'class="form-control tip" id="code" required="required"'); ?>
            </div>

            <div class="form-group">
                <?= lang('currency_name', 'name'); ?>
                <?= form_input('name', set_value('name', $currency->name), 'class="form-control tip" id="name" required="required"'); ?>
            </div>

            <div class="form-group">
                <?= lang('symbol', 'symbol'); ?>
                <?= form_input('symbol', $currency->symbol, 'class="form-control tip" id="symbol" required="required"'); ?>
            </div>

            <div class="form-group">
                <?= lang('exchange_rate', 'rate'); ?>
                <?= form_input('rate', set_value('rate', $currency->rate), 'class="form-control tip" id="rate"  required="required"'); ?>
            </div>

            <div class="form-group">
                <input type="checkbox" value="1" name="auto_update" id="auto_update" <?= $currency->auto_update ? 'checked="checked"' : ''; ?>>
                <label class="padding-left-10" for="auto_update"><?= lang("auto_update_rate"); ?></label>
            </div>
        </div>
        <div class="modal-footer">
            <?= form_submit('edit_currency', lang('edit_currency'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?= form_close(); ?>
</div>
<?= $modal_js ?>
