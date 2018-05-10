<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?= $supplier->company && $supplier->company != '-' ? $supplier->company : $supplier->name; ?></h4>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" style="margin-bottom:0;">
                    <tbody>
                    <tr>
                        <td><strong><?= lang("company"); ?></strong></td>
                        <td><?= $supplier->company; ?></strong></td>
                    </tr>
                    <tr>
                        <td><strong><?= lang("name"); ?></strong></td>
                        <td><?= $supplier->name; ?></strong></td>
                    </tr>
                    <tr>
                        <td><strong><?= lang("vat_no"); ?></strong></td>
                        <td><?= $supplier->vat_no; ?></strong></td>
                    </tr>
                    <tr>
                        <td><strong><?= lang("email"); ?></strong></td>
                        <td><?= $supplier->email; ?></strong></td>
                    </tr>
                    <tr>
                        <td><strong><?= lang("phone"); ?></strong></td>
                        <td><?= $supplier->phone; ?></strong></td>
                    </tr>
                    <tr>
                        <td><strong><?= lang("address"); ?></strong></td>
                        <td><?= $supplier->address; ?></strong></td>
                    </tr>
                    <tr>
                        <td><strong><?= lang("city"); ?></strong></td>
                        <td><?= $supplier->city; ?></strong></td>
                    </tr>
                    <tr>
                        <td><strong><?= lang("state"); ?></strong></td>
                        <td><?= $supplier->state; ?></strong></td>
                    </tr>
                    <tr>
                        <td><strong><?= lang("postal_code"); ?></strong></td>
                        <td><?= $supplier->postal_code; ?></strong></td>
                    </tr>
                    <tr>
                        <td><strong><?= lang("country"); ?></strong></td>
                        <td><?= $supplier->country; ?></strong></td>
                    </tr>
                    <tr>
                        <td><strong><?= lang("scf1"); ?></strong></td>
                        <td><?= $supplier->cf1; ?></strong></td>
                    </tr>
                    <tr>
                        <td><strong><?= lang("scf2"); ?></strong></td>
                        <td><?= $supplier->cf2; ?></strong></td>
                    </tr>
                    <tr>
                        <td><strong><?= lang("scf3"); ?></strong></td>
                        <td><?= $supplier->cf3; ?></strong></td>
                    </tr>
                    <tr>
                        <td><strong><?= lang("scf4"); ?></strong></td>
                        <td><?= $supplier->cf4; ?></strong></td>
                    </tr>
                    <tr>
                        <td><strong><?= lang("scf5"); ?></strong></td>
                        <td><?= $supplier->cf5; ?></strong></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer no-print">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?= lang('close'); ?></button>
                <?php if ($Owner || $Admin || $GP['reports-suppliers']) { ?>
                    <a href="<?=admin_url('reports/supplier_report/'.$supplier->id);?>" target="_blank" class="btn btn-primary"><?= lang('suppliers_report'); ?></a>
                <?php } ?>
                <?php if ($Owner || $Admin || $GP['suppliers-edit']) { ?>
                    <a href="<?=admin_url('suppliers/edit/'.$supplier->id);?>" data-toggle="modal" data-target="#myModal2" class="btn btn-primary"><?= lang('edit_supplier'); ?></a>
                <?php } ?>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>