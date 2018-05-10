<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('add_user') . " (" . $company->name . ")"; ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo admin_form_open("customers/add_user/" . $company->id, $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <div class="row">

                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <?php echo lang('first_name', 'first_name'); ?>
                        <div class="controls">
                            <?php echo form_input('first_name', '', 'class="form-control" id="first_name" required="required" pattern=".{3,10}"'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo lang('last_name', 'last_name'); ?>
                        <div class="controls">
                            <?php echo form_input('last_name', '', 'class="form-control" id="last_name" required="required"'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo lang('gender', 'gender'); ?>
                        <div class="controls">
                            <?php $opts = array('male' => lang('male'), 'female' => lang('female'));
                            echo form_dropdown('gender', $opts, '', 'class="form-control select" id="gender" required="required"'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo lang('phone', 'phone'); ?>
                        <div class="controls">
                            <?php echo form_input('phone', '', 'class="form-control" id="phone"'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo lang('email', 'email'); ?>
                        <div class="controls">
                            <input type="email" id="email" name="email" class="form-control" required="required"/>
                            <?php /* echo form_input('email', '', 'class="form-control" id="email" required="required"'); */ ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <?php echo lang('password', 'password'); ?>
                        <div class="controls">
                            <?php echo form_password('password', '', 'class="form-control tip" id="password" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"'); ?>
                            <span class="help-block">At least 1 capital, 1 lowercase, 1 number and more than 8 characters long</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo lang('confirm_password', 'password_confirm'); ?>
                        <div class="controls">
                            <?php echo form_password('password_confirm', '', 'class="form-control" id="password_confirm" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" data-bv-identical="true" data-bv-identical-field="password" data-bv-identical-message="' . lang('pw_not_same') . '"'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= lang('status', 'status'); ?>

                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <label class="checkbox" for="active">
                                    <input type="radio"  name="status" value="1" id="active" checked="checked"/>
                                    <?= lang('active') ?>
                                </label>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <label class="checkbox" for="inactive">
                                    <input type="radio" name="status" value="0" id="inactive"/>
                                    <?= lang('inactive') ?>
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <strong><?= lang('notify_user') ?></strong>
                        <label class="checkbox" for="notify">
                            <input type="checkbox" name="notify" value="1" id="notify" checked="checked"/>
                            <?= lang('notify_user_by_email') ?>
                        </label>
                    </div>
                    <div class="clearfix"></div>

                </div>
            </div>


        </div>
        <div class="modal-footer">
            <?php echo form_submit('add_user', lang('add_user'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<?= $modal_js ?>

