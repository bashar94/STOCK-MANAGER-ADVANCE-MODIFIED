<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
    var count = 1, an = 1, DT = <?= $Settings->default_tax_rate ?>, po_edit = 1,
        product_tax = 0, invoice_tax = 0, total_discount = 0, total = 0, shipping = 0, surcharge = 0,
        tax_rates = <?php echo json_encode($tax_rates); ?>;

    $(document).ready(function () {
        <?php if ($inv) { ?>
        //localStorage.setItem('redate', '<?= $this->sma->hrld($inv->date) ?>');
        localStorage.setItem('reref', '<?= $reference ?>');
        localStorage.setItem('renote', '<?= $this->sma->decode_html($inv->note); ?>');
        localStorage.setItem('reitems', JSON.stringify(<?= $inv_items; ?>));
        localStorage.setItem('rediscount', '<?= $inv->order_discount_id ?>');
        localStorage.setItem('retax2', '<?= $inv->order_tax_id ?>');
        localStorage.setItem('return_surcharge', '0');
        <?php } ?>
        <?php if ($Owner || $Admin) { ?>
        if (!localStorage.getItem('redate')) {
            // $("#redate").datetimepicker({
            //     format: site.dateFormats.js_ldate,
            //     fontAwesome: true,
            //     language: 'sma',
            //     weekStart: 1,
            //     todayBtn: 1,
            //     autoclose: 1,
            //     todayHighlight: 1,
            //     startView: 2,
            //     forceParse: 0
            // }).datetimepicker('update', new Date());
        }
        $(document).on('change', '#redate', function (e) {
            localStorage.setItem('redate', $(this).val());
        });
        if (redate = localStorage.getItem('redate')) {
            $('#redate').val(redate);
        }
        <?php } ?>
        if (reref = localStorage.getItem('reref')) {
            $('#reref').val(reref);
        }
        if (rediscount = localStorage.getItem('rediscount')) {
            $('#rediscount').val(rediscount);
        }
        if (retax2 = localStorage.getItem('retax2')) {
            $('#retax2').val(retax2);
        }
        if (return_surcharge = localStorage.getItem('return_surcharge')) {
            $('#return_surcharge').val(return_surcharge);
        }

        if (localStorage.getItem('reitems')) {
            loadItems();
        }
        /* ------------------------------
         * Edit Row Quantity
         ------------------------------- */

        var old_row_qty;
        $(document).on("focus", '.rquantity', function () {
            old_row_qty = $(this).val();
        }).on("change", '.rquantity', function () {
            var row = $(this).closest('tr');
            var new_qty = parseFloat($(this).val()),
                item_id = row.attr('data-item-id');
            if (!is_numeric(new_qty) || (new_qty > reitems[item_id].row.oqty)) {
                $(this).val(old_row_qty);
                bootbox.alert('<?= lang('unexpected_value'); ?>');
                return false;
            }
            if(new_qty > reitems[item_id].row.oqty) {
                bootbox.alert('<?= lang('unexpected_value'); ?>');
                $(this).val(old_row_qty);
                return false;
            }
            reitems[item_id].row.base_quantity = new_qty;
            if(reitems[item_id].row.unit != reitems[item_id].row.base_unit) {
                $.each(reitems[item_id].units, function(){
                    if (this.id == reitems[item_id].row.unit) {
                        reitems[item_id].row.base_quantity = unitToBaseQty(new_qty, this);
                    }
                });
            }
            reitems[item_id].row.qty = new_qty;
            localStorage.setItem('reitems', JSON.stringify(reitems));
            loadItems();
        });
        var old_surcharge;
        $(document).on("focus", '#return_surcharge', function () {
            old_surcharge = $(this).val() ? $(this).val() : '0';
        }).on("change", '#return_surcharge', function () {
            var new_surcharge = $(this).val() ? $(this).val() : '0';
            if (!is_valid_discount(new_surcharge)) {
                $(this).val(new_surcharge);
                bootbox.alert('<?= lang('unexpected_value'); ?>');
                return;
            }
            localStorage.setItem('return_surcharge', JSON.stringify(new_surcharge));
            loadItems();
        });
        $(document).on('click', '.redel', function () {
            var row = $(this).closest('tr');
            var item_id = row.attr('data-item-id');
            delete reitems[item_id];
            row.remove();
            if(reitems.hasOwnProperty(item_id)) { } else {
                localStorage.setItem('reitems', JSON.stringify(reitems));
                loadItems();
                return;
            }
        });
    });
    //localStorage.clear();
    function loadItems() {

        if (localStorage.getItem('reitems')) {
            total = 0;
            count = 1;
            an = 1;
            product_tax = 0;
            invoice_tax = 0;
            product_discount = 0;
            order_discount = 0;
            total_discount = 0;
            $("#reTable tbody").empty();
            reitems = JSON.parse(localStorage.getItem('reitems'));

            $.each(reitems, function () {

                var item = this;
                var item_id = site.settings.item_addition == 1 ? item.item_id : item.id;
                reitems[item_id] = item;

                var product_id = item.row.id, item_type = item.row.type, combo_items = item.combo_items, item_cost = item.row.cost, item_qty = item.row.qty, item_oqty = item.row.oqty, purchase_item_id = item.row.purchase_item_id, item_bqty = item.row.quantity_balance, item_expiry = item.row.expiry, item_tax_method = item.row.tax_method, item_ds = item.row.discount, item_discount = 0, item_option = item.row.option, item_code = item.row.code, item_name = item.row.name.replace(/"/g, "&#034;").replace(/'/g, "&#039;");
                var qty_received = (item.row.received >= 0) ? item.row.received : item.row.qty;
                
                var item_supplier_part_no = item.row.supplier_part_no ? item.row.supplier_part_no : '';
                if (item.row.new_entry === 1) { item_bqty = item_qty; }

                var unit_cost = item.row.real_unit_cost;

                var product_unit = item.row.unit, base_quantity = item.row.base_quantity;
                if(product_unit != item.row.base_unit) {
                    $.each(item.units, function(){
                        if (this.id == product_unit) {
                            base_quantity = formatDecimal(unitToBaseQty(item.row.qty, this), 4);
                        }
                    });
                }

                var ds = item_ds ? item_ds : '0';
                if (ds.indexOf("%") !== -1) {
                    var pds = ds.split("%");
                    if (!isNaN(pds[0])) {
                        item_discount = formatDecimal((parseFloat(((unit_cost) * parseFloat(pds[0])) / 100)), 4);
                    } else {
                        item_discount = formatDecimal(ds);
                    }
                } else {
                     item_discount = parseFloat(ds);
                }
                product_discount += formatDecimal((item_discount * item_qty), 4);

                unit_cost = formatDecimal(unit_cost-item_discount);
                var pr_tax = item.tax_rate;
                var pr_tax_val = 0, pr_tax_rate = 0;
                if (site.settings.tax1 == 1) {
                    if (pr_tax !== false) {
                        if (pr_tax.type == 1) {

                            if (item_tax_method == '0') {
                                pr_tax_val = formatDecimal(((unit_cost) * parseFloat(pr_tax.rate)) / (100 + parseFloat(pr_tax.rate)), 4);
                                pr_tax_rate = formatDecimal(pr_tax.rate) + '%';
                            } else {
                                pr_tax_val = formatDecimal(((unit_cost) * parseFloat(pr_tax.rate)) / 100, 4);
                                pr_tax_rate = formatDecimal(pr_tax.rate) + '%';
                            }

                        } else if (pr_tax.type == 2) {

                            pr_tax_val = parseFloat(pr_tax.rate);
                            pr_tax_rate = pr_tax.rate;

                        }
                        product_tax += pr_tax_val * item_qty;
                    }
                }
                item_cost = item_tax_method == 0 ? formatDecimal((unit_cost-pr_tax_val), 4) : formatDecimal(unit_cost);
                unit_cost = formatDecimal((unit_cost+item_discount), 4);
                var sel_opt = '';
                $.each(item.options, function () {
                    if(this.id == item_option) {
                        sel_opt = this.name;
                    }
                });

                var row_no = (new Date).getTime();
                var newTr = $('<tr id="row_' + row_no + '" class="row_' + item_id + '" data-item-id="' + item_id + '"></tr>');
                tr_html = '<td><input name="purchase_item_id[]" type="hidden" class="rpiid" value="' + purchase_item_id + '"><input name="product_id[]" type="hidden" class="rid" value="' + product_id + '"><input name="product[]" type="hidden" class="rcode" value="' + item_code + '"><input name="product_name[]" type="hidden" class="rname" value="' + item_name + '"><input name="product_option[]" type="hidden" class="roption" value="' + item_option + '"><input name="part_no[]" type="hidden" class="rpart_no" value="' + item_supplier_part_no + '"><span class="sname" id="name_' + row_no + '">' + item_name + ' (' + item_code + ')'+(sel_opt != '' ? ' ('+sel_opt+')' : '')+' <span class="label label-default">'+item_supplier_part_no+'</span></span></td>';
                if (site.settings.product_expiry == 1) {
                    tr_html += '<td><input class="form-control date rexpiry" name="expiry[]" type="text" value="' + item_expiry + '" data-id="' + row_no + '" data-item="' + item_id + '" id="expiry_' + row_no + '"></td>';
                }
                tr_html += '<td class="text-right"><input class="form-control input-sm text-right rcost" name="net_cost[]" type="hidden" id="cost_' + row_no + '" value="' + item_cost + '"><input class="rucost" name="unit_cost[]" type="hidden" value="' + unit_cost + '"><input class="realucost" name="real_unit_cost[]" type="hidden" value="' + item.row.real_unit_cost + '"><span class="text-right scost" id="scost_' + row_no + '">' + formatMoney(item_cost) + '</span></td>';
                tr_html += '<td class="text-center"><span>'+formatDecimal(item_oqty)+'</span></td>';
                if (po_edit) {
                    tr_html += '<td class="text-center"><span>'+formatDecimal(qty_received)+'</span></td>';
                }
                tr_html += '<td><input class="form-control text-center rquantity" name="quantity[]" type="text" value="' + formatDecimal(item_qty) + '" data-id="' + row_no + '" data-item="' + item_id + '" id="quantity_' + row_no + '" onClick="this.select();"><input name="product_unit[]" type="hidden" class="runit" value="' + product_unit + '"><input name="product_base_quantity[]" type="hidden" class="rbase_quantity" value="' + base_quantity + '"></td>';
                if (site.settings.product_discount == 1) {
                    tr_html += '<td class="text-right"><input class="form-control input-sm rdiscount" name="product_discount[]" type="hidden" id="discount_' + row_no + '" value="' + item_ds + '"><span class="text-right sdiscount text-danger" id="sdiscount_' + row_no + '">' + formatMoney(0 - (item_discount * item_qty)) + '</span></td>';
                }
                if (site.settings.tax1 == 1) {
                    tr_html += '<td class="text-right"><input class="form-control input-sm text-right rproduct_tax" name="product_tax[]" type="hidden" id="product_tax_' + row_no + '" value="' + pr_tax.id + '"><span class="text-right sproduct_tax" id="sproduct_tax_' + row_no + '">' + (pr_tax_rate ? '(' + pr_tax_rate + ')' : '') + ' ' + formatMoney(pr_tax_val * item_qty) + '</span></td>';
                }
                tr_html += '<td class="text-right"><span class="text-right ssubtotal" id="subtotal_' + row_no + '">' + formatMoney(((parseFloat(item_cost) + parseFloat(pr_tax_val)) * parseFloat(item_qty))) + '</span></td>';
                tr_html += '<td class="text-center"><i class="fa fa-times tip redel" id="' + row_no + '" title="Remove" style="cursor:pointer;"></i></td>';
                newTr.html(tr_html);
                newTr.prependTo("#reTable");
                //total += parseFloat(item_cost * item_qty);
                total += formatDecimal(((parseFloat(item_cost) + parseFloat(pr_tax_val)) * parseFloat(item_qty)));
                count += parseFloat(item_qty);
                an++;

            });

            // Order level discount calculations
            if (podiscount = localStorage.getItem('podiscount')) {
                var ds = podiscount;
                if (ds.indexOf("%") !== -1) {
                    var pds = ds.split("%");
                    if (!isNaN(pds[0])) {
                        order_discount = ((total) * parseFloat(pds[0])) / 100;
                    } else {
                        order_discount = parseFloat(ds);
                    }
                } else {
                    order_discount = parseFloat(ds);
                }
            }

            // Order level tax calculations
            if (site.settings.tax2 != 0) {
                if (potax2 = localStorage.getItem('potax2')) {
                    $.each(tax_rates, function () {
                        if (this.id == potax2) {
                            if (this.type == 2) {
                                invoice_tax = parseFloat(this.rate);
                            }
                            if (this.type == 1) {
                                invoice_tax = parseFloat(((total - order_discount) * this.rate) / 100);
                            }
                        }
                    });
                }
            }
            total_discount = parseFloat(order_discount + product_discount);
            // Totals calculations after item addition
            var gtotal = parseFloat(((total + invoice_tax) - order_discount));

            if (return_surcharge = localStorage.getItem('return_surcharge')) {
                var rs = return_surcharge.replace(/"/g, '');
                if (rs.indexOf("%") !== -1) {
                    var prs = rs.split('%');
                    var percentage = parseFloat(prs[0]);
                    if (!isNaN(prs[0])) {
                        surcharge = parseFloat((gtotal * percentage) / 100);
                    } else {
                        surcharge = parseFloat(rs);
                    }
                } else {
                    surcharge = parseFloat(rs);
                }
            }
            //console.log(surcharge);
            gtotal -= surcharge;

            $('#total').text(formatMoney(total));
            $('#titems').text((an - 1) + ' (' + (parseFloat(count) - 1) + ')');
            $('#total_items').val((parseFloat(count) - 1));
            $('#trs').text(formatMoney(surcharge));
            if (site.settings.tax1) {
                $('#ttax1').text(formatMoney(product_tax));
            }
            if (site.settings.tax2 != 0) {
                $('#ttax2').text(formatMoney(invoice_tax));
            }
            $('#gtotal').text(formatMoney(gtotal));

        }
    }
</script>


<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-minus-circle"></i><?= lang('return_purchase'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?php echo lang('enter_info'); ?></p>
                <?php
                $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'class' => 'edit-resl-form');
                echo admin_form_open_multipart("purchases/return_purchase/" . $inv->id, $attrib)
                ?>

                <div class="row">
                    <div class="col-lg-12">
                        <?php if ($Owner || $Admin) { ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?= lang("date", "redate"); ?>
                                    <?php echo form_input('date', (isset($_POST['date']) ? $_POST['date'] : ""), 'class="form-control input-tip date" id="redate" required="required"'); ?>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("reference_no", "reref"); ?>
                                <?php echo form_input('reference_no', (isset($_POST['reference_no']) ? $_POST['reference_no'] : ''), 'class="form-control input-tip" id="reref"'); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("return_surcharge", "return_surcharge"); ?>
                                <?php echo form_input('return_surcharge', (isset($_POST['return_surcharge']) ? $_POST['return_surcharge'] : ''), 'class="form-control input-tip" id="return_surcharge" required="required"'); ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("document", "document") ?>
                                <input id="document" type="file" data-browse-label="<?= lang('browse'); ?>" name="document" data-show-upload="false"
                                       data-show-preview="false" class="form-control file">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="control-group table-group">
                                <label class="table-label"><?= lang("order_items"); ?></label> (<?= lang('return_tip'); ?>)

                                <div class="controls table-controls">
                                    <table id="reTable"
                                           class="table items table-striped table-bordered table-condensed table-hover">
                                        <thead>
                                        <tr>
                                            <th class="col-md-4"><?= lang("product_name") . " (" . $this->lang->line("product_code") . ")"; ?></th>
                                            <?php
                                            if ($Settings->product_expiry) {
                                                echo '<th class="col-md-1">' . $this->lang->line("expiry_date") . '</th>';
                                            }
                                            ?>
                                            <th class="col-md-1"><?= lang("net_unit_cost"); ?></th>
                                            <th class="col-md-1"><?= lang("quantity"); ?></th>
                                            <th class="col-md-1"><?= lang("received"); ?></th>
                                            <th class="col-md-1"><?= lang("return_quantity"); ?></th>
                                            <?php
                                            if ($Settings->product_discount) {
                                                echo '<th class="col-md-1">' . $this->lang->line("discount") . '</th>';
                                            }
                                            ?>
                                            <?php
                                            if ($Settings->tax1) {
                                                echo '<th class="col-md-1">' . $this->lang->line("product_tax") . '</th>';
                                            }
                                            ?>
                                            <th><?= lang("subtotal"); ?> (<span
                                                    class="currency"><?= $default_currency->code ?></span>)
                                            </th>
                                            <th style="width: 30px !important; text-align: center;">
                                                <i class="fa fa-trash-o" style="opacity:0.5; filter:alpha(opacity=50);"></i>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="bottom-total" class="well well-sm" style="margin-bottom: 0;">
                                <table class="table table-bordered table-condensed totals" style="margin-bottom:0;">
                                    <tr class="warning">
                                        <td>
                                            <?= lang('items') ?>
                                            <span class="totals_val pull-right" id="titems">0</span>
                                        </td>
                                        <td>
                                            <?= lang('total') ?>
                                            <span class="totals_val pull-right" id="total">0.00</span>
                                        </td>
                                        <?php if ($Settings->tax1) { ?>
                                        <td>
                                            <?= lang('product_tax') ?>
                                            <span class="totals_val pull-right" id="ttax1">0.00</span>
                                        </td>
                                        <?php } ?>
                                        <td>
                                            <?= lang('surcharges') ?>
                                            <span class="totals_val pull-right" id="trs">0.00</span>
                                        </td>
                                        <?php if ($Settings->tax2) { ?>
                                        <td>
                                            <?= lang('order_tax') ?>
                                            <span class="totals_val pull-right" id="ttax2">0.00</span>
                                        </td>
                                        <?php } ?>
                                        <td>
                                            <?= lang('return_amount') ?>
                                            <span class="totals_val pull-right" id="gtotal">0.00</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div style="height:15px; clear: both;"></div>
                        <div class="col-md-12">
                            <?php
                            if ($inv->payment_status == 'paid' || $inv->payment_status == 'partial') {
                                echo '<div class="alert alert-success"><p>' . lang('payment_status') . ': <strong>' . $inv->payment_status . '</strong> & ' . lang('paid_amount') . ' <strong>' . $this->sma->formatMoney($inv->paid) . '</strong></p><p>'.lang('adjust_payments').'</p></div>';
                            } else {
                                echo '<div class="alert alert-warning"><p>' . lang('payment_status') . ': <strong>' . $inv->payment_status . '</strong> & ' . lang('paid_amount') . ' <strong>' . $this->sma->formatMoney($inv->paid) . '</strong></p><p>'.lang('adjust_payments').'</p></div>';
                            }
                            ?>
                        </div>

                        <input type="hidden" name="total_items" value="" id="total_items" required="required"/>
                        <input type="hidden" name="order_tax" value="" id="retax2" required="required"/>
                        <input type="hidden" name="discount" value="" id="rediscount" required="required"/>

                        <div class="row" id="bt">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?= lang("return_note", "renote"); ?>
                                        <?php echo form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : ""), 'class="form-control" id="renote" style="margin-top: 10px; height: 100px;"'); ?>

                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="col-md-12">
                            <div
                                class="fprom-group"><?php echo form_submit('add_return', $this->lang->line("submit"), 'id="add_return" class="btn btn-primary" style="padding: 6px 15px; margin:15px 0;"'); ?></div>
                        </div>
                    </div>
                </div>


                <?php echo form_close(); ?>

            </div>

        </div>
    </div>
</div>
