<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-lg no-modal-header">
    <div class="modal-content">
        <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="fa fa-2x">&times;</i>
            </button>
            <button type="button" class="btn btn-xs btn-default no-print pull-right" style="margin-right:15px;" onclick="window.print();">
                <i class="fa fa-print"></i> <?= lang('print'); ?>
            </button>
            <?php if ($logo) { ?>
            <div class="text-center" style="margin-bottom:20px;">
                <img src="<?= base_url() . 'assets/uploads/logos/' . $Settings->logo; ?>"
                alt="<?= $Settings->site_name; ?>">
            </div>
            <?php } ?>
            <div class="well well-sm">
                <div class="row bold">
                    <div class="col-xs-4"><?= lang("date"); ?>: <?= $this->sma->hrld($transfer->date); ?>
                        <br><?= lang("ref"); ?>: <?= $transfer->transfer_no; ?>
                    </div>
                    <div class="col-xs-6 pull-right text-right order_barcodes">
                        <img src="<?= admin_url('misc/barcode/'.$this->sma->base64url_encode($transfer->transfer_no).'/code128/74/0/1'); ?>" alt="<?= $transfer->transfer_no; ?>" class="bcimg" />
                        <?= $this->sma->qrcode('link', urlencode(admin_url('transfers/view/' . $transfer->id)), 2); ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    <?= lang("to"); ?>:<br/>
                    <h3 style="margin-top:10px;"><?= $to_warehouse->name . " ( " . $to_warehouse->code . " )"; ?></h3>
                    <?= "<p>" . $to_warehouse->address . "</p><p>" . $to_warehouse->phone . "<br>" . $to_warehouse->email . "</p>";
                    ?>
                </div>
                <div class="col-xs-6">
                    <?= lang("from"); ?>:
                    <h3 style="margin-top:10px;"><?= $from_warehouse->name . " ( " . $from_warehouse->code . " )"; ?></h3>
                    <?= "<p>" . $from_warehouse->address . "</p><p>" . $from_warehouse->phone . "<br>" . $from_warehouse->email . "</p>";
                    ?>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped order-table">
                    <thead>
                        <tr>
                            <th style="text-align:center; vertical-align:middle;"><?= lang("no"); ?></th>
                            <th style="vertical-align:middle;"><?= lang("description"); ?></th>
                            <?php if ($Settings->indian_gst) { ?>
                                <th><?= lang("hsn_code"); ?></th>
                            <?php } ?>
                            <th style="text-align:center; vertical-align:middle;"><?= lang("quantity"); ?></th>
                            <th style="text-align:center; vertical-align:middle;"><?= lang("unit_cost"); ?></th>
                            <?php if ($Settings->tax1) {
                                echo '<th style="text-align:center; vertical-align:middle;">' . lang("tax") . '</th>';
                            } ?>
                            <th style="text-align:center; vertical-align:middle;"><?= lang("subtotal"); ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $r = 1;
                        foreach ($rows as $row): ?>
                        <tr>
                            <td style="text-align:center; width:25px;"><?= $r; ?></td>
                            <td style="text-align:left;">
                                <?= $row->product_code.' - '.$row->product_name . ($row->variant ? ' (' . $row->variant . ')' : ''); ?>
                                <?= $row->second_name ? '<br>' . $row->second_name : ''; ?>
                            </td>
                            <?php if ($Settings->indian_gst) { ?>
                            <td style="width: 80px; text-align:center; vertical-align:middle;"><?= $row->hsn_code; ?></td>
                            <?php } ?>
                            <td style="text-align:center; width:80px; "><?= $this->sma->formatQuantity($row->unit_quantity).' '.$row->product_unit_code; ?></td>
                            <td style="width: 100px; text-align:right; vertical-align:middle;"><?= $this->sma->formatMoney($row->net_unit_cost); ?></td>
                            <?php if ($Settings->tax1) {
                                echo '<td style="width: 80px; text-align:right; vertical-align:middle;">' . ($Settings->indian_gst ? '<small>('.$row->tax.')</small>' : '') . ' ' . $this->sma->formatMoney($row->item_tax) . '</td>';
                            } ?>
                            <td style="width:100px; text-align:right; vertical-align:middle;"><?= $this->sma->formatMoney($row->subtotal); ?></td>
                        </tr>
                        <?php $r++;
                        endforeach; ?>
                    </tbody>
                    <tfoot>
                        <?php $col = $Settings->indian_gst ? 4 : 3;
                        if ($Settings->tax1) {
                            $col += 1;
                        } ?>

                        <tr>
                            <td colspan="<?= $col; ?>"
                                style="text-align:right;"><?= lang("total"); ?>
                                (<?= $default_currency->code; ?>)
                            </td>
                            <td style="text-align:right;">
                                <?= $this->sma->formatMoney($transfer->total_tax); ?>
                            </td>
                            <td style="text-align:right;">
                                <?= $this->sma->formatMoney($transfer->total+$transfer->total_tax); ?>
                            </td>
                        </tr>
                        <?php if ($Settings->indian_gst) {
                            if ($transfer->cgst > 0) {
                                echo '<tr><td colspan="' . ($col+1) . '" class="text-right">' . lang('cgst') . ' (' . $default_currency->code . ')</td><td class="text-right">' . ( $Settings->format_gst ? $this->sma->formatMoney($transfer->cgst) : $transfer->cgst) . '</td></tr>';
                            }
                            if ($transfer->sgst > 0) {
                                echo '<tr><td colspan="' . ($col+1) . '" class="text-right">' . lang('sgst') . ' (' . $default_currency->code . ')</td><td class="text-right">' . ( $Settings->format_gst ? $this->sma->formatMoney($transfer->sgst) : $transfer->sgst) . '</td></tr>';
                            }
                            if ($transfer->igst > 0) {
                                echo '<tr><td colspan="' . ($col+1) . '" class="text-right">' . lang('igst') . ' (' . $default_currency->code . ')</td><td class="text-right">' . ( $Settings->format_gst ? $this->sma->formatMoney($transfer->igst) : $transfer->igst) . '</td></tr>';
                            }
                        } ?>
                        <tr>
                            <td colspan="<?= $col+1; ?>"
                                style="text-align:right; font-weight:bold;"><?= lang("total_amount"); ?>
                                (<?= $default_currency->code; ?>)
                            </td>
                            <td style="text-align:right; font-weight:bold;"><?= $this->sma->formatMoney($transfer->grand_total); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <?php if ($transfer->note || $transfer->note != "") { ?>
                    <div class="well well-sm">
                        <p class="bold"><?= lang("note"); ?>:</p>

                        <div><?= $this->sma->decode_html($transfer->note); ?></div>
                    </div>
                    <?php } ?>
                </div>
                <div class="col-xs-4 pull-left">
                    <p><?= lang("created_by"); ?>: <?= $created_by->first_name.' '.$created_by->last_name; ?> </p>

                    <p>&nbsp;</p>

                    <p>&nbsp;</p>
                    <hr>
                    <p><?= lang("stamp_sign"); ?></p>
                </div>
                <div class="col-xs-4 col-xs-offset-1 pull-right">
                    <p><?= lang("received_by"); ?>: </p>

                    <p>&nbsp;</p>

                    <p>&nbsp;</p>
                    <hr>
                    <p><?= lang("stamp_sign"); ?></p>
                </div>
            </div>
            <?php if (!$Supplier || !$Customer) { ?>
            <div class="buttons">
                <div class="btn-group btn-group-justified">
                    <?php if ($transfer->attachment) { ?>
                    <div class="btn-group">
                        <a href="<?= admin_url('welcome/download/' . $transfer->attachment) ?>" class="tip btn btn-primary" title="<?= lang('attachment') ?>">
                            <i class="fa fa-chain"></i>
                            <span class="hidden-sm hidden-xs"><?= lang('attachment') ?></span>
                        </a>
                    </div>
                    <?php } ?>
                    <div class="btn-group">
                        <a href="<?= admin_url('transfers/email/' . $transfer->id) ?>" data-toggle="modal" data-target="#myModal2" class="tip btn btn-primary" title="<?= lang('email') ?>">
                            <i class="fa fa-envelope-o"></i>
                            <span class="hidden-sm hidden-xs"><?= lang('email') ?></span>
                        </a>
                    </div>
                    <div class="btn-group">
                        <a href="<?= admin_url('transfers/pdf/' . $transfer->id) ?>" class="tip btn btn-primary" title="<?= lang('download_pdf') ?>">
                            <i class="fa fa-download"></i>
                            <span class="hidden-sm hidden-xs"><?= lang('pdf') ?></span>
                        </a>
                    </div>
                    <div class="btn-group">
                        <a href="<?= admin_url('transfers/edit/' . $transfer->id) ?>" class="tip btn btn-warning sledit" title="<?= lang('edit') ?>">
                            <i class="fa fa-edit"></i>
                            <span class="hidden-sm hidden-xs"><?= lang('edit') ?></span>
                        </a>
                    </div>
                    <div class="btn-group">
                        <a href="#" class="tip btn btn-danger bpo" title="<b><?= $this->lang->line("delete") ?></b>"
                            data-content="<div style='width:150px;'><p><?= lang('r_u_sure') ?></p><a class='btn btn-danger' href='<?= admin_url('transfers/delete/' . $transfer->id) ?>'><?= lang('i_m_sure') ?></a> <button class='btn bpo-close'><?= lang('no') ?></button></div>"
                            data-html="true" data-placement="top">
                            <i class="fa fa-trash-o"></i>
                            <span class="hidden-sm hidden-xs"><?= lang('delete') ?></span>
                        </a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready( function() {
        $('.tip').tooltip();
    });
</script>
