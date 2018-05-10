<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <base href="<?= base_url(); ?>"/>
    <title><?php echo $page_title . " | " . $Settings->site_name; ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="<?= $assets; ?>styles/theme.css" type="text/css" charset="utf-8">
    <link rel="stylesheet" href="<?= $assets; ?>styles/style.css" type="text/css" charset="utf-8">
    <style>
        body {
            font-size: 13px;
            text-align: center;
            color: #000;
            background: #FFF;
        }

        body:before, body:after {
            display: none;
        }

        .tab-wrapper {
            max-width: 1000px;
            margin: 0 auto;
        }

        h4 {
            margin: 5px;
            padding: 0;
        }

        /*.bc img { width: 100%; }*/
        @media print {
            .table td {
                border-color: #F9F9F9 !important;
            }

            .table .table-barcode td {
                border-color: #FFF !important;
            }

            .tab-wrapper {
                width: auto !important;
            }

            h3 {
                margin-top: 0;
            }

            .container p, .pagination, .well {
                display: none;
            }

            hr { page-break-after: always; }

        }
    </style>
</head>
<body>
<div class="tab-wrapper">
    <div class="well">
                <span style="margin-top:15px; display: block;">
                    <div class="btn-group">
                        <!--<a class="btn btn-success" href="<?= admin_url() ?>"><i class="fa fa-home"></i> <?= lang('home') ?></a>-->
                        <a class="btn btn-primary" href="#" onclick="window.print();
                                return false;"><i class="fa fa-print"></i> <?php echo $this->lang->line('print'); ?></a>
                        <a class="btn btn-danger" onclick="javascript:window.close()"><i
                                class="fa fa-times"></i> <?= lang('close'); ?></a>
                    </div>
                </span>
    </div>
    <?php echo $table; ?>
    <div class="well">
                <span style="margin-top:15px; display: block;">
                    <div class="btn-group">
                        <!--<a class="btn btn-success" href="<?= admin_url() ?>"><i class="fa fa-home"></i> <?= lang('home') ?></a>-->
                        <a class="btn btn-primary" href="#" onclick="window.print();
                                return false;"><i class="fa fa-print"></i> <?php echo $this->lang->line('print'); ?></a>
                        <a class="btn btn-danger" onclick="javascript:window.close()"><i
                                class="fa fa-times"></i> <?= lang('close'); ?></a>
                    </div>
                </span>
    </div>
</div>

</body>
</html>
