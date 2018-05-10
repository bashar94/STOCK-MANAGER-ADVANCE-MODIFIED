<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?= base_url() ?>assets/styles/helpers/bootstrap.o.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/styles/style.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <script src="<?= base_url() ?>assets/js/respond.min.js"></script>
    <![endif]-->
    <style>
        .btn {
            margin-top: 10px;
        }

        span#recaptcha_privacy {
            display: none;
        }

        .recaptchatable #recaptcha_response_field {
            height: 30px;
            border-right: 1px solid #CCA940 !important;
        }

        /*#recaptcha_table tr:first-child td:nth-child(3), #recaptcha_table tr:nth-child(2) td:nth-child(2)  { display: none; }
        #recaptcha_table td, .recaptchatable { padding: 0 !important; border: 0 !important; }
        #recaptcha_image, #recaptcha_image img { padding: 0 !important; border: 1px solid #CCC; }*/
        /*#recaptcha_table tr:nth-child(6), #recaptcha_table tr:nth-child(7)  { display: none; }*/
    </style>

</head>

<body>
<div class="container">
    <div class="row">
        <div id="content" class="col-sm-12 full">
            <div class="row">

                <div class="login-box">
                    <div class="text-center"><?php if (LOGO) {
                            echo '<img src="' . admin_url() . 'assets/images/' . LOGO . '" alt="' . SITE_NAME . '"  />';
                        } ?></div>
                    <div style="clear: both; height: 20px;"></div>
                    <div class="header bblue">
                        <?= $this->lang->line('forgot_password_heading') ?>
                    </div>
                    <?php if ($message) { ?>
                        <div class="alert alert-danger">
                            <button data-dismiss="alert" class="close" type="button">×</button>
                            <?= $message; ?>
                        </div>
                    <?php } ?>
                    <?php echo admin_form_open("auth/forgot_password", 'class="login"'); ?>
                    <p><?php echo sprintf(lang('forgot_password_subheading'), $identity_label); ?></p>
                    <fieldset class="col-sm-12">
                        <div class="form-group">
                            <div class="controls row">
                                <div class="input-group col-sm-12">
                                    <?php // echo sprintf(lang('forgot_password_email_label'), $identity_label);?>
                                    <?php echo form_input($email); ?>

                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="controls row">
                                <div class="input-group col-sm-12"><span
                                        style="position:absolute; right: 7px; top:4px;"><a href="#"
                                                                                           class="reload-captcha"><img
                                                src="<?= base_url() ?>assets/images/reload.png" alt="reload image"/></a></span>
                                    <div class="text-center"><span class="captcha-image"><?php echo $image; ?></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="controls row">
                                <div class="input-group col-sm-12">
                                    <?php echo form_input($captcha); ?>
                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <?php echo form_submit('submit', lang('submit'), 'class="btn btn-primary col-xs-12"'); ?>


                        </div>

                    </fieldset>

                    <?php echo form_close(); ?>
                    <div class="clearfix" style="height: 10px;"></div>
                    <a href="<?= admin_url('auth/login') ?>"
                       class="btn btn-warning col-xs-7"><?php echo lang('back_to_login'); ?></a>
                    <a href="register"
                       class="btn  btn-success col-xs-4 col-xs-offset-1"><?php echo lang('register'); ?></a>
                    <!--<a class="pull-right" href="page-register.html">Sign Up!</a>-->

                    <div class="clearfix"></div>

                </div>
            </div>

        </div>


    </div>

</div>


<script src="<?= base_url() ?>assets/js/jquery-2.0.3.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery-migrate-1.2.1.min.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        $('.reload-captcha').click(function (event) {
            event.preventDefault();
            $.ajax({
                url: '<?=base_url();?>auth/reload_captcha',
                success: function (data) {
                    $('.captcha-image').html(data);
                }
            });
        });
    });
</script>

</body>
</html>

<!--<h1><?php echo lang('forgot_password_heading'); ?></h1>
<p><?php echo sprintf(lang('forgot_password_subheading'), $identity_label); ?></p>

<div id="infoMessage"><?php echo $message; ?></div>

<?php echo admin_form_open("auth/forgot_password"); ?>

      <p>
      	<label for="email"><?php echo sprintf(lang('forgot_password_email_label'), $identity_label); ?></label> <br />
      	<?php echo form_input($email); ?>
      </p>

      <p><?php echo form_submit('submit', lang('forgot_password_submit_btn')); ?></p>

<?php echo form_close(); ?>-->