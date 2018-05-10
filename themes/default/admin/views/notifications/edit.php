<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('edit_notification'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo admin_form_open("notifications/edit", $attrib); ?>
        <div class="modal-body">
            <p><?= lang('update_info'); ?></p>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <?php echo lang('from', 'from_date'); ?>
                        <div class="controls">
                            <?php echo form_input('from_date', date($dateFormats['php_ldate'], strtotime($notification->from_date)), 'class="form-control date" id="from_date" required="required"'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <?php echo lang('till', 'to_date'); ?>
                        <div class="controls">
                            <?php echo form_input('to_date', date($dateFormats['php_ldate'], strtotime($notification->till_date)), 'class="form-control date" id="to_date" required="required"'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <?php echo lang('comment', 'comment'); ?>
                <div class="controls">
                    <?php echo form_textarea($comment); ?>
                </div>
            </div>

            <div class="form-group">
                <input type="radio" class="checkbox" name="scope" value="1"
                       id="customer" <?= $notification->scope == '1' ? 'checked="checked"' : ''; ?>/><label
                    for="customer" class="padding05"><?= lang('for_customers_only') ?></label>
                <input type="radio" class="checkbox" name="scope" value="2"
                       id="staff" <?= $notification->scope == '2' ? 'checked="checked"' : ''; ?>><label for="staff"
                                                                                                        class="padding05"><?= lang('for_staff_only') ?></label>
                <input type="radio" class="checkbox" name="scope" value="3"
                       id="both" <?= $notification->scope == '3' ? 'checked="checked"' : ''; ?>><label for="both"
                                                                                                       class="padding05"><?= lang('for_both') ?></label>
            </div>

            <?php echo form_hidden('id', $id); ?>
        </div>
        <div class="modal-footer">
            <?php echo form_submit('edit_notification', lang('edit_notification'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<?= $modal_js ?>
<script type="text/javascript" src="<?= $assets ?>js/custom.js"></script>
<script type="text/javascript" charset="UTF-8">
    // $.fn.datetimepicker.dates['sma'] = <?=$dp_lang?>;
</script>
