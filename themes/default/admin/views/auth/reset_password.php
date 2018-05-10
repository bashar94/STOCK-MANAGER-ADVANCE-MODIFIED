<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <script type="text/javascript">if (parent.frames.length !== 0) {
            top.location = '<?=admin_url('pos')?>';
        }</script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?= $assets ?>styles/theme.css" rel="stylesheet">
    <link href="<?= $assets ?>styles/style.css" rel="stylesheet">
    <link href="<?= $assets ?>styles/helpers/login.css" rel="stylesheet">

</head>

<body class="login-page">
<noscript>
    <div class="global-site-notice noscript">
        <div class="notice-inner">
            <p><strong>JavaScript seems to be disabled in your browser.</strong><br>You must have JavaScript enabled in
                your browser to utilize the functionality of this website.</p>
        </div>
    </div>
</noscript>
<div class="page-back">
    <div class="text-center"><?php if ($Settings->logo2) {
            echo '<img src="' . base_url('assets/uploads/logos/' . $Settings->logo2) . '" alt="' . $Settings->site_name . '" style="margin-bottom:10px;" />';
        } ?></div>
    <div id="login">

        <div class=" container">

            <div class="login-form-div">
                <div class="login-content">
                    <?php if ($Settings->mmode) { ?>
                        <div class="alert alert-warning">
                            <button data-dismiss="alert" class="close" type="button">×</button>
                            <?= lang('site_is_offline') ?>
                        </div>
                    <?php }
                    if ($error) { ?>
                        <div class="alert alert-danger">
                            <button data-dismiss="alert" class="close" type="button">×</button>
                            <ul class="list-group"><?= $error; ?></ul>
                        </div>
                    <?php }
                    if ($message) { ?>
                        <div class="alert alert-success">
                            <button data-dismiss="alert" class="close" type="button">×</button>
                            <ul class="list-group"><?= $message; ?></ul>
                        </div>
                    <?php } ?>
                    <?php echo admin_form_open('auth/reset_password/' . $code, 'class="login" data-toggle="validator"'); ?>
                    <div class="div-title">
                        <h3 class="text-primary"><?php echo sprintf(lang('reset_password_email'), $identity_label); ?></h3>
                    </div>
                    <div class="textbox-wrap form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                            <?php echo form_input($new_password); ?>
                        </div>
                        <span class="help-block"><?= lang('pasword_hint') ?></span>
                    </div>
                    <div class="textbox-wrap form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                            <?php echo form_input($new_password_confirm); ?>
                        </div>
                    </div>
                    <?php echo form_input($user_id); ?>
                    <?php echo form_hidden($csrf); ?>

                    <div class="form-action clearfix">
                        <a class="btn btn-success pull-left login_link" href="<?= admin_url('login') ?>"><i
                                class="fa fa-chevron-left"></i> <?= lang('back_to_login') ?>  </a>
                        <button type="submit" class="btn btn-primary pull-right"><?= lang('submit') ?> &nbsp;&nbsp; <i
                                class="fa fa-send"></i></button>
                    </div>

                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= $assets ?>js/jquery.js"></script>
<script src="<?= $assets ?>js/bootstrap.min.js"></script>
<script src="<?= $assets ?>js/jquery.cookie.js"></script>
<script src="<?= $assets ?>js/login.js"></script>
</body>
</html>