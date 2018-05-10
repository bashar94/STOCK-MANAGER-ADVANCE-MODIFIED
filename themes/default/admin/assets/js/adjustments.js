$(document).ready(function () {
    if (!localStorage.getItem('qaref')) {
        localStorage.setItem('qaref', '');
    }

    ItemnTotals();
    $('.bootbox').on('hidden.bs.modal', function (e) {
        $('#add_item').focus();
    });
    $('body a, body button').attr('tabindex', -1);
    check_add_item_val();
    if (site.settings.set_focus != 1) {
        $('#add_item').focus();
    }

    //localStorage.clear();
    // If there is any item in localStorage
    if (localStorage.getItem('qaitems')) {
        loadItems();
    }

    // clear localStorage and reload
    $('#reset').click(function (e) {
        bootbox.confirm(lang.r_u_sure, function (result) {
            if (result) {
                if (localStorage.getItem('slitems')) {
                    localStorage.removeItem('qaitems');
                }
                if (localStorage.getItem('qaref')) {
                    localStorage.removeItem('qaref');
                }
                if (localStorage.getItem('qawarehouse')) {
                    localStorage.removeItem('qawarehouse');
                }
                if (localStorage.getItem('qanote')) {
                    localStorage.removeItem('qanote');
                }
                if (localStorage.getItem('qadate')) {
                    localStorage.removeItem('qadate');
                }

                $('#modal-loading').show();
                location.reload();
            }
        });
    });

    // save and load the fields in and/or from localStorage
    $('#qaref').change(function (e) {
        localStorage.setItem('qaref', $(this).val());
    });
    if (qaref = localStorage.getItem('qaref')) {
        $('#qaref').val(qaref);
    }
    $('#qawarehouse').change(function (e) {
        localStorage.setItem('qawarehouse', $(this).val());
    });
    if (qawarehouse = localStorage.getItem('qawarehouse')) {
        $('#qawarehouse').select2("val", qawarehouse);
    }

    //$(document).on('change', '#qanote', function (e) {
        $('#qanote').redactor('destroy');
        $('#qanote').redactor({
            buttons: ['formatting', '|', 'alignleft', 'aligncenter', 'alignright', 'justify', '|', 'bold', 'italic', 'underline', '|', 'unorderedlist', 'orderedlist', '|', 'link', '|', 'html'],
            formattingTags: ['p', 'pre', 'h3', 'h4'],
            minHeight: 100,
            changeCallback: function (e) {
                var v = this.get();
                localStorage.setItem('qanote', v);
            }
        });
        if (qanote = localStorage.getItem('qanote')) {
            $('#qanote').redactor('set', qanote);
        }

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

    $(document).on('click', '.qadel', function () {
        var row = $(this).closest('tr');
        var item_id = row.attr('data-item-id');
        delete qaitems[item_id];
        row.remove();
        if(qaitems.hasOwnProperty(item_id)) { } else {
            localStorage.setItem('qaitems', JSON.stringify(qaitems));
            loadItems();
            return;
        }
    });

    /* --------------------------
     * Edit Row Quantity Method 
     -------------------------- */

    $(document).on("change", '.rquantity', function () {
        var row = $(this).closest('tr');
        if (!is_numeric($(this).val()) || parseFloat($(this).val()) < 0) {
            $(this).val(old_row_qty);
            bootbox.alert(lang.unexpected_value);
            return;
        }
        var new_qty = parseFloat($(this).val()),
        item_id = row.attr('data-item-id');
        qaitems[item_id].row.qty = new_qty;
        localStorage.setItem('qaitems', JSON.stringify(qaitems));
        loadItems();
    });

    $(document).on("change", '.rtype', function () {
        var row = $(this).closest('tr');
        var new_type = $(this).val(),
        item_id = row.attr('data-item-id');
        qaitems[item_id].row.type = new_type;
        localStorage.setItem('qaitems', JSON.stringify(qaitems));
    });

    $(document).on("change", '.rvariant', function () {
        var row = $(this).closest('tr');
        var new_opt = $(this).val(),
        item_id = row.attr('data-item-id');
        qaitems[item_id].row.option = new_opt;
        localStorage.setItem('qaitems', JSON.stringify(qaitems));
    });
        

});


/* -----------------------
 * Load Items to table
 ----------------------- */

function loadItems() {

    if (localStorage.getItem('qaitems')) {
        count = 1;
        an = 1;
        $("#qaTable tbody").empty();
        qaitems = JSON.parse(localStorage.getItem('qaitems'));
        sortedItems = (site.settings.item_addition == 1) ? _.sortBy(qaitems, function(o){return [parseInt(o.order)];}) : qaitems;
        $.each(sortedItems, function () {
            var item = this;
            var item_id = site.settings.item_addition == 1 ? item.item_id : item.id;
            item.order = item.order ? item.order : new Date().getTime();
            var product_id = item.row.id, item_qty = item.row.qty, item_option = item.row.option, item_code = item.row.code, item_serial = item.row.serial, item_name = item.row.name.replace(/"/g, "&#034;").replace(/'/g, "&#039;");
            var type = item.row.type ? item.row.type : '';
            
            var opt = $("<select id=\"poption\" name=\"variant\[\]\" class=\"form-control select rvariant\" />");
            if(item.options !== false) {
                $.each(item.options, function () {
                    if (item.row.option == this.id)
                        $("<option />", {value: this.id, text: this.name, selected: 'selected'}).appendTo(opt);
                    else
                        $("<option />", {value: this.id, text: this.name}).appendTo(opt);
                });
            } else {
                $("<option />", {value: 0, text: 'n/a'}).appendTo(opt);
                opt = opt.hide();
            }

            var row_no = (new Date).getTime();
            var newTr = $('<tr id="row_' + row_no + '" class="row_' + item_id + '" data-item-id="' + item_id + '"></tr>');
            tr_html = '<td><input name="product_id[]" type="hidden" class="rid" value="' + product_id + '"><span class="sname" id="name_' + row_no + '">' + item_code +' - ' + item_name +'</span></td>';
            tr_html += '<td>'+(opt.get(0).outerHTML)+'</td>';
            tr_html += '<td><select name="type[]" class="form-contol select rtype" style="width:100%;"><option value="subtraction"'+(type == 'subtraction' ? ' selected' : '')+'>'+type_opt.subtraction+'</option><option value="addition"'+(type == 'addition' ? ' selected' : '')+'>'+type_opt.addition+'</option></select></td>';
            tr_html += '<td><input class="form-control text-center rquantity" tabindex="'+((site.settings.set_focus == 1) ? an : (an+1))+'" name="quantity[]" type="text" value="' + formatQuantity2(item_qty) + '" data-id="' + row_no + '" data-item="' + item_id + '" id="quantity_' + row_no + '" onClick="this.select();"></td>';
            if (site.settings.product_serial == 1) {
                tr_html += '<td class="text-right"><input class="form-control input-sm rserial" name="serial[]" type="text" id="serial_' + row_no + '" value="'+item_serial+'"></td>';
            }
            tr_html += '<td class="text-center"><i class="fa fa-times tip qadel" id="' + row_no + '" title="Remove" style="cursor:pointer;"></i></td>';
            newTr.html(tr_html);
            newTr.prependTo("#qaTable");
            count += parseFloat(item_qty);
            an++;
            
        });

        var col = 3;
        var tfoot = '<tr id="tfoot" class="tfoot active"><th colspan="'+col+'">Total</th><th class="text-center">' + formatQty(parseFloat(count) - 1) + '</th>';
        if (site.settings.product_serial == 1) { tfoot += '<th></th>'; }
        tfoot += '<th class="text-center"><i class="fa fa-trash-o" style="opacity:0.5; filter:alpha(opacity=50);"></i></th></tr>';
        $('#qaTable tfoot').html(tfoot);
        $('select.select').select2({minimumResultsForSearch: 7});
        if (an > parseInt(site.settings.bc_fix) && parseInt(site.settings.bc_fix) > 0) {
            $("html, body").animate({scrollTop: $('#sticker').offset().top}, 500);
            $(window).scrollTop($(window).scrollTop() + 1);
        }
        set_page_focus();
    }
}

/* -----------------------------
 * Add Purchase Item Function
 * @param {json} item
 * @returns {Boolean}
 ---------------------------- */
function add_adjustment_item(item) {

    if (count == 1) {
        qaitems = {};
    }
    if (item == null)
        return;

    var item_id = site.settings.item_addition == 1 ? item.item_id : item.id;
    if (qaitems[item_id]) {

        var new_qty = parseFloat(qaitems[item_id].row.qty) + 1;
        qaitems[item_id].row.base_quantity = new_qty;
        if(qaitems[item_id].row.unit != qaitems[item_id].row.base_unit) {
            $.each(qaitems[item_id].units, function(){
                if (this.id == qaitems[item_id].row.unit) {
                    qaitems[item_id].row.base_quantity = unitToBaseQty(new_qty, this);
                }
            });
        }
        qaitems[item_id].row.qty = new_qty;

    } else {
        qaitems[item_id] = item;
    }
    qaitems[item_id].order = new Date().getTime();
    localStorage.setItem('qaitems', JSON.stringify(qaitems));
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