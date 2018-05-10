<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('users') . " (" . $company->name . ")"; ?></h4>
        </div>

        <div class="modal-body">
            <!--<p><?= lang('list_results'); ?></p>-->

            <div class="table-responsive">
                <table id="CSUData" cellpadding="0" cellspacing="0" border="0"
                       class="table table-bordered table-condensed table-hover table-striped">
                    <thead>
                    <tr class="primary">
                        <!--<th style="width:55px;"><?= lang("id"); ?></th>-->
                        <th><?= lang("first_name"); ?></th>
                        <th><?= lang("last_name"); ?></th>
                        <th><?= lang("email_address"); ?></th>
                        <th><?= lang("status"); ?></th>
                        <th style="width:85px;"><?= lang("actions"); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($users)) {
                        foreach ($users as $user) {
                            echo '<tr>' .
                                //'<td class="text-center">'.$user->id.'</td>'.
                                '<td>' . $user->first_name . '</td>' .
                                '<td>' . $user->last_name . '</td>' .
                                '<td>' . $user->email . '</td>' .
                                '<td class="text-center">' . ($user->active ? '<a href="' . base_url() . 'auth/deactivate/' . $user->id . '" data-toggle="modal" data-target="#myModal2"><span class="label label-success"><i class="fa fa-check"></i> ' . lang('active') . '</span></a>' : '<a href="' . base_url() . 'auth/activate/' . $user->id . '"><span class="label label-danger"><i class="fa fa-times"></i> ' . lang('inactive') . '</span></a>') . '</td>' .
                                '<td class="text-center"><a href="' . admin_url('auth/profile/' . $user->id) . '" class="tip" title="' . lang("edit_profile") . '"><i class="fa fa-edit"></i></a> <a href="#" class="tip po" title="<b>' . $this->lang->line("delete_user") . '</b>" data-content="<p>' . lang('r_u_sure') . '</p><a class=\'btn btn-danger po-delete\' href=\'' . admin_url('auth/delete/' . $user->id) . '\'>' . lang('i_m_sure') . '</a> <button class=\'btn po-close\'>' . lang('no') . '</button>"  rel="popover"><i class="fa fa-trash-o"></i></a></td>' .
                                '</tr>';
                        }
                    } else { ?>
                        <tr>
                            <td colspan="6" class="dataTables_empty"><?= lang('sEmptyTable') ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close') ?></button>
        </div>
    </div>
    <?= $modal_js ?>

