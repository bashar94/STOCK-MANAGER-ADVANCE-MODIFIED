<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
    .table td:first-child {
        font-weight: bold;
    }

    label {
        margin-right: 10px;
    }
</style>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-folder-open"></i><?= lang('group_permissions'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?= lang("set_permissions"); ?></p>

                <?php if (!empty($p)) {
                    if ($p->group_id != 1) {

                        echo admin_form_open("system_settings/permissions/" . $id); ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped reports-table">

                                <thead>
                                <tr>
                                    <th colspan="6"
                                        class="text-center"><?php echo $group->description . ' ( ' . $group->name . ' ) ' . $this->lang->line("group_permissions"); ?></th>
                                </tr>
                                <tr>
                                    <th rowspan="2" class="text-center"><?= lang("module_name"); ?>
                                    </th>
                                    <th colspan="5" class="text-center"><?= lang("permissions"); ?></th>
                                </tr>
                                <tr>
                                    <th class="text-center"><?= lang("view"); ?></th>
                                    <th class="text-center"><?= lang("add"); ?></th>
                                    <th class="text-center"><?= lang("edit"); ?></th>
                                    <th class="text-center"><?= lang("delete"); ?></th>
                                    <th class="text-center"><?= lang("misc"); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><?= lang("products"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="products-index" <?php echo $p->{'products-index'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="products-add" <?php echo $p->{'products-add'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="products-edit" <?php echo $p->{'products-edit'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="products-delete" <?php echo $p->{'products-delete'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" id="products-cost" class="checkbox" name="products-cost" <?php echo $p->{'products-cost'} ? "checked" : ''; ?>>
                                            <label for="products-cost" class="padding05"><?= lang('product_cost') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" id="products-price" class="checkbox" name="products-price" <?php echo $p->{'products-price'} ? "checked" : ''; ?>>
                                            <label for="products-price" class="padding05"><?= lang('product_price') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" id="products-adjustments" class="checkbox" name="products-adjustments" <?php echo $p->{'products-adjustments'} ? "checked" : ''; ?>>
                                            <label for="products-adjustments" class="padding05"><?= lang('adjustments') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" id="products-barcode" class="checkbox" name="products-barcode" <?php echo $p->{'products-barcode'} ? "checked" : ''; ?>>
                                            <label for="products-barcode" class="padding05"><?= lang('print_barcodes') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" id="products-stock_count" class="checkbox" name="products-stock_count" <?php echo $p->{'products-stock_count'} ? "checked" : ''; ?>>
                                            <label for="products-stock_count" class="padding05"><?= lang('stock_counts') ?></label>
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td><?= lang("sales"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="sales-index" <?php echo $p->{'sales-index'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="sales-add" <?php echo $p->{'sales-add'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="sales-edit" <?php echo $p->{'sales-edit'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="sales-delete" <?php echo $p->{'sales-delete'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" id="sales-email" class="checkbox" name="sales-email" <?php echo $p->{'sales-email'} ? "checked" : ''; ?>>
                                            <label for="sales-email" class="padding05"><?= lang('email') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" id="sales-pdf" class="checkbox" name="sales-pdf" <?php echo $p->{'sales-pdf'} ? "checked" : ''; ?>>
                                            <label for="sales-pdf" class="padding05"><?= lang('pdf') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <?php if (POS) { ?>
                                            <input type="checkbox" value="1" id="pos-index" class="checkbox" name="pos-index" <?php echo $p->{'pos-index'} ? "checked" : ''; ?>>
                                            <label for="pos-index" class="padding05"><?= lang('pos') ?></label>
                                            <?php } ?>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" id="sales-payments" class="checkbox" name="sales-payments" <?php echo $p->{'sales-payments'} ? "checked" : ''; ?>>
                                            <label for="sales-payments" class="padding05"><?= lang('payments') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" id="sales-return_sales" class="checkbox" name="sales-return_sales" <?php echo $p->{'sales-return_sales'} ? "checked" : ''; ?>>
                                            <label for="sales-return_sales" class="padding05"><?= lang('return_sales') ?></label>
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td><?= lang("deliveries"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="sales-deliveries" <?php echo $p->{'sales-deliveries'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="sales-add_delivery" <?php echo $p->{'sales-add_delivery'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="sales-edit_delivery" <?php echo $p->{'sales-edit_delivery'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="sales-delete_delivery" <?php echo $p->{'sales-delete_delivery'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" id="sales-pdf" class="checkbox" name="sales-pdf_delivery" <?php echo $p->{'sales-pdf_delivery'} ? "checked" : ''; ?>>
                                            <label for="sales-pdf_delivery" class="padding05"><?= lang('pdf') ?></label>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?= lang("gift_cards"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="sales-gift_cards" <?php echo $p->{'sales-gift_cards'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="sales-add_gift_card" <?php echo $p->{'sales-add_gift_card'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="sales-edit_gift_card" <?php echo $p->{'sales-edit_gift_card'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="sales-delete_gift_card" <?php echo $p->{'sales-delete_gift_card'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>

                                    </td>
                                </tr>

                                <tr>
                                    <td><?= lang("quotes"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="quotes-index" <?php echo $p->{'quotes-index'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="quotes-add" <?php echo $p->{'quotes-add'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="quotes-edit" <?php echo $p->{'quotes-edit'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="quotes-delete" <?php echo $p->{'quotes-delete'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" id="quotes-email" class="checkbox" name="quotes-email" <?php echo $p->{'quotes-email'} ? "checked" : ''; ?>>
                                            <label for="quotes-email" class="padding05"><?= lang('email') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" id="quotes-pdf" class="checkbox" name="quotes-pdf" <?php echo $p->{'quotes-pdf'} ? "checked" : ''; ?>>
                                            <label for="quotes-pdf" class="padding05"><?= lang('pdf') ?></label>
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td><?= lang("purchases"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="purchases-index" <?php echo $p->{'purchases-index'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="purchases-add" <?php echo $p->{'purchases-add'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="purchases-edit" <?php echo $p->{'purchases-edit'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="purchases-delete" <?php echo $p->{'purchases-delete'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" id="purchases-email" class="checkbox" name="purchases-email" <?php echo $p->{'purchases-email'} ? "checked" : ''; ?>>
                                            <label for="purchases-email" class="padding05"><?= lang('email') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" id="purchases-pdf" class="checkbox" name="purchases-pdf" <?php echo $p->{'purchases-pdf'} ? "checked" : ''; ?>>
                                            <label for="purchases-pdf" class="padding05"><?= lang('pdf') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" id="purchases-payments" class="checkbox" name="purchases-payments" <?php echo $p->{'purchases-payments'} ? "checked" : ''; ?>>
                                            <label for="purchases-payments" class="padding05"><?= lang('payments') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" id="purchases-expenses" class="checkbox" name="purchases-expenses" <?php echo $p->{'purchases-expenses'} ? "checked" : ''; ?>>
                                            <label for="purchases-expenses" class="padding05"><?= lang('expenses') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" id="purchases-return_purchases" class="checkbox" name="purchases-return_purchases" <?php echo $p->{'purchases-return_purchases'} ? "checked" : ''; ?>>
                                            <label for="purchases-return_purchases" class="padding05"><?= lang('return_purchases') ?></label>
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td><?= lang("transfers"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="transfers-index" <?php echo $p->{'transfers-index'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="transfers-add" <?php echo $p->{'transfers-add'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="transfers-edit" <?php echo $p->{'transfers-edit'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="transfers-delete" <?php echo $p->{'transfers-delete'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" id="transfers-email" class="checkbox" name="transfers-email" <?php echo $p->{'transfers-email'} ? "checked" : ''; ?>>
                                            <label for="transfers-email" class="padding05"><?= lang('email') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" id="transfers-pdf" class="checkbox" name="transfers-pdf" <?php echo $p->{'transfers-pdf'} ? "checked" : ''; ?>>
                                            <label for="transfers-pdf" class="padding05"><?= lang('pdf') ?></label>
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td><?= lang("returns"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="returns-index" <?php echo $p->{'returns-index'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="returns-add" <?php echo $p->{'returns-add'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="returns-edit" <?php echo $p->{'returns-edit'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="returns-delete" <?php echo $p->{'returns-delete'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" id="returns-email" class="checkbox" name="returns-email" <?php echo $p->{'returns-email'} ? "checked" : ''; ?>>
                                            <label for="returns-email" class="padding05"><?= lang('email') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" id="returns-pdf" class="checkbox" name="returns-pdf" <?php echo $p->{'returns-pdf'} ? "checked" : ''; ?>>
                                            <label for="returns-pdf" class="padding05"><?= lang('pdf') ?></label>
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td><?= lang("customers"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="customers-index" <?php echo $p->{'customers-index'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="customers-add" <?php echo $p->{'customers-add'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="customers-edit" <?php echo $p->{'customers-edit'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="customers-delete" <?php echo $p->{'customers-delete'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" id="customers-deposits" class="checkbox" name="customers-deposits" <?php echo $p->{'customers-deposits'} ? "checked" : ''; ?>>
                                            <label for="customers-deposits" class="padding05"><?= lang('deposits') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" id="customers-delete_deposit" class="checkbox" name="customers-delete_deposit" <?php echo $p->{'customers-delete_deposit'} ? "checked" : ''; ?>>
                                            <label for="customers-delete_deposit" class="padding05"><?= lang('delete_deposit') ?></label>
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td><?= lang("suppliers"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="suppliers-index" <?php echo $p->{'suppliers-index'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="suppliers-add" <?php echo $p->{'suppliers-add'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="suppliers-edit" <?php echo $p->{'suppliers-edit'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox" name="suppliers-delete" <?php echo $p->{'suppliers-delete'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                    </td>
                                </tr>

                                <tr>
                                    <td><?= lang("reports"); ?></td>
                                    <td colspan="5">
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" class="checkbox" id="product_quantity_alerts" name="reports-quantity_alerts" <?php echo $p->{'reports-quantity_alerts'} ? "checked" : ''; ?>>
                                            <label for="product_quantity_alerts" class="padding05"><?= lang('product_quantity_alerts') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" class="checkbox" id="Product_expiry_alerts" name="reports-expiry_alerts" <?php echo $p->{'reports-expiry_alerts'} ? "checked" : ''; ?>>
                                            <label for="Product_expiry_alerts" class="padding05"><?= lang('product_expiry_alerts') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" class="checkbox" id="products"
                                            name="reports-products" <?php echo $p->{'reports-products'} ? "checked" : ''; ?>><label for="products" class="padding05"><?= lang('products') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" class="checkbox" id="daily_sales" name="reports-daily_sales" <?php echo $p->{'reports-daily_sales'} ? "checked" : ''; ?>>
                                            <label for="daily_sales" class="padding05"><?= lang('daily_sales') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" class="checkbox" id="monthly_sales" name="reports-monthly_sales" <?php echo $p->{'reports-monthly_sales'} ? "checked" : ''; ?>>
                                            <label for="monthly_sales" class="padding05"><?= lang('monthly_sales') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" class="checkbox" id="sales" name="reports-sales" <?php echo $p->{'reports-sales'} ? "checked" : ''; ?>>
                                            <label for="sales" class="padding05"><?= lang('sales') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" class="checkbox" id="payments" name="reports-payments" <?php echo $p->{'reports-payments'} ? "checked" : ''; ?>>
                                            <label for="payments" class="padding05"><?= lang('payments') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" class="checkbox" id="tax" name="reports-tax" <?php echo $p->{'reports-tax'} ? "checked" : ''; ?>>
                                            <label for="tax" class="padding05"><?= lang('tax_report') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" class="checkbox" id="expenses" name="reports-expenses" <?php echo $p->{'reports-expenses'} ? "checked" : ''; ?>>
                                            <label for="expenses" class="padding05"><?= lang('expenses') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" class="checkbox" id="daily_purchases" name="reports-daily_purchases" <?php echo $p->{'reports-daily_purchases'} ? "checked" : ''; ?>>
                                            <label for="daily_purchases" class="padding05"><?= lang('daily_purchases') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" class="checkbox" id="monthly_purchases" name="reports-monthly_purchases" <?php echo $p->{'reports-monthly_purchases'} ? "checked" : ''; ?>>
                                            <label for="monthly_purchases" class="padding05"><?= lang('monthly_purchases') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" class="checkbox" id="purchases" name="reports-purchases" <?php echo $p->{'reports-purchases'} ? "checked" : ''; ?>>
                                            <label for="purchases" class="padding05"><?= lang('purchases') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" class="checkbox" id="customers" name="reports-customers" <?php echo $p->{'reports-customers'} ? "checked" : ''; ?>>
                                            <label for="customers" class="padding05"><?= lang('customers') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" class="checkbox" id="suppliers" name="reports-suppliers" <?php echo $p->{'reports-suppliers'} ? "checked" : ''; ?>>
                                            <label for="suppliers" class="padding05"><?= lang('suppliers') ?></label>
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td><?= lang("misc"); ?></td>
                                    <td colspan="5">
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" class="checkbox" id="bulk_actions"
                                            name="bulk_actions" <?php echo $p->bulk_actions ? "checked" : ''; ?>>
                                            <label for="bulk_actions" class="padding05"><?= lang('bulk_actions') ?></label>
                                        </span>
                                        <span style="display:inline-block;">
                                            <input type="checkbox" value="1" class="checkbox" id="edit_price"
                                            name="edit_price" <?php echo $p->edit_price ? "checked" : ''; ?>>
                                            <label for="edit_price" class="padding05"><?= lang('edit_price_on_sale') ?></label>
                                        </span>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary"><?=lang('update')?></button>
                        </div>
                        <?php echo form_close();
                    } else {
                        echo $this->lang->line("group_x_allowed");
                    }
                } else {
                    echo $this->lang->line("group_x_allowed");
                } ?>


            </div>
        </div>
    </div>
</div>
