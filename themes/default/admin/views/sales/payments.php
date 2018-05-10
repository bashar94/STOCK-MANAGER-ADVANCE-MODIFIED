<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="fa fa-2x">&times;</i>
            </button>
            <button type="button" class="btn btn-xs btn-default no-print pull-right" style="margin-right:15px;" onclick="window.print();">
                <i class="fa fa-print"></i> <?= lang('print'); ?>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?= lang('view_payments').' ('.lang('sale').' '.lang('reference').': '.$inv->reference_no.')'; ?></h4>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table id="CompTable" cellpadding="0" cellspacing="0" border="0"
                       class="table table-bordered table-hover table-striped">
                    <thead>
                    <tr>
                        <th style="width:30%;"><?= $this->lang->line("date"); ?></th>
                        <th style="width:30%;"><?= $this->lang->line("reference_no"); ?></th>
                        <th style="width:15%;"><?= $this->lang->line("amount"); ?></th>
                        <th style="width:15%;"><?= $this->lang->line("paid_by"); ?></th>
                        <th style="width:10%;"><?= $this->lang->line("actions"); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($payments)) {
                        foreach ($payments as $payment) { ?>
                            <tr class="row<?= $payment->id ?>">
                                <td><?= $this->sma->hrld($payment->date); ?></td>
                                <td><?= $payment->reference_no; ?></td>
                                <td><?= $this->sma->formatMoney($payment->amount) . ' ' . (($payment->attachment) ? '<a href="' . admin_url('welcome/download/' . $payment->attachment) . '"><i class="fa fa-chain"></i></a>' : ''); ?></td>
                                <td><?= lang($payment->paid_by); ?></td>
                                <td>
                                    <div class="text-center">
                                        <a href="<?= admin_url('sales/payment_note/' . $payment->id) ?>"
                                           data-toggle="modal" data-target="#myModal2"><i class="fa fa-file-text-o"></i></a>
                                        <?php if ($payment->paid_by != 'gift_card') { ?>
                                            <a href="<?= admin_url('sales/email_payment/' . $payment->id) ?>" class="email_payment"><i class="fa fa-envelope"></i></a>
                                            <a href="<?= admin_url('sales/edit_payment/' . $payment->id) ?>"
                                               data-toggle="modal" data-target="#myModal2"><i
                                                    class="fa fa-edit"></i></a>
                                            <a href="#" class="po"
                                               title="<b><?= $this->lang->line("delete_payment") ?></b>"
                                               data-content="<p><?= lang('r_u_sure') ?></p><a class='btn btn-danger' id='<?= $payment->id ?>' href='<?= admin_url('sales/delete_payment/' . $payment->id) ?>'><?= lang('i_m_sure') ?></a> <button class='btn po-close'><?= lang('no') ?></button>"
                                               rel="popover"><i class="fa fa-trash-o"></i></a>
                                        <?php } ?>
                                    </div>
                                </td>
                            </tr>
                        <?php }
                    } else {
                        echo "<tr><td colspan='5'>" . lang('no_data_available') . "</td></tr>";
                    } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" charset="UTF-8">
    $(document).ready(function () {
        $(document).on('click', '.po-delete', function () {
            var id = $(this).attr('id');
            $(this).closest('tr').remove();
        });
        $(document).on('click', '.email_payment', function (e) {
            e.preventDefault();
            var link = $(this).attr('href');
            $.get(link, function(data) {
                bootbox.alert(data.msg);
            });
            return false;
        });
    });
</script>
