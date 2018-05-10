<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $page_title.' | '.$Settings->site_name; ?></title>
    <link rel="shortcut icon" href="<?= $assets ?>img/icon.png"/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="<?= $assets ?>styles/helpers/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= $assets ?>styles/helpers/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <style>
        body { text-align:center; }
        td { text-align: center; }
        h4 { margin:5px; padding:0; }
        .price { font-size:0.8em; font-weight:bold; }
        @media print
        {
            .container { width: auto !important; }
            .container h4, .container p,
            .well, .btn-group, .pagination { display: none; }
            .labels { text-align:center;font-size:10pt;page-break-after:always;padding:1px; }
            .labels img { max-width: 100%; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h4><?=$Settings->site_name.'<br>'.$page_title?></h4>

        <div class="btn-group">
            <a class="btn btn-default" href="javascript:void();" onclick="window.print();"><i class="fa fa-print"></i> <?= lang('print'); ?></a>
            <a class="btn btn-danger" href="javascript:void();" onclick="window.close();"><i class="fa fa-times"></i> <?= lang('close'); ?></a>
        </div>

        <?= (!empty($html)) ? $html : '<h4>'.lang('no_product_found').'</h4>'; ?>
        
    </div>

    <script type="text/javascript" src="<?= $assets ?>js/jquery-2.0.3.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#category').val('<?=$category_id?>');
            $('#category').change(function () {
                window.location.replace("<?php echo admin_url('products/print_labels2'); ?>/" + $(this).val());
                return false;
            });
        });
    </script>
</body>
</html>