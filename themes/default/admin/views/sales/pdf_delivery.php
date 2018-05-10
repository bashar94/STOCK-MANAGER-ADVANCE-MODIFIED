<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $this->lang->line("delivery") . " " . $delivery->do_transfer_no; ?></title>
    <link href="<?php echo $assets ?>styles/style.css" rel="stylesheet">
    <style type="text/css">
        html, body {
            height: 100%;
            background: #FFF;
        }
        body:before, body:after {
            display: none !important;
        }
        .table th {
            text-align: center;
            padding: 5px;
        }
        .table td {
            padding: 4px;
        }
    </style>
</head>

<body>
<div id="wrap">

    <?php if ($logo) { ?>
        <div class="text-center" style="margin-bottom:20px;">
            <img src="<?= base_url() . 'assets/uploads/logos/' . $biller->logo; ?>"
                 alt="<?= $biller->company != '-' ? $biller->company : $biller->name; ?>">
        </div>
    <?php } ?>
    <div class="table-responsive">
        <table class="table table-bordered">

            <tbody>
            <tr>
                <td width="30%"><?php echo $this->lang->line("date"); ?></td>
                <td width="70%"><?php echo $this->sma->hrld($delivery->date); ?></td>
            </tr>
            <tr>
                <td><?php echo $this->lang->line("do_reference_no"); ?></td>
                <td><?php echo $delivery->do_reference_no; ?></td>
            </tr>
            <tr>
                <td><?php echo $this->lang->line("sale_reference_no"); ?></td>
                <td><?php echo $delivery->sale_reference_no; ?></td>
            </tr>
            <tr>
                <td><?php echo $this->lang->line("customer"); ?></td>
                <td><?php echo $delivery->customer; ?></td>
            </tr>
            <tr>
                <td><?php echo $this->lang->line("address"); ?></td>
                <td><?php echo $delivery->address; ?></td>
            </tr>
            <tr>
                <td><?= lang("status"); ?></td>
                <td><?= lang($delivery->status); ?></td>
            </tr>
            <?php if ($delivery->note) { ?>
                <tr>
                    <td><?php echo $this->lang->line("note"); ?></td>
                    <td><?php echo $this->sma->decode_html($delivery->note); ?></td>
                </tr>
            <?php } ?>
            </tbody>

        </table>
    </div>
    <h3><?php echo $this->lang->line("items"); ?></h3>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">

            <thead>
                <tr>
                    <th style="text-align:center; vertical-align:middle;"><?php echo $this->lang->line("no"); ?></th>
                    <th style="vertical-align:middle;"><?php echo $this->lang->line("description"); ?></th>
                    <th style="text-align:center; vertical-align:middle;"><?php echo $this->lang->line("quantity"); ?></th>
                </tr>
            </thead>

            <tbody>
            <?php $r = 1;
            foreach ($rows as $row): ?>
                <tr>
                    <td style="text-align:center; width:40px; vertical-align:middle;"><?php echo $r; ?></td>
                    <td style="vertical-align:middle;">
                        <?= $row->product_code ." - " .$row->product_name .($row->variant ? ' (' . $row->variant . ')' : '');
                        if ($row->details) {
                            echo '<br><strong>' . lang("product_details") . '</strong> ' .
                            html_entity_decode($row->details);
                        }
                        ?>
                    </td>
                    <td style="width: 150px; text-align:center; vertical-align:middle;">
                        <?= $this->sma->formatQuantity($row->unit_quantity).' '.$row->product_unit_code; ?>
                    </td>
                </tr>
                <?php
                $r++;
            endforeach;
            ?>
            </tbody>
        </table>
    </div>

    <div class="clearfix"></div>

    <?php if ($delivery->status == 'delivered') { ?>
    <div class="row">
        <div class="col-xs-4">
            <p><?= lang("prepared_by"); ?>:<br> <?= $user->first_name . ' ' . $user->last_name; ?> </p>
        </div>
        <div class="col-xs-4">
            <p><?= lang("delivered_by"); ?>:<br> <?= $delivery->delivered_by; ?></p>
        </div>
        <div class="col-xs-4">
            <p><?= lang("received_by"); ?>:<br> <?= $delivery->received_by; ?></p>
        </div>
    </div>
    <?php } else { ?>
    <div class="row">
        <div class="col-xs-4">
            <p style="height:80px;"><?= lang("prepared_by"); ?>
                : <?= $user->first_name . ' ' . $user->last_name; ?> </p>
            <hr>
            <p><?= lang("stamp_sign"); ?></p>
        </div>
        <div class="col-xs-4">
            <p style="height:80px;"><?= lang("delivered_by"); ?>: </p>
            <hr>
            <p><?= lang("stamp_sign"); ?></p>
        </div>
        <div class="col-xs-4">
            <p style="height:80px;"><?= lang("received_by"); ?>: </p>
            <hr>
            <p><?= lang("stamp_sign"); ?></p>
        </div>
    </div>
    <?php } ?>

</div>
</body>
</html>
