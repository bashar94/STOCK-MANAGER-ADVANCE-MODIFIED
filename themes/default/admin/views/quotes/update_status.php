<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('update_status'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo admin_form_open_multipart("quotes/update_status/" . $inv->id, $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?= lang('quote_details'); ?>
                </div>
                <div class="panel-body">
                    <table class="table table-condensed table-striped table-borderless" style="margin-bottom:0;">
                        <tbody>
                            <tr>
                                <td><?= lang('reference_no'); ?></td>
                                <td><?= $inv->reference_no; ?></td>
                            </tr>
                            <tr>
                                <td><?= lang('biller'); ?></td>
                                <td><?= $inv->biller; ?></td>
                            </tr>
                            <tr>
                                <td><?= lang('customer'); ?></td>
                                <td><?= $inv->customer; ?></td>
                            </tr>
                            <tr>
                                <td><?= lang('status'); ?></td>
                                <td><strong><?= lang($inv->status); ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="form-group">
                <?= lang('status', 'status'); ?>
                <?php
                $opts = array('pending' => lang('pending'), 'sent' => lang('sent'), 'completed' => lang('completed'));
                ?>
                <?= form_dropdown('status', $opts, $inv->status, 'class="form-control" id="status" required="required" style="width:100%;"'); ?>
            </div>

            <div class="form-group">
                <?= lang("note", "note"); ?>
                <?php echo form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : $this->sma->decode_html($inv->note)), 'class="form-control" id="note"'); ?>
            </div>

        </div>

        <div class="modal-footer">
            <?php echo form_submit('update', lang('update'), 'class="btn btn-primary"'); ?>
        </div>

    </div>
    <?php echo form_close(); ?>
</div>
<?= $modal_js ?>
