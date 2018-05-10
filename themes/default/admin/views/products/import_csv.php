<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-plus"></i><?= lang('import_products_by_csv'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <?php
                $attrib = array('class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form');
                echo admin_form_open_multipart("products/import_csv", $attrib)
                ?>
                <div class="row">
                    <div class="col-md-12">

                        <div class="well well-small">
                            <a href="<?php echo base_url(); ?>assets/csv/sample_products.csv"
                               class="btn btn-primary pull-right"><i
                                    class="fa fa-download"></i> <?= lang("download_sample_file") ?></a>
                            <span class="text-warning"><?= lang("csv1"); ?></span><br/><?= lang("csv2"); ?> <span
                                class="text-info">(<?= lang("name") . ', ' . lang("code") . ', ' . lang("barcode_symbology") . ', ' .  lang("brand") . ', ' . lang("category_code") . ', ' . lang("unit_code") . ', ' . lang("sale").' '.lang('unit_code') . ', ' . lang("purchase").' '.lang("unit_code") . ', ' .  lang("cost") . ', ' . lang("price") . ', ' . lang("alert_quantity") . ', ' . lang("tax") . ', ' . lang("tax_method") . ', ' . lang("image") . ', ' . lang("subcategory_code") . ', ' . lang("product_variants_sep_by"). ', ' . lang("pcf1"). ', ' . lang("pcf2"). ', ' . lang("pcf3"). ', ' . lang("pcf4"). ', ' . lang("pcf5"). ', ' . lang("pcf6"). ', ' . lang("hsn_code"); ?>
                                )</span> <?= lang("csv3"); ?>
                                <p><?= lang('images_location_tip'); ?></p>

                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="csv_file"><?= lang("upload_file"); ?></label>
                                <input type="file" data-browse-label="<?= lang('browse'); ?>" name="userfile" class="form-control file" data-show-upload="false" data-show-preview="false" id="csv_file" required="required"/>
                            </div>

                            <div class="form-group">
                                <?php echo form_submit('import', $this->lang->line("import"), 'class="btn btn-primary"'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>
