<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-upload"></i><?= lang('updates'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <p class="introtext"><?= lang('update_heading'); ?></p>

                <div class="row">
                    <div class="col-md-12">
                        <?php
                        if(!$Settings->purchase_code || !$Settings->envato_username) {
                            echo admin_form_open('system_settings/updates');
                        ?>
                            <div class="form-group">
                                <?= lang('purchase_code', 'purchase_code'); ?>
                                <?= form_input('purchase_code', '', 'class="form-control tip" id="purchase_code"  required="required"'); ?>
                            </div>
                            <div class="form-group">
                                <?= lang('envato_username', 'envato_username'); ?>
                                <?= form_input('envato_username', '', 'class="form-control tip" id="envato_username"  required="required"'); ?>
                            </div>
                            <div class="form-group">
                                <?= form_submit('update', lang('update'), 'class="btn btn-primary"'); ?>
                            </div>
                        <?php
                            echo form_close();
                        } else {
                            if (!empty($updates->data->updates)) {
                                $c = 1;
                                foreach ($updates->data->updates as $update) {
                                    echo '<ul class="list-group"><li class="list-group-item">';
                                    echo '<h3><strong>' . lang('version') . ' ' . $update->version . '</strong> ';
                                    if ($c == 1 && !empty($update->filename)) {
                                        echo anchor('admin/system_settings/install_update/' . substr($update->filename, 0, -4) . '/' . (!empty($update->mversion) ? $update->mversion : 0) . '/' . $update->version, '<i class="fa fa-download"></i> ' . lang('install'), 'class="btn btn-primary pull-right"') . ' ';
                                    }
                                    echo '</h3><h3>' . lang('changelog') . '<h3><pre>' . $update->changelog . '</pre>';
                                    echo '</li></ul>';
                                    $c++;
                                }
                            } else {
                                echo '<div class="well"><strong>' . lang('using_latest_update') . '</strong></div>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>