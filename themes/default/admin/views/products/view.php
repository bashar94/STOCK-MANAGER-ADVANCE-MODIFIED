<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if ($Owner || $Admin) { ?>
    <ul id="myTab" class="nav nav-tabs">
        <li class=""><a href="#details" class="tab-grey"><?= lang('product_details') ?></a></li>
        <li class=""><a href="#chart" class="tab-grey"><?= lang('chart') ?></a></li>
        <li class=""><a href="#sales" class="tab-grey"><?= lang('sales') ?></a></li>
        <li class=""><a href="#quotes" class="tab-grey"><?= lang('quotes') ?></a></li>
        <?php if($product->type == 'standard') { ?>
        <li class=""><a href="#purchases" class="tab-grey"><?= lang('purchases') ?></a></li>
        <li class=""><a href="#transfers" class="tab-grey"><?= lang('transfers') ?></a></li>
        <li class=""><a href="#damages" class="tab-grey"><?= lang('quantity_adjustments') ?></a></li>
        <?php } ?>
    </ul>

<div class="tab-content">
    <div id="details" class="tab-pane fade in">
        <?php } ?>
        <div class="box">
            <div class="box-header">
                <h2 class="blue"><i class="fa-fw fa fa-file-text-o nb"></i> <?= $product->name.(SHOP && $product->hide != 1 ? ' ('.lang('shop_views').': '.$product->views.')' : ''); ?></h2>

                <div class="box-icon">
                    <ul class="btn-tasks">
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <i class="icon fa fa-tasks tip" data-placement="left" title="<?= lang("actions") ?>"></i>
                            </a>
                            <ul class="dropdown-menu pull-right tasks-menus" role="menu"
                                aria-labelledby="dLabel">
                                <li>
                                    <a href="<?= admin_url('products/edit/' . $product->id) ?>">
                                        <i class="fa fa-edit"></i> <?= lang('edit') ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= admin_url('products/print_barcodes/' . $product->id) ?>">
                                        <i class="fa fa-print"></i> <?= lang('print_barcode_label') ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= admin_url('products/pdf/' . $product->id) ?>">
                                        <i class="fa fa-download"></i> <?= lang('pdf') ?>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="#" class="bpo" title="<b><?= lang("delete_product") ?></b>"
                                        data-content="<div style='width:150px;'><p><?= lang('r_u_sure') ?></p><a class='btn btn-danger' href='<?= admin_url('products/delete/' . $product->id) ?>'><?= lang('i_m_sure') ?></a> <button class='btn bpo-close'><?= lang('no') ?></button></div>"
                                        data-html="true" data-placement="left">
                                        <i class="fa fa-trash-o"></i> <?= lang('delete') ?>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="box-content">
                <div class="row">
                    <div class="col-lg-12">
                        <p class="introtext"><?php echo lang('product_details'); ?></p>

                        <div class="row">
                            <div class="col-sm-5">
                                <img src="<?= base_url() ?>assets/uploads/<?= $product->image ?>"
                                     alt="<?= $product->name ?>" class="img-responsive img-thumbnail"/>

                                <div id="multiimages" class="padding10">
                                    <?php if (!empty($images)) {
                                        echo '<a class="img-thumbnail" data-toggle="lightbox" data-gallery="multiimages" data-parent="#multiimages" href="' . base_url() . 'assets/uploads/' . $product->image . '" style="margin-right:5px;"><img class="img-responsive" src="' . base_url() . 'assets/uploads/thumbs/' . $product->image . '" alt="' . $product->image . '" style="width:' . $Settings->twidth . 'px; height:' . $Settings->theight . 'px;" /></a>';
                                        foreach ($images as $ph) {
                                            echo '<div class="gallery-image"><a class="img-thumbnail" data-toggle="lightbox" data-gallery="multiimages" data-parent="#multiimages" href="' . base_url() . 'assets/uploads/' . $ph->photo . '" style="margin-right:5px;"><img class="img-responsive" src="' . base_url() . 'assets/uploads/thumbs/' . $ph->photo . '" alt="' . $ph->photo . '" style="width:' . $Settings->twidth . 'px; height:' . $Settings->theight . 'px;" /></a>';
                                            if ($Owner || $Admin || $GP['products-edit']) {
                                                echo '<a href="#" class="delimg" data-item-id="'.$ph->id.'"><i class="fa fa-times"></i></a>';
                                            }
                                            echo '</div>';
                                        }
                                    }
                                    ?>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-striped dfTable table-right-left">
                                        <tbody>
                                        <tr>
                                            <td colspan="2" style="background-color:#FFF;"></td>
                                        </tr>
                                        <tr>
                                            <td style="width:30%;"><?= lang("barcode_qrcode"); ?></td>
                                            <td style="width:70%;">
                                            <img src="<?= admin_url('misc/barcode/'.$product->code.'/'.$product->barcode_symbology.'/74/0'); ?>" alt="<?= $product->code; ?>" class="bcimg" />
                                                <?= $this->sma->qrcode('link', urlencode(admin_url('products/view/' . $product->id)), 2); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?= lang("type"); ?></td>
                                            <td><?php echo lang($product->type); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang("name"); ?></td>
                                            <td><?php echo $product->name; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang("code"); ?></td>
                                            <td><?php echo $product->code; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang("brand"); ?></td>
                                            <td><?= $brand ? $brand->name : ''; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang("category"); ?></td>
                                            <td><?php echo $category->name; ?></td>
                                        </tr>
                                        <?php if ($product->subcategory_id) { ?>
                                            <tr>
                                                <td><?= lang("subcategory"); ?></td>
                                                <td><?php echo $subcategory->name; ?></td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td><?= lang("unit"); ?></td>
                                            <td><?= $unit ? $unit->name.' ('.$unit->code.')' : ''; ?></td>
                                        </tr>
                                        <?php if ($Owner || $Admin) {
                                            echo '<tr><td>' . lang("cost") . '</td><td>' . $this->sma->formatMoney($product->cost) . '</td></tr>';
                                            echo '<tr><td>' . lang("price") . '</td><td>' . $this->sma->formatMoney($product->price) . '</td></tr>';
                                            if ($product->promotion) {
                                                echo '<tr><td>' . lang("promotion") . '</td><td>' . $this->sma->formatMoney($product->promo_price) . ' ('.$this->sma->hrsd($product->start_date).' - '.$this->sma->hrsd($product->end_date).')</td></tr>';
                                            }
                                        } else {
                                            if ($this->session->userdata('show_cost')) {
                                                echo '<tr><td>' . lang("cost") . '</td><td>' . $this->sma->formatMoney($product->cost) . '</td></tr>';
                                            }
                                            if ($this->session->userdata('show_price')) {
                                                echo '<tr><td>' . lang("price") . '</td><td>' . $this->sma->formatMoney($product->price) . '</td></tr>';
                                                if ($product->promotion) {
                                                    echo '<tr><td>' . lang("promotion") . '</td><td>' . $this->sma->formatMoney($product->promo_price) . ' ('.$this->sma->hrsd($product->start_date).' - '.$this->sma->hrsd($product->start_date).')</td></tr>';
                                                }
                                            }
                                        }
                                        ?>

                                        <?php if ($product->tax_rate) { ?>
                                            <tr>
                                                <td><?= lang("tax_rate"); ?></td>
                                                <td><?php echo $tax_rate->name; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= lang("tax_method"); ?></td>
                                                <td><?php echo $product->tax_method == 0 ? lang('inclusive') : lang('exclusive'); ?></td>
                                            </tr>
                                        <?php } ?>
                                        <?php if ($product->alert_quantity != 0) { ?>
                                            <tr>
                                                <td><?= lang("alert_quantity"); ?></td>
                                                <td><?php echo $this->sma->formatQuantity($product->alert_quantity); ?></td>
                                            </tr>
                                        <?php } ?>
                                        <?php if ($variants) { ?>
                                            <tr>
                                                <td><?= lang("product_variants"); ?></td>
                                                <td><?php foreach ($variants as $variant) {
                                                        echo '<span class="label label-primary">' . $variant->name . '</span> ';
                                                    } ?></td>
                                            </tr>
                                        <?php } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <?php if ($product->cf1 || $product->cf2 || $product->cf3 || $product->cf4 || $product->cf5 || $product->cf6) { ?>
                                            <h3 class="bold"><?= lang('custom_fields') ?></h3>
                                            <div class="table-responsive">
                                                <table
                                                    class="table table-bordered table-striped table-condensed dfTable two-columns">
                                                    <thead>
                                                    <tr>
                                                        <th><?= lang('custom_field') ?></th>
                                                        <th><?= lang('value') ?></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    if ($product->cf1) {
                                                        echo '<tr><td>' . lang("pcf1") . '</td><td>' . $product->cf1 . '</td></tr>';
                                                    }
                                                    if ($product->cf2) {
                                                        echo '<tr><td>' . lang("pcf2") . '</td><td>' . $product->cf2 . '</td></tr>';
                                                    }
                                                    if ($product->cf3) {
                                                        echo '<tr><td>' . lang("pcf3") . '</td><td>' . $product->cf3 . '</td></tr>';
                                                    }
                                                    if ($product->cf4) {
                                                        echo '<tr><td>' . lang("pcf4") . '</td><td>' . $product->cf4 . '</td></tr>';
                                                    }
                                                    if ($product->cf5) {
                                                        echo '<tr><td>' . lang("pcf5") . '</td><td>' . $product->cf5 . '</td></tr>';
                                                    }
                                                    if ($product->cf6) {
                                                        echo '<tr><td>' . lang("pcf6") . '</td><td>' . $product->cf6 . '</td></tr>';
                                                    }
                                                    ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php } ?>

                                        <?php if ((!$Supplier || !$Customer) && !empty($warehouses) && $product->type == 'standard') { ?>
                                            <h3 class="bold"><?= lang('warehouse_quantity') ?></h3>
                                            <div class="table-responsive">
                                                <table
                                                    class="table table-bordered table-striped table-condensed dfTable two-columns">
                                                    <thead>
                                                    <tr>
                                                        <th><?= lang('warehouse_name') ?></th>
                                                        <th><?= lang('quantity') . ' (' . lang('rack') . ')'; ?></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php foreach ($warehouses as $warehouse) {
                                                        if ($warehouse->quantity != 0) {
                                                            echo '<tr><td>' . $warehouse->name . ' (' . $warehouse->code . ')</td><td><strong>' . $this->sma->formatQuantity($warehouse->quantity) . '</strong>' . ($warehouse->rack ? ' (' . $warehouse->rack . ')' : '') . '</td></tr>';
                                                        }
                                                    } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-sm-7">
                                        <?php if ($product->type == 'combo') { ?>
                                            <h3 class="bold"><?= lang('combo_items') ?></h3>
                                            <div class="table-responsive">
                                                <table
                                                    class="table table-bordered table-striped table-condensed dfTable two-columns">
                                                    <thead>
                                                    <tr>
                                                        <th><?= lang('product_name') ?></th>
                                                        <th><?= lang('quantity') ?></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php foreach ($combo_items as $combo_item) {
                                                        echo '<tr><td>' . $combo_item->name . ' (' . $combo_item->code . ') </td><td>' . $this->sma->formatQuantity($combo_item->qty) . '</td></tr>';
                                                    } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php } ?>
                                        <?php if (!empty($options)) { ?>
                                            <h3 class="bold"><?= lang('product_variants_quantity'); ?></h3>
                                            <div class="table-responsive">
                                                <table
                                                    class="table table-bordered table-striped table-condensed dfTable">
                                                    <thead>
                                                    <tr>
                                                        <th><?= lang('warehouse_name') ?></th>
                                                        <th><?= lang('product_variant'); ?></th>
                                                        <th><?= lang('quantity') . ' (' . lang('rack') . ')'; ?></th>
                                                        <?php if ($Owner || $Admin) {
                                                            echo '<th>' . lang('cost') . '</th>';
                                                            echo '<th>' . lang('price') . '</th>';
                                                        } ?>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    foreach ($options as $option) {
                                                        if ($option->wh_qty != 0) {
                                                            echo '<tr><td>' . $option->wh_name . '</td><td>' . $option->name . '</td><td class="text-center">' . $this->sma->formatQuantity($option->wh_qty) . '</td>';
                                                            if ($Owner || $Admin && (!$Customer || $this->session->userdata('show_cost'))) {
                                                                echo '<td class="text-right">' . $this->sma->formatMoney($option->cost) . '</td><td class="text-right">' . $this->sma->formatMoney($option->price) . '</td>';
                                                            }
                                                            echo '</tr>';
                                                        }

                                                    }
                                                    ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">

                                <?= $product->details ? '<div class="panel panel-success"><div class="panel-heading">' . lang('product_details_for_invoice') . '</div><div class="panel-body">' . $product->details . '</div></div>' : ''; ?>
                                <?= $product->product_details ? '<div class="panel panel-primary"><div class="panel-heading">' . lang('product_details') . '</div><div class="panel-body">' . $product->product_details . '</div></div>' : ''; ?>

                            </div>
                        </div>

                        <?php if (!$Supplier || !$Customer) { ?>
                        <div class="buttons">
                            <div class="btn-group btn-group-justified">
                                <div class="btn-group">
                                    <a href="<?= admin_url('products/print_barcodes/' . $product->id) ?>" class="tip btn btn-primary" title="<?= lang('print_barcode_label') ?>">
                                        <i class="fa fa-print"></i>
                                        <span class="hidden-sm hidden-xs"><?= lang('print_barcode_label') ?></span>
                                    </a>
                                </div>
                                <div class="btn-group">
                                    <a href="<?= admin_url('products/pdf/' . $product->id) ?>" class="tip btn btn-primary" title="<?= lang('pdf') ?>">
                                        <i class="fa fa-download"></i> <span class="hidden-sm hidden-xs"><?= lang('pdf') ?></span>
                                    </a>
                                </div>
                                <div class="btn-group">
                                    <a href="<?= admin_url('products/edit/' . $product->id) ?>" class="tip btn btn-warning tip" title="<?= lang('edit_product') ?>">
                                        <i class="fa fa-edit"></i> <span class="hidden-sm hidden-xs"><?= lang('edit') ?></span>
                                    </a>
                                </div>
                                <div class="btn-group">
                                    <a href="#" class="tip btn btn-danger bpo" title="<b><?= lang("delete_product") ?></b>"
                                        data-content="<div style='width:150px;'><p><?= lang('r_u_sure') ?></p><a class='btn btn-danger' href='<?= admin_url('products/delete/' . $product->id) ?>'><?= lang('i_m_sure') ?></a> <button class='btn bpo-close'><?= lang('no') ?></button></div>"
                                        data-html="true" data-placement="top">
                                        <i class="fa fa-trash-o"></i> <span class="hidden-sm hidden-xs"><?= lang('delete') ?></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.tip').tooltip();
            });
        </script>
    <?php } ?>

        <?php if ($Owner || $Admin) { ?>
    </div>
    <div id="chart" class="tab-pane fade">
        <script src="<?= $assets; ?>js/hc/highcharts.js"></script>
        <script type="text/javascript">
            $(function () {
                Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
                    return {
                        radialGradient: {cx: 0.5, cy: 0.3, r: 0.7},
                        stops: [[0, color], [1, Highcharts.Color(color).brighten(-0.3).get('rgb')]]
                    };
                });
                <?php if($sold) { ?>
                var sold_chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'soldchart',
                        type: 'line',
                        width: <?= $purchased ? "($('#details').width()-160)/2" : "$('#details').width()-100"; ?>
                    },
                    credits: {enabled: false},
                    title: {text: ''},
                    xAxis: {
                        categories: [<?php
                    foreach ($sold as $r) {
                        $month = explode('-', $r->month);
                        echo "'".lang('cal_'.strtolower($month[1]))." ".$month[0]."', ";
                    }
                    ?>]
                    },
                    yAxis: {min: 0, title: ""},
                    legend: {enabled: false},
                    tooltip: {
                        shared: true,
                        followPointer: true,
                        formatter: function () {
                            var s = '<div class="well well-sm hc-tip" style="margin-bottom:0;min-width:150px;"><h2 style="margin-top:0;">' + this.x + '</h2><table class="table table-striped"  style="margin-bottom:0;">';
                            $.each(this.points, function () {
                                if (this.series.name == '<?= lang("amount"); ?>') {
                                    s += '<tr><td style="color:{series.color};padding:0">' + this.series.name + ': </td><td style="color:{series.color};padding:0;text-align:right;"> <b>' +
                                    currencyFormat(this.y) + '</b></td></tr>';
                                } else {
                                    s += '<tr><td style="color:{series.color};padding:0">' + this.series.name + ': </td><td style="color:{series.color};padding:0;text-align:right;"> <b>' +
                                    formatQuantity(this.y) + '</b></td></tr>';
                                }
                            });
                            s += '</table></div>';
                            return s;
                        },
                        useHTML: true, borderWidth: 0, shadow: false, valueDecimals: site.settings.decimals,
                        style: {fontSize: '14px', padding: '0', color: '#000000'}
                    },
                    series: [{
                        type: 'spline',
                        name: '<?= lang("sold"); ?>',
                        data: [<?php
                        foreach ($sold as $r) {
                            $month = explode('-', $r->month);
                            echo "['".lang('cal_'.strtolower($month[1]))." ".$month[0]."', ".$r->sold."],";
                            // echo "['".lang('cal_'.strtolower($r->month))."', ".$r->sold."],";
                        }
                        ?>]
                    }, {
                        type: 'spline',
                        name: '<?= lang("amount"); ?>',
                        data: [<?php
                        foreach ($sold as $r) {
                            $month = explode('-', $r->month);
                            echo "['".lang('cal_'.strtolower($month[1]))." ".$month[0]."', ".$r->amount."],";
                            // echo "['".lang('cal_'.strtolower($r->month))."', ".$r->amount."],";
                        }
                        ?>]
                    }]
                });
                $(window).resize(function () {
                    sold_chart.setSize($('#soldchart').width(), 450);
                });
                <?php } if($purchased) { ?>
                var purchased_chart = new Highcharts.Chart({
                    chart: {renderTo: 'purchasedchart', type: 'line', width: ($('#details').width() - 160) / 2},
                    credits: {enabled: false},
                    title: {text: ''},
                    xAxis: {
                        categories: [<?php
        foreach ($purchased as $r) {
            $month = explode('-', $r->month);
            echo "'".lang('cal_'.strtolower($month[1]))." ".$month[0]."', ";
        }
        ?>]
                    },
                    yAxis: {min: 0, title: ""},
                    legend: {enabled: false},
                    tooltip: {
                        shared: true,
                        followPointer: true,
                        formatter: function () {
                            var s = '<div class="well well-sm hc-tip" style="margin-bottom:0;min-width:150px;"><h2 style="margin-top:0;">' + this.x + '</h2><table class="table table-striped"  style="margin-bottom:0;">';
                            $.each(this.points, function () {
                                if (this.series.name == '<?= lang("amount"); ?>') {
                                    s += '<tr><td style="color:{series.color};padding:0">' + this.series.name + ': </td><td style="color:{series.color};padding:0;text-align:right;"> <b>' +
                                    currencyFormat(this.y) + '</b></td></tr>';
                                } else {
                                    s += '<tr><td style="color:{series.color};padding:0">' + this.series.name + ': </td><td style="color:{series.color};padding:0;text-align:right;"> <b>' +
                                    formatQuantity(this.y) + '</b></td></tr>';
                                }
                            });
                            s += '</table></div>';
                            return s;
                        },
                        useHTML: true, borderWidth: 0, shadow: false, valueDecimals: site.settings.decimals,
                        style: {fontSize: '14px', padding: '0', color: '#000000'}
                    },
                    series: [{
                        type: 'spline',
                        name: '<?= lang("purchased"); ?>',
                        data: [<?php
            foreach ($purchased as $r) {
                $month = explode('-', $r->month);
                echo "['".lang('cal_'.strtolower($month[1]))." ".$month[0]."', ".$r->purchased."],";
                // echo "['".lang('cal_'.strtolower($r->month))."', ".$r->purchased."],";
            }
            ?>]
                    }, {
                        type: 'spline',
                        name: '<?= lang("amount"); ?>',
                        data: [<?php
            foreach ($purchased as $r) {
                $month = explode('-', $r->month);
                echo "['".lang('cal_'.strtolower($month[1]))." ".$month[0]."', ".$r->amount."],";
                // echo "['".lang('cal_'.strtolower($r->month))."', ".$r->amount."],";
            }
            ?>]
                    }]
                });
                $(window).resize(function () {
                    purchased_chart.setSize($('#purchasedchart').width(), 450);
                });
                <?php } ?>

            });
        </script>
        <div class="box">
            <div class="box-header">
                <h2 class="blue"><i class="fa-fw fa fa-bar-chart-o nb"></i><?= lang('chart'); ?></h2>
            </div>
            <div class="box-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row" style="margin-bottom: 15px;">
                            <div class="col-sm-<?= $purchased ? '6' : '12'; ?>">
                                <div class="box" style="border-top: 1px solid #dbdee0;">
                                    <div class="box-header">
                                        <h2 class="blue"><i class="fa-fw fa fa-bar-chart-o"></i><?= lang('sold'); ?>
                                        </h2>
                                    </div>
                                    <div class="box-content">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="soldchart" style="width:100%; height:450px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if ($purchased) { ?>
                                <div class="col-sm-6">
                                    <div class="box" style="border-top: 1px solid #dbdee0;">
                                        <div class="box-header">
                                            <h2 class="blue"><i
                                                    class="fa-fw fa fa-bar-chart-o"></i><?= lang('purchased'); ?></h2>
                                        </div>
                                        <div class="box-content">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="purchasedchart" style="width:100%; height:450px;"></div>
                                                </div>
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
    <div id="sales" class="tab-pane fade">
        <?php $warehouse_id = NULL; ?>
        <script type="text/javascript">
            $(document).ready(function () {
                oTable = $('#SlRData').dataTable({
                    "aaSorting": [[0, "desc"]],
                    "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
                    "iDisplayLength": <?= $Settings->rows_per_page ?>,
                    'bProcessing': true, 'bServerSide': true,
                    'sAjaxSource': '<?= admin_url('reports/getSalesReport/?v=1&product='.$product->id) ?>',
                    'fnServerData': function (sSource, aoData, fnCallback) {
                        aoData.push({
                            "name": "<?= $this->security->get_csrf_token_name() ?>",
                            "value": "<?= $this->security->get_csrf_hash() ?>"
                        });
                        $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
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
        <div class="box">
            <div class="box-header">
                <h2 class="blue"><i class="fa-fw fa fa-heart nb"></i><?= $product->name . ' ' . lang('sales'); ?></h2>

                <div class="box-icon">
                    <ul class="btn-tasks">
                        <li class="dropdown">
                            <a href="#" id="xls" class="tip" title="<?= lang('download_xls') ?>">
                                <i class="icon fa fa-file-excel-o"></i>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="#" id="image" class="tip image" title="<?= lang('save_image') ?>">
                                <i class="icon fa fa-file-picture-o"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="box-content">
                <div class="row">
                    <div class="col-lg-12">
                        <p class="introtext"><?php echo lang('list_results'); ?></p>

                        <div class="table-responsive">
                            <table id="SlRData" class="table table-bordered table-hover table-striped table-condensed">
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
    <div id="quotes" class="tab-pane fade">
        <script type="text/javascript">
            $(document).ready(function () {
                oTable = $('#QuRData').dataTable({
                    "aaSorting": [[0, "desc"]],
                    "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
                    "iDisplayLength": <?= $Settings->rows_per_page ?>,
                    'bProcessing': true, 'bServerSide': true,
                    'sAjaxSource': '<?= admin_url('reports/getQuotesReport/?v=1&product='.$product->id) ?>',
                    'fnServerData': function (sSource, aoData, fnCallback) {
                        aoData.push({
                            "name": "<?= $this->security->get_csrf_token_name() ?>",
                            "value": "<?= $this->security->get_csrf_hash() ?>"
                        });
                        $.ajax({ 'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback });
                    },
                    'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                        var oSettings = oTable.fnSettings();
                        nRow.id = aData[7];
                        nRow.className = "quote_link2";
                        return nRow;
                    },
                    "aoColumns": [{"mRender": fld}, null, null, null, {
                        "bSearchable": false,
                        "mRender": pqFormat
                    }, {"mRender": currencyFormat}, {"mRender": row_status}],
                }).fnSetFilteringDelay().dtFilter([
                    {column_number: 0, filter_default_label: "[<?=lang('date');?> (yyyy-mm-dd)]", filter_type: "text", data: []},
                    {column_number: 1, filter_default_label: "[<?=lang('reference_no');?>]", filter_type: "text", data: []},
                    {column_number: 2, filter_default_label: "[<?=lang('biller');?>]", filter_type: "text", data: []},
                    {column_number: 3, filter_default_label: "[<?=lang('customer');?>]", filter_type: "text", data: []},
                    {column_number: 5, filter_default_label: "[<?=lang('grand_total');?>]", filter_type: "text", data: []},
                    {column_number: 6, filter_default_label: "[<?=lang('status');?>]", filter_type: "text", data: []},
                ], "footer");
            });
        </script>
        <div class="box">
            <div class="box-header">
                <h2 class="blue"><i class="fa-fw fa fa-heart-o nb"></i><?= $product->name . ' ' . lang('quotes'); ?>
                </h2>

                <div class="box-icon">
                    <ul class="btn-tasks">
                        <li class="dropdown">
                            <a href="#" id="pdf1" class="tip" title="<?= lang('download_pdf') ?>">
                                <i class="icon fa fa-file-pdf-o"></i>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="#" id="xls1" class="tip" title="<?= lang('download_xls') ?>">
                                <i class="icon fa fa-file-excel-o"></i>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="#" id="image1" class="tip image" title="<?= lang('save_image') ?>">
                                <i class="icon fa fa-file-picture-o"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="box-content">
                <div class="row">
                    <div class="col-lg-12">
                        <p class="introtext"><?php echo lang('list_results'); ?></p>

                        <div class="table-responsive">
                            <table id="QuRData" class="table table-bordered table-hover table-striped table-condensed">
                                <thead>
                                <tr>
                                    <th><?= lang("date"); ?></th>
                                    <th><?= lang("reference_no"); ?></th>
                                    <th><?= lang("biller"); ?></th>
                                    <th><?= lang("customer"); ?></th>
                                    <th><?= lang("product_qty"); ?></th>
                                    <th><?= lang("grand_total"); ?></th>
                                    <th><?= lang("status"); ?></th>
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
                                    <th><?= lang("product_qty"); ?></th>
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
    <div id="purchases" class="tab-pane fade">
        <script type="text/javascript">
            $(document).ready(function () {
                oTable = $('#PoRData').dataTable({
                    "aaSorting": [[0, "desc"]],
                    "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
                    "iDisplayLength": <?= $Settings->rows_per_page ?>,
                    'bProcessing': true, 'bServerSide': true,
                    'sAjaxSource': '<?= admin_url('reports/getPurchasesReport/?v=1&product=' . $product->id) ?>',
                    'fnServerData': function (sSource, aoData, fnCallback) {
                        aoData.push({
                            "name": "<?= $this->security->get_csrf_token_name() ?>",
                            "value": "<?= $this->security->get_csrf_hash() ?>"
                        });
                        $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
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
        <div class="box">
            <div class="box-header">
                <h2 class="blue"><i class="fa-fw fa fa-star nb"></i><?= $product->name . ' ' . lang('purchases'); ?>
                </h2>

                <div class="box-icon">
                    <ul class="btn-tasks">
                        <li class="dropdown">
                            <a href="#" id="pdf2" class="tip" title="<?= lang('download_pdf') ?>">
                                <i class="icon fa fa-file-pdf-o"></i>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="#" id="xls2" class="tip" title="<?= lang('download_xls') ?>">
                                <i class="icon fa fa-file-excel-o"></i>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="#" id="image2" class="tip image" title="<?= lang('save_image') ?>">
                                <i class="icon fa fa-file-picture-o"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="box-content">
                <div class="row">
                    <div class="col-lg-12">
                        <p class="introtext"><?php echo lang('list_results'); ?></p>

                        <div class="table-responsive">
                            <table id="PoRData" class="table table-bordered table-hover table-striped table-condensed">
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
    <div id="transfers" class="tab-pane fade">
        <script type="text/javascript">
            $(document).ready(function () {
                oTable = $('#TrRData').dataTable({
                    "aaSorting": [[0, "desc"]],
                    "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
                    "iDisplayLength": <?= $Settings->rows_per_page ?>,
                    'bProcessing': true, 'bServerSide': true,
                    'sAjaxSource': '<?= admin_url('reports/getTransfersReport/?v=1&product='.$product->id) ?>',
                    'fnServerData': function (sSource, aoData, fnCallback) {
                        aoData.push({
                            "name": "<?= $this->security->get_csrf_token_name() ?>",
                            "value": "<?= $this->security->get_csrf_hash() ?>"
                        });
                        $.ajax({ 'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback });
                    },
                    'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                        var oSettings = oTable.fnSettings();
                        nRow.id = aData[7];
                        nRow.className = "transfer_link2";
                        return nRow;
                    },
                    "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                        var gtotal = 0;
                        for (var i = 0; i < aaData.length; i++) {
                            gtotal += parseFloat(aaData[aiDisplay[i]][5]);;
                        }
                        var nCells = nRow.getElementsByTagName('th');
                        nCells[5].innerHTML = currencyFormat(formatMoney(gtotal));
                    },
                    "aoColumns": [{"mRender": fld}, null, {
                        "bSearchable": false,
                        "mRender": pqFormat
                    }, null, null, {"mRender": currencyFormat}, {"mRender": row_status}],
                }).fnSetFilteringDelay().dtFilter([
                    {column_number: 0, filter_default_label: "[<?=lang('date');?> (yyyy-mm-dd)]", filter_type: "text", data: []},
                    {column_number: 1, filter_default_label: "[<?=lang('reference_no');?>]", filter_type: "text", data: []},
                    {
                        column_number: 3,
                        filter_default_label: "[<?=lang("warehouse").' ('.lang('from').')';?>]",
                        filter_type: "text", data: []
                    },
                    {
                        column_number: 4,
                        filter_default_label: "[<?=lang("warehouse").' ('.lang('to').')';?>]",
                        filter_type: "text", data: []
                    },
                    {column_number: 5, filter_default_label: "[<?=lang('grand_total');?>]", filter_type: "text", data: []},
                    {column_number: 6, filter_default_label: "[<?=lang('status');?>]", filter_type: "text", data: []},
                ], "footer");
            });
        </script>
        <div class="box">
            <div class="box-header">
                <h2 class="blue"><i class="fa-fw fa fa-star-o nb"></i><?= $product->name . ' ' . lang('transfers'); ?>
                </h2>

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
                        <p class="introtext"><?php echo lang('list_results'); ?></p>

                        <div class="table-responsive">
                            <table id="TrRData" class="table table-bordered table-hover table-striped table-condensed">
                                <thead>
                                <tr>
                                    <th><?= lang("date"); ?></th>
                                    <th><?= lang("reference_no"); ?></th>
                                    <th><?= lang("product_qty"); ?></th>
                                    <th><?= lang("warehouse") . ' (' . lang('from') . ')'; ?></th>
                                    <th><?= lang("warehouse") . ' (' . lang('to') . ')'; ?></th>
                                    <th><?= lang("grand_total"); ?></th>
                                    <th><?= lang("status"); ?></th>
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
                                    <th><?= lang("product_qty"); ?></th>
                                    <th></th>
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
    <div id="damages" class="tab-pane fade">
        <script>
            $(document).ready(function () {
                oTable = $('#dmpData').dataTable({
                    "aaSorting": [[0, "desc"]],
                    "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
                    "iDisplayLength": <?= $Settings->rows_per_page ?>,
                    'bProcessing': true, 'bServerSide': true,
                    'sAjaxSource': '<?= admin_url('reports/getAdjustmentReport/?v=1&product='.$product->id); ?>',
                    'fnServerData': function (sSource, aoData, fnCallback) {
                        aoData.push({
                            "name": "<?= $this->security->get_csrf_token_name() ?>",
                            "value": "<?= $this->security->get_csrf_hash() ?>"
                        });
                        $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
                    },
                    "aoColumns": [{"mRender": fld}, null, null, null, {"mRender": decode_html}, {"bSortable": false, "mRender": pqFormat}],
                    'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                        nRow.id = aData[6];
                        nRow.className = "adjustment_link2";
                        return nRow;
                    },
                }).fnSetFilteringDelay().dtFilter([
                    {column_number: 0, filter_default_label: "[<?=lang('date');?> (yyyy-mm-dd)]", filter_type: "text", data: []},
                    {column_number: 1, filter_default_label: "[<?=lang('reference_no');?>]", filter_type: "text", data: []},
                    {column_number: 2, filter_default_label: "[<?=lang('warehouse');?>]", filter_type: "text", data: []},
                    {column_number: 3, filter_default_label: "[<?=lang('created_by');?>]", filter_type: "text", data: []},
                    {column_number: 4, filter_default_label: "[<?=lang(' note');?>]", filter_type: "text", data: []},
                ], "footer");
            });
        </script>
        <div class="box">
            <div class="box-header">
                <h2 class="blue"><i class="fa-fw fa fa-filter"></i><?= lang('adjustments_report'); ?><?php
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
            </div>
            <div class="box-content">
                <div class="row">
                    <div class="col-lg-12">
                        <p class="introtext"><?= lang('list_results'); ?></p>

                        <div class="table-responsive">
                            <table id="dmpData" class="table table-bordered table-condensed table-hover table-striped">
                                <thead>
                                <tr>
                                    <th class="col-xs-2"><?= lang("date"); ?></th>
                                    <th class="col-xs-2"><?= lang("reference_no"); ?></th>
                                    <th class="col-xs-2"><?= lang("warehouse"); ?></th>
                                    <th class="col-xs-1"><?= lang("created_by"); ?></th>
                                    <th><?= lang("note"); ?></th>
                                    <th class="col-xs-2"><?= lang('products'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td colspan="8" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                                </tr>
                                </tbody>
                                <tfoot class="dtFilter">
                                <tr class="active">
                                    <th></th><th></th><th></th><th></th><th></th>
                                    <th><?= lang('products'); ?></th>
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

    <script type="text/javascript" src="<?= $assets ?>js/html2canvas.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#pdf').click(function (event) {
                event.preventDefault();
                window.location.href = "<?=admin_url('reports/getSalesReport/pdf/?v=1&product='.$product->id)?>";
                return false;
            });
            $('#xls').click(function (event) {
                event.preventDefault();
                window.location.href = "<?=admin_url('reports/getSalesReport/0/xls/?v=1&product='.$product->id)?>";
                return false;
            });
            $('#pdf1').click(function (event) {
                event.preventDefault();
                window.location.href = "<?=admin_url('reports/getQuotesReport/pdf/?v=1&product='.$product->id)?>";
                return false;
            });
            $('#xls1').click(function (event) {
                event.preventDefault();
                window.location.href = "<?=admin_url('reports/getQuotesReport/0/xls/?v=1&product='.$product->id)?>";
                return false;
            });
            $('#pdf2').click(function (event) {
                event.preventDefault();
                window.location.href = "<?=admin_url('reports/getPurchasesReport/pdf/?v=1&product='.$product->id)?>";
                return false;
            });
            $('#xls2').click(function (event) {
                event.preventDefault();
                window.location.href = "<?=admin_url('reports/getPurchasesReport/0/xls/?v=1&product='.$product->id)?>";
                return false;
            });
            $('#pdf3').click(function (event) {
                event.preventDefault();
                window.location.href = "<?=admin_url('reports/getTransfersReport/pdf/?v=1&product='.$product->id)?>";
                return false;
            });
            $('#xls3').click(function (event) {
                event.preventDefault();
                window.location.href = "<?=admin_url('reports/getTransfersReport/0/xls/?v=1&product='.$product->id)?>";
                return false;
            });
            $('#pdf4').click(function (event) {
                event.preventDefault();
                window.location.href = "<?=admin_url('products/getadjustments/pdf/?v=1&product='.$product->id)?>";
                return false;
            });
            $('#xls4').click(function (event) {
                event.preventDefault();
                window.location.href = "<?=admin_url('products/getadjustments/0/xls/?v=1&product='.$product->id)?>";
                return false;
            });
            $('#pdf5').click(function (event) {
                event.preventDefault();
                window.location.href = "<?=admin_url('reports/getAdjustmentReport/pdf/?v=1'.$v)?>";
                return false;
            });
            $('#xls5').click(function (event) {
                event.preventDefault();
                window.location.href = "<?=admin_url('reports/getAdjustmentReport/0/xls/?v=1'.$v)?>";
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
<?php } ?>
