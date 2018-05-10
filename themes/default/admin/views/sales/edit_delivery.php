<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?= lang('edit_delivery'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo admin_form_open_multipart("sales/edit_delivery/" . $delivery->id, $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>
            <div class="row">
            <div class="col-md-6">
                
            <?php if ($Owner || $Admin) { ?>
                <div class="form-group">
                    <?= lang("date", "date"); ?>
                    <?= form_input('date', (isset($_POST['date']) ? $_POST['date'] : $this->sma->hrld($delivery->date)), 'class="form-control date" id="date" required="required"'); ?>
                </div>
            <?php } ?>
            <div class="form-group">
                <?= lang("do_reference_no", "do_reference_no"); ?>
                <?= form_input('do_reference_no', (isset($_POST['do_reference_no']) ? $_POST['do_reference_no'] : $delivery->do_reference_no), 'class="form-control tip" id="do_reference_no" required="required"'); ?>
            </div>

            <div class="form-group">
                <?= lang("sale_reference_no", "sale_reference_no"); ?>
                <?= form_input('sale_reference_no', (isset($_POST['sale_reference_no']) ? $_POST['sale_reference_no'] : $delivery->sale_reference_no), 'class="form-control tip" id="sale_reference_no" required="required"'); ?>
            </div>
            <input type="hidden" value="<?= $delivery->sale_id; ?>" name="sale_id"/>

            <div class="form-group">
                <?= lang("customer", "customer"); ?>
                <?= form_input('customer', (isset($_POST['customer']) ? $_POST['customer'] : $delivery->customer), 'class="form-control" id="customer" required="required" '); ?>
            </div>

            <div class="form-group">
                <?= lang("address", "address"); ?>
                <?= form_textarea('address', (isset($_POST['address']) ? $_POST['address'] : $delivery->address), 'class="form-control" id="address" required="required"'); ?>
            </div>
            </div>
            <div class="col-md-6">

            <div class="form-group">
                <?= lang('status', 'status'); ?>
                <?php
                $opts = array('packing' => lang('packing'), 'delivering' => lang('delivering'), 'delivered' => lang('delivered'));
                ?>
                <?= form_dropdown('status', $opts, (isset($_POST['status']) ? $_POST['status'] : $delivery->status), 'class="form-control" id="status" required="required" style="width:100%;"'); ?>
            </div>

            <div class="form-group">
                <?= lang("delivered_by", "delivered_by"); ?>
                <?= form_input('delivered_by', (isset($_POST['delivered_by']) ? $_POST['delivered_by'] : $delivery->delivered_by), 'class="form-control" id="delivered_by"'); ?>
            </div>

            <div class="form-group">
                <?= lang("received_by", "received_by"); ?>
                <?= form_input('received_by', (isset($_POST['received_by']) ? $_POST['received_by'] : $delivery->received_by), 'class="form-control" id="received_by"'); ?>
            </div>

            <div class="form-group">
                <?= lang("attachment", "attachment") ?>
                <input id="attachment" type="file" data-browse-label="<?= lang('browse'); ?>" name="document" data-show-upload="false" data-show-preview="false" class="form-control file">
            </div>

            <div class="form-group">
                <?= lang("note", "note"); ?>
                <?= form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : $delivery->note), 'class="form-control" id="note"'); ?>
            </div>
            </div>
            </div>

        </div>
        <div class="modal-footer">
            <?= form_submit('edit_delivery', lang('edit_delivery'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?= form_close(); ?>
</div>
<script type="text/javascript" src="<?= $assets ?>js/custom.js"></script>
<script type="text/javascript" charset="UTF-8">
    // $.fn.datetimepicker.dates['sma'] = <?=$dp_lang?>;
</script>
<?= $modal_js ?>
<script type="text/javascript" charset="UTF-8">
    $(document).ready(function () {
        // $.fn.datetimepicker.dates['sma'] = <?=$dp_lang?>;
    });
</script>
