<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
    $(document).ready(function () {
        $('#skrill_form').bootstrapValidator({
            message: 'Please enter/select a value',
            submitButtons: 'input[type="submit"]'
        });
        $('#active').change(function () {
            var v = $(this).val();
            if (v == 1) {
                $('#account_email').attr('required', 'required');
                $('#skrill_form').bootstrapValidator('addField', 'account_email');
            } else {
                $('#account_email').removeAttr('required');
                $('#skrill_form').bootstrapValidator('removeField', 'account_email');
            }
        });
        var v = <?=$skrill->active;?>;
        if (v == 1) {
            $('#account_email').attr('required', 'required');
            $('#skrill_form').bootstrapValidator('addField', 'account_email');
        } else {
            $('#account_email').removeAttr('required');
            $('#skrill_form').bootstrapValidator('removeField', 'account_email');
        }
    });
</script>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-cog"></i><?= lang('skrill_settings'); ?></h2>

        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown"><a href="<?= admin_url('system_settings/paypal') ?>" class="toggle_up"><i
                            class="icon fa fa-paypal"></i><span
                            class="padding-right-10"><?= lang('paypal'); ?></span></a></li>
                <li class="dropdown"><a href="<?= admin_url('system_settings/skrill') ?>" class="toggle_down"><i
                            class="icon fa fa-bank"></i><span class="padding-right-10"><?= lang('skrill'); ?></span></a>
                </li>
            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?= lang('update_info'); ?></p>

                <?php $attrib = array('role' => 'form', 'id="skrill_form"');
                echo admin_form_open("system_settings/skrill", $attrib);
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= lang("activate", "active"); ?>
                            <?php
                            $yn = array('1' => 'Yes', '0' => 'No');
                            echo form_dropdown('active', $yn, $skrill->active, 'class="form-control tip" required="required" id="active"');
                            ?>
                        </div>

                        <div class="form-group">
                            <?= lang("skrill_account_email", "account_email"); ?>
                            <?php echo form_input('account_email', $skrill->account_email, 'class="form-control tip" id="account_email"'); ?>
                            <small class="help-block"><?= lang("skrill_email_tip"); ?></small>
                        </div>

                        <div class="form-group">
                            <?= lang("secret_word", "secret_word"); ?>
                            <?php echo form_input('secret_word', $skrill->secret_word, 'class="form-control tip" id="secret_word"'); ?>
                            <small class="help-block"><?= lang("secret_word_tip"); ?></small>
                        </div>

                        <div class="form-group">
                            <?= lang("fixed_charges", "fixed_charges"); ?>
                            <?php echo form_input('fixed_charges', $skrill->fixed_charges, 'class="form-control tip" id="fixed_charges"'); ?>
                            <small class="help-block"><?= lang("fixed_charges_tip"); ?></small>
                        </div>
                        <div class="form-group">
                            <?= lang("extra_charges_my", "extra_charges_my"); ?>
                            <?php echo form_input('extra_charges_my', $skrill->extra_charges_my, 'class="form-control tip" id="extra_charges_my"'); ?>
                            <small class="help-block"><?= lang("extra_charges_my_tip"); ?></small>
                        </div>
                        <div class="form-group">
                            <?= lang("extra_charges_others", "extra_charges_other"); ?>
                            <?php echo form_input('extra_charges_other', $skrill->extra_charges_other, 'class="form-control tip" id="extra_charges"'); ?>
                            <small class="help-block"><?= lang("extra_charges_others_tip"); ?></small>
                        </div>

                    </div>
                </div>
                <div style="clear: both; height: 10px;"></div>
                <div class="form-group">
                    <?php echo form_submit('update_settings', lang("update_settings"), 'class="btn btn-primary"'); ?>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>