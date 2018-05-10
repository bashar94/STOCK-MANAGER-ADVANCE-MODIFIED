<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php

$v = "";
if ($this->input->post('biller')) {
    $v .= "&biller=" . $this->input->post('biller');
}
if ($this->input->post('warehouse')) {
    $v .= "&warehouse=" . $this->input->post('warehouse');
}
if ($this->input->post('start_date')) {
    $v .= "&start_date=" . $this->input->post('start_date');
}
if ($this->input->post('end_date')) {
    $v .= "&end_date=" . $this->input->post('end_date');
}

?>

<ul id="myTab" class="nav nav-tabs no-print">
    <li class=""><a href="#sales-con" class="tab-grey"><?= lang('sales') ?></a></li>
    <li class=""><a href="#purchases-con" class="tab-grey"><?= lang('purchases') ?></a></li>
</ul>

<div class="tab-content">
    <div id="sales-con" class="tab-pane fade in">
<script>
    $(document).ready(function () {
        oTable = $('#TAXData').dataTable({
            "aaSorting": [[0, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= admin_url('reports/get_sale_taxes/?v=1' . $v) ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                nRow.id = aData[<?= $Settings->indian_gst ? 11 : 8; ?>];
                nRow.className = (aData[2] == 'completed') ? "invoice_link2" : "invoice_link2 warning";
                return nRow;
            },
            "aoColumns": [{"mRender": fld}, null, {"mRender": row_status}, null, null,
            <?php if ($Settings->indian_gst) { ?>
            {"mRender": currencyFormat<?= $Settings->indian_gst ? '' : ", 'bVisible': false"; ?>},
            {"mRender": currencyFormat<?= $Settings->indian_gst ? '' : ", 'bVisible': false"; ?>},
            {"mRender": currencyFormat<?= $Settings->indian_gst ? '' : ", 'bVisible': false"; ?>},
            <?php } ?>
            {"mRender": currencyFormat}, {"mRender": currencyFormat}, {"mRender": currencyFormat}],
            "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                var gtotal = paid = ptax = otax = igst = cgst = sgst = 0;
                for (var i = 0; i < aaData.length; i++) {
                    igst += aaData[aiDisplay[i]][5] != null ? parseFloat(aaData[aiDisplay[i]][5]) : 0;
                    cgst += aaData[aiDisplay[i]][6] != null ? parseFloat(aaData[aiDisplay[i]][6]) : 0;
                    sgst += aaData[aiDisplay[i]][7] != null ? parseFloat(aaData[aiDisplay[i]][7]) : 0;
                    <?php if ($Settings->indian_gst) { ?>
                    ptax += parseFloat(aaData[aiDisplay[i]][8]);
                    otax += parseFloat(aaData[aiDisplay[i]][9]);
                    gtotal += parseFloat(aaData[aiDisplay[i]][10]);
                    <?php } ?>
                    // paid += parseFloat(aaData[aiDisplay[i]][9]);
                }
                var nCells = nRow.getElementsByTagName('th');
                nCells[5].innerHTML = currencyFormat(parseFloat(igst));
                nCells[6].innerHTML = currencyFormat(parseFloat(cgst));
                nCells[7].innerHTML = currencyFormat(parseFloat(sgst));
                <?php if ($Settings->indian_gst) { ?>
                nCells[8].innerHTML = currencyFormat(parseFloat(ptax));
                nCells[9].innerHTML = currencyFormat(parseFloat(otax));
                nCells[10].innerHTML = currencyFormat(parseFloat(gtotal));
                <?php } ?>
                // nCells[9].innerHTML = currencyFormat(parseFloat(paid));
            }
        }).fnSetFilteringDelay().dtFilter([
            {column_number: 0, filter_default_label: "[<?=lang('date');?> (yyyy-mm-dd)]", filter_type: "text", data: []},
            {column_number: 1, filter_default_label: "[<?=lang('reference_no');?>]", filter_type: "text", data: []},
            {column_number: 2, filter_default_label: "[<?=lang('status');?>]", filter_type: "text", data: []},
            {column_number: 3, filter_default_label: "[<?=lang('warehouse');?>]", filter_type: "text", data: []},
            {column_number: 4, filter_default_label: "[<?=lang('biller');?>]", filter_type: "text", data: []},
        ], "footer");
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#form').hide();
        $('.toggle_down').click(function () {
            $("#form").slideDown();
            return false;
        });
        $('.toggle_up').click(function () {
            $("#form").slideUp();
            return false;
        });
    });
</script>


<div class="box box1">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-heart nb"></i><?= lang('sales_tax_report'); ?> <?php
            if ($this->input->post('start_date')) {
                echo "From " . $this->input->post('start_date') . " to " . $this->input->post('end_date');
            }
            ?>
        </h2>

        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a href="#" class="toggle_up tip" title="<?= lang('hide_form') ?>">
                        <i class="icon fa fa-toggle-up"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="toggle_down tip" title="<?= lang('show_form') ?>">
                        <i class="icon fa fa-toggle-down"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a href="#" id="xls" class="tip" title="<?= lang('download_xls') ?>">
                        <i class="icon fa fa-file-excel-o"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" id="image" class="tip" title="<?= lang('save_image') ?>">
                        <i class="icon fa fa-file-picture-o"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?= lang('customize_report'); ?></p>

                <div id="form">

                    <?php echo admin_form_open("reports/tax"); ?>
                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label" for="biller"><?= lang("biller"); ?></label>
                                <?php
                                $bl[""] = lang('select').' '.lang('biller');
                                foreach ($billers as $biller) {
                                    $bl[$biller->id] = $biller->company != '-' ? $biller->company : $biller->name;
                                }
                                echo form_dropdown('biller', $bl, (isset($_POST['biller']) ? $_POST['biller'] : ""), 'class="form-control" id="biller" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("biller") . '"');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label" for="warehouse"><?= lang("warehouse"); ?></label>
                                <?php
                                $wh[""] = lang('select').' '.lang('warehouse');
                                foreach ($warehouses as $warehouse) {
                                    $wh[$warehouse->id] = $warehouse->name;
                                }
                                echo form_dropdown('warehouse', $wh, (isset($_POST['warehouse']) ? $_POST['warehouse'] : ""), 'class="form-control" id="warehouse" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("warehouse") . '"');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <?= lang("start_date", "start_date"); ?>
                                <?php echo form_input('start_date', (isset($_POST['start_date']) ? $_POST['start_date'] : ""), 'class="form-control date" id="start_date"'); ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <?= lang("end_date", "end_date"); ?>
                                <?php echo form_input('end_date', (isset($_POST['end_date']) ? $_POST['end_date'] : ""), 'class="form-control date" id="end_date"'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div
                            class="controls"> <?php echo form_submit('submit_report', $this->lang->line("submit"), 'class="btn btn-primary"'); ?> </div>
                    </div>
                    <?php echo form_close(); ?>

                </div>
                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-sm-12">
                        <?php if ($Settings->indian_gst) { ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <?php } ?>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="small-box padding1010 bblue">
                                            <h3><?= isset($sale_tax->grand_total) ? $this->sma->formatMoney($sale_tax->grand_total) : '0.00' ?></h3>
                                            <p><?= lang('sales_amount') ?></p>
                                        </div>
                                    </div>
                                    <!-- <div class="col-sm-3">
                                        <div class="small-box padding1010 bdarkGreen">
                                            <h3><?= isset($sale_tax->paid) ? $this->sma->formatMoney($sale_tax->paid) : '0.00' ?></h3>
                                            <p><?= lang('received_payment') ?></p>
                                        </div>
                                    </div> -->
                                    <div class="col-sm-4">
                                        <div class="small-box padding1010 bpurple">
                                            <h3><?= isset($sale_tax->product_tax) ? $this->sma->formatMoney($sale_tax->product_tax) : '0.00' ?></h3>
                                            <p><?= lang('total_product_tax') ?></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="small-box padding1010 borange">
                                            <h3><?= isset($sale_tax->order_tax) ? $this->sma->formatMoney($sale_tax->order_tax) : '0.00' ?></h3>
                                            <p><?= lang('total_order_tax') ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($Settings->indian_gst) { ?>
                            </div>
                            <div class="col-sm-6">
                                <div class="small-box col-sm-4 padding1010 bdarkGreen">
                                    <h3><?= isset($sale_tax->igst) ? $this->sma->formatMoney($sale_tax->igst) : '0.00' ?></h3>
                                    <p><?= lang('igst') ?></p>
                                </div>
                                <div class="small-box col-sm-4 padding1010 bpurple">
                                    <h3><?= isset($sale_tax->cgst) ? $this->sma->formatMoney($sale_tax->cgst) : '0.00' ?></h3>
                                    <p><?= lang('cgst') ?></p>
                                </div>
                                <div class="small-box col-sm-4 padding1010 borange">
                                    <h3><?= isset($sale_tax->sgst) ? $this->sma->formatMoney($sale_tax->sgst) : '0.00' ?></h3>
                                    <p><?= lang('sgst') ?></p>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="clearfix"></div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="TAXData"
                           class="table table-bordered table-hover table-striped table-condensed reports-table">
                        <thead>
                        <tr>
                            <th style="min-width:150px !important;"><?= lang("date"); ?></th>
                            <th style="min-width:150px !important;"><?= lang("reference_no"); ?></th>
                            <th style="min-width:80px !important;"><?= lang("status"); ?></th>
                            <th style="min-width:150px !important;"><?= lang("warehouse"); ?></th>
                            <th style="min-width:150px !important;"><?= lang("biller"); ?></th>
                            <?php if ($Settings->indian_gst) { ?>
                            <th style="min-width:80px !important;"><?= lang("igst"); ?></th>
                            <th style="min-width:80px !important;"><?= lang("cgst"); ?></th>
                            <th style="min-width:80px !important;"><?= lang("sgst"); ?></th>
                            <?php } ?>
                            <th style="min-width:80px !important;"><?= lang("product_tax"); ?></th>
                            <th style="min-width:80px !important;"><?= lang("order_tax"); ?></th>
                            <th style="min-width:120px !important;"><?= lang("grand_total"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="11" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                        </tr>
                        </tbody>
                        <tfoot class="dtFilter">
                        <tr class="active">
                            <th style="min-width:150px !important;"></th>
                            <th style="min-width:150px !important;"></th>
                            <th style="min-width:80px !important;"></th>
                            <th style="min-width:150px !important;"></th>
                            <th style="min-width:150px !important;"></th>
                            <?php if ($Settings->indian_gst) { ?>
                            <th style="min-width:80px !important;"></th>
                            <th style="min-width:80px !important;"></th>
                            <th style="min-width:80px !important;"></th>
                            <?php } ?>
                            <th style="min-width:80px !important;"><?= lang("product_tax"); ?></th>
                            <th style="min-width:80px !important;"><?= lang("order_tax"); ?></th>
                            <th style="min-width:120px !important;"><?= lang("grand_total"); ?></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div id="purchases-con" class="tab-pane fade in">

    <script type="text/javascript">
        $(document).ready(function () {
            $('#purchaseform').hide();
            $('.purchasetoggle_down').click(function () {
                $("#purchaseform").slideDown();
                return false;
            });
            $('.purchasetoggle_up').click(function () {
                $("#purchaseform").slideUp();
                return false;
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            oTable = $('#PTAXData').dataTable({
                "aaSorting": [[0, "desc"]],
                "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
                "iDisplayLength": <?= $Settings->rows_per_page ?>,
                'bProcessing': true, 'bServerSide': true,
                'sAjaxSource': '<?= admin_url('reports/get_purchase_taxes/?v=1' . $v) ?>',
                'fnServerData': function (sSource, aoData, fnCallback) {
                    aoData.push({
                        "name": "<?= $this->security->get_csrf_token_name() ?>",
                        "value": "<?= $this->security->get_csrf_hash() ?>"
                    });
                    $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
                },
                'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                    nRow.id = aData[<?= $Settings->indian_gst ? 11 : 8; ?>];
                    nRow.className = (aData[2] == 'received') ? "purchase_link" : "purchase_link warning";
                    return nRow;
                },
                "aoColumns": [{"mRender": fld}, null, {"mRender": row_status}, null, null,
                <?php if ($Settings->indian_gst) { ?>
                {"mRender": currencyFormat<?= $Settings->indian_gst ? '' : ", 'bVisible': false"; ?>},
                {"mRender": currencyFormat<?= $Settings->indian_gst ? '' : ", 'bVisible': false"; ?>},
                {"mRender": currencyFormat<?= $Settings->indian_gst ? '' : ", 'bVisible': false"; ?>},
                <?php } ?>
                {"mRender": currencyFormat}, {"mRender": currencyFormat}, {"mRender": currencyFormat}],
                "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                    var gtotal = paid = ptax = otax = igst = cgst = sgst = 0;
                    for (var i = 0; i < aaData.length; i++) {
                        igst += aaData[aiDisplay[i]][5] != null ? parseFloat(aaData[aiDisplay[i]][5]) : 0;
                        cgst += aaData[aiDisplay[i]][6] != null ? parseFloat(aaData[aiDisplay[i]][6]) : 0;
                        sgst += aaData[aiDisplay[i]][7] != null ? parseFloat(aaData[aiDisplay[i]][7]) : 0;
                        <?php if ($Settings->indian_gst) { ?>
                        ptax += parseFloat(aaData[aiDisplay[i]][8]);
                        otax += parseFloat(aaData[aiDisplay[i]][9]);
                        gtotal += parseFloat(aaData[aiDisplay[i]][10]);
                        <?php } ?>
                        // paid += parseFloat(aaData[aiDisplay[i]][10]);
                    }
                    var nCells = nRow.getElementsByTagName('th');
                    nCells[5].innerHTML = currencyFormat(parseFloat(igst));
                    nCells[6].innerHTML = currencyFormat(parseFloat(cgst));
                    nCells[7].innerHTML = currencyFormat(parseFloat(sgst));
                    <?php if ($Settings->indian_gst) { ?>
                    nCells[8].innerHTML = currencyFormat(parseFloat(ptax));
                    nCells[9].innerHTML = currencyFormat(parseFloat(otax));
                    nCells[10].innerHTML = currencyFormat(parseFloat(gtotal));
                    <?php } ?>
                    // nCells[10].innerHTML = currencyFormat(parseFloat(paid));
                }
            }).fnSetFilteringDelay().dtFilter([
                {column_number: 0, filter_default_label: "[<?=lang('date');?> (yyyy-mm-dd)]", filter_type: "text", data: []},
                {column_number: 1, filter_default_label: "[<?=lang('reference_no');?>]", filter_type: "text", data: []},
                {column_number: 2, filter_default_label: "[<?=lang('status');?>]", filter_type: "text", data: []},
                {column_number: 3, filter_default_label: "[<?=lang('warehouse');?>]", filter_type: "text", data: []},
                {column_number: 4, filter_default_label: "[<?=lang('supplier');?>]", filter_type: "text", data: []},
            ], "footer");
        });
    </script>
    <div class="box box2">
        <div class="box-header">
            <h2 class="blue"><i class="fa-fw fa fa-star nb"></i><?= lang('purchases_tax_report'); ?> <?php
            if ($this->input->post('start_date')) {
                echo "From " . $this->input->post('start_date') . " to " . $this->input->post('end_date');
            }
            ?>
        </h2>

        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a href="#" class="purchasetoggle_up tip" title="<?= lang('hide_form') ?>">
                        <i class="icon fa fa-toggle-up"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="purchasetoggle_down tip" title="<?= lang('show_form') ?>">
                        <i class="icon fa fa-toggle-down"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a href="#" id="xls1" class="tip" title="<?= lang('download_xls') ?>">
                        <i class="icon fa fa-file-excel-o"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" id="image1" class="tip" title="<?= lang('save_image') ?>">
                        <i class="icon fa fa-file-picture-o"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?= lang('customize_report'); ?></p>

                <div id="purchaseform">

                    <?php echo admin_form_open("reports/tax"); ?>
                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label" for="biller"><?= lang("biller"); ?></label>
                                <?php
                                $bl[""] = lang('select').' '.lang('biller');
                                foreach ($billers as $biller) {
                                    $bl[$biller->id] = $biller->company != '-' ? $biller->company : $biller->name;
                                }
                                echo form_dropdown('biller', $bl, (isset($_POST['biller']) ? $_POST['biller'] : ""), 'class="form-control" id="biller" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("biller") . '"');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label" for="warehouse"><?= lang("warehouse"); ?></label>
                                <?php
                                $wh[""] = lang('select').' '.lang('warehouse');
                                foreach ($warehouses as $warehouse) {
                                    $wh[$warehouse->id] = $warehouse->name;
                                }
                                echo form_dropdown('warehouse', $wh, (isset($_POST['warehouse']) ? $_POST['warehouse'] : ""), 'class="form-control" id="warehouse" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("warehouse") . '"');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <?= lang("start_date", "start_date"); ?>
                                <?php echo form_input('start_date', (isset($_POST['start_date']) ? $_POST['start_date'] : ""), 'class="form-control date" id="start_date"'); ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <?= lang("end_date", "end_date"); ?>
                                <?php echo form_input('end_date', (isset($_POST['end_date']) ? $_POST['end_date'] : ""), 'class="form-control date" id="end_date"'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div
                            class="controls"> <?php echo form_submit('submit_report', $this->lang->line("submit"), 'class="btn btn-primary"'); ?> </div>
                    </div>
                    <?php echo form_close(); ?>

                </div>
                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-sm-12">
                        <?php if ($Settings->indian_gst) { ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <?php } ?>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="small-box padding1010 bblue">
                                            <h3><?= isset($purchase_tax->grand_total) ? $this->sma->formatMoney($purchase_tax->grand_total) : '0.00' ?></h3>
                                            <p><?= lang('sales_amount') ?></p>
                                        </div>
                                    </div>
                                    <!-- <div class="col-sm-3">
                                        <div class="small-box padding1010 bdarkGreen">
                                            <h3><?= isset($purchase_tax->paid) ? $this->sma->formatMoney($purchase_tax->paid) : '0.00' ?></h3>
                                            <p><?= lang('received_payment') ?></p>
                                        </div>
                                    </div> -->
                                    <div class="col-sm-4">
                                        <div class="small-box padding1010 bpurple">
                                            <h3><?= isset($purchase_tax->product_tax) ? $this->sma->formatMoney($purchase_tax->product_tax) : '0.00' ?></h3>
                                            <p><?= lang('total_product_tax') ?></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="small-box padding1010 borange">
                                            <h3><?= isset($purchase_tax->order_tax) ? $this->sma->formatMoney($purchase_tax->order_tax) : '0.00' ?></h3>
                                            <p><?= lang('total_order_tax') ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($Settings->indian_gst) { ?>
                            </div>
                            <div class="col-sm-6">
                                <div class="small-box col-sm-4 padding1010 bdarkGreen">
                                    <h3><?= isset($purchase_tax->igst) ? $this->sma->formatMoney($purchase_tax->igst) : '0.00' ?></h3>
                                    <p><?= lang('igst') ?></p>
                                </div>
                                <div class="small-box col-sm-4 padding1010 bpurple">
                                    <h3><?= isset($purchase_tax->cgst) ? $this->sma->formatMoney($purchase_tax->cgst) : '0.00' ?></h3>
                                    <p><?= lang('cgst') ?></p>
                                </div>
                                <div class="small-box col-sm-4 padding1010 borange">
                                    <h3><?= isset($purchase_tax->sgst) ? $this->sma->formatMoney($purchase_tax->sgst) : '0.00' ?></h3>
                                    <p><?= lang('sgst') ?></p>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="clearfix"></div>

                        <div class="table-responsive">
                            <table id="PTAXData"
                                   class="table table-bordered table-hover table-striped table-condensed reports-table">
                                <thead>
                                <tr>
                                    <th style="min-width:150px !important;"><?= lang("date"); ?></th>
                                    <th style="min-width:150px !important;"><?= lang("reference_no"); ?></th>
                                    <th style="min-width:80px !important;"><?= lang("status"); ?></th>
                                    <th style="min-width:150px !important;"><?= lang("warehouse"); ?></th>
                                    <th style="min-width:150px !important;"><?= lang("supplier"); ?></th>
                                    <?php if ($Settings->indian_gst) { ?>
                                    <th style="min-width:80px !important;"><?= lang("igst"); ?></th>
                                    <th style="min-width:80px !important;"><?= lang("cgst"); ?></th>
                                    <th style="min-width:80px !important;"><?= lang("sgst"); ?></th>
                                    <?php } ?>
                                    <th style="min-width:80px !important;"><?= lang("product_tax"); ?></th>
                                    <th style="min-width:80px !important;"><?= lang("order_tax"); ?></th>
                                    <th style="min-width:120px !important;"><?= lang("grand_total"); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td colspan="9" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                                </tr>
                                </tbody>
                                <tfoot class="dtFilter">
                                <tr class="active">
                                    <th style="min-width:150px !important;"></th>
                                    <th style="min-width:150px !important;"></th>
                                    <th style="min-width:80px !important;"></th>
                                    <th style="min-width:150px !important;"></th>
                                    <th style="min-width:150px !important;"></th>
                                    <?php if ($Settings->indian_gst) { ?>
                                    <th style="min-width:80px !important;"></th>
                                    <th style="min-width:80px !important;"></th>
                                    <th style="min-width:80px !important;"></th>
                                    <?php } ?>
                                    <th style="min-width:80px !important;"><?= lang("product_tax"); ?></th>
                                    <th style="min-width:80px !important;"><?= lang("order_tax"); ?></th>
                                    <th style="min-width:120px !important;"><?= lang("grand_total"); ?></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<script type="text/javascript" src="<?= $assets ?>js/html2canvas.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#xls').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=admin_url('reports/get_sale_taxes/0/xls/?v=1'.$v)?>";
            return false;
        });
        $('#xls1').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=admin_url('reports/get_purchase_taxes/0/xls/?v=1'.$v)?>";
            return false;
        });
        $('#image').click(function (event) {
            event.preventDefault();
            html2canvas($('.box1'), {
                onrendered: function (canvas) {
                    openImg(canvas.toDataURL());
                }
            });
            return false;
        });
        $('#image1').click(function (event) {
            event.preventDefault();
            html2canvas($('.box2'), {
                onrendered: function (canvas) {
                    openImg(canvas.toDataURL());
                }
            });
            return false;
        });
    });
</script>
