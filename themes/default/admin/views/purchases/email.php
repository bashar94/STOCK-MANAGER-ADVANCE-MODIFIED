<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
    $(function () {
        $('.bcc').hide();
        $(".toggle_form").slideDown('hide');
        $('.toggle_form').click(function () {
            $("#bcc").slideToggle();
            return false;
        });
    });
</script>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('email_purchase'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo admin_form_open("purchases/email/" . $id, $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <div class="form-group">
                <?= lang("to", 'to'); ?>
                <input type="email" name="to" id="to" class="form-control" value="<?= $supplier->email ?>"
                       required="required"/>
            </div>
            <div id="bcc" style="display:none;">
                <div class="form-group">
                    <?= lang("cc", 'cc'); ?>
                    <input type="text" name="cc" id="cc" class="form-control" />
                </div>
                <div class="form-group">
                    <?= lang("bcc", 'bcc'); ?>
                    <input type="text" name="bcc" id="bcc" class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <?= lang("subject", 'subject'); ?>
                <?php echo form_input($subject, '', 'class="form-control" id="subject" pattern=".{2,255}" required="required" '); ?>
            </div>
            <div class="form-group">
                <?= lang("message", 'note'); ?>
                <?php echo form_textarea($note, (isset($_POST['note']) ? $_POST['note'] : ""), 'class="form-control" id="note" '); ?>
            </div>

        </div>
        <div class="modal-footer">
            <a href="#"
               class="btn btn-sm btn-default pull-left toggle_form"><?php echo $this->lang->line("show_bcc"); ?></a>
            <?php echo form_submit('send_email', lang('send_email'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<?= $modal_js ?>
