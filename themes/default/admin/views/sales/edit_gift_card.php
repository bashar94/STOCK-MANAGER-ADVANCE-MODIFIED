<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript" src="<?= $assets ?>js/custom.js"></script>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?= lang('edit_gift_card'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo admin_form_open("sales/edit_gift_card/" . $gift_card->id, $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <div class="form-group">
                <?= lang("card_no", "card_no"); ?>
                <div class="input-group">
                    <?php echo form_input('card_no', $gift_card->card_no, 'class="form-control" id="card_no" required="required"'); ?>
                    <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;"><a href="#"
                                                                                                       id="genNo"><i
                                class="fa fa-cogs"></i></a></div>
                </div>
            </div>
            <div class="form-group">
                <?= lang("value", "value"); ?>
                <?php echo form_input('value', $this->sma->formatDecimal($gift_card->value), 'class="form-control" id="value" required="required"'); ?>
            </div>
            <div class="form-group">
                <?= lang("customer", "customer"); ?>
                <?php echo form_input('customer', $gift_card->customer_id, 'class="form-control" id="customer"'); ?>
            </div>
            <div class="form-group">
                <?= lang("expiry_date", "expiry"); ?>
                <?php echo form_input('expiry', $this->sma->hrsd($gift_card->expiry), 'class="form-control date" id="expiry"'); ?>
            </div>

        </div>
        <div class="modal-footer">
            <?php echo form_submit('edit_gift_card', lang('edit_gift_card'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<?= $modal_js ?>
<script type="text/javascript">
    $(document).ready(function () {
        // $.fn.datetimepicker.dates['sma'] = <?=$dp_lang?>;
        $('#customer').val('<?=$gift_card->customer_id?>').select2({
            minimumInputLength: 1,
            data: [],
            initSelection: function (element, callback) {
                $.ajax({
                    type: "get", async: false,
                    url: "<?= admin_url('customers/getCustomer') ?>/" + $(element).val(),
                    dataType: "json",
                    success: function (data) {
                        if (data != null) {
                            callback(data[0]);
                        }
                    }
                });
            },
            ajax: {
                url: site.base_url + "customers/suggestions",
                dataType: 'json',
                quietMillis: 15,
                data: function (term, page) {
                    return {
                        term: term,
                        limit: 10
                    };
                },
                results: function (data, page) {
                    if (data.results != null) {
                        return {results: data.results};
                    } else {
                        return {results: [{id: '', text: 'No Match Found'}]};
                    }
                }
            }
        });//.select2("val", "<?=$gift_card->customer_id?>");
        $('#genNo').click(function () {
            var no = generateCardNo();
            $(this).parent().parent('.input-group').children('input').val(no);
            return false;
        });
    });

</script>    