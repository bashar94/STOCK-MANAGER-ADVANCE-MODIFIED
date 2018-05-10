<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript" src="<?= $assets ?>js/custom.js"></script>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?= lang('add_gift_card'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo admin_form_open("sales/add_gift_card", $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <div class="form-group">
                <?= lang("card_no", "card_no"); ?>
                <div class="input-group">
                    <?php echo form_input('card_no', '', 'class="form-control" id="card_no" required="required"'); ?>
                    <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                        <a href="#" id="genNo">
                            <i class="fa fa-cogs"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <?= lang("value", "value"); ?>
                <?php echo form_input('value', '', 'class="form-control" id="value" required="required"'); ?>
            </div>
            <div class="form-group">
                <input type="checkbox" class="checkbox" name="staff_points" id="staff_points">
                <label for="staff_points" class="padding05"><?= lang('use_staff_award_points'); ?></label>
            </div>
            <div id="staff-con" style="display:none;">
                <div class="form-group">
                    <label class="control-label" for="user"><?= lang("user"); ?></label>
                    <?php
                    $us[""] = "";
                    foreach ($users as $user) {
                        $us[$user->id] = $user->first_name . " " . $user->last_name;
                    }
                    echo form_dropdown('user', $us, (isset($_POST['user']) ? $_POST['user'] : ""), 'class="form-control" id="user" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("user") . '"');
                    ?>
                </div>
                <div class="form-group well well-sm" id="sa-points-con" style="display:none;">
                    <p class="bold"><?= lang("award_points"); ?>: <span id="staff_award_points"></span></p>
                    <?= lang("use_points", "sa_points"); ?>
                    <?php echo form_input('sa_points', '', 'class="form-control" id="sa_points"'); ?>
                </div>
            </div>
            <div id="customer-con">
                <div class="form-group">
                    <?= lang("customer", "customer"); ?>
                    <?php echo form_input('customer', '', 'class="form-control" id="customer"'); ?>
                </div>
                <div class="well well-sm" id="award-points-con" style="display:none;">
                    <div class="form-group">
                        <p class="bold"><?= lang("award_points"); ?>: <span id="award_points"></span></p>
                        <input type="checkbox" class="checkbox" name="use_points" id="use_points"><label
                            for="use_points" class="padding05"><?= lang('use_award_points'); ?></label>
                    </div>
                    <div class="form-group" id="ca-points-con" style="display:none;">
                        <?= lang("use_points", "ca_points"); ?>
                        <?php echo form_input('ca_points', '', 'class="form-control" id="ca_points"'); ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <?= lang("expiry_date", "expiry"); ?>
                <?php echo form_input('expiry', $this->sma->hrsd(date("Y-m-d", strtotime("+2 year"))), 'class="form-control date" id="expiry"'); ?>
            </div>

        </div>
        <div class="modal-footer">
            <?php echo form_submit('add_gift_card', lang('add_gift_card'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<?= $modal_js ?>
<script type="text/javascript">
    $(document).ready(function () {
        // $.fn.datetimepicker.dates['sma'] = <?=$dp_lang?>;
        $('#customer').select2({
            minimumInputLength: 1,
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
        });
        var customer_points = 0;
        $('#customer').on('select2-close', function () {
            var selected_customer = $(this).val();
            $.ajax({
                type: "get", async: false,
                url: site.base_url + "customers/get_award_points/" + selected_customer,
                dataType: 'json',
                success: function (data) {
                    if (data != null) {
                        $('#award_points').html(data.ca_points);
                        $('#ca_points').val(data.ca_points);
                        customer_points = parseInt(data.ca_points);
                        if (data.ca_points > 0) {
                            $('#award-points-con').slideDown();
                        } else {
                            $('#award-points-con').slideUp();
                        }
                    } else {
                        $('#award-points-con').slideUp();
                    }
                }
            });
        });
        $(document).on('change', '#ca_points', function () {
            if (parseInt($(this).val()) <= customer_points) {
                $("[name='add_gift_card']").attr('disabled', false);
            } else {
                $("[name='add_gift_card']").attr('disabled', true);
            }
        });
        $(document).on('ifChecked', '#use_points', function (event) {
            $('#ca-points-con').slideDown();
        });
        $(document).on('ifUnchecked', '#use_points', function (event) {
            $('#ca-points-con').slideUp();
        });
        $('#genNo').click(function () {
            var no = generateCardNo();
            $(this).parent().parent('.input-group').children('input').val(no);
            return false;
        });
        $('#staff_points').on('ifChecked', function (event) {
            $('#customer-con').slideUp('fast');
            $('#staff-con').slideDown();
        });
        $('#staff_points').on('ifUnchecked', function (event) {
            $('#staff-con').slideUp('fast');
            $('#customer-con').slideDown();
        });
        $('#user').change(function () {
            var selected_user = $(this).val();
            $.ajax({
                type: "get", async: false,
                url: site.base_url + "sales/get_award_points/" + selected_user,
                dataType: 'json',
                success: function (data) {
                    if (data != null) {
                        $('#staff_award_points').html(data.sa_points);
                        $('#sa_points').val(data.sa_points);
                        if (data.sa_points > 0) {
                            $('#sa-points-con').slideDown();
                        } else {
                            $('#sa-points-con').slideUp();
                        }
                    } else {
                        $('#sa-points-con').slideUp();
                    }
                }
            });
        });
    });

</script>    