<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('add_tax_rate'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo admin_form_open("system_settings/add_tax_rate", $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <div class="form-group">
                <label for="name"><?php echo $this->lang->line("name"); ?></label>

                <div
                    class="controls"> <?php echo form_input('name', '', 'class="form-control" id="name" required="required"'); ?> </div>
            </div>
            <div class="form-group">
                <label for="code"><?php echo $this->lang->line("code"); ?></label>

                <div
                    class="controls"> <?php echo form_input('code', '', 'class="form-control" id="code"'); ?> </div>
            </div>
            <div class="form-group">
                <label for="rate"><?php echo $this->lang->line("rate"); ?></label>

                <div
                    class="controls"> <?php echo form_input('rate', '', 'class="form-control" id="rate" required="required"'); ?> </div>
            </div>
            <div class="form-group">
                <label for="type"><?php echo $this->lang->line("type"); ?></label>

                <div class="controls"> <?php $type = array('1' => lang('percentage'), '2' => lang('fixed'));
                    echo form_dropdown('type', $type, '', 'class="form-control" id="type" required="required"'); ?> </div>
            </div>
        </div>
        <div class="modal-footer">
            <?php echo form_submit('add_tax_rate', lang('add_tax_rate'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<?= $modal_js ?>