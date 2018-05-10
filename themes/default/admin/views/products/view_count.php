<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="fa fa-2x">&times;</i>
            </button>
            <button type="button" class="btn btn-xs btn-default no-print pull-right" style="margin-right:15px;" onclick="window.print();">
                <i class="fa fa-print"></i> <?= lang('print'); ?>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?= lang('stock_count'); ?></h4>
        </div>
        <div class="modal-body">

            <div class="row">
                <div class="col-xs-12">
                <table class="table table-bordered table-condensed">
                        <tbody>
                            <tr>
                                <td><?= lang('warehouse'); ?></td>
                                <td><?= $warehouse->name.' ( '.$warehouse->code.' )'; ?></td>
                            </tr>
                            <tr>
                                <td><?= lang('start_date'); ?></td>
                                <td><?= $this->sma->hrld($stock_count->date); ?></td>
                            </tr>
                            <tr>
                                <td><?= lang('end_date'); ?></td>
                                <td><?= $this->sma->hrld($stock_count->updated_at); ?></td>
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
                            <tr>
                                <td><?= lang('files'); ?></td>
                                <td>
                                    <?= anchor('admin/welcome/download/'.$stock_count->initial_file, '<i class="fa fa-download"></i> '.lang('initial_file'), 'class="btn btn-primary btn-xs"'); ?>
                                    <?= anchor('admin/welcome/download/'.$stock_count->final_file, '<i class="fa fa-download"></i> '.lang('final_file'), 'class="btn btn-primary btn-xs"'); ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <?php if (!empty($stock_count_items)) { ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped order-table">
                            <thead>
                            <tr>
                                <th style="text-align:center; vertical-align:middle;"><?= lang("no"); ?></th>
                                <th style="vertical-align:middle;"><?= lang("description"); ?></th>
                                <th style="text-align:center; vertical-align:middle;"><?= lang("expected"); ?></th>
                                <th style="text-align:center; vertical-align:middle;"><?= lang("counted"); ?></th>
                                <th style="text-align:center; vertical-align:middle;"><?= lang("difference"); ?></th>
                                <th style="text-align:center; vertical-align:middle;"><?= lang("cost"); ?></th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php $r = 1; $total = 0; $items = 0;
                            foreach ($stock_count_items as $row): ?>
                                <tr>
                                    <td style="text-align:center; width:25px;"><?= $r; ?></td>
                                    <td style="text-align:left;">
                                        <?= $row->product_code.' - '.$row->product_name . ($row->product_variant ? ' (' . $row->product_variant . ')' : ''); ?>
                                    </td>
                                    <td style="text-align:center; width:80px;">
                                        <?= $this->sma->formatQuantity($row->expected); ?>
                                    </td>
                                    <td style="text-align:center; width:80px;">
                                        <?= $this->sma->formatQuantity($row->counted); ?>
                                    </td>
                                    <td style="text-align:right; width:80px;">
                                        <?= $this->sma->formatQuantity($row->counted-$row->expected); ?>
                                    </td>
                                    <td style="text-align:right; width:100px;">
                                        <?= $this->sma->formatMoney($row->cost*($row->counted-$row->expected)); ?>
                                    </td>
                                </tr>
                                <?php $r++;
                                $items += $row->counted-$row->expected;
                                $total += $row->cost*($row->counted-$row->expected);
                            endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4"><?= lang('total'); ?></th>
                                    <th style="text-align:right; width:80px;">
                                    <?= $this->sma->formatQuantity($items); ?>
                                    </th>
                                    <th style="text-align:right; width:100px;">
                                        <?= $this->sma->formatMoney($total); ?>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <?php 
                    } else {
                        echo '<div class="well well-sm">'.lang('no_mismatch_found').'</div>';
                    }
                    ?>
                    <?php
                    if ($adjustment) {
                        echo '<a href="'.admin_url('products/view_adjustment/'.$adjustment->id).'" class="btn btn-primary btn-block no-print" data-toggle="modal" data-target="#myModal2">'.lang('view_adjustment').'</a>';
                    } elseif (!empty($stock_count_items)) {
                        echo '<a href="'.admin_url('products/add_adjustment/'.$stock_count->id).'" class="btn btn-primary btn-block no-print">'.lang('add_adjustment').'</a>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
