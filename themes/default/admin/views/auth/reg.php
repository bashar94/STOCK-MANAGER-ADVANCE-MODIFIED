<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?= base_url() ?>assets/styles/theme.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/styles/style.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/styles/helpers/login.css" rel="stylesheet">
    <script type="text/javascript" src="<?= admin_url() ?>assets/js/jquery-2.0.3.min.js"></script>
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
    </style>

</head>

<body class="login-page">
<div class="colorBg3 colorBg">
    <div id="login" data-panel="first">

        <div class=" container">

            <div class="login-form-div">
                <div class="login-content">
                    <form>
                        <div class="div-title">
                            <h3>LogIn to your Account</h3>
                        </div>
                        <div class="textbox-wrap">
                            <div class="input-group">
                                <span class="input-group-addon "><i class="fa fa-user"></i></span>
                                <input type="text" required="required" class="form-control" placeholder="Username"/>
                            </div>
                        </div>
                        <div class="textbox-wrap">
                            <div class="input-group">
                                <span class="input-group-addon "><i class="fa fa-key"></i></span>
                                <input type="password" required="required" class="form-control "
                                       placeholder="Password"/>
                            </div>
                        </div>
                        <div class="login-form-action clearfix">
                            <div class="checkbox pull-left">
                                <div class="custom-checkbox">
                                    <input type="checkbox" checked name="iCheck">
                                </div>
                                <span class="checkbox-text pull-left">&nbsp;Remember Me</span>
                            </div>
                            <button type="submit" class="btn btn-success pull-right">LogIn &nbsp; <i
                                    class="fa fa-chevron-right"></i></button>
                        </div>
                    </form>
                </div>
                <div class="login-form-links link1">
                    <h4 class="blue">Don't have an Account?</h4>
                    <span>No worry</span>
                    <a href="#register" class="blue">Click Here</a>
                    <span>to Register</span>
                </div>
                <div class="login-form-links link2">
                    <h4 class="green">Forget your Password?</h4>
                    <span>Dont worry</span>
                    <a href="#forgot_password" class="green">Click Here</a>
                    <span>to Get New One</span>
                </div>
            </div>


        </div>
    </div>

    <div id="register" data-panel="second">
        <div class=" container">
            <br/>
            <br/>
            <!-- #region Registration Form -->
            <div class="registration-form-div">
                <form>
                    <div class="div-title reg-header">
                        <h3>Get your Account Here </h3>

                    </div>
                    <div class="clearfix">
                        <div class="col-sm-6 registration-left-div">
                            <div class="reg-content">
                                <div class="textbox-wrap">
                                    <div class="input-group">
                                        <span class="input-group-addon "><i class="fa fa-user"></i></span>
                                        <input type="text" class="form-control " placeholder="FirstName"
                                               required="required"/>
                                    </div>
                                </div>
                                <div class="textbox-wrap">
                                    <div class="input-group">
                                        <span class="input-group-addon "><i class="fa fa-user"></i></span>
                                        <input type="text" class="form-control " placeholder="LastName"
                                               required="required"/>
                                    </div>
                                </div>
                                <div class="textbox-wrap">
                                    <div class="input-group">
                                        <span class="input-group-addon "><i class="fa fa-envelope"></i></span>
                                        <input type="email" class="form-control " placeholder="Email Id"
                                               required="required"/>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="col-sm-6 registration-right-div">
                            <div class="reg-content">
                                <div class="textbox-wrap">
                                    <div class="input-group">
                                        <span class="input-group-addon "><i class="fa fa-user"></i></span>
                                        <input type="text" class="form-control " placeholder="UserName"
                                               required="required"/>
                                    </div>
                                </div>
                                <div class="textbox-wrap">
                                    <div class="input-group">
                                        <span class="input-group-addon "><i class="fa fa-key"></i></span>
                                        <input type="password" class="form-control " placeholder="Password"
                                               required="required"/>
                                    </div>
                                </div>
                                <div class="textbox-wrap">
                                    <div class="input-group">
                                        <span class="input-group-addon "><i class="fa fa-key"></i></span>
                                        <input type="password" class="form-control " placeholder="Confirm-Password"
                                               required="required"/>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="registration-form-action clearfix">
                        <a href="#login" class="btn btn-success pull-left">
                            <i class="fa fa-chevron-left"></i>&nbsp; &nbsp;Back To Login
                        </a>
                        <button type="submit" class="btn btn-success pull-right">Register Now &nbsp; <i
                                class="fa fa-chevron-right"></i></button>

                    </div>
                </form>
            </div>


        </div>
    </div>

    <div id="forgot_password" data-panel="third">
        <div class=" container">
            <br/>
            <br/>
            <br/>

            <div class="forgot-password-div">
                <div class="div-title">
                    <h3>Forget Password</h3>
                </div>
                <div class="forgot-content">
                    <form>
                        <div class="textbox-wrap">
                            <div class="input-group">
                                <span class="input-group-addon "><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control " placeholder="Username" required="required"/>
                            </div>
                        </div>
                        <div class="textbox-wrap">
                            <div class="input-group">
                                <span class="input-group-addon "><i class="fa fa-envelope"></i></span>
                                <input type="email" class="form-control " placeholder="Email Id" required="required"/>
                            </div>
                        </div>
                        <div class="forget-form-action clearfix">
                            <a class="btn btn-success pull-left" href="#login"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back
                            </a>
                            <button type="submit" class="btn btn-success pull-right">Submit &nbsp;&nbsp; <i
                                    class="fa fa-chevron-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>
</div>
<script src="<?= base_url() ?>assets/js/jquery.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/js/custom.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.cookie.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.panelSnap.js"></script>
<script>
    $(document).ready(function () {
        if ($("#identity").val() == "") {
            $("#identity").focus()
        } else {
            $("#password").focus();
        }
        $('.reload-captcha').click(function (event) {
            event.preventDefault();
            $.ajax({
                url: '<?=base_url();?>auth/reload_captcha',
                success: function (data) {
                    $('.captcha-image').html(data);
                }
            });
        });
        if ($.cookie('the_style')) {
            if ($.cookie('the_style') == 'light') {
                if ($('body').hasClass('bblack')) {
                    $('body, #content').removeClass('bblack');
                }
                if ($('body').hasClass('bblue')) {
                    $('body, #content').removeClass('bblue');
                }
            }
            if ($.cookie('the_style') == 'blue') {
                $('body, #content').addClass('bblue');
                $('.header').addClass('bblack');
            }
            if ($.cookie('the_style') == 'black') {
                $('body, #content').addClass('bblack');
            }
        } else {
            $('body, #content').addClass('bblack');
        }

    });
</script>

<script type="text/javascript">
    $(function () {
        $("input").iCheck({
            checkboxClass: 'icheckbox_square-blue',
            increaseArea: '20%' // optional
        });
        $(".dark input").iCheck({
            checkboxClass: 'icheckbox_polaris',
            increaseArea: '20%' // optional
        });
        $(".form-control").focus(function () {
            $(this).closest(".textbox-wrap").addClass("focused");
        }).blur(function () {
            $(this).closest(".textbox-wrap").removeClass("focused");
        });


    });
</script>

</body>
</html>
