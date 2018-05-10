<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>ul.ui-autocomplete {
        z-index: 1100;
    }</style>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?= $product->name; ?></h4>
        </div>
        <?php echo admin_form_open("products/set_rack/" . $product->id . '/' . $warehouse_id); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <div class="form-group">
                <?php echo lang('rack_location', 'rack'); ?>
                <div class="controls">
                    <?php echo form_input('rack', $rack, 'id="rack" class="form-control" required="required"'); ?>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <?php echo form_submit('set_rack', lang('set_rack'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
    