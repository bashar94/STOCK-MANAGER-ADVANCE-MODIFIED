<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('edit_group'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo admin_form_open("system_settings/edit_group/" . $group->id, $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <div class="form-group">
                <?= lang("group_name", "group_name"); ?></label>
                <?php echo form_input('group_name', $group->name, 'class="form-control" id="group_name" required="required"'); ?>
            </div>

            <div class="form-group">
                <?= lang("description", "description"); ?></label>
                <?php echo form_input('description', $group->description, 'class="form-control" id="description" required="required"'); ?>
            </div>

        </div>
        <div class="modal-footer">
            <?php echo form_submit('edit_group', lang('edit_group'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<?= $modal_js ?>
