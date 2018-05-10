<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-plus"></i><?= lang('finalize_count'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?php echo lang('enter_info'); ?></p>
                <?php
                $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'id' => 'stForm');
                echo admin_form_open_multipart('products/finalize_count/'.$stock_count->id, $attrib);
                echo form_hidden('count_id', $stock_count->id);
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <?= lang('stock_count'); ?>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-striped table-bordered" style="margin-bottom: 0;">
                                        <tbody>
                                            <tr>
                                                <td><?= lang('warehouse'); ?></td>
                                                <td><?= $warehouse->name.' ( '.$warehouse->code.' )'; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('date'); ?></td>
                                                <td><?= $this->sma->hrld($stock_count->date); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('reference'); ?></td>
                                                <td><?= $stock_count->reference_no; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang('type'); ?></td>
                                                <td><?= lang($stock_count->type); ?></td>
                                            </tr>
                                            <?php if ($stock_count->type == 'partial') { ?>
                                                <tr>
                                                    <td><?= lang('categories'); ?></td>
                                                    <td><?= $stock_count->category_names; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?= lang('brands'); ?></td>
                                                    <td><?= $stock_count->brand_names; ?></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                            <div class="panel panel-default download_csv">
                                <div class="panel-body">
                                    <a href="<?= admin_url('welcome/download/'.$stock_count->initial_file); ?>" class="btn btn-primary pull-right">
                                        <i class="fa fa-download"></i> <?= lang('download_csv_file'); ?>
                                    </a>
                                    <span class="text-success">
                                        <?= lang("csv1"); ?></span><br/><?= lang("csv2"); ?> 
                                        <span class="text-info">
                                            (<?= lang("product_code") . ', ' . lang("product_name") . ', ' . lang("variant") . ', ' . lang("expected") . ', ' . lang("counted"); ?>)
                                        </span>
                                        <?= lang("csv3"); ?><br>
                                        <strong><?= lang('stock_count_tip'); ?></strong>
                                </div>
                            </div>

                                <div class="form-group">
                                    <label for="csv_file"><?= lang("upload_file"); ?></label>
                                    <input type="file" data-browse-label="<?= lang('browse'); ?>" name="csv_file" class="form-control file" data-show-upload="false" data-show-preview="false" id="csv_file" required="required"/>
                                </div>
                                <div class="form-group">
                                    <?= lang("note", "qanote"); ?>
                                    <?php echo form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : ""), 'class="form-control" id="qanote" style="margin-top: 10px; height: 100px;"'); ?>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                        <div class="col-md-12">
                            <div class="fprom-group">
                                <?= form_submit('stock_count', lang("submit"), 'id="stock_count" class="btn btn-primary" style="padding: 6px 15px; margin:15px 0;"'); ?>
                                <button type="button" class="btn btn-danger" id="reset"><?= lang('reset') ?></div>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>

            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#brand option[value=''], #category option[value='']").remove();
        $('.type').on('ifChecked', function(e){
            var type_opt = $(this).val();
            if (type_opt == 'partial')
                $('.partials').slideDown();
            else
                $('.partials').slideUp();
            $('.download_csv').slideDown();
        });
        $("#date").datetimepicker({format: site.dateFormats.js_ldate, fontAwesome: true, language: 'sma', weekStart: 1, todayBtn: 1, autoclose: 1, todayHighlight: 1, startView: 2, forceParse: 0, startDate: "<?= $this->sma->hrld(date('Y-m-d')); ?>"});
        $('#download_csv').click(function(e) {
            e.preventDefault();
            var type = $('input[name=type]:checked').val();
            if (type) {
                var categories = $('#category').val() ? $('#category').val() : 0;
                var brands = $('#brand').val() ? $('#brand').val() : 0;
                $('#csv_file').removeAttr('required');
                $('#stForm').attr('action', site.base_url+'products/download_stock_count_csv').submit();
                // $('#csv_file').attr('required', 'required');

                // $.post(site.base_url+'products/download_stock_count_csv', {type: type, categories: categories, barnds: brands}, function(data, textStatus, xhr) {
                    
                // });
            } else {
                bootbox.alert('<?= lang('please_select_type'); ?>');
            }
        });
        
    });
</script>
