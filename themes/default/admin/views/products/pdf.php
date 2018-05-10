<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <base href="<?= admin_url() ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $product->name ?> - <?= $Settings->site_name ?></title>
    <link href="<?= $assets ?>styles/pdf/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $assets ?>styles/pdf/pdf.css" rel="stylesheet">
<body>
<div class="row">
    <div class="col-lg-12">
        <?php
        $path = base_url() . 'assets/uploads/logos/' . $Settings->logo;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        ?>
        <div class="text-center" style="margin-bottom:20px;">
            <img src="<?= $base64; ?>" alt="<?=$Settings->site_name;?>">
        </div>

        <div class="clearfix"></div>
        <div class="text-center">
            <?php
            $path = admin_url('misc/barcode/'.$product->code.'/'.$product->barcode_symbology.'/60');
            $type = $Settings->barcode_img ? 'png' : 'svg+xml';
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            ?>
            <img src="<?= $base64; ?>" alt="<?= $product->code; ?>" class="bcimg" />
            <?= $this->sma->qrcode('link', urlencode(admin_url('products/view/' . $product->id)), 2); ?>
        </div>

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-sm-5">
                <?php if ($product->image != 'no_image.png') {
                    $path = base_url() . 'assets/uploads/' . $product->image;
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    ?>
                    <br><div class="text-center"><img src="<?= $base64; ?>" alt="<?= $product->name ?>" /></div><br><br>
                    <?php
                } ?>
            </div>
            <div class="col-sm-7">
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped dfTable table-right-left">
                        <tbody>
                        <tr>
                            <td><?= lang("type"); ?></td>
                            <td><?= lang($product->type); ?></td>
                        </tr>
                        <tr>
                            <td><?= lang("name"); ?></td>
                            <td><?= $product->name; ?></td>
                        </tr>
                        <tr>
                            <td><?= lang("code"); ?></td>
                            <td><?= $product->code; ?></td>
                        </tr>
                        <tr>
                            <td><?= lang("brand"); ?></td>
                            <td><?= $brand ? $brand->name : ''; ?></td>
                        </tr>
                        <tr>
                            <td><?= lang("category"); ?></td>
                            <td><?= $category->name; ?></td>
                        </tr>
                        <?php if ($product->subcategory_id) { ?>
                            <tr>
                                <td><?= lang("subcategory"); ?></td>
                                <td><?= $subcategory->name; ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td><?= lang("unit"); ?></td>
                            <td><?= $unit->name.' ('.$unit->code.')'; ?></td>
                        </tr>
                        <?php if ($Owner || $Admin) {
                            echo '<tr><td>' . lang("cost") . '</td><td>' . $this->sma->formatMoney($product->cost) . '</td></tr>';
                            echo '<tr><td>' . lang("price") . '</td><td>' . $this->sma->formatMoney($product->price) . '</td></tr>';
                        } else {
                            if ($this->session->userdata('show_cost')) {
                                echo '<tr><td>' . lang("cost") . '</td><td>' . $this->sma->formatMoney($product->cost) . '</td></tr>';
                            }
                            if ($this->session->userdata('show_price')) {
                                echo '<tr><td>' . lang("price") . '</td><td>' . $this->sma->formatMoney($product->price) . '</td></tr>';
                            }
                        }
                        ?>

                        <?php if ($product->tax_rate) { ?>
                            <tr>
                                <td><?= lang("tax_rate"); ?></td>
                                <td><?= $tax_rate->name; ?></td>
                            </tr>
                            <tr>
                                <td><?= lang("tax_method"); ?></td>
                                <td><?= $product->tax_method == 0 ? lang('inclusive') : lang('exclusive'); ?></td>
                            </tr>
                        <?php } ?>
                        <?php if ($product->alert_quantity != 0) { ?>
                            <tr>
                                <td><?= lang("alert_quantity"); ?></td>
                                <td><?= $this->sma->formatQuantity($product->alert_quantity); ?></td>
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
                                <table class="table table-bordered table-striped table-condensed dfTable two-columns">
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
                        <?php if ($product->type == 'combo') { ?>
                            <h3 class="bold"><?= lang('combo_items') ?></h3>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-condensed dfTable two-columns">
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

                        <?php if ((!$Supplier || !$Customer) && !empty($warehouses) && $product->type == 'standard') { ?>
                            <h3 class="bold"><?= lang('warehouse_quantity') ?></h3>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-condensed dfTable two-columns">
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
                        <?php if (!empty($options)) { ?>
                            <h3 class="bold"><?= lang('product_variants_quantity'); ?></h3>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-condensed dfTable">
                                    <thead>
                                    <tr>
                                        <th><?= lang('warehouse_name') ?></th>
                                        <th><?= lang('product_variant'); ?></th>
                                        <th><?= lang('quantity') . ' (' . lang('rack') . ')'; ?></th>
                                        <?php /* if($Owner || $Admin) {
                                            echo '<th>'.lang('cost').'</th>';
                                            echo '<th>'.lang('price').'</th>';
                                        } */ ?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($options as $option) {
                                        if ($option->wh_qty != 0) {
                                            echo '<tr><td>' . $option->wh_name . '</td><td>' . $option->name . '</td><td class="text-center">' . $this->sma->formatQuantity($option->wh_qty) . '</td>';
                                            /*if($Owner || $Admin && (!$Customer || $this->session->userdata('show_cost'))) {
                                                echo '<td class="text-right">'.$this->sma->formatMoney($option->cost).'</td><td class="text-right">'.$this->sma->formatMoney($option->price).'</td>';
                                            }*/
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

        <?php
        if (!empty($images)) {
            foreach ($images as $ph) {
                echo '<img class="img-responsive" src="' . base_url() . 'assets/uploads/' . $ph->photo . '" alt="' . $ph->photo . '" style="width:' . $Settings->iwidth . 'px; height:' . $Settings->iheight . 'px;" />';
            }
        }
        ?>
    </div>
</div>
</body>
</html>
