<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <base href="<?= admin_url() ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?> - <?= $Settings->site_name ?></title>
    <link rel="shortcut icon" href="<?= $assets ?>images/icon.png"/>
    <link href="<?= $assets ?>styles/theme.css" rel="stylesheet"/>
    <link href="<?= $assets ?>styles/style.css" rel="stylesheet"/>
    <script type="text/javascript" src="<?= $assets ?>js/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="<?= $assets ?>js/jquery-migrate-1.2.1.min.js"></script>
    <!--[if lt IE 9]>
    <script src="<?= $assets ?>js/jquery.js"></script>
    <![endif]-->
    <noscript><style type="text/css">#loading { display: none; }</style></noscript>
    <?php if ($Settings->user_rtl) { ?>
        <link href="<?= $assets ?>styles/helpers/bootstrap-rtl.min.css" rel="stylesheet"/>
        <link href="<?= $assets ?>styles/style-rtl.css" rel="stylesheet"/>
        <script type="text/javascript">
            $(document).ready(function () { $('.pull-right, .pull-left').addClass('flip'); });
        </script>
    <?php } ?>
    <script type="text/javascript">
        $(window).load(function () {
            $("#loading").fadeOut("slow");
        });
    </script>
</head>

<body>
<noscript>
    <div class="global-site-notice noscript">
        <div class="notice-inner">
            <p><strong>JavaScript seems to be disabled in your browser.</strong><br>You must have JavaScript enabled in
                your browser to utilize the functionality of this website.</p>
        </div>
    </div>
</noscript>
<div id="loading"></div>
<div id="app_wrapper">
    <header id="header" class="navbar">
        <div class="container">
            <a class="navbar-brand" href="<?= admin_url() ?>"><span class="logo"><?= $Settings->site_name ?></span></a>

            <div class="btn-group visible-xs pull-right btn-visible-sm">
                <button class="navbar-toggle btn" type="button" data-toggle="collapse" data-target="#sidebar_menu">
                    <span class="fa fa-bars"></span>
                </button>
                <?php if (SHOP) { ?>
                <a href="<?= site_url('/') ?>" class="btn">
                    <span class="fa fa-shopping-cart"></span>
                </a>
                <?php } ?>
                <a href="<?= admin_url('calendar') ?>" class="btn">
                    <span class="fa fa-calendar"></span>
                </a>
                <a href="<?= admin_url('users/profile/' . $this->session->userdata('user_id')); ?>" class="btn">
                    <span class="fa fa-user"></span>
                </a>
                <a href="<?= admin_url('logout'); ?>" class="btn">
                    <span class="fa fa-sign-out"></span>
                </a>
            </div>
            <div class="header-nav">
                <ul class="nav navbar-nav pull-right">
                    <li class="dropdown">
                        <a class="btn account dropdown-toggle" data-toggle="dropdown" href="#">
                            <img alt="" src="<?= $this->session->userdata('avatar') ? base_url() . 'assets/uploads/avatars/thumbs/' . $this->session->userdata('avatar') : base_url('assets/images/' . $this->session->userdata('gender') . '.png'); ?>" class="mini_avatar img-rounded">

                            <div class="user">
                                <span><?= lang('welcome') ?> <?= $this->session->userdata('username'); ?></span>
                            </div>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li>
                                <a href="<?= admin_url('users/profile/' . $this->session->userdata('user_id')); ?>">
                                    <i class="fa fa-user"></i> <?= lang('profile'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?= admin_url('users/profile/' . $this->session->userdata('user_id') . '/#cpassword'); ?>"><i class="fa fa-key"></i> <?= lang('change_password'); ?>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="<?= admin_url('logout'); ?>">
                                    <i class="fa fa-sign-out"></i> <?= lang('logout'); ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav pull-right">
                    <li class="dropdown hidden-xs"><a class="btn tip" title="<?= lang('dashboard') ?>" data-placement="bottom" href="<?= admin_url('welcome') ?>"><i class="fa fa-dashboard"></i></a></li>
                    <?php if (SHOP) { ?>
                    <li class="dropdown hidden-xs"><a class="btn tip" title="<?= lang('shop') ?>" data-placement="bottom" href="<?= base_url() ?>"><i class="fa fa-shopping-cart"></i></a></li>
                    <?php } ?>
                    <?php if ($Owner) { ?>
                    <li class="dropdown hidden-sm">
                        <a class="btn tip" title="<?= lang('settings') ?>" data-placement="bottom" href="<?= admin_url('system_settings') ?>">
                            <i class="fa fa-cogs"></i>
                        </a>
                    </li>
                    <?php } ?>
                    <li class="dropdown hidden-xs">
                        <a class="btn tip" title="<?= lang('calculator') ?>" data-placement="bottom" href="#" data-toggle="dropdown">
                            <i class="fa fa-calculator"></i>
                        </a>
                        <ul class="dropdown-menu pull-right calc">
                            <li class="dropdown-content">
                                <span id="inlineCalc"></span>
                            </li>
                        </ul>
                    </li>
                    <?php if ($info) { ?>
                        <li class="dropdown hidden-sm">
                            <a class="btn tip" title="<?= lang('notifications') ?>" data-placement="bottom" href="#" data-toggle="dropdown">
                                <i class="fa fa-info-circle"></i>
                                <span class="number blightOrange black"><?= sizeof($info) ?></span>
                            </a>
                            <ul class="dropdown-menu pull-right content-scroll">
                                <li class="dropdown-header"><i class="fa fa-info-circle"></i> <?= lang('notifications'); ?></li>
                                <li class="dropdown-content">
                                    <div class="scroll-div">
                                        <div class="top-menu-scroll">
                                            <ol class="oe">
                                                <?php foreach ($info as $n) {
                                                    echo '<li>' . $n->comment . '</li>';
                                                } ?>
                                            </ol>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>
                    <?php if ($events) { ?>
                        <li class="dropdown hidden-xs">
                            <a class="btn tip" title="<?= lang('calendar') ?>" data-placement="bottom" href="#" data-toggle="dropdown">
                                <i class="fa fa-calendar"></i>
                                <span class="number blightOrange black"><?= sizeof($events) ?></span>
                            </a>
                            <ul class="dropdown-menu pull-right content-scroll">
                                <li class="dropdown-header">
                                <i class="fa fa-calendar"></i> <?= lang('upcoming_events'); ?>
                                </li>
                                <li class="dropdown-content">
                                    <div class="top-menu-scroll">
                                        <ol class="oe">
                                            <?php foreach ($events as $event) {
                                                echo '<li>' . date($dateFormats['php_ldate'], strtotime($event->start)) . ' <strong>' . $event->title . '</strong><br>'.$event->description.'</li>';
                                            } ?>
                                        </ol>
                                    </div>
                                </li>
                                <li class="dropdown-footer">
                                    <a href="<?= admin_url('calendar') ?>" class="btn-block link">
                                        <i class="fa fa-calendar"></i> <?= lang('calendar') ?>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php } else { ?>
                    <li class="dropdown hidden-xs">
                        <a class="btn tip" title="<?= lang('calendar') ?>" data-placement="bottom" href="<?= admin_url('calendar') ?>">
                            <i class="fa fa-calendar"></i>
                        </a>
                    </li>
                    <?php } ?>
                    <li class="dropdown hidden-sm">
                        <a class="btn tip" title="<?= lang('styles') ?>" data-placement="bottom" data-toggle="dropdown"
                           href="#">
                            <i class="fa fa-css3"></i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li class="bwhite noPadding">
                                <a href="#" id="fixed" class="">
                                    <i class="fa fa-angle-double-left"></i>
                                    <span id="fixedText">Fixed</span>
                                </a>
                                <a href="#" id="cssLight" class="grey">
                                    <i class="fa fa-stop"></i> Grey
                                </a>
                                <a href="#" id="cssBlue" class="blue">
                                    <i class="fa fa-stop"></i> Blue
                                </a>
                                <a href="#" id="cssBlack" class="black">
                                   <i class="fa fa-stop"></i> Black
                               </a>
                           </li>
                        </ul>
                    </li>
                    <li class="dropdown hidden-xs">
                        <a class="btn tip" title="<?= lang('language') ?>" data-placement="bottom" data-toggle="dropdown"
                           href="#">
                            <img src="<?= base_url('assets/images/' . $Settings->user_language . '.png'); ?>" alt="">
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <?php $scanned_lang_dir = array_map(function ($path) {
                                return basename($path);
                            }, glob(APPPATH . 'language/*', GLOB_ONLYDIR));
                            foreach ($scanned_lang_dir as $entry) { ?>
                                <li>
                                    <a href="<?= admin_url('welcome/language/' . $entry); ?>">
                                        <img src="<?= base_url('assets/images/'.$entry.'.png'); ?>" class="language-img">
                                        &nbsp;&nbsp;<?= ucwords($entry); ?>
                                    </a>
                                </li>
                            <?php } ?>
                            <li class="divider"></li>
                            <li>
                                <a href="<?= admin_url('welcome/toggle_rtl') ?>">
                                    <i class="fa fa-align-<?=$Settings->user_rtl ? 'right' : 'left';?>"></i>
                                    <?= lang('toggle_alignment') ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <?php /* if ($Owner && $Settings->update) { ?>
                    <li class="dropdown hidden-sm">
                        <a class="btn blightOrange tip" title="<?= lang('update_available') ?>"
                            data-placement="bottom" data-container="body" href="<?= admin_url('system_settings/updates') ?>">
                            <i class="fa fa-download"></i>
                        </a>
                    </li>
                        <?php } */ ?>
                    <?php if (($Owner || $Admin || $GP['reports-quantity_alerts'] || $GP['reports-expiry_alerts']) && ($qty_alert_num > 0 || $exp_alert_num > 0 || $shop_sale_alerts)) { ?>
                        <li class="dropdown hidden-sm">
                            <a class="btn blightOrange tip" title="<?= lang('alerts') ?>"
                                data-placement="left" data-toggle="dropdown" href="#">
                                <i class="fa fa-exclamation-triangle"></i>
                                <span class="number bred black"><?= $qty_alert_num+(($Settings->product_expiry) ? $exp_alert_num : 0)+$shop_sale_alerts+$shop_payment_alerts; ?></span>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <?php if ($qty_alert_num > 0) { ?>
                                <li>
                                    <a href="<?= admin_url('reports/quantity_alerts') ?>" class="">
                                        <span class="label label-danger pull-right" style="margin-top:3px;"><?= $qty_alert_num; ?></span>
                                        <span style="padding-right: 35px;"><?= lang('quantity_alerts') ?></span>
                                    </a>
                                </li>
                                <?php } ?>
                                <?php if ($Settings->product_expiry) { ?>
                                <li>
                                    <a href="<?= admin_url('reports/expiry_alerts') ?>" class="">
                                        <span class="label label-danger pull-right" style="margin-top:3px;"><?= $exp_alert_num; ?></span>
                                        <span style="padding-right: 35px;"><?= lang('expiry_alerts') ?></span>
                                    </a>
                                </li>
                                <?php } ?>
                                <?php if ($shop_sale_alerts) { ?>
                                <li>
                                    <a href="<?= admin_url('sales?shop=yes&delivery=no') ?>" class="">
                                        <span class="label label-danger pull-right" style="margin-top:3px;"><?= $shop_sale_alerts; ?></span>
                                        <span style="padding-right: 35px;"><?= lang('sales_x_delivered') ?></span>
                                    </a>
                                </li>
                                <?php } ?>
                                <?php if ($shop_payment_alerts) { ?>
                                <li>
                                    <a href="<?= admin_url('sales?shop=yes&attachment=yes') ?>" class="">
                                        <span class="label label-danger pull-right" style="margin-top:3px;"><?= $shop_payment_alerts; ?></span>
                                        <span style="padding-right: 35px;"><?= lang('manual_payments') ?></span>
                                    </a>
                                </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                    <?php if (POS) { ?>
                    <li class="dropdown hidden-xs">
                        <a class="btn bdarkGreen tip" title="<?= lang('pos') ?>" data-placement="bottom" href="<?= admin_url('pos') ?>">
                            <i class="fa fa-th-large"></i> <span class="padding05"><?= lang('pos') ?></span>
                        </a>
                    </li>
                    <?php } ?>
                    <?php if ($Owner) { ?>
                        <li class="dropdown">
                            <a class="btn bdarkGreen tip" id="today_profit" title="<span><?= lang('today_profit') ?></span>"
                                data-placement="bottom" data-html="true" href="<?= admin_url('reports/profit') ?>"
                                data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-hourglass-2"></i>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($Owner || $Admin) { ?>
                    <?php if (POS) { ?>
                    <li class="dropdown hidden-xs">
                        <a class="btn bblue tip" title="<?= lang('list_open_registers') ?>" data-placement="bottom" href="<?= admin_url('pos/registers') ?>">
                            <i class="fa fa-list"></i>
                        </a>
                    </li>
                    <?php } ?>
                    <li class="dropdown hidden-xs">
                        <a class="btn bred tip" title="<?= lang('clear_ls') ?>" data-placement="bottom" id="clearLS" href="#">
                            <i class="fa fa-eraser"></i>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </header>

    <div class="container" id="container">
        <div class="row" id="main-con">
        <table class="lt"><tr><td class="sidebar-con">
            <div id="sidebar-left">
                <div class="sidebar-nav nav-collapse collapse navbar-collapse" id="sidebar_menu">
                    <ul class="nav main-menu">
                        <li class="mm_welcome">
                            <a href="<?= admin_url() ?>">
                                <i class="fa fa-dashboard"></i>
                                <span class="text"> <?= lang('dashboard'); ?></span>
                            </a>
                        </li>

                        <?php
                        if ($Owner || $Admin) {
                            ?>

                            <li class="mm_products">
                                <a class="dropmenu" href="#">
                                    <i class="fa fa-barcode"></i>
                                    <span class="text"> <?= lang('products'); ?> </span>
                                    <span class="chevron closed"></span>
                                </a>
                                <ul>
                                    <li id="products_index">
                                        <a class="submenu" href="<?= admin_url('products'); ?>">
                                            <i class="fa fa-barcode"></i>
                                            <span class="text"> <?= lang('list_products'); ?></span>
                                        </a>
                                    </li>
                                    <li id="products_add">
                                        <a class="submenu" href="<?= admin_url('products/add'); ?>">
                                            <i class="fa fa-plus-circle"></i>
                                            <span class="text"> <?= lang('add_product'); ?></span>
                                        </a>
                                    </li>

                                     <li id="products_add_existing">
                                        <a class="submenu" href="<?= admin_url('products/add_existing'); ?>">
                                            <i class="fa fa-plus-circle"></i>
                                            <span class="text"> Add Existing</span>
                                        </a>
                                    </li>  

                                    <li id="products_import_csv">
                                        <a class="submenu" href="<?= admin_url('products/import_csv'); ?>">
                                            <i class="fa fa-file-text"></i>
                                            <span class="text"> <?= lang('import_products'); ?></span>
                                        </a>
                                    </li>
                                    <li id="products_print_barcodes">
                                        <a class="submenu" href="<?= admin_url('products/print_barcodes'); ?>">
                                            <i class="fa fa-tags"></i>
                                            <span class="text"> <?= lang('print_barcode_label'); ?></span>
                                        </a>
                                    </li>
                                    <li id="products_quantity_adjustments">
                                        <a class="submenu" href="<?= admin_url('products/quantity_adjustments'); ?>">
                                            <i class="fa fa-filter"></i>
                                            <span class="text"> <?= lang('quantity_adjustments'); ?></span>
                                        </a>
                                    </li>
                                    <li id="products_add_adjustment">
                                        <a class="submenu" href="<?= admin_url('products/add_adjustment'); ?>">
                                            <i class="fa fa-filter"></i>
                                            <span class="text"> <?= lang('add_adjustment'); ?></span>
                                        </a>
                                    </li>
                                    <li id="products_stock_counts">
                                        <a class="submenu" href="<?= admin_url('products/stock_counts'); ?>">
                                            <i class="fa fa-list-ol"></i>
                                            <span class="text"> <?= lang('stock_counts'); ?></span>
                                        </a>
                                    </li>
                                    <li id="products_count_stock">
                                        <a class="submenu" href="<?= admin_url('products/count_stock'); ?>">
                                            <i class="fa fa-plus-circle"></i>
                                            <span class="text"> <?= lang('count_stock'); ?></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="mm_sales <?= strtolower($this->router->fetch_method()) == 'sales' ? 'mm_pos' : '' ?>">
                                <a class="dropmenu" href="#">
                                    <i class="fa fa-heart"></i>
                                    <span class="text"> <?= lang('sales'); ?>
                                    </span> <span class="chevron closed"></span>
                                </a>
                                <ul>
                                    <li id="sales_index">
                                        <a class="submenu" href="<?= admin_url('sales'); ?>">
                                            <i class="fa fa-heart"></i>
                                            <span class="text"> <?= lang('list_sales'); ?></span>
                                        </a>
                                    </li>
                                    <?php if (POS) { ?>
                                    <li id="pos_sales">
                                        <a class="submenu" href="<?= admin_url('pos/sales'); ?>">
                                            <i class="fa fa-heart"></i>
                                            <span class="text"> <?= lang('pos_sales'); ?></span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <li id="sales_add">
                                        <a class="submenu" href="<?= admin_url('sales/add'); ?>">
                                            <i class="fa fa-plus-circle"></i>
                                            <span class="text"> <?= lang('add_sale'); ?></span>
                                        </a>
                                    </li>
                                    <li id="sales_sale_by_csv">
                                        <a class="submenu" href="<?= admin_url('sales/sale_by_csv'); ?>">
                                            <i class="fa fa-plus-circle"></i>
                                            <span class="text"> <?= lang('add_sale_by_csv'); ?></span>
                                        </a>
                                    </li>
                                    <li id="sales_deliveries">
                                        <a class="submenu" href="<?= admin_url('sales/deliveries'); ?>">
                                            <i class="fa fa-truck"></i>
                                            <span class="text"> <?= lang('deliveries'); ?></span>
                                        </a>
                                    </li>
                                    <li id="sales_gift_cards">
                                        <a class="submenu" href="<?= admin_url('sales/gift_cards'); ?>">
                                            <i class="fa fa-gift"></i>
                                            <span class="text"> <?= lang('list_gift_cards'); ?></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="mm_quotes">
                                <a class="dropmenu" href="#">
                                    <i class="fa fa-heart-o"></i>
                                    <span class="text"> <?= lang('quotes'); ?> </span>
                                    <span class="chevron closed"></span>
                                </a>
                                <ul>
                                    <li id="quotes_index">
                                        <a class="submenu" href="<?= admin_url('quotes'); ?>">
                                            <i class="fa fa-heart-o"></i>
                                            <span class="text"> <?= lang('list_quotes'); ?></span>
                                        </a>
                                    </li>
                                    <li id="quotes_add">
                                        <a class="submenu" href="<?= admin_url('quotes/add'); ?>">
                                            <i class="fa fa-plus-circle"></i>
                                            <span class="text"> <?= lang('add_quote'); ?></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="mm_purchases">
                                <a class="dropmenu" href="#">
                                    <i class="fa fa-star"></i>
                                    <span class="text"> <?= lang('purchases'); ?>
                                    </span> <span class="chevron closed"></span>
                                </a>
                                <ul>
                                    <li id="purchases_index">
                                        <a class="submenu" href="<?= admin_url('purchases'); ?>">
                                            <i class="fa fa-star"></i>
                                            <span class="text"> <?= lang('list_purchases'); ?></span>
                                        </a>
                                    </li>
                                    <li id="purchases_add">
                                        <a class="submenu" href="<?= admin_url('purchases/add'); ?>">
                                            <i class="fa fa-plus-circle"></i>
                                            <span class="text"> <?= lang('add_purchase'); ?></span>
                                        </a>
                                    </li>
                                    <li id="purchases_purchase_by_csv">
                                        <a class="submenu" href="<?= admin_url('purchases/purchase_by_csv'); ?>">
                                            <i class="fa fa-plus-circle"></i>
                                            <span class="text"> <?= lang('add_purchase_by_csv'); ?></span>
                                        </a>
                                    </li>
                                    <li id="purchases_expenses">
                                        <a class="submenu" href="<?= admin_url('purchases/expenses'); ?>">
                                            <i class="fa fa-dollar"></i>
                                            <span class="text"> <?= lang('list_expenses'); ?></span>
                                        </a>
                                    </li>
                                    <li id="purchases_add_expense">
                                        <a class="submenu" href="<?= admin_url('purchases/add_expense'); ?>" data-toggle="modal" data-target="#myModal">
                                            <i class="fa fa-plus-circle"></i>
                                            <span class="text"> <?= lang('add_expense'); ?></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="mm_transfers">
                                <a class="dropmenu" href="#">
                                    <i class="fa fa-star-o"></i>
                                    <span class="text"> <?= lang('transfers'); ?> </span>
                                    <span class="chevron closed"></span>
                                </a>
                                <ul>
                                    <li id="transfers_index">
                                        <a class="submenu" href="<?= admin_url('transfers'); ?>">
                                            <i class="fa fa-star-o"></i><span class="text"> <?= lang('list_transfers'); ?></span>
                                        </a>
                                    </li>
                                    <li id="transfers_add">
                                        <a class="submenu" href="<?= admin_url('transfers/add'); ?>">
                                            <i class="fa fa-plus-circle"></i><span class="text"> <?= lang('add_transfer'); ?></span>
                                        </a>
                                    </li>
                                    <li id="transfers_purchase_by_csv">
                                        <a class="submenu" href="<?= admin_url('transfers/transfer_by_csv'); ?>">
                                            <i class="fa fa-plus-circle"></i><span class="text"> <?= lang('add_transfer_by_csv'); ?></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                          <!--   <li class="mm_returns">
                                <a class="dropmenu" href="#">
                                    <i class="fa fa-random"></i>
                                    <span class="text"> <?= lang('returns'); ?> </span>
                                    <span class="chevron closed"></span>
                                </a>
                                <ul>
                                    <li id="returns_index">
                                        <a class="submenu" href="<?= admin_url('returns'); ?>">
                                            <i class="fa fa-random"></i><span class="text"> <?= lang('list_returns'); ?></span>
                                        </a>
                                    </li>
                                    <li id="returns_add">
                                        <a class="submenu" href="<?= admin_url('returns/add'); ?>">
                                            <i class="fa fa-plus-circle"></i><span class="text"> <?= lang('add_return'); ?></span>
                                        </a>
                                    </li>
                                </ul>
                            </li> -->

                            <li class="mm_auth mm_customers mm_suppliers mm_billers">
                                <a class="dropmenu" href="#">
                                <i class="fa fa-users"></i>
                                <span class="text"> <?= lang('people'); ?> </span>
                                <span class="chevron closed"></span>
                                </a>
                                <ul>
                                    <?php if ($Owner) { ?>
                                    <li id="auth_users">
                                        <a class="submenu" href="<?= admin_url('users'); ?>">
                                            <i class="fa fa-users"></i><span class="text"> <?= lang('list_users'); ?></span>
                                        </a>
                                    </li>
                                    <li id="auth_create_user">
                                        <a class="submenu" href="<?= admin_url('users/create_user'); ?>">
                                            <i class="fa fa-user-plus"></i><span class="text"> <?= lang('new_user'); ?></span>
                                        </a>
                                    </li>
                                    <li id="billers_index">
                                        <a class="submenu" href="<?= admin_url('billers'); ?>">
                                            <i class="fa fa-users"></i><span class="text"> <?= lang('list_billers'); ?></span>
                                        </a>
                                    </li>
                                    <li id="billers_index">
                                        <a class="submenu" href="<?= admin_url('billers/add'); ?>" data-toggle="modal" data-target="#myModal">
                                            <i class="fa fa-plus-circle"></i><span class="text"> <?= lang('add_biller'); ?></span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <li id="customers_index">
                                        <a class="submenu" href="<?= admin_url('customers'); ?>">
                                            <i class="fa fa-users"></i><span class="text"> <?= lang('list_customers'); ?></span>
                                        </a>
                                    </li>
                                    <li id="customers_index">
                                        <a class="submenu" href="<?= admin_url('customers/add'); ?>" data-toggle="modal" data-target="#myModal">
                                            <i class="fa fa-plus-circle"></i><span class="text"> <?= lang('add_customer'); ?></span>
                                        </a>
                                    </li>
                                    <li id="suppliers_index">
                                        <a class="submenu" href="<?= admin_url('suppliers'); ?>">
                                            <i class="fa fa-users"></i><span class="text"> <?= lang('list_suppliers'); ?></span>
                                        </a>
                                    </li>
                                    <li id="suppliers_index">
                                        <a class="submenu" href="<?= admin_url('suppliers/add'); ?>" data-toggle="modal" data-target="#myModal">
                                            <i class="fa fa-plus-circle"></i><span class="text"> <?= lang('add_supplier'); ?></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="mm_notifications">
                                <a class="submenu" href="<?= admin_url('notifications'); ?>">
                                    <i class="fa fa-info-circle"></i><span class="text"> <?= lang('notifications'); ?></span>
                                </a>
                            </li>
                            <li class="mm_calendar">
                                <a class="submenu" href="<?= admin_url('calendar'); ?>">
                                    <i class="fa fa-calendar"></i><span class="text"> <?= lang('calendar'); ?></span>
                                </a>
                            </li>
                            <?php if ($Owner) { ?>
                                <li class="mm_system_settings <?= strtolower($this->router->fetch_method()) == 'sales' ? '' : 'mm_pos' ?>">
                                    <a class="dropmenu" href="#">
                                        <i class="fa fa-cog"></i><span class="text"> <?= lang('settings'); ?> </span>
                                        <span class="chevron closed"></span>
                                    </a>
                                    <ul>
                                        <li id="system_settings_index">
                                            <a href="<?= admin_url('system_settings') ?>">
                                                <i class="fa fa-cogs"></i><span class="text"> <?= lang('system_settings'); ?></span>
                                            </a>
                                        </li>
                                        <?php if (POS) { ?>
                                        <li id="pos_settings">
                                            <a href="<?= admin_url('pos/settings') ?>">
                                                <i class="fa fa-th-large"></i><span class="text"> <?= lang('pos_settings'); ?></span>
                                            </a>
                                        </li>
                                        <li id="pos_printers">
                                            <a href="<?= admin_url('pos/printers') ?>">
                                                <i class="fa fa-print"></i><span class="text"> <?= lang('list_printers'); ?></span>
                                            </a>
                                        </li>
                                        <li id="pos_add_printer">
                                            <a href="<?= admin_url('pos/add_printer') ?>">
                                                <i class="fa fa-plus-circle"></i><span class="text"> <?= lang('add_printer'); ?></span>
                                            </a>
                                        </li>
                                        <?php } ?>
                                        <li id="system_settings_change_logo">
                                            <a href="<?= admin_url('system_settings/change_logo') ?>" data-toggle="modal" data-target="#myModal">
                                                <i class="fa fa-upload"></i><span class="text"> <?= lang('change_logo'); ?></span>
                                            </a>
                                        </li>
                                        <li id="system_settings_currencies">
                                            <a href="<?= admin_url('system_settings/currencies') ?>">
                                                <i class="fa fa-money"></i><span class="text"> <?= lang('currencies'); ?></span>
                                            </a>
                                        </li>
                                        <li id="system_settings_customer_groups">
                                            <a href="<?= admin_url('system_settings/customer_groups') ?>">
                                                <i class="fa fa-chain"></i><span class="text"> <?= lang('customer_groups'); ?></span>
                                            </a>
                                        </li>
                                        <li id="system_settings_price_groups">
                                            <a href="<?= admin_url('system_settings/price_groups') ?>">
                                                <i class="fa fa-dollar"></i><span class="text"> <?= lang('price_groups'); ?></span>
                                            </a>
                                        </li>
                                        <li id="system_settings_categories">
                                            <a href="<?= admin_url('system_settings/categories') ?>">
                                                <i class="fa fa-folder-open"></i><span class="text"> <?= lang('categories'); ?></span>
                                            </a>
                                        </li>
                                        <li id="system_settings_expense_categories">
                                            <a href="<?= admin_url('system_settings/expense_categories') ?>">
                                                <i class="fa fa-folder-open"></i><span class="text"> <?= lang('expense_categories'); ?></span>
                                            </a>
                                        </li>
                                        <li id="system_settings_units">
                                            <a href="<?= admin_url('system_settings/units') ?>">
                                                <i class="fa fa-wrench"></i><span class="text"> <?= lang('units'); ?></span>
                                            </a>
                                        </li>
                                        <li id="system_settings_brands">
                                            <a href="<?= admin_url('system_settings/brands') ?>">
                                                <i class="fa fa-th-list"></i><span class="text"> <?= lang('brands'); ?></span>
                                            </a>
                                        </li>
                                        <li id="system_settings_variants">
                                            <a href="<?= admin_url('system_settings/variants') ?>">
                                                <i class="fa fa-tags"></i><span class="text"> <?= lang('variants'); ?></span>
                                            </a>
                                        </li>
                                        <li id="system_settings_tax_rates">
                                            <a href="<?= admin_url('system_settings/tax_rates') ?>">
                                                <i class="fa fa-plus-circle"></i><span class="text"> <?= lang('tax_rates'); ?></span>
                                            </a>
                                        </li>
                                        <li id="system_settings_warehouses">
                                            <a href="<?= admin_url('system_settings/warehouses') ?>">
                                                <i class="fa fa-building-o"></i><span class="text"> <?= lang('warehouses'); ?></span>
                                            </a>
                                        </li>
                                        <li id="system_settings_email_templates">
                                            <a href="<?= admin_url('system_settings/email_templates') ?>">
                                                <i class="fa fa-envelope"></i><span class="text"> <?= lang('email_templates'); ?></span>
                                            </a>
                                        </li>
                                        <li id="system_settings_user_groups">
                                            <a href="<?= admin_url('system_settings/user_groups') ?>">
                                                <i class="fa fa-key"></i><span class="text"> <?= lang('group_permissions'); ?></span>
                                            </a>
                                        </li>
                                        <li id="system_settings_backups">
                                            <a href="<?= admin_url('system_settings/backups') ?>">
                                                <i class="fa fa-database"></i><span class="text"> <?= lang('backups'); ?></span>
                                            </a>
                                        </li>
                                        <!-- <li id="system_settings_updates">
                                            <a href="<?= admin_url('system_settings/updates') ?>">
                                                <i class="fa fa-upload"></i><span class="text"> <?= lang('updates'); ?></span>
                                            </a>
                                        </li> -->
                                    </ul>
                                </li>
                            <?php } ?>
                            <li class="mm_reports">
                                <a class="dropmenu" href="#">
                                    <i class="fa fa-bar-chart-o"></i>
                                    <span class="text"> <?= lang('reports'); ?> </span>
                                    <span class="chevron closed"></span>
                                </a>
                                <ul>
                                    <li id="reports_index">
                                        <a href="<?= admin_url('reports') ?>">
                                            <i class="fa fa-bars"></i><span class="text"> <?= lang('overview_chart'); ?></span>
                                        </a>
                                    </li>
                                    <li id="reports_warehouse_stock">
                                        <a href="<?= admin_url('reports/warehouse_stock') ?>">
                                            <i class="fa fa-building"></i><span class="text"> <?= lang('warehouse_stock'); ?></span>
                                        </a>
                                    </li>
                                    <li id="reports_best_sellers">
                                        <a href="<?= admin_url('reports/best_sellers') ?>">
                                            <i class="fa fa-line-chart"></i><span class="text"> <?= lang('best_sellers'); ?></span>
                                        </a>
                                    </li>
                                    <?php if (POS) { ?>
                                    <li id="reports_register">
                                        <a href="<?= admin_url('reports/register') ?>">
                                            <i class="fa fa-th-large"></i><span class="text"> <?= lang('register_report'); ?></span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <li id="reports_quantity_alerts">
                                        <a href="<?= admin_url('reports/quantity_alerts') ?>">
                                            <i class="fa fa-bar-chart-o"></i><span class="text"> <?= lang('product_quantity_alerts'); ?></span>
                                        </a>
                                    </li>
                                    <?php if ($Settings->product_expiry) { ?>
                                    <li id="reports_expiry_alerts">
                                        <a href="<?= admin_url('reports/expiry_alerts') ?>">
                                            <i class="fa fa-bar-chart-o"></i><span class="text"> <?= lang('product_expiry_alerts'); ?></span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <li id="reports_products">
                                        <a href="<?= admin_url('reports/products') ?>">
                                            <i class="fa fa-barcode"></i><span class="text"> <?= lang('products_report'); ?></span>
                                        </a>
                                    </li>
                                    <li id="reports_adjustments">
                                        <a href="<?= admin_url('reports/adjustments') ?>">
                                            <i class="fa fa-filter"></i><span class="text"> <?= lang('adjustments_report'); ?></span>
                                        </a>
                                    </li>
                                    <li id="reports_categories">
                                        <a href="<?= admin_url('reports/categories') ?>">
                                            <i class="fa fa-folder-open"></i><span class="text"> <?= lang('categories_report'); ?></span>
                                        </a>
                                    </li>
                                    <li id="reports_brands">
                                        <a href="<?= admin_url('reports/brands') ?>">
                                            <i class="fa fa-cubes"></i><span class="text"> <?= lang('brands_report'); ?></span>
                                        </a>
                                    </li>
                                    <li id="reports_daily_sales">
                                        <a href="<?= admin_url('reports/daily_sales') ?>">
                                            <i class="fa fa-calendar"></i><span class="text"> <?= lang('daily_sales'); ?></span>
                                        </a>
                                    </li>
                                    <li id="reports_monthly_sales">
                                        <a href="<?= admin_url('reports/monthly_sales') ?>">
                                            <i class="fa fa-calendar"></i><span class="text"> <?= lang('monthly_sales'); ?></span>
                                        </a>
                                    </li>
                                    <li id="reports_sales">
                                        <a href="<?= admin_url('reports/sales') ?>">
                                            <i class="fa fa-heart"></i><span class="text"> <?= lang('sales_report'); ?></span>
                                        </a>
                                    </li>
                                    <li id="reports_payments">
                                        <a href="<?= admin_url('reports/payments') ?>">
                                            <i class="fa fa-money"></i><span class="text"> <?= lang('payments_report'); ?></span>
                                        </a>
                                    </li>
                                    <li id="reports_tax">
                                        <a href="<?= admin_url('reports/tax') ?>">
                                            <i class="fa fa-area-chart"></i><span class="text"> <?= lang('tax_report'); ?></span>
                                        </a>
                                    </li>
                                    <li id="reports_profit_loss">
                                        <a href="<?= admin_url('reports/profit_loss') ?>">
                                            <i class="fa fa-money"></i><span class="text"> <?= lang('profit_and_loss'); ?></span>
                                        </a>
                                    </li>
                                    <li id="reports_daily_purchases">
                                        <a href="<?= admin_url('reports/daily_purchases') ?>">
                                            <i class="fa fa-calendar"></i><span class="text"> <?= lang('daily_purchases'); ?></span>
                                        </a>
                                    </li>
                                    <li id="reports_monthly_purchases">
                                        <a href="<?= admin_url('reports/monthly_purchases') ?>">
                                            <i class="fa fa-calendar"></i><span class="text"> <?= lang('monthly_purchases'); ?></span>
                                        </a>
                                    </li>
                                    <li id="reports_purchases">
                                        <a href="<?= admin_url('reports/purchases') ?>">
                                            <i class="fa fa-star"></i><span class="text"> <?= lang('purchases_report'); ?></span>
                                        </a>
                                    </li>
                                    <li id="reports_expenses">
                                        <a href="<?= admin_url('reports/expenses') ?>">
                                            <i class="fa fa-star"></i><span class="text"> <?= lang('expenses_report'); ?></span>
                                        </a>
                                    </li>
                                    <li id="reports_customer_report">
                                        <a href="<?= admin_url('reports/customers') ?>">
                                            <i class="fa fa-users"></i><span class="text"> <?= lang('customers_report'); ?></span>
                                        </a>
                                    </li>
                                    <li id="reports_supplier_report">
                                        <a href="<?= admin_url('reports/suppliers') ?>">
                                            <i class="fa fa-users"></i><span class="text"> <?= lang('suppliers_report'); ?></span>
                                        </a>
                                    </li>
                                    <li id="reports_staff_report">
                                        <a href="<?= admin_url('reports/users') ?>">
                                            <i class="fa fa-users"></i><span class="text"> <?= lang('staff_report'); ?></span>
                                        </a>
                                    </li>

                                    <li id="reports_stock_report">
                                        <a href="<?= admin_url('reports/stocks') ?>">
                                            <i class="fa fa-users"></i><span class="text"> Stocks Report</span>
                                        </a>
                                    </li>

                                    <li id="reports_return_report">
                                        <a href="<?= admin_url('reports/returns') ?>">
                                            <i class="fa fa-users"></i><span class="text"> Returns Report</span>
                                        </a>
                                    </li>

                                    <li id="reports_damage_report">
                                        <a href="<?= admin_url('reports/damages') ?>">
                                            <i class="fa fa-users"></i><span class="text"> Damages Report</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php if ($Owner && file_exists(APPPATH.'controllers'.DIRECTORY_SEPARATOR.'shop'.DIRECTORY_SEPARATOR.'Shop.php')) { ?>
                            <li class="mm_shop_settings mm_api_settings">
                                <a class="dropmenu" href="#">
                                    <i class="fa fa-shopping-cart"></i><span class="text"> <?= lang('front_end'); ?> </span>
                                    <span class="chevron closed"></span>
                                </a>
                                <ul>
                                    <li id="shop_settings_index">
                                        <a href="<?= admin_url('shop_settings') ?>">
                                            <i class="fa fa-cog"></i><span class="text"> <?= lang('shop_settings'); ?></span>
                                        </a>
                                    </li>
                                    <li id="shop_settings_slider">
                                        <a href="<?= admin_url('shop_settings/slider') ?>">
                                            <i class="fa fa-file"></i><span class="text"> <?= lang('slider_settings'); ?></span>
                                        </a>
                                    </li>
                                    <?php if ($this->Settings->apis) { ?>
                                    <li id="api_settings_index">
                                        <a href="<?= admin_url('api_settings') ?>">
                                            <i class="fa fa-key"></i><span class="text"> <?= lang('api_keys'); ?></span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <li id="shop_settings_pages">
                                        <a href="<?= admin_url('shop_settings/pages') ?>">
                                            <i class="fa fa-file"></i><span class="text"> <?= lang('list_pages'); ?></span>
                                        </a>
                                    </li>
                                    <li id="shop_settings_pages">
                                        <a href="<?= admin_url('shop_settings/add_page') ?>">
                                            <i class="fa fa-plus-circle"></i><span class="text"> <?= lang('add_page'); ?></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php } ?>

                        <?php
                        } else { // not owner and not admin
                            ?>
                            <?php if ($GP['products-index'] || $GP['products-add'] || $GP['products-barcode'] || $GP['products-adjustments'] || $GP['products-stock_count']) { ?>
                            <li class="mm_products">
                                <a class="dropmenu" href="#">
                                    <i class="fa fa-barcode"></i>
                                    <span class="text"> <?= lang('products'); ?>
                                    </span> <span class="chevron closed"></span>
                                </a>
                                <ul>
                                    <li id="products_index">
                                        <a class="submenu" href="<?= admin_url('products'); ?>">
                                            <i class="fa fa-barcode"></i><span class="text"> <?= lang('list_products'); ?></span>
                                        </a>
                                    </li>
                                    <?php if ($GP['products-add']) { ?>
                                    <li id="products_add">
                                        <a class="submenu" href="<?= admin_url('products/add'); ?>">
                                            <i class="fa fa-plus-circle"></i><span class="text"> <?= lang('add_product'); ?></span>
                                        </a>
                                    </li>
                                    <?php } ?>

                                    
                                    <?php if ($GP['products-barcode']) { ?>
                                    <li id="products_sheet">
                                        <a class="submenu" href="<?= admin_url('products/print_barcodes'); ?>">
                                            <i class="fa fa-tags"></i><span class="text"> <?= lang('print_barcode_label'); ?></span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <?php if ($GP['products-adjustments']) { ?>
                                    <li id="products_quantity_adjustments">
                                        <a class="submenu" href="<?= admin_url('products/quantity_adjustments'); ?>">
                                            <i class="fa fa-filter"></i><span class="text"> <?= lang('quantity_adjustments'); ?></span>
                                        </a>
                                    </li>
                                    <li id="products_add_adjustment">
                                        <a class="submenu" href="<?= admin_url('products/add_adjustment'); ?>">
                                            <i class="fa fa-filter"></i>
                                            <span class="text"> <?= lang('add_adjustment'); ?></span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <?php if ($GP['products-stock_count']) { ?>
                                    <li id="products_stock_counts">
                                        <a class="submenu" href="<?= admin_url('products/stock_counts'); ?>">
                                            <i class="fa fa-list-ol"></i>
                                            <span class="text"> <?= lang('stock_counts'); ?></span>
                                        </a>
                                    </li>
                                    <li id="products_count_stock">
                                        <a class="submenu" href="<?= admin_url('products/count_stock'); ?>">
                                            <i class="fa fa-plus-circle"></i>
                                            <span class="text"> <?= lang('count_stock'); ?></span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php } ?>

                            <?php if ($GP['sales-index'] || $GP['sales-add'] || $GP['sales-deliveries'] || $GP['sales-gift_cards']) { ?>
                            <li class="mm_sales <?= strtolower($this->router->fetch_method()) == 'sales' ? 'mm_pos' : '' ?>">
                                <a class="dropmenu" href="#">
                                    <i class="fa fa-heart"></i>
                                    <span class="text"> <?= lang('sales'); ?>
                                    </span> <span class="chevron closed"></span>
                                </a>
                                <ul>
                                    <li id="sales_index">
                                        <a class="submenu" href="<?= admin_url('sales'); ?>">
                                            <i class="fa fa-heart"></i><span class="text"> <?= lang('list_sales'); ?></span>
                                        </a>
                                    </li>
                                    <?php if (POS && $GP['pos-index']) { ?>
                                    <li id="pos_sales">
                                        <a class="submenu" href="<?= admin_url('pos/sales'); ?>">
                                            <i class="fa fa-heart"></i><span class="text"> <?= lang('pos_sales'); ?></span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <?php if ($GP['sales-add']) { ?>
                                    <li id="sales_add">
                                        <a class="submenu" href="<?= admin_url('sales/add'); ?>">
                                            <i class="fa fa-plus-circle"></i><span class="text"> <?= lang('add_sale'); ?></span>
                                        </a>
                                    </li>
                                    <?php }
                                    if ($GP['sales-deliveries']) { ?>
                                    <li id="sales_deliveries">
                                        <a class="submenu" href="<?= admin_url('sales/deliveries'); ?>">
                                            <i class="fa fa-truck"></i><span class="text"> <?= lang('deliveries'); ?></span>
                                        </a>
                                    </li>
                                    <?php }
                                    if ($GP['sales-gift_cards']) { ?>
                                    <li id="sales_gift_cards">
                                        <a class="submenu" href="<?= admin_url('sales/gift_cards'); ?>">
                                            <i class="fa fa-gift"></i><span class="text"> <?= lang('gift_cards'); ?></span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php } ?>

                            <?php if ($GP['quotes-index'] || $GP['quotes-add']) { ?>
                            <li class="mm_quotes">
                                <a class="dropmenu" href="#">
                                    <i class="fa fa-heart-o"></i>
                                    <span class="text"> <?= lang('quotes'); ?> </span>
                                    <span class="chevron closed"></span>
                                </a>
                                <ul>
                                    <li id="sales_index">
                                        <a class="submenu" href="<?= admin_url('quotes'); ?>">
                                            <i class="fa fa-heart-o"></i><span class="text"> <?= lang('list_quotes'); ?></span>
                                        </a>
                                    </li>
                                    <?php if ($GP['quotes-add']) { ?>
                                    <li id="sales_add">
                                        <a class="submenu" href="<?= admin_url('quotes/add'); ?>">
                                            <i class="fa fa-plus-circle"></i><span class="text"> <?= lang('add_quote'); ?></span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php } ?>

                            <?php if ($GP['purchases-index'] || $GP['purchases-add'] || $GP['purchases-expenses']) { ?>
                            <li class="mm_purchases">
                                <a class="dropmenu" href="#">
                                    <i class="fa fa-star"></i>
                                    <span class="text"> <?= lang('purchases'); ?>
                                    </span> <span class="chevron closed"></span>
                                </a>
                                <ul>
                                    <li id="purchases_index">
                                        <a class="submenu" href="<?= admin_url('purchases'); ?>">
                                            <i class="fa fa-star"></i><span class="text"> <?= lang('list_purchases'); ?></span>
                                        </a>
                                    </li>
                                    <?php if ($GP['purchases-add']) { ?>
                                    <li id="purchases_add">
                                        <a class="submenu" href="<?= admin_url('purchases/add'); ?>">
                                            <i class="fa fa-plus-circle"></i><span class="text"> <?= lang('add_purchase'); ?></span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <?php if ($GP['purchases-expenses']) { ?>
                                    <li id="purchases_expenses">
                                        <a class="submenu" href="<?= admin_url('purchases/expenses'); ?>">
                                            <i class="fa fa-dollar"></i><span class="text"> <?= lang('list_expenses'); ?></span>
                                        </a>
                                    </li>
                                    <li id="purchases_add_expense">
                                        <a class="submenu" href="<?= admin_url('purchases/add_expense'); ?>"
                                            data-toggle="modal" data-target="#myModal">
                                            <i class="fa fa-plus-circle"></i><span class="text"> <?= lang('add_expense'); ?></span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php } ?>

                            <?php if ($GP['transfers-index'] || $GP['transfers-add']) { ?>
                            <li class="mm_transfers">
                                <a class="dropmenu" href="#">
                                    <i class="fa fa-star-o"></i>
                                    <span class="text"> <?= lang('transfers'); ?> </span>
                                    <span class="chevron closed"></span>
                                </a>
                                <ul>
                                    <li id="transfers_index">
                                        <a class="submenu" href="<?= admin_url('transfers'); ?>">
                                            <i class="fa fa-star-o"></i><span class="text"> <?= lang('list_transfers'); ?></span>
                                        </a>
                                    </li>
                                    <?php if ($GP['transfers-add']) { ?>
                                    <li id="transfers_add">
                                        <a class="submenu" href="<?= admin_url('transfers/add'); ?>">
                                            <i class="fa fa-plus-circle"></i><span class="text"> <?= lang('add_transfer'); ?></span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php } ?>

                            <?php if ($GP['returns-index'] || $GP['returns-add']) { ?>
                            <li class="mm_returns">
                                <a class="dropmenu" href="#">
                                    <i class="fa fa-random"></i>
                                    <span class="text"> <?= lang('returns'); ?> </span>
                                    <span class="chevron closed"></span>
                                </a>
                                <ul>
                                    <li id="returns_index">
                                        <a class="submenu" href="<?= admin_url('returns'); ?>">
                                            <i class="fa fa-random"></i><span class="text"> <?= lang('list_returns'); ?></span>
                                        </a>
                                    </li>
                                    <?php if ($GP['returns-add']) { ?>
                                    <li id="returns_add">
                                        <a class="submenu" href="<?= admin_url('returns/add'); ?>">
                                            <i class="fa fa-plus-circle"></i><span class="text"> <?= lang('add_return'); ?></span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php } ?>

                            <?php if ($GP['customers-index'] || $GP['customers-add'] || $GP['suppliers-index'] || $GP['suppliers-add']) { ?>
                            <li class="mm_auth mm_customers mm_suppliers mm_billers">
                                <a class="dropmenu" href="#">
                                    <i class="fa fa-users"></i>
                                    <span class="text"> <?= lang('people'); ?> </span>
                                    <span class="chevron closed"></span>
                                </a>
                                <ul>
                                    <?php if ($GP['customers-index']) { ?>
                                    <li id="customers_index">
                                        <a class="submenu" href="<?= admin_url('customers'); ?>">
                                            <i class="fa fa-users"></i><span class="text"> <?= lang('list_customers'); ?></span>
                                        </a>
                                    </li>
                                    <?php }
                                    if ($GP['customers-add']) { ?>
                                    <li id="customers_index">
                                        <a class="submenu" href="<?= admin_url('customers/add'); ?>" data-toggle="modal" data-target="#myModal">
                                            <i class="fa fa-plus-circle"></i><span class="text"> <?= lang('add_customer'); ?></span>
                                        </a>
                                    </li>
                                    <?php }
                                    if ($GP['suppliers-index']) { ?>
                                    <li id="suppliers_index">
                                        <a class="submenu" href="<?= admin_url('suppliers'); ?>">
                                            <i class="fa fa-users"></i><span class="text"> <?= lang('list_suppliers'); ?></span>
                                        </a>
                                    </li>
                                    <?php }
                                    if ($GP['suppliers-add']) { ?>
                                    <li id="suppliers_index">
                                        <a class="submenu" href="<?= admin_url('suppliers/add'); ?>" data-toggle="modal" data-target="#myModal">
                                            <i class="fa fa-plus-circle"></i><span class="text"> <?= lang('add_supplier'); ?></span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php } ?>

                            <?php if ($GP['reports-quantity_alerts'] || $GP['reports-expiry_alerts'] || $GP['reports-products'] || $GP['reports-monthly_sales'] || $GP['reports-sales'] || $GP['reports-payments'] || $GP['reports-purchases'] || $GP['reports-customers'] || $GP['reports-suppliers'] || $GP['reports-expenses']) { ?>
                            <li class="mm_reports">
                                <a class="dropmenu" href="#">
                                    <i class="fa fa-bar-chart-o"></i>
                                    <span class="text"> <?= lang('reports'); ?> </span>
                                    <span class="chevron closed"></span>
                                </a>
                                <ul>
                                    <?php if ($GP['reports-quantity_alerts']) { ?>
                                    <li id="reports_quantity_alerts">
                                        <a href="<?= admin_url('reports/quantity_alerts') ?>">
                                            <i class="fa fa-bar-chart-o"></i><span class="text"> <?= lang('product_quantity_alerts'); ?></span>
                                        </a>
                                    </li>
                                    <?php }
                                    if ($GP['reports-expiry_alerts']) { ?>
                                    <?php if ($Settings->product_expiry) { ?>
                                    <li id="reports_expiry_alerts">
                                        <a href="<?= admin_url('reports/expiry_alerts') ?>">
                                            <i class="fa fa-bar-chart-o"></i><span class="text"> <?= lang('product_expiry_alerts'); ?></span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <?php }
                                    if ($GP['reports-products']) { ?>
                                    <li id="reports_products">
                                        <a href="<?= admin_url('reports/products') ?>">
                                            <i class="fa fa-filter"></i><span class="text"> <?= lang('products_report'); ?></span>
                                        </a>
                                    </li>
                                    <li id="reports_adjustments">
                                        <a href="<?= admin_url('reports/adjustments') ?>">
                                            <i class="fa fa-barcode"></i><span class="text"> <?= lang('adjustments_report'); ?></span>
                                        </a>
                                    </li>
                                    <li id="reports_categories">
                                        <a href="<?= admin_url('reports/categories') ?>">
                                            <i class="fa fa-folder-open"></i><span class="text"> <?= lang('categories_report'); ?></span>
                                        </a>
                                    </li>
                                    <li id="reports_brands">
                                        <a href="<?= admin_url('reports/brands') ?>">
                                            <i class="fa fa-cubes"></i><span class="text"> <?= lang('brands_report'); ?></span>
                                        </a>
                                    </li>
                                    <?php }
                                    if ($GP['reports-daily_sales']) { ?>
                                    <li id="reports_daily_sales">
                                        <a href="<?= admin_url('reports/daily_sales') ?>">
                                            <i class="fa fa-calendar-o"></i><span class="text"> <?= lang('daily_sales'); ?></span>
                                        </a>
                                    </li>
                                    <?php }
                                    if ($GP['reports-monthly_sales']) { ?>
                                    <li id="reports_monthly_sales">
                                        <a href="<?= admin_url('reports/monthly_sales') ?>">
                                            <i class="fa fa-calendar-o"></i><span class="text"> <?= lang('monthly_sales'); ?></span>
                                        </a>
                                    </li>
                                    <?php }
                                    if ($GP['reports-sales']) { ?>
                                    <li id="reports_sales">
                                        <a href="<?= admin_url('reports/sales') ?>">
                                            <i class="fa fa-heart"></i><span class="text"> <?= lang('sales_report'); ?></span>
                                        </a>
                                    </li>
                                    <?php }
                                    if ($GP['reports-payments']) { ?>
                                    <li id="reports_payments">
                                        <a href="<?= admin_url('reports/payments') ?>">
                                            <i class="fa fa-money"></i><span class="text"> <?= lang('payments_report'); ?></span>
                                        </a>
                                    </li>
                                    <?php }
                                    if ($GP['reports-tax']) { ?>
                                    <li id="reports_tax">
                                        <a href="<?= admin_url('reports/tax') ?>">
                                            <i class="fa fa-area-chart"></i><span class="text"> <?= lang('tax_report'); ?></span>
                                        </a>
                                    </li>
                                    <?php }
                                    if ($GP['reports-daily_purchases']) { ?>
                                    <li id="reports_daily_purchases">
                                        <a href="<?= admin_url('reports/daily_purchases') ?>">
                                            <i class="fa fa-calendar-o"></i><span class="text"> <?= lang('daily_purchases'); ?></span>
                                        </a>
                                    </li>
                                    <?php }
                                    if ($GP['reports-monthly_purchases']) { ?>
                                    <li id="reports_monthly_purchases">
                                        <a href="<?= admin_url('reports/monthly_purchases') ?>">
                                            <i class="fa fa-calendar-o"></i><span class="text"> <?= lang('monthly_purchases'); ?></span>
                                        </a>
                                    </li>
                                    <?php }
                                    if ($GP['reports-purchases']) { ?>
                                    <li id="reports_purchases">
                                        <a href="<?= admin_url('reports/purchases') ?>">
                                            <i class="fa fa-star"></i><span class="text"> <?= lang('purchases_report'); ?></span>
                                        </a>
                                    </li>
                                    <?php }
                                    if ($GP['reports-expenses']) { ?>
                                    <li id="reports_expenses">
                                        <a href="<?= admin_url('reports/expenses') ?>">
                                            <i class="fa fa-star"></i><span class="text"> <?= lang('expenses_report'); ?></span>
                                        </a>
                                    </li>
                                    <?php }
                                    if ($GP['reports-customers']) { ?>
                                    <li id="reports_customer_report">
                                        <a href="<?= admin_url('reports/customers') ?>">
                                            <i class="fa fa-users"></i><span class="text"> <?= lang('customers_report'); ?></span>
                                        </a>
                                    </li>
                                    <?php }
                                    if ($GP['reports-suppliers']) { ?>
                                    <li id="reports_supplier_report">
                                        <a href="<?= admin_url('reports/suppliers') ?>">
                                            <i class="fa fa-users"></i><span class="text"> <?= lang('suppliers_report'); ?></span>
                                        </a>
                                    </li>
                                    <?php } 
                                    if ($GP['reports-stocks']) { ?>
                                    <li id="reports_stock_report">
                                        <a href="<?= admin_url('reports/stocks') ?>">
                                            <i class="fa fa-users"></i><span class="text"> Stocks Report</span>
                                        </a>
                                    </li>
                                    <?php }
                                    if ($GP['reports-returns']) { ?>
                                    <li id="reports_return_report">
                                        <a href="<?= admin_url('reports/returns') ?>">
                                            <i class="fa fa-users"></i><span class="text">Return Report</span>
                                        </a>
                                    </li>
                                    <?php }
                                    if ($GP['reports-damages']) { ?>
                                    <li id="reports_damage_report">
                                        <a href="<?= admin_url('reports/damages') ?>">
                                            <i class="fa fa-users"></i><span class="text"> <?= lang('damages_report'); ?></span>
                                        </a>
                                    </li>
                                    <?php }?>
                                </ul>
                            </li>
                            <?php } ?>

                        <?php } ?>
                    </ul>
                </div>
                <a href="#" id="main-menu-act" class="full visible-md visible-lg">
                    <i class="fa fa-angle-double-left"></i>
                </a>
            </div>
            </td><td class="content-con">
            <div id="content">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <ul class="breadcrumb">
                            <?php
                            foreach ($bc as $b) {
                                if ($b['link'] === '#') {
                                    echo '<li class="active">' . $b['page'] . '</li>';
                                } else {
                                    echo '<li><a href="' . $b['link'] . '">' . $b['page'] . '</a></li>';
                                }
                            }
                            ?>
                            <li class="right_log hidden-xs">
                                <?= lang('your_ip') . ' ' . $ip_address . " <span class='hidden-sm'>( " . lang('last_login_at') . ": " . date($dateFormats['php_ldate'], $this->session->userdata('old_last_login')) . " " . ($this->session->userdata('last_ip') != $ip_address ? lang('ip:') . ' ' . $this->session->userdata('last_ip') : '') . " )</span>" ?>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <?php if ($message) { ?>
                            <div class="alert alert-success">
                                <button data-dismiss="alert" class="close" type="button">×</button>
                                <?= $message; ?>
                            </div>
                        <?php } ?>
                        <?php if ($error) { ?>
                            <div class="alert alert-danger">
                                <button data-dismiss="alert" class="close" type="button">×</button>
                                <?= $error; ?>
                            </div>
                        <?php } ?>
                        <?php if ($warning) { ?>
                            <div class="alert alert-warning">
                                <button data-dismiss="alert" class="close" type="button">×</button>
                                <?= $warning; ?>
                            </div>
                        <?php } ?>
                        <?php
                        if ($info) {
                            foreach ($info as $n) {
                                if (!$this->session->userdata('hidden' . $n->id)) {
                                    ?>
                                    <div class="alert alert-info">
                                        <a href="#" id="<?= $n->id ?>" class="close hideComment external"
                                           data-dismiss="alert">&times;</a>
                                        <?= $n->comment; ?>
                                    </div>
                                <?php }
                            }
                        } ?>
                        <div class="alerts-con"></div>
