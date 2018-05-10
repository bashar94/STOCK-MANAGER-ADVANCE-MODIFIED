<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
    .table th {
        text-align: center;
    }

    .ctable td {
        text-align: center;
    }

    .table a:hover {
        text-decoration: none;
    }

    .cl_wday {
        text-align: center;
        font-weight: bold;
    }

    .cl_equal {
        width: 14%;
    }

    td.day {
        width: 14%;
        padding: 0 !important;
        vertical-align: top !important;
    }

    .day_num {
        width: 100%;
        text-align: left;
        cursor: pointer;
        margin: 0;
        padding: 8px;
    }

    .day_num:hover {
        background: #F5F5F5;
    }

    .content {
        width: 100%;
        text-align: left;
        color: #428bca;
        padding: 8px;
    }

    .highlight {
        color: #0088CC;
        font-weight: bold;
    }
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-6">
                <div class="small-box padding1010 col-sm-4 bblue">
                    <h3 class="bold"><?= isset($sales->total_amount) ? $this->sma->formatMoney($sales->total_amount) : '0.00' ?></h3>

                    <p class="bold"><?= $sales->total . ' ' . lang('sales') ?></p>
                </div>
                <div class="small-box padding1010 col-sm-4 bdarkGreen">
                    <h3><?= isset($sales->paid) ? $this->sma->formatMoney($sales->paid) : '0.00' ?></h3>

                    <p><?= lang('total_paid') ?></p>
                </div>
                <div class="small-box padding1010 col-sm-4 borange">
                    <h3><?= (isset($sales->total_amount) || isset($sales->paid)) ? $this->sma->formatMoney($sales->total_amount - $sales->paid) : '0.00' ?></h3>

                    <p><?= lang('due_amount') ?></p>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="small-box padding1010 col-sm-4 bblue">
                    <h3 class="bold"><?= isset($purchases->total_amount) ? $this->sma->formatMoney($purchases->total_amount) : '0.00' ?></h3>

                    <p class="bold"><?= $purchases->total . ' ' . lang('purchases') ?></p>
                </div>
                <div class="small-box padding1010 col-sm-4 blightOrange">
                    <h3><?= isset($purchases->paid) ? $this->sma->formatMoney($purchases->paid) : '0.00' ?></h3>

                    <p><?= lang('total_paid') ?></p>
                </div>
                <div class="small-box padding1010 col-sm-4 borange">
                    <h3><?= (isset($purchases->total_amount) || isset($purchases->paid)) ? $this->sma->formatMoney($purchases->total_amount - $purchases->paid) : '0.00' ?></h3>

                    <p><?= lang('due_amount') ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="clear:both;height:20px;"></div>
<ul id="myTab" class="nav nav-tabs no-print">
    <li class=""><a href="#daily-con" class="tab-grey"><?= lang('staff_daily_sales') ?></a></li>
    <li class=""><a href="#monthly-con" class="tab-grey"><?= lang('staff_monthly_sales') ?></a></li>
    <li class=""><a href="#sales-con" class="tab-grey"><?= lang('staff_sales_report') ?></a></li>
    <li class=""><a href="#purchases-con" class="tab-grey"><?= lang('staff_purchases_report') ?></a></li>
    <li class=""><a href="#payments-con" class="tab-grey"><?= lang('staff_payments_report') ?></a></li>
    <li class=""><a href="#logins-con" class="tab-grey"><?= lang('staff_logins_report') ?></a></li>
</ul>

<div class="tab-content">
    <div id="daily-con" class="tab-pane fade in">
        <div class="box">
            <div class="box-header">
                <h2 class="blue"><i class="fa-fw fa fa-calendar nb"></i> <?= lang('daily_sales'); ?></h2>

                <div class="box-icon">
                    <ul class="btn-tasks">
                        <li class="dropdown"><a href="#" id="image" class="tip image" title="<?= lang('save_image') ?>"><i class="icon fa fa-file-picture-o"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="box-content">
                <div class="row">
                    <div class="col-lg-12">

                        <p class="introtext"><?= lang("reports_calendar_text") ?></p>

                        <div>
                            <?= $calender; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div id="monthly-con" class="tab-pane fade in">
        <div class="box">
            <div class="box-header">
                <h2 class="blue"><i class="fa-fw fa fa-calendar nb"></i> <?= lang('monthly_sales'); ?></h2>

                <div class="box-icon">
                    <ul class="btn-tasks">
                        <li class="dropdown"><a href="#" id="pdf1" class="tip" title="<?= lang('download_pdf') ?>"><i
                                    class="icon fa fa-file-pdf-o"></i></a></li>
                        <li class="dropdown"><a href="#" id="image1" class="tip image"
                                                title="<?= lang('save_image') ?>"><i
                                    class="icon fa fa-file-picture-o"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="box-content">
                <div class="row">
                    <div class="col-lg-12">
                        <p class="introtext"><?= lang("reports_calendar_text") ?></p>

                        <div class="table-responsive">
                            <table class="table table-bordered dfTable reports-table">
                                <tr class="year_roller">
                                    <th>
                                        <div class="text-center"><a href="reports/staff_report/<?= $user_id; ?>/<?= $year - 1; ?>/#monthly-con">&lt;&lt;</a>
                                        </div>
                                    </th>
                                    <th colspan="10">
                                        <div class="text-center"> <?= $year; ?> </div>
                                    </td>
                                    <th>
                                        <div class="text-center"><a href="reports/staff_report/<?= $user_id; ?>/<?= $year + 1; ?>/#monthly-con">&gt;&gt;</a>
                                        </div>
                                    </th>
                                    </th>
                                </tr>
                                <tr>
                                    <td><?= lang("cal_january"); ?></td>
                                    <td><?= lang("cal_february"); ?></td>
                                    <td><?= lang("cal_march"); ?></td>
                                    <td><?= lang("cal_april"); ?></td>
                                    <td><?= lang("cal_may"); ?></td>
                                    <td><?= lang("cal_june"); ?></td>
                                    <td><?= lang("cal_july"); ?></td>
                                    <td><?= lang("cal_august"); ?></td>
                                    <td><?= lang("cal_september"); ?></td>
                                    <td><?= lang("cal_october"); ?></td>
                                    <td><?= lang("cal_november"); ?></td>
                                    <td><?= lang("cal_december"); ?></td>
                                </tr>
                                <tr>

                                    <?php
                                    if (!empty($msales)) {

                                        foreach ($msales as $value) {
                                            $array[$value->date] = "<table class='table table-bordered table-hover table-striped table-condensed reports-table data' style='margin:0;'><tr><td>" . lang("product_tax") . "</td></tr><tr><td>" . $this->sma->formatMoney($value->tax1) . "</td></tr><tr><td>" . lang("order_tax") . "</td></tr><tr><td>" . $this->sma->formatMoney($value->tax2) . "</td></tr><tr><td>" . lang("total") . "</td></tr><tr><td>" . $this->sma->formatMoney($value->total) . "</td></tr></table>";
                                        }

                                        for ($i = 1; $i <= 12; $i++) {
                                            echo "<td>";
                                            if (isset($array[$i])) {
                                                echo $array[$i];
                                            } else {
                                                echo '<strong>&nbsp;</strong>';
                                            }
                                            echo "</td>";
                                        }
                                    } else {
                                        for ($i = 1; $i <= 12; $i++) {
                                            echo "<td><strong>0</strong></td>";
                                        }
                                    }
                                    ?>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div id="sales-con" class="tab-pane fade in">

        <?php
        $v = "&user=" . $user_id;
        if ($this->input->post('submit_sale_report')) {
            if ($this->input->post('biller')) {
                $v .= "&biller=" . $this->input->post('biller');
            }
            if ($this->input->post('warehouse')) {
                $v .= "&warehouse=" . $this->input->post('warehouse');
            }
            if ($this->input->post('csutomer')) {
                $v .= "&customer=" . $this->input->post('customer');
            }
            if ($this->input->post('serial')) {
                $v .= "&serial=" . $this->input->post('serial');
            }
            if ($this->input->post('start_date')) {
                $v .= "&start_date=" . $this->input->post('start_date');
            }
            if ($this->input->post('end_date')) {
                $v .= "&end_date=" . $this->input->post('end_date');
            }
        }
        ?>
        <script>
            $(document).ready(function () {
                oTable = $('#SlRData').dataTable({
                    "aaSorting": [[0, "desc"]],
                    "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
                    "iDisplayLength": <?= $Settings->rows_per_page ?>,
                    'bProcessing': true, 'bServerSide': true,
                    'sAjaxSource': '<?= admin_url('reports/getSalesReport/?v=1' . $v) ?>',
                    'fnServerData': function (sSource, aoData, fnCallback) {
                        aoData.push({
                            "name": "<?= $this->security->get_csrf_token_name() ?>",
                            "value": "<?= $this->security->get_csrf_hash() ?>"
                        });
                        $.ajax({ 'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback });
                    },
                    'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                        nRow.id = aData[9];
                        nRow.className = (aData[5] > 0) ? "invoice_link2" : "invoice_link2 warning";
                        return nRow;
                    },
                    "aoColumns": [{"mRender": fld}, null, null, null, {
                        "bSearchable": false,
                        "mRender": pqFormat
                    }, {"mRender": currencyFormat}, {"mRender": currencyFormat}, {"mRender": currencyFormat}, {"mRender": row_status}],
                    "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                        var gtotal = 0, paid = 0, balance = 0;
                        for (var i = 0; i < aaData.length; i++) {
                            gtotal += parseFloat(aaData[aiDisplay[i]][5]);
                            paid += parseFloat(aaData[aiDisplay[i]][6]);
                            balance += parseFloat(aaData[aiDisplay[i]][7]);
                        }
                        var nCells = nRow.getElementsByTagName('th');
                        nCells[5].innerHTML = currencyFormat(parseFloat(gtotal));
                        nCells[6].innerHTML = currencyFormat(parseFloat(paid));
                        nCells[7].innerHTML = currencyFormat(parseFloat(balance));
                    }
                }).fnSetFilteringDelay().dtFilter([
                    {column_number: 0, filter_default_label: "[<?=lang('date');?> (yyyy-mm-dd)]", filter_type: "text", data: []},
                    {column_number: 1, filter_default_label: "[<?=lang('reference_no');?>]", filter_type: "text", data: []},
                    {column_number: 2, filter_default_label: "[<?=lang('biller');?>]", filter_type: "text", data: []},
                    {column_number: 3, filter_default_label: "[<?=lang('customer');?>]", filter_type: "text", data: []},
                    {column_number: 8, filter_default_label: "[<?=lang('payment_status');?>]", filter_type: "text", data: []},
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

        <div class="box">
            <div class="box-header">
                <h2 class="blue"><i class="fa-fw fa fa-heart nb"></i> <?= lang('staff_sales_report'); ?> <?php
                    if ($this->input->post('start_date')) {
                        echo "From " . $this->input->post('start_date') . " to " . $this->input->post('end_date');
                    }
                    ?></h2>

                <div class="box-icon">
                    <ul class="btn-tasks">
                        <li class="dropdown"><a href="#" class="toggle_up tip" title="<?= lang('hide_form') ?>"><i
                                    class="icon fa fa-toggle-up"></i></a></li>
                        <li class="dropdown"><a href="#" class="toggle_down tip" title="<?= lang('show_form') ?>"><i
                                    class="icon fa fa-toggle-down"></i></a></li>
                    </ul>
                </div>
                <div class="box-icon">
                    <ul class="btn-tasks">
                        <li class="dropdown"><a href="#" id="pdf2" class="tip" title="<?= lang('download_pdf') ?>"><i
                                    class="icon fa fa-file-pdf-o"></i></a></li>
                        <li class="dropdown"><a href="#" id="xls2" class="tip" title="<?= lang('download_xls') ?>"><i
                                    class="icon fa fa-file-excel-o"></i></a></li>
                        <li class="dropdown"><a href="#" id="image2" class="tip image"
                                                title="<?= lang('save_image') ?>"><i
                                    class="icon fa fa-file-picture-o"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="box-content">
                <div class="row">
                    <div class="col-lg-12">

                        <p class="introtext"><?= lang('customize_report'); ?></p>

                        <div id="form">

                            <?= admin_form_open("reports/staff_report/" . $user_id . '#sales-con'); ?>
                            <div class="row">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label" for="customer"><?= lang("customer"); ?></label>
                                        <?php
                                        echo form_input('customer', (isset($_POST['customer']) ? $_POST['customer'] : ""), 'class="form-control" id="customer" data-placeholder="' . lang("select") . " " . lang("customer") . '"');
                                        ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label" for="biller"><?= lang("biller"); ?></label>
                                        <?php
                                        $bl[""] = lang('select').' '.lang('biller');
                                        foreach ($billers as $biller) {
                                            $bl[$biller->id] = $biller->company != '-' ? $biller->company : $biller->name;
                                        }
                                        echo form_dropdown('biller', $bl, (isset($_POST['biller']) ? $_POST['biller'] : ""), 'class="form-control" id="biller" data-placeholder="' . lang("select") . " " . lang("biller") . '"');
                                        ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label" for="warehouse"><?= lang("warehouse"); ?></label>
                                        <?php
                                        $wh[""] = lang('select').' '.lang('warehouse');
                                        foreach ($warehouses as $warehouse) {
                                            $wh[$warehouse->id] = $warehouse->name;
                                        }
                                        echo form_dropdown('warehouse', $wh, (isset($_POST['warehouse']) ? $_POST['warehouse'] : ""), 'class="form-control" id="warehouse" data-placeholder="' . lang("select") . " " . lang("warehouse") . '"');
                                        ?>
                                    </div>
                                </div>
                                <?php if($Settings->product_serial) { ?>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <?= lang('serial_no', 'serial'); ?>
                                        <?= form_input('serial', '', 'class="form-control tip" id="serial"'); ?>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <?= lang("start_date", "start_date"); ?>
                                        <?= form_input('start_date', (isset($_POST['start_date']) ? $_POST['start_date'] : ""), 'class="form-control date" id="start_date"'); ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <?= lang("end_date", "end_date"); ?>
                                        <?= form_input('end_date', (isset($_POST['end_date']) ? $_POST['end_date'] : ""), 'class="form-control date" id="end_date"'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div
                                    class="controls"> <?= form_submit('submit_sale_report', lang("submit"), 'class="btn btn-primary"'); ?> </div>
                            </div>
                            <?= form_close(); ?>

                        </div>
                        <div class="clearfix"></div>


                        <div class="table-responsive">
                            <table id="SlRData"
                                   class="table table-bordered table-hover table-striped table-condensed reports-table">
                                <thead>
                                <tr>
                                    <th><?= lang("date"); ?></th>
                                    <th><?= lang("reference_no"); ?></th>
                                    <th><?= lang("biller"); ?></th>
                                    <th><?= lang("customer"); ?></th>
                                    <th><?= lang("product_qty"); ?></th>
                                    <th><?= lang("grand_total"); ?></th>
                                    <th><?= lang("paid"); ?></th>
                                    <th><?= lang("balance"); ?></th>
                                    <th><?= lang("payment_status"); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td colspan="9"
                                        class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                                </tr>

                                </tbody>
                                <tfoot class="dtFilter">
                                <tr class="active">
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><?= lang("product_qty"); ?></th>
                                    <th><?= lang("grand_total"); ?></th>
                                    <th><?= lang("paid"); ?></th>
                                    <th><?= lang("balance"); ?></th>
                                    <th></th>
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
        <?php
        $v1 = "&user=" . $user_id;
        if ($this->input->post('submit_purchase_report')) {
            if ($this->input->post('biller')) {
                $v1 .= "&biller=" . $this->input->post('biller');
            }
            if ($this->input->post('pr_warehouse')) {
                $v1 .= "&warehouse=" . $this->input->post('pr_warehouse');
            }
            if ($this->input->post('supplier')) {
                $v1 .= "&supplier=" . $this->input->post('supplier');
            }
            if ($this->input->post('pr_start_date')) {
                $v1 .= "&start_date=" . $this->input->post('pr_start_date');
            }
            if ($this->input->post('pr_end_date')) {
                $v1 .= "&end_date=" . $this->input->post('pr_end_date');
            }
        }
        ?>
        <script>
            $(document).ready(function () {
                oTable = $('#PoRData').dataTable({
                    "aaSorting": [[0, "desc"]],
                    "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
                    "iDisplayLength": <?= $Settings->rows_per_page ?>,
                    'bProcessing': true, 'bServerSide': true,
                    'sAjaxSource': '<?= admin_url('reports/getPurchasesReport/?v=1' . $v1) ?>',
                    'fnServerData': function (sSource, aoData, fnCallback) {
                        aoData.push({ "name": "<?= $this->security->get_csrf_token_name() ?>", "value": "<?= $this->security->get_csrf_hash() ?>" });
                        $.ajax({ 'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback });
                    },
                    'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                        nRow.id = aData[9];
                        nRow.className = (aData[5] > 0) ? "purchase_link2" : "purchase_link2 warning";
                        return nRow;
                    },
                    "aoColumns": [{"mRender": fld}, null, null, null, {
                        "bSearchable": false,
                        "mRender": pqFormat
                    }, {"mRender": currencyFormat}, {"mRender": currencyFormat}, {"mRender": currencyFormat}, {"mRender": row_status}],
                    "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                        var gtotal = 0, paid = 0, balance = 0;
                        for (var i = 0; i < aaData.length; i++) {
                            gtotal += parseFloat(aaData[aiDisplay[i]][5]);
                            paid += parseFloat(aaData[aiDisplay[i]][6]);
                            balance += parseFloat(aaData[aiDisplay[i]][7]);
                        }
                        var nCells = nRow.getElementsByTagName('th');
                        nCells[5].innerHTML = currencyFormat(parseFloat(gtotal));
                        nCells[6].innerHTML = currencyFormat(parseFloat(paid));
                        nCells[7].innerHTML = currencyFormat(parseFloat(balance));
                    }
                }).fnSetFilteringDelay().dtFilter([
                    {column_number: 0, filter_default_label: "[<?=lang('date');?> (yyyy-mm-dd)]", filter_type: "text", data: []},
                    {column_number: 1, filter_default_label: "[<?=lang('reference_no');?>]", filter_type: "text", data: []},
                    {column_number: 2, filter_default_label: "[<?=lang('warehouse');?>]", filter_type: "text", data: []},
                    {column_number: 3, filter_default_label: "[<?=lang('supplier');?>]", filter_type: "text", data: []},
                    {column_number: 8, filter_default_label: "[<?=lang('status');?>]", filter_type: "text", data: []},
                ], "footer");
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#pform').hide();
                $('.ptoggle_down').click(function () {
                    $("#pform").slideDown();
                    return false;
                });
                $('.ptoggle_up').click(function () {
                    $("#pform").slideUp();
                    return false;
                });
            });
        </script>

        <div class="box">
            <div class="box-header">
                <h2 class="blue"><i class="fa-fw fa fa-star nb"></i><?= lang('staff_purchases_report'); ?> <?php
                    if ($this->input->post('start_date')) {
                        echo "From " . $this->input->post('start_date') . " to " . $this->input->post('end_date');
                    }
                    ?></h2>

                <div class="box-icon">
                    <ul class="btn-tasks">
                        <li class="dropdown"><a href="#" class="ptoggle_up tip" title="<?= lang('hide_form') ?>"><i
                                    class="icon fa fa-toggle-up"></i></a></li>
                        <li class="dropdown"><a href="#" class="ptoggle_down tip" title="<?= lang('show_form') ?>"><i
                                    class="icon fa fa-toggle-down"></i></a></li>
                    </ul>
                </div>
                <div class="box-icon">
                    <ul class="btn-tasks">
                        <li class="dropdown"><a href="#" id="pdf3" class="tip" title="<?= lang('download_pdf') ?>"><i
                                    class="icon fa fa-file-pdf-o"></i></a></li>
                        <li class="dropdown"><a href="#" id="xls3" class="tip" title="<?= lang('download_xls') ?>"><i
                                    class="icon fa fa-file-excel-o"></i></a></li>
                        <li class="dropdown"><a href="#" id="image3" class="tip image"
                                                title="<?= lang('save_image') ?>"><i
                                    class="icon fa fa-file-picture-o"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="box-content">
                <div class="row">
                    <div class="col-lg-12">

                        <p class="introtext"><?= lang('customize_report'); ?></p>

                        <div id="pform">

                            <?= admin_form_open("reports/staff_report/" . $user_id . '#purchases-con'); ?>
                            <div class="row">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label" for="supplier"><?= lang("supplier"); ?></label>
                                        <?php
                                        echo form_input('supplier', (isset($_POST['supplier']) ? $_POST['supplier'] : ""), 'class="form-control" id="supplier" data-placeholder="' . lang("select") . " " . lang("supplier") . '"');
                                        ?>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label" for="pr_warehouse"><?= lang("warehouse"); ?></label>
                                        <?php
                                        $wh[""] = lang('select').' '.lang('warehouse');
                                        foreach ($warehouses as $warehouse) {
                                            $wh[$warehouse->id] = $warehouse->name;
                                        }
                                        echo form_dropdown('pr_warehouse', $wh, (isset($_POST['pr_warehouse']) ? $_POST['pr_warehouse'] : ""), 'class="form-control" id="pr_warehouse" data-placeholder="' . lang("select") . " " . lang("warehouse") . '"');
                                        ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <?= lang("start_date", "pr_start_date"); ?>
                                        <?= form_input('pr_start_date', (isset($_POST['pr_start_date']) ? $_POST['pr_start_date'] : ""), 'class="form-control date" id="pr_start_date"'); ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <?= lang("end_date", "pr_end_date"); ?>
                                        <?= form_input('pr_end_date', (isset($_POST['pr_end_date']) ? $_POST['pr_end_date'] : ""), 'class="form-control date" id="pr_end_date"'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div
                                    class="controls"> <?= form_submit('submit_purchase_report', lang("submit"), 'class="btn btn-primary"'); ?> </div>
                            </div>
                            <?= form_close(); ?>

                        </div>
                        <div class="clearfix"></div>

                        <div class="table-responsive">
                            <table id="PoRData"
                                   class="table table-bordered table-hover table-striped table-condensed reports-table">
                                <thead>
                                <tr>
                                    <th><?= lang("date"); ?></th>
                                    <th><?= lang("reference_no"); ?></th>
                                    <th><?= lang("warehouse"); ?></th>
                                    <th><?= lang("supplier"); ?></th>
                                    <th><?= lang("product_qty"); ?></th>
                                    <th><?= lang("grand_total"); ?></th>
                                    <th><?= lang("paid"); ?></th>
                                    <th><?= lang("balance"); ?></th>
                                    <th><?= lang("status"); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td colspan="9"
                                        class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                                </tr>

                                </tbody>
                                <tfoot class="dtFilter">
                                <tr class="active">
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><?= lang("product_qty"); ?></th>
                                    <th><?= lang("grand_total"); ?></th>
                                    <th><?= lang("paid"); ?></th>
                                    <th><?= lang("balance"); ?></th>
                                    <th></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="payments-con" class="tab-pane fade in">
        <?php
        $p = "&user=" . $user_id;
        if ($this->input->post('submit_payment_report')) {
            if ($this->input->post('pay_start_date')) {
                $p .= "&start_date=" . $this->input->post('pay_start_date');
            }
            if ($this->input->post('psupplier')) {
                $p .= "&supplier=" . $this->input->post('psupplier');
            }
            if ($this->input->post('pcustomer')) {
                $p .= "&customer=" . $this->input->post('pcustomer');
            }
            if ($this->input->post('pay_end_date')) {
                $p .= "&end_date=" . $this->input->post('pay_end_date');
            }
        }
        ?>
        <script>
            $(document).ready(function () {
                var pb = <?= json_encode($pb); ?>;
                function paid_by(x) {
                    return (x != null) ? (pb[x] ? pb[x] : x) : x;
                }

                oTable = $('#PayRData').dataTable({
                    "aaSorting": [[0, "desc"]],
                    "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
                    "iDisplayLength": <?= $Settings->rows_per_page ?>,
                    'bProcessing': true, 'bServerSide': true,
                    'sAjaxSource': '<?= admin_url('reports/getPaymentsReport/?v=1' . $p) ?>',
                    'fnServerData': function (sSource, aoData, fnCallback) {
                        aoData.push({
                            "name": "<?= $this->security->get_csrf_token_name() ?>",
                            "value": "<?= $this->security->get_csrf_hash() ?>"
                        });
                        $.ajax({
                            'dataType': 'json',
                            'type': 'POST',
                            'url': sSource,
                            'data': aoData,
                            'success': fnCallback
                        });
                    },
                    "aoColumns": [{"mRender": fld}, null, null, null, {"mRender": paid_by}, {"mRender": currencyFormat}, {"mRender": row_status}],
                    'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                        nRow.id = aData[7];
                        nRow.className = "payment_link";
                        if (aData[6] == 'sent') {
                            nRow.className = "payment_link2 warning";
                        } else if (aData[6] == 'returned') {
                            nRow.className = "payment_link danger";
                        }
                        return nRow;
                    },
                    "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                        var total = 0;
                        for (var i = 0; i < aaData.length; i++) {
                            total += parseFloat(aaData[aiDisplay[i]][5]);
                        }
                        var nCells = nRow.getElementsByTagName('th');
                        nCells[5].innerHTML = currencyFormat(parseFloat(total));
                    }
                }).fnSetFilteringDelay().dtFilter([
                    {column_number: 0, filter_default_label: "[<?=lang('date');?> (yyyy-mm-dd)]", filter_type: "text", data: []},
                    {column_number: 1, filter_default_label: "[<?=lang('payment_ref');?>]", filter_type: "text", data: []},
                    {column_number: 2, filter_default_label: "[<?=lang('sale_ref');?>]", filter_type: "text", data: []},
                    {
                        column_number: 3,
                        filter_default_label: "[<?=lang('purchase_ref');?>]",
                        filter_type: "text",
                        data: []
                    },
                    {column_number: 4, filter_default_label: "[<?=lang('paid_by');?>]", filter_type: "text", data: []},
                    {column_number: 6, filter_default_label: "[<?=lang('type');?>]", filter_type: "text", data: []},
                ], "footer");
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#payform').hide();
                $('.paytoggle_down').click(function () {
                    $("#payform").slideDown();
                    return false;
                });
                $('.paytoggle_up').click(function () {
                    $("#payform").slideUp();
                    return false;
                });
            });
        </script>
        <div class="box">
            <div class="box-header">
                <h2 class="blue"><i class="fa-fw fa fa-money nb"></i><?= lang('staff_payments_report'); ?> <?php
                    if ($this->input->post('start_date')) {
                        echo "From " . $this->input->post('start_date') . " to " . $this->input->post('end_date');
                    }
                    ?></h2>

                <div class="box-icon">
                    <ul class="btn-tasks">
                        <li class="dropdown"><a href="#" class="paytoggle_up tip" title="<?= lang('hide_form') ?>"><i
                                    class="icon fa fa-toggle-up"></i></a></li>
                        <li class="dropdown"><a href="#" class="paytoggle_down tip" title="<?= lang('hide_form') ?>"><i
                                    class="icon fa fa-toggle-down"></i></a></li>
                    </ul>
                </div>
                <div class="box-icon">
                    <ul class="btn-tasks">
                        <li class="dropdown"><a href="#" id="pdf4" class="tip" title="<?= lang('download_pdf') ?>"><i
                                    class="icon fa fa-file-pdf-o"></i></a></li>
                        <li class="dropdown"><a href="#" id="xls4" class="tip" title="<?= lang('download_xls') ?>"><i
                                    class="icon fa fa-file-excel-o"></i></a></li>
                        <li class="dropdown"><a href="#" id="image4" class="tip image"
                                                title="<?= lang('save_image') ?>"><i
                                    class="icon fa fa-file-picture-o"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="box-content">
                <div class="row">
                    <div class="col-lg-12">

                        <p class="introtext"><?= lang('customize_report'); ?></p>

                        <div id="payform">

                            <?= admin_form_open("reports/staff_report/" . $user_id . '#payments-con'); ?>
                            <div class="row">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label" for="rcustomer"><?= lang("customer"); ?></label>
                                        <?php
                                        echo form_input('pcustomer', (isset($_POST['pcustomer']) ? $_POST['pcustomer'] : ""), 'class="form-control" id="rcustomer" data-placeholder="' . lang("select") . " " . lang("customer") . '"');
                                        ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label" for="rsupplier"><?= lang("supplier"); ?></label>
                                        <?php
                                        echo form_input('psupplier', (isset($_POST['psupplier']) ? $_POST['psupplier'] : ""), 'class="form-control" id="rsupplier" data-placeholder="' . lang("select") . " " . lang("supplier") . '"');
                                        ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <?= lang("start_date", "start_date"); ?>
                                        <?= form_input('pay_start_date', (isset($_POST['pay_start_date']) ? $_POST['pay_start_date'] : ""), 'class="form-control date" id="start_date"'); ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <?= lang("end_date", "end_date"); ?>
                                        <?= form_input('pay_end_date', (isset($_POST['pay_end_date']) ? $_POST['pay_end_date'] : ""), 'class="form-control date" id="end_date"'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div
                                    class="controls"> <?= form_submit('submit_payment_report', lang("submit"), 'class="btn btn-primary"'); ?> </div>
                            </div>
                            <?= form_close(); ?>

                        </div>
                        <div class="clearfix"></div>

                        <div class="table-responsive">
                            <table id="PayRData"
                                   class="table table-bordered table-hover table-striped table-condensed reports-table">

                                <thead>
                                <tr>
                                    <th><?= lang("date"); ?></th>
                                    <th><?= lang("payment_ref"); ?></th>
                                    <th><?= lang("sale_ref"); ?></th>
                                    <th><?= lang("purchase_ref"); ?></th>
                                    <th><?= lang("paid_by"); ?></th>
                                    <th><?= lang("amount"); ?></th>
                                    <th><?= lang("type"); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td colspan="7"
                                        class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                                </tr>
                                </tbody>
                                <tfoot class="dtFilter">
                                <tr class="active">
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><?= lang("amount"); ?></th>
                                    <th></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="logins-con" class="tab-pane fade in">
        <div class="box">
            <div class="box-header">
                <h2 class="blue"><i class="fa-fw fa fa-file-text nb"></i> <?= lang('staff_logins_report'); ?></h2>

                <div class="box-icon">
                    <ul class="btn-tasks">
                        <li class="dropdown"><a href="#" class="logintoggle_up tip" title="<?= lang('hide_form') ?>"><i
                                    class="icon fa fa-toggle-up"></i></a></li>
                        <li class="dropdown"><a href="#" class="logintoggle_down tip"
                                                title="<?= lang('hide_form') ?>"><i class="icon fa fa-toggle-down"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="box-icon">
                    <ul class="btn-tasks">
                        <li class="dropdown"><a href="#" id="pdf5" class="tip" title="<?= lang('download_pdf') ?>"><i
                                    class="icon fa fa-file-pdf-o"></i></a></li>
                        <li class="dropdown"><a href="#" id="xls5" class="tip" title="<?= lang('download_xls') ?>"><i
                                    class="icon fa fa-file-excel-o"></i></a></li>
                        <li class="dropdown"><a href="#" id="image5" class="tip image"
                                                title="<?= lang('save_image') ?>"><i
                                    class="icon fa fa-file-picture-o"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="box-content">
                <div class="row">
                    <div class="col-lg-12">

                        <p class="introtext"><?= lang("staff_logins_report") ?></p>

                        <div id="loginform">

                            <?= admin_form_open("reports/staff_report/" . $user_id . '#logins-con'); ?>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <?= lang("start_date", "start_date"); ?>
                                        <?= form_input('login_start_date', (isset($_POST['login_start_date']) ? $_POST['login_start_date'] : ""), 'class="form-control date" id="start_date"'); ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <?= lang("end_date", "end_date"); ?>
                                        <?= form_input('login_end_date', (isset($_POST['login_end_date']) ? $_POST['login_end_date'] : ""), 'class="form-control date" id="end_date"'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div
                                    class="controls"> <?= form_submit('submit_login_report', lang("submit"), 'class="btn btn-primary"'); ?> </div>
                            </div>
                            <?= form_close(); ?>

                        </div>
                        <div class="clearfix"></div>
                        <div>
                            <?php $l = '';
                            if ($this->input->post('submit_login_report')) {
                                if ($this->input->post('login_start_date')) {
                                    $l .= "&start_date=" . $this->input->post('login_start_date');
                                }
                                if ($this->input->post('login_end_date')) {
                                    $l .= "&end_date=" . $this->input->post('login_end_date');
                                }
                            }
                            ?>
                            <script>
                                $(document).ready(function () {
                                    $('#LGTable').dataTable({
                                        "aaSorting": [[2, "desc"]],
                                        "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
                                        "iDisplayLength": <?= $Settings->rows_per_page ?>,
                                        'bProcessing': true, 'bServerSide': true,
                                        'sAjaxSource': '<?= admin_url('reports/getUserLogins/' . $user_id.'/?v=1'.$l); ?>',
                                        'fnServerData': function (sSource, aoData, fnCallback) {
                                            aoData.push({
                                                "name": "<?= $this->security->get_csrf_token_name(); ?>",
                                                "value": "<?= $this->security->get_csrf_hash() ?>"
                                            });
                                            $.ajax({
                                                'dataType': 'json',
                                                'type': 'POST',
                                                'url': sSource,
                                                'data': aoData,
                                                'success': fnCallback
                                            });
                                        },
                                        "aoColumns": [null, null, {"mRender": fld}]
                                    }).fnSetFilteringDelay().dtFilter([
                                        {
                                            column_number: 0,
                                            filter_default_label: "[<?=lang('email');?>]",
                                            filter_type: "text", data: []
                                        },
                                        {
                                            column_number: 1,
                                            filter_default_label: "[<?=lang('ip_address');?>]",
                                            filter_type: "text", data: []
                                        },
                                        {
                                            column_number: 2,
                                            filter_default_label: "[<?=lang('time');?> (yyyy-mm-dd HH:mm)]",
                                            filter_type: "text", data: []
                                        },
                                    ], "footer");
                                });

                            </script>
                            <script type="text/javascript">
                                $(document).ready(function () {
                                    $('#loginform').hide();
                                    $('.logintoggle_down').click(function () {
                                        $("#loginform").slideDown();
                                        return false;
                                    });
                                    $('.logintoggle_up').click(function () {
                                        $("#loginform").slideUp();
                                        return false;
                                    });
                                });
                            </script>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="LGTable"
                                               class="table table-bordered table-hover table-striped reports-table">
                                            <thead>
                                            <tr>
                                                <th><?= lang('email'); ?></th>
                                                <th><?= lang('ip_address'); ?></th>
                                                <th><?= lang('time'); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td colspan="3"
                                                    class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                                            </tr>
                                            </tbody>
                                            <tfoot class="dtFilter">
                                            <tr class="active">
                                                <th></th>
                                                <th></th>
                                                <th></th>
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
</div>

<script type="text/javascript" src="<?= $assets ?>js/html2canvas.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#pdf').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=admin_url('reports/staff_report/'.$user_id.'/'.$year.'/'.$month.'/pdf')?>";
            return false;
        });
        $('#pdf1').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=admin_url('reports/staff_report/'.$user_id.'/'.$year.'/'.$month.'/pdf/1')?>";
            return false;
        });
        $('#pdf2').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=admin_url('reports/getSalesReport/pdf/?v=1'.$v)?>";
            return false;
        });
        $('#xls2').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=admin_url('reports/getSalesReport/0/xls/?v=1'.$v)?>";
            return false;
        });
        $('#pdf3').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=admin_url('reports/getPurchasesReport/pdf/?v=1'.$v1)?>";
            return false;
        });
        $('#xls3').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=admin_url('reports/getPurchasesReport/0/xls/?v=1'.$v1)?>";
            return false;
        });
        $('#pdf4').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=admin_url('reports/getPaymentsReport/pdf/?v=1'.$p)?>";
            return false;
        });
        $('#xls4').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=admin_url('reports/getPaymentsReport/0/xls/?v=1'.$p)?>";
            return false;
        });
        $('#pdf5').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=admin_url('reports/getUserLogins/'.$user_id.'/pdf/?v=1'.$l)?>";
            return false;
        });
        $('#xls5').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=admin_url('reports/getUserLogins/'.$user_id.'/0/xls?v=1'.$l)?>";
            return false;
        });
        $('.image').click(function (event) {
            var box = $(this).closest('.box');
            event.preventDefault();
            html2canvas(box, {
                onrendered: function (canvas) {
                    openImg(canvas.toDataURL());
                }
            });
            return false;
        });
    });
</script>
