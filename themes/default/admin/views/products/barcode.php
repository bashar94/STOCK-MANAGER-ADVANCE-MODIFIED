<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo "Barcode of " . $product_details->name; ?></title>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            font-family: Tahoma, Geneva, sans-serif;
            font-size: 12px;
        }

        #bwrapper {
            width: 348px;
            height: 198px;
            padding: 10px;
            border: 1px solid #666;
            background-color: #FFF;
            margin-top: 25px;
            margin-left: 25px;
            text-align: center;
        }

        #barcode_wrapper img {
            margin: auto;
        }
    </style>
</head>

<body>
<div id="bwrapper">
    <h1><?php echo $product_details->name; ?></h1>
    <?php echo $img; ?>
</div>
</body>
</html>
