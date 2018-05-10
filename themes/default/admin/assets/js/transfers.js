$(document).ready(function () {
$('body a, body button').attr('tabindex', -1);
check_add_item_val();
if (site.settings.set_focus != 1) {
    $('#add_item').focus();
}
// Order level shipping and discoutn localStorage 
$('#tostatus').change(function (e) {
    localStorage.setItem('tostatus', $(this).val());
});
if (tostatus = localStorage.getItem('tostatus')) {
    $('#tostatus').select2("val", tostatus);
    if(tostatus == 'completed') {
        $('#tostatus').select2("readonly", true);
    }
}
var old_shipping;
$('#toshipping').focus(function () {
    old_shipping = $(this).val();
}).change(function () {
    if (!is_numeric($(this).val())) {
        $(this).val(old_shipping);
        bootbox.alert(lang.unexpected_value);
        return;
    } else {
        shipping = $(this).val() ? parseFloat($(this).val()) : '0';
    }
    localStorage.setItem('toshipping', shipping);
    var gtotal = total  + shipping;
    $('#gtotal').text(formatMoney(gtotal));
    $('#tship').text(formatMoney(shipping));
});
if (toshipping = localStorage.getItem('toshipping')) {
    shipping = parseFloat(toshipping);
    $('#toshipping').val(shipping);
}
//localStorage.clear();
// If there is any item in localStorage
if (localStorage.getItem('toitems')) {
    loadItems();
}

    // clear localStorage and reload
    $('#reset').click(function (e) {
        bootbox.confirm(lang.r_u_sure, function (result) {
            if (result) {
                if (localStorage.getItem('toitems')) {
                    localStorage.removeItem('toitems');
                }
                if (localStorage.getItem('toshipping')) {
                    localStorage.removeItem('toshipping');
                }
                if (localStorage.getItem('toref')) {
                    localStorage.removeItem('toref');
                }
                if (localStorage.getItem('to_warehouse')) {
                    localStorage.removeItem('to_warehouse');
                }
                if (localStorage.getItem('tonote')) {
                    localStorage.removeItem('tonote');
                }
                if (localStorage.getItem('from_warehouse')) {
                    localStorage.removeItem('from_warehouse');
                }
                if (localStorage.getItem('todate')) {
                    localStorage.removeItem('todate');
                }
                if (localStorage.getItem('tostatus')) {
                    localStorage.removeItem('tostatus');
                }

                 $('#modal-loading').show();
                 location.reload();
             }
         });
});

// save and load the fields in and/or from localStorage

$('#toref').change(function (e) {
    localStorage.setItem('toref', $(this).val());
});
if (toref = localStorage.getItem('toref')) {
    $('#toref').val(toref);
}
$('#to_warehouse').change(function (e) {
    localStorage.setItem('to_warehouse', $(this).val());
});
if (to_warehouse = localStorage.getItem('to_warehouse')) {
    $('#to_warehouse').select2("val", to_warehouse);
}
$('#from_warehouse').change(function (e) {
    localStorage.setItem('from_warehouse', $(this).val());
});
if (from_warehouse = localStorage.getItem('from_warehouse')) {
    $('#from_warehouse').select2("val", from_warehouse);
    if (count > 1) {
        $('#from_warehouse').select2("readonly", true);
    }
}

    //$(document).on('change', '#tonote', function (e) {
        $('#tonote').redactor('destroy');
        $('#tonote').redactor({
            buttons: ['formatting', '|', 'alignleft', 'aligncenter', 'alignright', 'justify', '|', 'bold', 'italic', 'underline', '|', 'unorderedlist', 'orderedlist', '|', 'link', '|', 'html'],
            formattingTags: ['p', 'pre', 'h3', 'h4'],
            minHeight: 100,
            changeCallback: function (e) {
                var v = this.get();
                localStorage.setItem('tonote', v);
            }
        });
        if (tonote = localStorage.getItem('tonote')) {
            $('#tonote').redactor('set', tonote);
        }

        $(document).on('change', '.rexpiry', function () { 
            var item_id = $(this).closest('tr').attr('data-item-id');
            toitems[item_id].row.expiry = $(this).val();
            localStorage.setItem('toitems', JSON.stringify(toitems));
        });


// prevent default action upon enter
$('body').bind('keypress', function (e) {
    if ($(e.target).hasClass('redactor_editor')) {
        return true;
    }
    if (e.keyCode == 13) {
        e.preventDefault();
        return false;
    }
});


    /* ---------------------- 
     * Delete Row Method 
     * ---------------------- */

    $(document).on('click', '.todel', function () {
        var row = $(this).closest('tr');
        var item_id = row.attr('data-item-id');
        delete toitems[item_id];
        row.remove();
        if(toitems.hasOwnProperty(item_id)) { } else {
            localStorage.setItem('toitems', JSON.stringify(toitems));
            loadItems();
            return;
        }
    });

    /* --------------------------
     * Edit Row Quantity Method 
     -------------------------- */
     var old_row_qty;
     $(document).on("focus", '.rquantity', function () {
        old_row_qty = $(this).val();
    }).on("change", '.rquantity', function () {
        var row = $(this).closest('tr');
        if (!is_numeric($(this).val()) || parseFloat($(this).val()) < 0) {
            $(this).val(old_row_qty);
            bootbox.alert(lang.unexpected_value);
            return;
        }
        var new_qty = parseFloat($(this).val()),
        item_id = row.attr('data-item-id');
        toitems[item_id].row.base_quantity = new_qty;
        if(toitems[item_id].row.unit != toitems[item_id].row.base_unit) {
            $.each(toitems[item_id].units, function(){
                if (this.id == toitems[item_id].row.unit) {
                    toitems[item_id].row.base_quantity = unitToBaseQty(new_qty, this);
                }
            });
        }
        toitems[item_id].row.qty = new_qty;
        localStorage.setItem('toitems', JSON.stringify(toitems));
        loadItems();
    });
    
    /* --------------------------
     * Edit Row Cost Method 
     -------------------------- */
     var old_cost;
     $(document).on("focus", '.rcost', function () {
        old_cost = $(this).val();
    }).on("change", '.rcost', function () {
        var row = $(this).closest('tr');
        if (!is_numeric($(this).val())) {
            $(this).val(old_cost);
            bootbox.alert(lang.unexpected_value);
            return;
        }
        var new_cost = parseFloat($(this).val()),
        item_id = row.attr('data-item-id');
        toitems[item_id].row.cost = new_cost;
        localStorage.setItem('toitems', JSON.stringify(toitems));
        loadItems();
    });
    
    $(document).on("click", '#removeReadonly', function () { 
     $('#from_warehouse').select2('readonly', false); 
     return false;
 });
    
    
});

/* -----------------------
 * Edit Row Modal Hanlder 
 ----------------------- */
 $(document).on('click', '.edit', function () {
    var row = $(this).closest('tr');
    var row_id = row.attr('id');
    item_id = row.attr('data-item-id');
    item = toitems[item_id];
    var qty = row.children().children('.rquantity').val(), 
    product_option = row.children().children('.roption').val(),
    cost = row.children().children('.rucost').val();
    $('#prModalLabel').text(item.row.name + ' (' + item.row.code + ')');
    if (site.settings.tax1) {
        var tax = item.tax_rate != 0 ? item.tax_rate.name + ' (' + item.tax_rate.rate + ')' : 'N/A';
        $('#ptax').text(tax);
        $('#old_tax').val($('#sproduct_tax_' + row_id).text());
    }

    var opt = '<p style="margin: 12px 0 0 0;">n/a</p>';
    if(item.options !== false) {
        var o = 1;
        opt = $("<select id=\"poption\" name=\"poption\" class=\"form-control select\" />");
        $.each(item.options, function () {
            if(o == 1) {
                if(product_option == '') { product_variant = this.id; } else { product_variant = product_option; }
            }
            $("<option />", {value: this.id, text: this.name}).appendTo(opt);
            o++;
        });
    } 
    uopt = $("<select id=\"punit\" name=\"punit\" class=\"form-control select\" />");
        $.each(item.units, function () {
            if(this.id == item.row.unit) {
                $("<option />", {value: this.id, text: this.name, selected:true}).appendTo(uopt);
            } else {
                $("<option />", {value: this.id, text: this.name}).appendTo(uopt);
            }
        });
    $('#poptions-div').html(opt);
    $('#punits-div').html(uopt);
    $('select.select').select2({minimumResultsForSearch: 7});
    $('#pquantity').val(qty);
    $('#old_qty').val(qty);
    $('#pprice').val(cost);
    $('#poption').select2('val', item.row.option);
    $('#old_price').val(cost);
    $('#row_id').val(row_id);
    $('#item_id').val(item_id);
    $('#pserial').val(row.children().children('.rserial').val());
    $('#pproduct_tax').select2('val', row.children().children('.rproduct_tax').val());
    $('#pdiscount').val(row.children().children('.rdiscount').val());
    $('#prModal').appendTo("body").modal('show');

});

$('#prModal').on('shown.bs.modal', function (e) {
    if($('#poption').select2('val') != '') {
        $('#poption').select2('val', product_variant);
        product_variant = 0;
    }
});

$(document).on('change', '#punit', function () {
    var row = $('#' + $('#row_id').val());
    var item_id = row.attr('data-item-id');
    var item = toitems[item_id];
    if (!is_numeric($('#pquantity').val()) || parseFloat($('#pquantity').val()) < 0) {
        $(this).val(old_row_qty);
        bootbox.alert(lang.unexpected_value);
        return;
    }
    var unit = $('#punit').val();
    if(unit != toitems[item_id].row.base_unit) {
        $.each(item.units, function() {
            if (this.id == unit) {
                $('#pprice').val(formatDecimal((parseFloat(item.row.base_unit_cost)*(unitToBaseQty(1, this))), 4)).change();
            }
        });
    } else {
        $('#pprice').val(formatDecimal(item.row.base_unit_cost)).change();
    }
});

/* -----------------------
 * Edit Row Method 
 ----------------------- */
 $(document).on('click', '#editItem', function () {
    var row = $('#' + $('#row_id').val());
    var item_id = row.attr('data-item-id');
    if (!is_numeric($('#pquantity').val()) || parseFloat($('#pquantity').val()) < 0) {
        $(this).val(old_row_qty);
        bootbox.alert(lang.unexpected_value);
        return;
    }
    var unit = $('#punit').val();
    var base_quantity = parseFloat($('#pquantity').val());
    if(unit != toitems[item_id].row.base_unit) {
        $.each(toitems[item_id].units, function(){
            if (this.id == unit) {
                base_quantity = unitToBaseQty($('#pquantity').val(), this);
            }
        });
    }
    toitems[item_id].row.fup = 1,
    toitems[item_id].row.qty = parseFloat($('#pquantity').val()),
    toitems[item_id].row.base_quantity = parseFloat(base_quantity),
    toitems[item_id].row.unit = unit,
    toitems[item_id].row.real_unit_cost = parseFloat($('#pprice').val()),
    toitems[item_id].row.cost = parseFloat($('#pprice').val()),
    // toitems[item_id].row.tax_rate = new_pr_tax_rate,
    toitems[item_id].row.discount = $('#pdiscount').val(),
    toitems[item_id].row.option = $('#poption').val(),
    // toitems[item_id].row.tax_method = 1;
    localStorage.setItem('toitems', JSON.stringify(toitems));
    $('#prModal').modal('hide');
    
    loadItems();
    return;
});

/* -----------------------
 * Misc Actions
 ----------------------- */

 function loadItems() {

    if (localStorage.getItem('toitems')) {
        total = 0;
        count = 1;
        an = 1;
        product_tax = 0;
        $("#toTable tbody").empty();
        $('#add_transfer, #edit_transfer').attr('disabled', false);
        toitems = JSON.parse(localStorage.getItem('toitems'));
        sortedItems = (site.settings.item_addition == 1) ? _.sortBy(toitems, function(o){return [parseInt(o.order)];}) :   toitems;

        var order_no = new Date().getTime();
        $.each(sortedItems, function () {
            var item = this;
            var item_id = site.settings.item_addition == 1 ? item.item_id : item.id;
            item.order = item.order ? item.order : order_no++;
            var from_warehouse = localStorage.getItem('from_warehouse'), check = false;
            var product_id = item.row.id, item_type = item.row.type, item_cost = item.row.cost, item_qty = item.row.qty, item_bqty = item.row.quantity_balance, item_oqty = item.row.ordered_quantity, item_expiry = item.row.expiry, item_aqty = item.row.quantity, item_tax_method = item.row.tax_method, item_ds = item.row.discount, item_discount = 0, item_option = item.row.option, item_code = item.row.code, item_serial = item.row.serial, item_name = item.row.name.replace(/"/g, "&#034;").replace(/'/g, "&#039;");

            var unit_cost = item.row.real_unit_cost;
            var product_unit = item.row.unit, base_quantity = item.row.base_quantity;

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
            item_cost = item_tax_method == 0 ? formatDecimal(unit_cost-pr_tax_val, 4) : formatDecimal(unit_cost);
            unit_cost = formatDecimal(unit_cost+item_discount, 4);
            var sel_opt = '';
            $.each(item.options, function () {
                if(this.id == item_option) {
                    sel_opt = this.name;
                }
            });

            var row_no = (new Date).getTime();
            var newTr = $('<tr id="row_' + row_no + '" class="row_' + item_id + '" data-item-id="' + item_id + '"></tr>');
            tr_html = '<td><input name="product_id[]" type="hidden" class="rid" value="' + product_id + '"><input name="product_type[]" type="hidden" class="rtype" value="' + item_type + '"><input name="product_code[]" type="hidden" class="rcode" value="' + item_code + '"><input name="product_name[]" type="hidden" class="rname" value="' + item_name + '"><input name="product_option[]" type="hidden" class="roption" value="' + item_option + '"><span class="sname" id="name_' + row_no + '">' + item_code +' - '+ item_name +(sel_opt != '' ? ' ('+sel_opt+')' : '')+'</span> <i class="pull-right fa fa-edit tip tointer edit" id="' + row_no + '" data-item="' + item_id + '" title="Edit" style="cursor:pointer;"></i></td>';
            if (site.settings.product_expiry == 1) {
                tr_html += '<td><input class="form-control date rexpiry" name="expiry[]" type="text" value="' + item_expiry + '" data-id="' + row_no + '" data-item="' + item_id + '" id="expiry_' + row_no + '"></td>';
            }
            tr_html += '<td class="text-right"><input class="form-control input-sm text-right rcost" name="net_cost[]" type="hidden" id="cost_' + row_no + '" value="' + formatDecimal(item_cost) + '"><input class="rucost" name="unit_cost[]" type="hidden" value="' + unit_cost + '"><input class="realucost" name="real_unit_cost[]" type="hidden" value="' + item.row.real_unit_cost + '"><span class="text-right scost" id="scost_' + row_no + '">' + formatMoney(item_cost) + '</span></td>';
            tr_html += '<td><input name="quantity_balance[]" type="hidden" class="rbqty" value="' + formatDecimal(item_bqty, 4) + '"><input name="ordered_quantity[]" type="hidden" class="roqty" value="' + formatDecimal(item_oqty, 4) + '"><input class="form-control text-center rquantity" tabindex="'+((site.settings.set_focus == 1) ? an : (an+1))+'" name="quantity[]" type="text" value="' + formatQuantity2(item_qty) + '" data-id="' + row_no + '" data-item="' + item_id + '" id="quantity_' + row_no + '" onClick="this.select();"><input name="product_unit[]" type="hidden" class="runit" value="' + product_unit + '"><input name="product_base_quantity[]" type="hidden" class="rbase_quantity" value="' + base_quantity + '"></td>';
            if (site.settings.tax1 == 1) {
                tr_html += '<td class="text-right"><input class="form-control input-sm text-right rproduct_tax" name="product_tax[]" type="hidden" id="product_tax_' + row_no + '" value="' + pr_tax.id + '"><span class="text-right sproduct_tax" id="sproduct_tax_' + row_no + '">' + (pr_tax_rate ? '(' + formatDecimal(pr_tax_rate) + ')' : '') + ' ' + formatMoney(pr_tax_val * item_qty) + '</span></td>';
            }
            tr_html += '<td class="text-right"><span class="text-right ssubtotal" id="subtotal_' + row_no + '">' + formatMoney(((parseFloat(item_cost) - item_discount + parseFloat(pr_tax_val)) * parseFloat(item_qty))) + '</span></td>';
            tr_html += '<td class="text-center"><i class="fa fa-times tip todel" id="' + row_no + '" title="Remove" style="cursor:pointer;"></i></td>';
            newTr.html(tr_html);
            newTr.prependTo("#toTable");
            total += formatDecimal(((parseFloat(item_cost) + parseFloat(pr_tax_val)) * parseFloat(item_qty)), 4);
            count += parseFloat(item_qty);
            an++;
            if (item.options !== false) {
                $.each(item.options, function () {
                    if(this.id == item_option && base_quantity > this.quantity) {
                        $('#row_' + row_no).addClass('danger');
                        $('#add_transfer, #edit_transfer').attr('disabled', true); 
                    }
                });
            } else if(base_quantity > item_aqty) { 
                $('#row_' + row_no).addClass('danger');
                $('#add_transfer, #edit_transfer').attr('disabled', true); 
            }
            
        });

        var col = 2;
        if (site.settings.product_expiry == 1) { col++; }
        var tfoot = '<tr id="tfoot" class="tfoot active"><th colspan="'+col+'">Total</th><th class="text-center">' + formatQty(parseFloat(count) - 1) + '</th>';
        if (site.settings.tax1 == 1) {
            tfoot += '<th class="text-right">'+formatMoney(product_tax)+'</th>';
        }
        tfoot += '<th class="text-right">'+formatMoney(total)+'</th><th class="text-center"><i class="fa fa-trash-o" style="opacity:0.5; filter:alpha(opacity=50);"></i></th></tr>';
        $('#toTable tfoot').html(tfoot);

        // Totals calculations after item addition
        var gtotal = total + shipping;
        $('#total').text(formatMoney(total));
        $('#titems').text((an-1)+' ('+(formatQty(parseFloat(count) - 1))+')');
        if (site.settings.tax1) {
            $('#ttax1').text(formatMoney(product_tax));
        }
        $('#gtotal').text(formatMoney(gtotal));
        if (an > parseInt(site.settings.bc_fix) && parseInt(site.settings.bc_fix) > 0) {
            $("html, body").animate({scrollTop: $('#sticker').offset().top}, 500);
            $(window).scrollTop($(window).scrollTop() + 1);
        }
        set_page_focus();
    }
}

/* -----------------------------
 * Add Purchase Iten Function
 * @param {json} item
 * @returns {Boolean}
 ---------------------------- */
 function add_transfer_item(item) {

    if (count == 1) {
        toitems = {};
        if ($('#from_warehouse').val()) {
            $('#from_warehouse').select2("readonly", true);
        } else {
            bootbox.alert(lang.select_above);
            item = null;
            return;
        }
    }
    if (item == null)
        return;

    var item_id = site.settings.item_addition == 1 ? item.item_id : item.id;
    if (toitems[item_id]) {

        var new_qty = parseFloat(toitems[item_id].row.qty) + 1;
        toitems[item_id].row.base_quantity = new_qty;
        if(toitems[item_id].row.unit != toitems[item_id].row.base_unit) {
            $.each(toitems[item_id].units, function(){
                if (this.id == toitems[item_id].row.unit) {
                    toitems[item_id].row.base_quantity = unitToBaseQty(new_qty, this);
                }
            });
        }
        toitems[item_id].row.qty = new_qty;

    } else {
        toitems[item_id] = item;
    }
    toitems[item_id].order = new Date().getTime();
    localStorage.setItem('toitems', JSON.stringify(toitems));
    loadItems();
    return true;
}

if (typeof (Storage) === "undefined") {
    $(window).bind('beforeunload', function (e) {
        if (count > 1) {
            var message = "You will loss data!";
            return message;
        }
    });
}