<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-users"></i><?= lang('change_password_heading'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <?php echo admin_form_open("auth/change_password"); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-5">
                            <p>
                                <?php echo lang('change_password_old_password_label', 'old_password'); ?> <br/>
                                <?php echo form_input($old_password); ?>
                            </p>

                            <p>
                                <label
                                    for="new_password"><?php echo sprintf(lang('change_password_new_password_label'), $min_password_length); ?></label>
                                <br/>
                                <?php echo form_input($new_password); ?>
                            </p>

                            <p>
                                <?php echo lang('change_password_new_password_confirm_label', 'new_password_confirm'); ?>
                                <br/>
                                <?php echo form_input($new_password_confirm); ?>
                            </p>

                            <?php echo form_input($user_id); ?>
                            <p><?php echo form_submit('submit', lang('change_password_submit_btn'), 'class="btn btn-lg btn-primary"'); ?></p>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
