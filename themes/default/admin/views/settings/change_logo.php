<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('change_logo'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo admin_form_open_multipart("system_settings/change_logo", $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <p class="text-primary"><?= lang('logo_image_tip'); ?></p>

            <div class="form-group">
                <?= lang("site_logo", "site_logo") ?>
                <input id="site_logo" type="file" data-browse-label="<?= lang('browse'); ?>" name="site_logo" data-show-upload="false" data-show-preview="false" class="form-control file">
            </div>
            <div class="form-group">
                <?= lang("login_logo", "login_logo") ?>
                <input id="login_logo" type="file" data-browse-label="<?= lang('browse'); ?>" name="login_logo" data-show-upload="false" data-show-preview="false" class="form-control file">
            </div>
            <div class="form-group">
                <?= lang("biller_logo", "biller_logo") ?>
                <input id="biller_logo" type="file" data-browse-label="<?= lang('browse'); ?>" name="biller_logo" data-show-upload="false"
                       data-show-preview="false" class="form-control file">
                <small class="help-block"><?= lang('biller_logo_tip'); ?></small>
            </div>
        </div>
        <div class="modal-footer">
            <?php echo form_submit('upload_logo', lang('upload_logo'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript" src="<?= $assets ?>js/custom.js"></script>
<?= $modal_js ?>