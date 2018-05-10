<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('add_deposit') . " (" . $company->name . ")"; ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo admin_form_open("customers/add_deposit/" . $company->id, $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <div class="row">
                <div class="col-sm-12">
                    <?php if ($Owner || $Admin) { ?>
                    <div class="form-group">
                        <?php echo lang('date', 'date'); ?>
                        <div class="controls">
                            <?php echo form_input('date', set_value('date', date($dateFormats['php_ldate'])), 'class="form-control date" id="date" required="required"'); ?>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="form-group">
                        <?php echo lang('amount', 'amount'); ?>
                        <div class="controls">
                            <?php echo form_input('amount', set_value('amount'), 'class="form-control" id="amount" required="required"'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo lang('paid_by', 'paid_by'); ?>
                        <div class="controls">
                            <?php echo form_input('paid_by', set_value('paid_by'), 'class="form-control" id="paid_by"'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo lang('note', 'note'); ?>
                        <div class="controls">
                            <?php echo form_textarea('note', set_value('note'), 'class="form-control" id="note"'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <?php echo form_submit('add_deposit', lang('add_deposit'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<?= $modal_js ?>

