<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">

    $(document).ready(function () {

        <?php if ($Owner || $Admin) { ?>
        if (!localStorage.getItem('qadate')) {
            // $("#qadate").datetimepicker({
            //     format: site.dateFormats.js_ldate,
            //     fontAwesome: true,
            //     language: 'sma',
            //     weekStart: 1,
            //     todayBtn: 1,
            //     autoclose: 1,
            //     todayHighlight: 1,
            //     startView: 2,
            //     forceParse: 0
            // }).datetimepicker('update', new Date());
        }
        $(document).on('change', '#qadate', function (e) {
            localStorage.setItem('qadate', $(this).val());
        });
        if (qadate = localStorage.getItem('qadate')) {
            $('#qadate').val(qadate);
        }
        <?php } ?>
        
    });
</script>

<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-plus"></i><?= lang('add_adjustment_by_csv'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?php echo lang('enter_info'); ?></p>
                <?php
                $attrib = array('data-toggle' => 'validator', 'role' => 'form');
                echo admin_form_open_multipart("products/add_adjustment_by_csv", $attrib);
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <?php if ($Owner || $Admin) { ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?= lang("date", "qadate"); ?>
                                    <?php echo form_input('date', (isset($_POST['date']) ? $_POST['date'] : ""), 'class="form-control input-tip date" id="qadate" required="required"'); ?>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("reference_no", "qaref"); ?>
                                <?php echo form_input('reference_no', (isset($_POST['reference_no']) ? $_POST['reference_no'] : ''), 'class="form-control input-tip" id="qaref"'); ?>
                            </div>
                        </div>

                        <?php if ($Owner || $Admin || !$this->session->userdata('warehouse_id')) { ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?= lang("warehouse", "qawarehouse"); ?>
                                    <?php
                                    $wh[''] = '';
                                    foreach ($warehouses as $warehouse) {
                                        $wh[$warehouse->id] = $warehouse->name;
                                    }
                                    echo form_dropdown('warehouse', $wh, (isset($_POST['warehouse']) ? $_POST['warehouse'] : $Settings->default_warehouse), 'id="qawarehouse" class="form-control input-tip select" data-placeholder="' . lang("select") . ' ' . lang("warehouse") . '" required="required" style="width:100%;"');
                                    ?>
                                </div>
                            </div>
                            <?php } else {
                                $warehouse_input = array(
                                    'type' => 'hidden',
                                    'name' => 'warehouse',
                                    'id' => 'qawarehouse',
                                    'value' => $this->session->userdata('warehouse_id'),
                                    );

                                echo form_input($warehouse_input);
                            } ?>

                        <div class="clearfix"></div>



                        <div class="col-md-12">

                            <div class="well well-small">
                                <a href="<?php echo base_url(); ?>assets/csv/sample_adjustments.csv"
                                 class="btn btn-primary pull-right"><i
                                 class="fa fa-download"></i> <?= lang("download_sample_file") ?></a>
                                 <span class="text-warning"><?= lang("csv1"); ?></span><br/><?= lang("csv2"); ?> <span
                                 class="text-info">(<?= lang("product_code") . ', ' . lang("quantity") . ', ' . lang("variant"); ?>
                                 )</span> <?= lang("csv3"); ?>
                                <br><strong><?= lang('quantity_colum_tip'); ?></strong>
                             </div>

                             <div class="form-group">
                                <label for="csv_file"><?= lang("upload_file"); ?></label>
                                <input type="file" data-browse-label="<?= lang('browse'); ?>" name="csv_file" class="form-control file" data-show-upload="false" data-show-preview="false" id="csv_file" required="required"/>
                            </div>

                        </div>
                        <div class="clearfix"></div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <?= lang("note", "qanote"); ?>
                                    <?php echo form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : ""), 'class="form-control" id="qanote" style="margin-top: 10px; height: 100px;"'); ?>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                        <div class="col-md-12">
                            <div
                                class="fprom-group"><?php echo form_submit('add_adjustment', lang("submit"), 'id="add_adjustment" class="btn btn-primary" style="padding: 6px 15px; margin:15px 0;"'); ?>
                                <button type="button" class="btn btn-danger" id="reset"><?= lang('reset') ?></div>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>

            </div>

        </div>
    </div>
</div>
