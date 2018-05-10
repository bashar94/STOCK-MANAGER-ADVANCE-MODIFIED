<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-envelope"></i><?= lang('email_templates'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <!--<p class="introtext"><?= lang('list_results'); ?></p>-->
                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <ul id="myTab" class="nav nav-tabs">
                            <li class=""><a href="#credentials"><?= lang('new_user') ?></a></li>
                            <li class=""><a href="#activate_email"><?= lang('activate_email') ?></a></li>
                            <li class=""><a href="#forgot_password"><?= lang('forgot_password') ?></a></li>
                            <li class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" id="more" href="#">More <b
                                        class="caret"></b></a>
                                <ul aria-labelledby="more" role="menu" class="dropdown-menu">
                                    <li class=""><a href="#sale"><?= lang('sale') ?></a></li>
                                    <li class=""><a href="#quote"><?= lang('quote') ?></a></li>
                                    <li class=""><a href="#purchase"><?= lang('purchase') ?></a></li>
                                    <li class=""><a href="#transfer"><?= lang('transfer') ?></a></li>
                                    <li class=""><a href="#payment"><?= lang('payment') ?></a></li>
                                </ul>
                            </li>

                        </ul>

                        <div class="tab-content">
                            <div id="credentials" class="tab-pane fade in">
                                <?= admin_form_open('system_settings/email_templates'); ?>

                                <?php echo form_textarea('mail_body', (isset($_POST['mail_body']) ? html_entity_decode($_POST['mail_body']) : html_entity_decode($credentials)), 'class="form-control" id="comment"'); ?>

                                <input type="submit" name="submit" class="btn btn-primary" value="<?= lang('save'); ?>"
                                       style="margin-top:15px;"/>

                                <?php echo form_close(); ?>
                            </div>

                            <div id="activate_email" class="tab-pane fade">
                                <?= admin_form_open('system_settings/email_templates/activate_email'); ?>

                                <?php echo form_textarea('mail_body', (isset($_POST['mail_body']) ? html_entity_decode($_POST['mail_body']) : html_entity_decode($activate_email)), 'class="form-control" id="comment"'); ?>

                                <input type="submit" name="submit" class="btn btn-primary" value="<?= lang('save'); ?>"
                                       style="margin-top:15px;"/>

                                <?php echo form_close(); ?>
                            </div>

                            <div id="forgot_password" class="tab-pane fade">
                                <?= admin_form_open('system_settings/email_templates/forgot_password'); ?>

                                <?php echo form_textarea('mail_body', (isset($_POST['mail_body']) ? html_entity_decode($_POST['mail_body']) : html_entity_decode($forgot_password)), 'class="form-control" id="comment"'); ?>

                                <input type="submit" name="submit" class="btn btn-primary" value="<?= lang('save'); ?>"
                                       style="margin-top:15px;"/>

                                <?php echo form_close(); ?>
                            </div>

                            <div id="sale" class="tab-pane fade">
                                <?= admin_form_open('system_settings/email_templates/sale'); ?>

                                <?php echo form_textarea('mail_body', (isset($_POST['mail_body']) ? html_entity_decode($_POST['mail_body']) : html_entity_decode($sale)), 'class="form-control" id="comment"'); ?>

                                <input type="submit" name="submit" class="btn btn-primary" value="<?= lang('save'); ?>"
                                       style="margin-top:15px;"/>

                                <?php echo form_close(); ?>
                            </div>
                            <div id="quote" class="tab-pane fade">
                                <?= admin_form_open('system_settings/email_templates/quote'); ?>

                                <?php echo form_textarea('mail_body', (isset($_POST['mail_body']) ? html_entity_decode($_POST['mail_body']) : html_entity_decode($quote)), 'class="form-control" id="comment"'); ?>

                                <input type="submit" name="submit" class="btn btn-primary" value="<?= lang('save'); ?>"
                                       style="margin-top:15px;"/>

                                <?php echo form_close(); ?>
                            </div>
                            <div id="purchase" class="tab-pane fade">
                                <?= admin_form_open('system_settings/email_templates/purchase'); ?>

                                <?php echo form_textarea('mail_body', (isset($_POST['mail_body']) ? html_entity_decode($_POST['mail_body']) : html_entity_decode($purchase)), 'class="form-control" id="comment"'); ?>

                                <input type="submit" name="submit" class="btn btn-primary" value="<?= lang('save'); ?>"
                                       style="margin-top:15px;"/>

                                <?php echo form_close(); ?>
                            </div>
                            <div id="transfer" class="tab-pane fade">
                                <?= admin_form_open('system_settings/email_templates/transfer'); ?>

                                <?php echo form_textarea('mail_body', (isset($_POST['mail_body']) ? html_entity_decode($_POST['mail_body']) : html_entity_decode($transfer)), 'class="form-control" id="comment"'); ?>

                                <input type="submit" name="submit" class="btn btn-primary" value="<?= lang('save'); ?>"
                                       style="margin-top:15px;"/>

                                <?php echo form_close(); ?>
                            </div>
                            <div id="payment" class="tab-pane fade">
                                <?= admin_form_open('system_settings/email_templates/payment'); ?>

                                <?php echo form_textarea('mail_body', (isset($_POST['mail_body']) ? html_entity_decode($_POST['mail_body']) : html_entity_decode($payment)), 'class="form-control" id="comment"'); ?>

                                <input type="submit" name="submit" class="btn btn-primary" value="<?= lang('save'); ?>"
                                       style="margin-top:15px;"/>

                                <?php echo form_close(); ?>
                            </div>


                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="margin5">
                            <h3 style="font-weight: bold;"><?= $this->lang->line('short_tags'); ?></h3>
                            <pre>{logo} {site_name} {site_link}</pre>
                            <?= lang('new_user') ?>
                            <pre>{client_name} {email} {password} </pre>
                            <?= lang('forgot_password') ?>
                            <pre>{user_name} {email} {reset_password_link}</pre>
                            <?= lang('activate_email') ?>
                            <pre>{user_name} {email} {activation_link}</pre>
                            <?= lang('orders') ?> &amp; <?= lang('payments') ?>
                            <pre>{company} {contact_person} {reference_number}</pre>


                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
</div>