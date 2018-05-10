<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMA Promotional Page</title>
    <link href="<?= $assets ?>styles/theme.css" rel="stylesheet">
    <style>
    a,a:focus,a:hover{color:#000}.btn-default,.btn-default:focus,.btn-default:hover{color:#333;text-shadow:none;background-color:#fff;border:1px solid #fff}body,html{height:100%;background-color:#FFF}body{color:#333;text-align:center;text-shadow:0 1px 3px rgba(0,0,0,.05)}.site-wrapper{display:table;width:100%;height:100%;min-height:100%;-webkit-box-shadow:inset 0 0 100px rgba(0,0,0,.5);border:1px solid #ddd;border-radius:10px;}.site-wrapper-inner{display:table-cell;vertical-align:top}.cover-container{margin-right:auto;margin-left:auto}.inner{padding:30px}.masthead-brand{margin-top:10px;margin-bottom:10px}.masthead-nav>li{display:inline-block}.masthead-nav>li+li{margin-left:20px}.masthead-nav>li>a{padding-right:0;padding-left:0;font-size:16px;font-weight:700;color:#333;color:rgba(255,255,255,.75);border-bottom:2px solid transparent}.masthead-nav>li>a:focus,.masthead-nav>li>a:hover{background-color:transparent;border-bottom-color:#a9a9a9;border-bottom-color:rgba(255,255,255,.25)}.masthead-nav>.active>a,.masthead-nav>.active>a:focus,.masthead-nav>.active>a:hover{color:#333;border-bottom-color:#fff}.cover{padding:0 20px}.cover .btn-lg{padding:10px 20px;font-weight:700}.mastfoot{color:#ccc;color:#333}@media (min-width:768px){.masthead{position:fixed;top:0}.mastfoot{position:fixed;bottom:0}.site-wrapper-inner{vertical-align:middle}.cover-container,.mastfoot,.masthead{width:100%}}@media (min-width:992px){.cover-container,.mastfoot,.masthead{width:700px}}
    </style>
</head>

<body>
    <div class="site-wrapper">
        <div class="site-wrapper-inner">
            <div class="cover-container">
                <div class="masthead clearfix">
                    <div class="inner">
                        <h3 class="text-center"><?= $Settings->site_name; ?></h3>
                    </div>
                </div>
                <div class="inner cover">
                    <h1 class="cover-heading">POS Module for Stock Manager Advance</h1>
                    <p class="lead">Stock Manager Advance is php based web application for small and medium business to manage inventory, sales (with online payments), expenses, customers and warehouses. </p>
                    <p>Please edit themes/<?=$Settings->theme;?>/views/promotions.php</p>
                </div>
                <div class="mastfoot">
                    <div class="inner">
                        <p>Stock Manager Advacne by <a href="http://tecdiary.com">Tecdiary</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?= $assets ?>js/jquery.js"></script>
    <script type="text/javascript" src="<?= $assets ?>js/bootstrap.min.js"></script>
</body>
</html>
