<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('addresses') . " (" . $company->name . ")"; ?></h4>
        </div>

        <div class="modal-body">
            <!--<p><?= lang('list_results'); ?></p>-->

            <div class="table-responsive">
                <table id="CSUData" cellpadding="0" cellspacing="0" border="0"
                       class="table table-bordered table-condensed table-hover table-striped">
                    <thead>
                    <tr class="primary">
                        <th><?= lang("addresses"); ?></th>
                        <th style="width:85px;"><?= lang("actions"); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($addresses)) {
                        foreach ($addresses as $address) {
                            echo '<tr>' .
                                '<td>' . $address->line1 . '<br>' . $address->line2 . '<br>' . $address->city . ' ' . $address->postal_code . '<br>' . $address->state . ' ' . $address->country . '<br>' . lang('phone').' '. $address->phone . '</td>' .
                                '<td class="text-center"><a href="' . admin_url('customers/edit_address/' . $address->id) . '" class="tip" title="' . lang("edit_address") . '" data-toggle="modal" data-target="#myModal2"><i class="fa fa-edit"></i></a> <a href="#" class="tip po" title="' . $this->lang->line("delete_address") . '" data-content="<p>' . lang('r_u_sure') . '</p><a class=\'btn btn-danger\' href=\'' . admin_url('customers/delete_address/' . $address->id) . '\'>' . lang('i_m_sure') . '</a> <button class=\'btn po-close\'>' . lang('no') . '</button>"  rel="popover"><i class="fa fa-trash-o"></i></a></td>' .
                                '</tr>';
                        }
                    } else { ?>
                        <tr>
                            <td colspan="2" class="dataTables_empty"><?= lang('sEmptyTable') ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>


        </div>
        <div class="modal-footer">
            <a href="<?= admin_url('customers/add_address/'.$company->id); ?>" class="btn btn-primary pull-left" data-toggle='modal' data-target='#myModal2'><?= lang('add_address'); ?></a>
            <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close') ?></button>
        </div>
    </div>
    <?= $modal_js ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.tip').tooltip();
        });
    </script>

