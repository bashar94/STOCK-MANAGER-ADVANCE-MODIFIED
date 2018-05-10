<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<script src="<?= $assets; ?>js/hc/highcharts.js"></script>
<script type="text/javascript">
    $(function () {
        Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
            return {
                radialGradient: {cx: 0.5, cy: 0.3, r: 0.7},
                stops: [[0, color], [1, Highcharts.Color(color).brighten(-0.3).get('rgb')]]
            };
        });
        <?php if ($m2bs) { ?>
        $('#m2bschart').highcharts({
            chart: {type: 'column'},
            title: {text: ''},
            credits: {enabled: false},
            xAxis: {type: 'category', labels: {rotation: -60, style: {fontSize: '13px'}}},
            yAxis: {min: 0, title: {text: ''}},
            legend: {enabled: false},
            series: [{
                name: '<?=lang('sold');?>',
                data: [<?php
                foreach ($m2bs as $r) {
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
        <?php } if ($m1bs) { ?>
        $('#m1bschart').highcharts({
            chart: {type: 'column'},
            title: {text: ''},
            credits: {enabled: false},
            xAxis: {type: 'category', labels: {rotation: -60, style: {fontSize: '13px'}}},
            yAxis: {min: 0, title: {text: ''}},
            legend: {enabled: false},
            series: [{
                name: '<?=lang('sold');?>',
                data: [<?php
            foreach ($m1bs as $r) {
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
        <?php } if ($m3bs) { ?>
        $('#m3bschart').highcharts({
            chart: {type: 'column'},
            title: {text: ''},
            credits: {enabled: false},
            xAxis: {type: 'category', labels: {rotation: -60, style: {fontSize: '13px'}}},
            yAxis: {min: 0, title: {text: ''}},
            legend: {enabled: false},
            series: [{
                name: '<?=lang('sold');?>',
                data: [<?php
            foreach ($m3bs as $r) {
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
        <?php } if ($m4bs) { ?>
        $('#m4bschart').highcharts({
            chart: {type: 'column'},
            title: {text: ''},
            credits: {enabled: false},
            xAxis: {type: 'category', labels: {rotation: -60, style: {fontSize: '13px'}}},
            yAxis: {min: 0, title: {text: ''}},
            legend: {enabled: false},
            series: [{
                name: '<?=lang('sold');?>',
                data: [<?php
            foreach ($m4bs as $r) {
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
<div class="box">
    <div class="box-header">
        <h2 class="blue">
            <i class="fa-fw fa fa-line-chart"></i>
            <?= lang('best_sellers').' (' . ($warehouse ? $warehouse->name : lang('all_warehouses')) . ')'; ?>
        </h2>
        <?php if (!empty($warehouses)) { ?>
        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon fa fa-building-o tip" data-placement="left" title="<?= lang("warehouses") ?>"></i></a>
                    <ul class="dropdown-menu pull-right tasks-menus" role="menu" aria-labelledby="dLabel">
                        <li><a href="<?= admin_url('reports/best_sellers') ?>"><i class="fa fa-building-o"></i> <?= lang('all_warehouses') ?></a></li>
                        <li class="divider"></li>
                        <?php
                        foreach ($warehouses as $warehouse) {
                            echo '<li><a href="' . admin_url('reports/best_sellers/' . $warehouse->id) . '"><i class="fa fa-building"></i>' . $warehouse->name . '</a></li>';
                        }
                        ?>
                    </ul>
                </li>
            </ul>
        </div>
        <?php } ?>
    </div>
    <div class="box-content">

    <div class="row" style="margin-bottom: 15px;">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                    <h2 class="blue"><?= $m1; ?>
                    </h2>
                </div>
                <div class="box-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="m1bschart" style="width:100%; height:450px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                    <h2 class="blue"><?= $m2; ?>
                    </h2>
                </div>
                <div class="box-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="m2bschart" style="width:100%; height:450px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                    <h2 class="blue"><?= $m3; ?>
                    </h2>
                </div>
                <div class="box-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="m3bschart" style="width:100%; height:450px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                    <h2 class="blue"><?= $m4; ?>
                    </h2>
                </div>
                <div class="box-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="m4bschart" style="width:100%; height:450px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

