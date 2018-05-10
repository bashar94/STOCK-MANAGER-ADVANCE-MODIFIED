<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
function row_status($x)
{
    if ($x == null) {
        return '';
    } elseif ($x == 'pending') {
        return '<div class="text-center"><span class="label label-warning">' . lang($x) . '</span></div>';
    } elseif ($x == 'completed' || $x == 'paid' || $x == 'sent' || $x == 'received') {
        return '<div class="text-center"><span class="label label-success">' . lang($x) . '</span></div>';
    } elseif ($x == 'partial' || $x == 'transferring') {
        return '<div class="text-center"><span class="label label-info">' . lang($x) . '</span></div>';
    } elseif ($x == 'due') {
        return '<div class="text-center"><span class="label label-danger">' . lang($x) . '</span></div>';
    } else {
        return '<div class="text-center"><span class="label label-default">' . lang($x) . '</span></div>';
    }
}

?>
<?php if (($Owner || $Admin) && $chatData) {
    foreach ($chatData as $month_sale) {
        $months[] = date('M-Y', strtotime($month_sale->month));
        $msales[] = $month_sale->sales;
        $mtax1[] = $month_sale->tax1;
        $mtax2[] = $month_sale->tax2;
        $mpurchases[] = $month_sale->purchases;
        $mtax3[] = $month_sale->ptax;
    }
    ?>
    <div class="box" style="margin-bottom: 15px;">
        <div class="box-header">
            <h2 class="blue"><i class="fa-fw fa fa-bar-chart-o"></i><?= lang('overview_chart'); ?></h2>
        </div>
        <div class="box-content">
            <div class="row">
                <div class="col-md-12">
                    <p class="introtext"><?php echo lang('overview_chart_heading'); ?></p>

                    <div id="ov-chart" style="width:100%; height:450px;"></div>
                    <p class="text-center"><?= lang("chart_lable_toggle"); ?></p>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Owner || $Admin) { ?>
<div class="row" style="margin-bottom: 15px;">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header">
                <h2 class="blue"><i class="fa fa-th"></i><span class="break"></span><?= lang('quick_links') ?></h2>
            </div>
            <div class="box-content">
                <div class="col-lg-1 col-md-2 col-xs-6">
                    <a class="bblue white quick-button small" href="<?= admin_url('products') ?>">
                        <i class="fa fa-barcode"></i>

                        <p><?= lang('products') ?></p>
                    </a>
                </div>
                <div class="col-lg-1 col-md-2 col-xs-6">
                    <a class="bdarkGreen white quick-button small" href="<?= admin_url('sales') ?>">
                        <i class="fa fa-heart"></i>

                        <p><?= lang('sales') ?></p>
                    </a>
                </div>

                <div class="col-lg-1 col-md-2 col-xs-6">
                    <a class="blightOrange white quick-button small" href="<?= admin_url('quotes') ?>">
                        <i class="fa fa-heart-o"></i>

                        <p><?= lang('quotes') ?></p>
                    </a>
                </div>

                <div class="col-lg-1 col-md-2 col-xs-6">
                    <a class="bred white quick-button small" href="<?= admin_url('purchases') ?>">
                        <i class="fa fa-star"></i>

                        <p><?= lang('purchases') ?></p>
                    </a>
                </div>

                <div class="col-lg-1 col-md-2 col-xs-6">
                    <a class="bpink white quick-button small" href="<?= admin_url('transfers') ?>">
                        <i class="fa fa-star-o"></i>

                        <p><?= lang('transfers') ?></p>
                    </a>
                </div>

                <div class="col-lg-1 col-md-2 col-xs-6">
                    <a class="bgrey white quick-button small" href="<?= admin_url('customers') ?>">
                        <i class="fa fa-users"></i>

                        <p><?= lang('customers') ?></p>
                    </a>
                </div>

                <div class="col-lg-1 col-md-2 col-xs-6">
                    <a class="bgrey white quick-button small" href="<?= admin_url('suppliers') ?>">
                        <i class="fa fa-users"></i>

                        <p><?= lang('suppliers') ?></p>
                    </a>
                </div>

                <div class="col-lg-1 col-md-2 col-xs-6">
                    <a class="blightBlue white quick-button small" href="<?= admin_url('notifications') ?>">
                        <i class="fa fa-comments"></i>

                        <p><?= lang('notifications') ?></p>
                        <!--<span class="notification green">4</span>-->
                    </a>
                </div>

                <?php if ($Owner) { ?>
                    <div class="col-lg-1 col-md-2 col-xs-6">
                        <a class="bblue white quick-button small" href="<?= admin_url('auth/users') ?>">
                            <i class="fa fa-group"></i>
                            <p><?= lang('users') ?></p>
                        </a>
                    </div>
                    <div class="col-lg-1 col-md-2 col-xs-6">
                        <a class="bblue white quick-button small" href="<?= admin_url('system_settings') ?>">
                            <i class="fa fa-cogs"></i>

                            <p><?= lang('settings') ?></p>
                        </a>
                    </div>
                <?php } ?>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<?php } else { ?>
<div class="row" style="margin-bottom: 15px;">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header">
                <h2 class="blue"><i class="fa fa-th"></i><span class="break"></span><?= lang('quick_links') ?></h2>
            </div>
            <div class="box-content">
            <?php if ($GP['products-index']) { ?>
                <div class="col-lg-1 col-md-2 col-xs-6">
                    <a class="bblue white quick-button small" href="<?= admin_url('products') ?>">
                        <i class="fa fa-barcode"></i>
                        <p><?= lang('products') ?></p>
                    </a>
                </div>
            <?php } if ($GP['sales-index']) { ?>
                <div class="col-lg-1 col-md-2 col-xs-6">
                    <a class="bdarkGreen white quick-button small" href="<?= admin_url('sales') ?>">
                        <i class="fa fa-heart"></i>
                        <p><?= lang('sales') ?></p>
                    </a>
                </div>
            <?php } if ($GP['quotes-index']) { ?>
                <div class="col-lg-1 col-md-2 col-xs-6">
                    <a class="blightOrange white quick-button small" href="<?= admin_url('quotes') ?>">
                        <i class="fa fa-heart-o"></i>
                        <p><?= lang('quotes') ?></p>
                    </a>
                </div>
            <?php } if ($GP['purchases-index']) { ?>
                <div class="col-lg-1 col-md-2 col-xs-6">
                    <a class="bred white quick-button small" href="<?= admin_url('purchases') ?>">
                        <i class="fa fa-star"></i>
                        <p><?= lang('purchases') ?></p>
                    </a>
                </div>
            <?php } if ($GP['transfers-index']) { ?>
                <div class="col-lg-1 col-md-2 col-xs-6">
                    <a class="bpink white quick-button small" href="<?= admin_url('transfers') ?>">
                        <i class="fa fa-star-o"></i>
                        <p><?= lang('transfers') ?></p>
                    </a>
                </div>
            <?php } if ($GP['customers-index']) { ?>
                <div class="col-lg-1 col-md-2 col-xs-6">
                    <a class="bgrey white quick-button small" href="<?= admin_url('customers') ?>">
                        <i class="fa fa-users"></i>
                        <p><?= lang('customers') ?></p>
                    </a>
                </div>
            <?php } if ($GP['suppliers-index']) { ?>
                <div class="col-lg-1 col-md-2 col-xs-6">
                    <a class="bgrey white quick-button small" href="<?= admin_url('suppliers') ?>">
                        <i class="fa fa-users"></i>

                        <p><?= lang('suppliers') ?></p>
                    </a>
                </div>
            <?php } ?>
            <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<div class="row" style="margin-bottom: 15px;">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h2 class="blue"><i class="fa-fw fa fa-tasks"></i> <?= lang('latest_five') ?></h2>
            </div>
            <div class="box-content">
                <div class="row">
                    <div class="col-md-12">

                        <ul id="dbTab" class="nav nav-tabs">
                            <?php if ($Owner || $Admin || $GP['sales-index']) { ?>
                            <li class=""><a href="#sales"><?= lang('sales') ?></a></li>
                            <?php } if ($Owner || $Admin || $GP['quotes-index']) { ?>
                            <li class=""><a href="#quotes"><?= lang('quotes') ?></a></li>
                            <?php } if ($Owner || $Admin || $GP['purchases-index']) { ?>
                            <li class=""><a href="#purchases"><?= lang('purchases') ?></a></li>
                            <?php } if ($Owner || $Admin || $GP['transfers-index']) { ?>
                            <li class=""><a href="#transfers"><?= lang('transfers') ?></a></li>
                            <?php } if ($Owner || $Admin || $GP['customers-index']) { ?>
                            <li class=""><a href="#customers"><?= lang('customers') ?></a></li>
                            <?php } if ($Owner || $Admin || $GP['suppliers-index']) { ?>
                            <li class=""><a href="#suppliers"><?= lang('suppliers') ?></a></li>
                            <?php } ?>
                        </ul>

                        <div class="tab-content">
                        <?php if ($Owner || $Admin || $GP['sales-index']) { ?>

                            <div id="sales" class="tab-pane fade in">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table id="sales-tbl" cellpadding="0" cellspacing="0" border="0"
                                                   class="table table-bordered table-hover table-striped"
                                                   style="margin-bottom: 0;">
                                                <thead>
                                                <tr>
                                                    <th style="width:30px !important;">#</th>
                                                    <th><?= $this->lang->line("date"); ?></th>
                                                    <th><?= $this->lang->line("reference_no"); ?></th>
                                                    <th><?= $this->lang->line("customer"); ?></th>
                                                    <th><?= $this->lang->line("status"); ?></th>
                                                    <th><?= $this->lang->line("total"); ?></th>
                                                    <th><?= $this->lang->line("payment_status"); ?></th>
                                                    <th><?= $this->lang->line("paid"); ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if (!empty($sales)) {
                                                    $r = 1;
                                                    foreach ($sales as $order) {
                                                        echo '<tr id="' . $order->id . '" class="' . ($order->pos ? "receipt_link" : "invoice_link") . '"><td>' . $r . '</td>
                                                            <td>' . $this->sma->hrld($order->date) . '</td>
                                                            <td>' . $order->reference_no . '</td>
                                                            <td>' . $order->customer . '</td>
                                                            <td>' . row_status($order->sale_status) . '</td>
                                                            <td class="text-right">' . $this->sma->formatMoney($order->grand_total) . '</td>
                                                            <td>' . row_status($order->payment_status) . '</td>
                                                            <td class="text-right">' . $this->sma->formatMoney($order->paid) . '</td>
                                                        </tr>';
                                                        $r++;
                                                    }
                                                } else { ?>
                                                    <tr>
                                                        <td colspan="7"
                                                            class="dataTables_empty"><?= lang('no_data_available') ?></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php } if ($Owner || $Admin || $GP['quotes-index']) { ?>

                            <div id="quotes" class="tab-pane fade">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table id="quotes-tbl" cellpadding="0" cellspacing="0" border="0"
                                                   class="table table-bordered table-hover table-striped"
                                                   style="margin-bottom: 0;">
                                                <thead>
                                                <tr>
                                                    <th style="width:30px !important;">#</th>
                                                    <th><?= $this->lang->line("date"); ?></th>
                                                    <th><?= $this->lang->line("reference_no"); ?></th>
                                                    <th><?= $this->lang->line("customer"); ?></th>
                                                    <th><?= $this->lang->line("status"); ?></th>
                                                    <th><?= $this->lang->line("amount"); ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if (!empty($quotes)) {
                                                    $r = 1;
                                                    foreach ($quotes as $quote) {
                                                        echo '<tr id="' . $quote->id . '" class="quote_link"><td>' . $r . '</td>
                                                        <td>' . $this->sma->hrld($quote->date) . '</td>
                                                        <td>' . $quote->reference_no . '</td>
                                                        <td>' . $quote->customer . '</td>
                                                        <td>' . row_status($quote->status) . '</td>
                                                        <td class="text-right">' . $this->sma->formatMoney($quote->grand_total) . '</td>
                                                    </tr>';
                                                        $r++;
                                                    }
                                                } else { ?>
                                                    <tr>
                                                        <td colspan="6"
                                                            class="dataTables_empty"><?= lang('no_data_available') ?></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php } if ($Owner || $Admin || $GP['purchases-index']) { ?>

                            <div id="purchases" class="tab-pane fade in">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table id="purchases-tbl" cellpadding="0" cellspacing="0" border="0"
                                                   class="table table-bordered table-hover table-striped"
                                                   style="margin-bottom: 0;">
                                                <thead>
                                                <tr>
                                                    <th style="width:30px !important;">#</th>
                                                    <th><?= $this->lang->line("date"); ?></th>
                                                    <th><?= $this->lang->line("reference_no"); ?></th>
                                                    <th><?= $this->lang->line("supplier"); ?></th>
                                                    <th><?= $this->lang->line("status"); ?></th>
                                                    <th><?= $this->lang->line("amount"); ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if (!empty($purchases)) {
                                                    $r = 1;
                                                    foreach ($purchases as $purchase) {
                                                        echo '<tr id="' . $purchase->id . '" class="purchase_link"><td>' . $r . '</td>
                                                    <td>' . $this->sma->hrld($purchase->date) . '</td>
                                                    <td>' . $purchase->reference_no . '</td>
                                                    <td>' . $purchase->supplier . '</td>
                                                    <td>' . row_status($purchase->status) . '</td>
                                                    <td class="text-right">' . $this->sma->formatMoney($purchase->grand_total) . '</td>
                                                </tr>';
                                                        $r++;
                                                    }
                                                } else { ?>
                                                    <tr>
                                                        <td colspan="6"
                                                            class="dataTables_empty"><?= lang('no_data_available') ?></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php } if ($Owner || $Admin || $GP['transfers-index']) { ?>

                            <div id="transfers" class="tab-pane fade">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table id="transfers-tbl" cellpadding="0" cellspacing="0" border="0"
                                                   class="table table-bordered table-hover table-striped"
                                                   style="margin-bottom: 0;">
                                                <thead>
                                                <tr>
                                                    <th style="width:30px !important;">#</th>
                                                    <th><?= $this->lang->line("date"); ?></th>
                                                    <th><?= $this->lang->line("reference_no"); ?></th>
                                                    <th><?= $this->lang->line("from"); ?></th>
                                                    <th><?= $this->lang->line("to"); ?></th>
                                                    <th><?= $this->lang->line("status"); ?></th>
                                                    <th><?= $this->lang->line("amount"); ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if (!empty($transfers)) {
                                                    $r = 1;
                                                    foreach ($transfers as $transfer) {
                                                        echo '<tr id="' . $transfer->id . '" class="transfer_link"><td>' . $r . '</td>
                                                <td>' . $this->sma->hrld($transfer->date) . '</td>
                                                <td>' . $transfer->transfer_no . '</td>
                                                <td>' . $transfer->from_warehouse_name . '</td>
                                                <td>' . $transfer->to_warehouse_name . '</td>
                                                <td>' . row_status($transfer->status) . '</td>
                                                <td class="text-right">' . $this->sma->formatMoney($transfer->grand_total) . '</td>
                                            </tr>';
                                                        $r++;
                                                    }
                                                } else { ?>
                                                    <tr>
                                                        <td colspan="7"
                                                            class="dataTables_empty"><?= lang('no_data_available') ?></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php } if ($Owner || $Admin || $GP['customers-index']) { ?>

                            <div id="customers" class="tab-pane fade in">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table id="customers-tbl" cellpadding="0" cellspacing="0" border="0"
                                                   class="table table-bordered table-hover table-striped"
                                                   style="margin-bottom: 0;">
                                                <thead>
                                                <tr>
                                                    <th style="width:30px !important;">#</th>
                                                    <th><?= $this->lang->line("company"); ?></th>
                                                    <th><?= $this->lang->line("name"); ?></th>
                                                    <th><?= $this->lang->line("email"); ?></th>
                                                    <th><?= $this->lang->line("phone"); ?></th>
                                                    <th><?= $this->lang->line("address"); ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if (!empty($customers)) {
                                                    $r = 1;
                                                    foreach ($customers as $customer) {
                                                        echo '<tr id="' . $customer->id . '" class="customer_link pointer"><td>' . $r . '</td>
                                            <td>' . $customer->company . '</td>
                                            <td>' . $customer->name . '</td>
                                            <td>' . $customer->email . '</td>
                                            <td>' . $customer->phone . '</td>
                                            <td>' . $customer->address . '</td>
                                        </tr>';
                                                        $r++;
                                                    }
                                                } else { ?>
                                                    <tr>
                                                        <td colspan="6"
                                                            class="dataTables_empty"><?= lang('no_data_available') ?></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php } if ($Owner || $Admin || $GP['suppliers-index']) { ?>

                            <div id="suppliers" class="tab-pane fade">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table id="suppliers-tbl" cellpadding="0" cellspacing="0" border="0"
                                                   class="table table-bordered table-hover table-striped"
                                                   style="margin-bottom: 0;">
                                                <thead>
                                                <tr>
                                                    <th style="width:30px !important;">#</th>
                                                    <th><?= $this->lang->line("company"); ?></th>
                                                    <th><?= $this->lang->line("name"); ?></th>
                                                    <th><?= $this->lang->line("email"); ?></th>
                                                    <th><?= $this->lang->line("phone"); ?></th>
                                                    <th><?= $this->lang->line("address"); ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if (!empty($suppliers)) {
                                                    $r = 1;
                                                    foreach ($suppliers as $supplier) {
                                                        echo '<tr id="' . $supplier->id . '" class="supplier_link pointer"><td>' . $r . '</td>
                                        <td>' . $supplier->company . '</td>
                                        <td>' . $supplier->name . '</td>
                                        <td>' . $supplier->email . '</td>
                                        <td>' . $supplier->phone . '</td>
                                        <td>' . $supplier->address . '</td>
                                    </tr>';
                                                        $r++;
                                                    }
                                                } else { ?>
                                                    <tr>
                                                        <td colspan="6"
                                                            class="dataTables_empty"><?= lang('no_data_available') ?></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php } ?>

                        </div>


                    </div>

                </div>

            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('.order').click(function () {
            window.location.href = '<?=admin_url()?>orders/view/' + $(this).attr('id') + '#comments';
        });
        $('.invoice').click(function () {
            window.location.href = '<?=admin_url()?>orders/view/' + $(this).attr('id');
        });
        $('.quote').click(function () {
            window.location.href = '<?=admin_url()?>quotes/view/' + $(this).attr('id');
        });
    });
</script>

<?php if (($Owner || $Admin) && $chatData) { ?>
    <style type="text/css" media="screen">
        .tooltip-inner {
            max-width: 500px;
        }
    </style>
    <script src="<?= $assets; ?>js/hc/highcharts.js"></script>
    <script type="text/javascript">
        $(function () {
            Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
                return {
                    radialGradient: {cx: 0.5, cy: 0.3, r: 0.7},
                    stops: [[0, color], [1, Highcharts.Color(color).brighten(-0.3).get('rgb')]]
                };
            });
            $('#ov-chart').highcharts({
                chart: {},
                credits: {enabled: false},
                title: {text: ''},
                xAxis: {categories: <?= json_encode($months); ?>},
                yAxis: {min: 0, title: ""},
                tooltip: {
                    shared: true,
                    followPointer: true,
                    formatter: function () {
                        if (this.key) {
                            return '<div class="tooltip-inner hc-tip" style="margin-bottom:0;">' + this.key + '<br><strong>' + currencyFormat(this.y) + '</strong> (' + formatNumber(this.percentage) + '%)';
                        } else {
                            var s = '<div class="well well-sm hc-tip" style="margin-bottom:0;"><h2 style="margin-top:0;">' + this.x + '</h2><table class="table table-striped"  style="margin-bottom:0;">';
                            $.each(this.points, function () {
                                s += '<tr><td style="color:{series.color};padding:0">' + this.series.name + ': </td><td style="color:{series.color};padding:0;text-align:right;"> <b>' +
                                currencyFormat(this.y) + '</b></td></tr>';
                            });
                            s += '</table></div>';
                            return s;
                        }
                    },
                    useHTML: true, borderWidth: 0, shadow: false, valueDecimals: site.settings.decimals,
                    style: {fontSize: '14px', padding: '0', color: '#000000'}
                },
                series: [{
                    type: 'column',
                    name: '<?= lang("sp_tax"); ?>',
                    data: [<?php
                    echo implode(', ', $mtax1);
                    ?>]
                },
                    {
                        type: 'column',
                        name: '<?= lang("order_tax"); ?>',
                        data: [<?php
                    echo implode(', ', $mtax2);
                    ?>]
                    },
                    {
                        type: 'column',
                        name: '<?= lang("sales"); ?>',
                        data: [<?php
                    echo implode(', ', $msales);
                    ?>]
                    }, {
                        type: 'spline',
                        name: '<?= lang("purchases"); ?>',
                        data: [<?php
                    echo implode(', ', $mpurchases);
                    ?>],
                        marker: {
                            lineWidth: 2,
                            states: {
                                hover: {
                                    lineWidth: 4
                                }
                            },
                            lineColor: Highcharts.getOptions().colors[3],
                            fillColor: 'white'
                        }
                    }, {
                        type: 'spline',
                        name: '<?= lang("pp_tax"); ?>',
                        data: [<?php
                    echo implode(', ', $mtax3);
                    ?>],
                        marker: {
                            lineWidth: 2,
                            states: {
                                hover: {
                                    lineWidth: 4
                                }
                            },
                            lineColor: Highcharts.getOptions().colors[3],
                            fillColor: 'white'
                        }
                    }, {
                        type: 'pie',
                        name: '<?= lang("stock_value"); ?>',
                        data: [
                            ['', 0],
                            ['', 0],
                            ['<?= lang("stock_value_by_price"); ?>', <?php echo $stock->stock_by_price; ?>],
                            ['<?= lang("stock_value_by_cost"); ?>', <?php echo $stock->stock_by_cost; ?>],
                        ],
                        center: [80, 42],
                        size: 80,
                        showInLegend: false,
                        dataLabels: {
                            enabled: false
                        }
                    }]
            });
        });
    </script>

    <script type="text/javascript">
        $(function () {
            <?php if ($lmbs) { ?>
            $('#lmbschart').highcharts({
                chart: {type: 'column'},
                title: {text: ''},
                credits: {enabled: false},
                xAxis: {type: 'category', labels: {rotation: -60, style: {fontSize: '13px'}}},
                yAxis: {min: 0, title: {text: ''}},
                legend: {enabled: false},
                series: [{
                    name: '<?=lang('sold');?>',
                    data: [<?php
                    foreach ($lmbs as $r) {
                        if($r->quantity > 0) {
                            echo "['".$r->product_name."<br>(".$r->product_code.")', ".$r->quantity."],";
                        }
                    }
                    ?>],
                    dataLabels: {
                        enabled: true,
                        rotation: -90,
                        color: '#000',
                        align: 'right',
                        y: -25,
                        style: {fontSize: '12px'}
                    }
                }]
            });
            <?php } if ($bs) { ?>
            $('#bschart').highcharts({
                chart: {type: 'column'},
                title: {text: ''},
                credits: {enabled: false},
                xAxis: {type: 'category', labels: {rotation: -60, style: {fontSize: '13px'}}},
                yAxis: {min: 0, title: {text: ''}},
                legend: {enabled: false},
                series: [{
                    name: '<?=lang('sold');?>',
                    data: [<?php
                foreach ($bs as $r) {
                    if($r->quantity > 0) {
                        echo "['".$r->product_name."<br>(".$r->product_code.")', ".$r->quantity."],";
                    }
                }
                ?>],
                    dataLabels: {
                        enabled: true,
                        rotation: -90,
                        color: '#000',
                        align: 'right',
                        y: -25,
                        style: {fontSize: '12px'}
                    }
                }]
            });
            <?php } ?>
        });
    </script>
    <div class="row" style="margin-bottom: 15px;">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                    <h2 class="blue"><i
                            class="fa-fw fa fa-line-chart"></i><?= lang('best_sellers'), ' (' . date('M-Y', time()) . ')'; ?>
                    </h2>
                </div>
                <div class="box-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="bschart" style="width:100%; height:450px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                    <h2 class="blue"><i
                            class="fa-fw fa fa-line-chart"></i><?= lang('best_sellers') . ' (' . date('M-Y', strtotime('-1 month')) . ')'; ?>
                    </h2>
                </div>
                <div class="box-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="lmbschart" style="width:100%; height:450px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
