<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= lang('view_bill') . " | " . $Settings->site_name; ?></title>
    <base href="<?= base_url() ?>"/>
    <meta http-equiv="cache-control" content="max-age=0"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta http-equiv="expires" content="0"/>
    <meta http-equiv="pragma" content="no-cache"/>
    <link rel="shortcut icon" href="<?=$assets?>images/icon.png"/>
    <link rel="stylesheet" href="<?= $assets ?>styles/theme.css" type="text/css"/>
    <style type="text/css">
        html, body { background: #F9F9F9; margin: 0; padding: 0; width: 100%; height: 100%; min-width: 400px; color: #333; }
        a { outline: none; }
        h2 { margin: 20px 0; }
        .with-promo-space { }
        .bill { min-height: 600px; background: #FFF; margin: 20px 20px 0 20px; }
        .content { display: none; }
        .with-promo-space .wrap { margin: 0; padding: 0; overflow: hidden; }
        .with-promo-space .main { margin: 20px 20px 0 0; width: calc(100% - 470px); float: right; }
        .with-promo-space .content { display: block; }
        .with-promo-space .bill { width: 400px; float: left; min-height: 600px; }
        td { vertical-align: middle !important; }
        #product-list { display: block; overflow: hidden; min-height: 486px; border: 1px solid #ddd; padding: 20px 20px 0 20px; }
        #totals { border-top: 1px solid #ddd; }
        .preview_frame { width: 100%; }
        .ctable tr td:first-child { width: 20%; }
    </style>
</head>
<body class="with-promo-space">
<!-- just remove the class with-promo-space from body to make it full page -->
<noscript>
    <div class="global-site-notice noscript">
        <div class="notice-inner">
            <p><strong>JavaScript seems to be disabled in your browser.</strong><br>You must have JavaScript enabled in
                your browser to utilize the functionality of this website.</p>
        </div>
    </div>
</noscript>

<div class="wrap">
    <div class="bill" id="bill">
        <div id="product-list">
            <table style="margin-bottom: 0;" id="billTable" class="table table-striped table-condensed">
                <thead>
                <tr>
                    <th width="50%" class="text-center"><?= lang('product'); ?></th>
                    <th width="15%" class="text-center"><?= lang('price'); ?></th>
                    <th width="15%" class="text-center"><?= lang('qty'); ?></th>
                    <th width="20%" class="text-center"><?= lang('subtotal'); ?></th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div id="totals">
            <table style="width:100%; float:right; padding:5px; color:#000; background: #FFF;" id="totalTable">
                <tbody>
                <tr>
                    <td style="border-left: 1px solid #ddd; padding-left:10px; text-align:left; font-weight:normal;">
                        <?= lang('items'); ?>
                    </td>
                    <td style="text-align:right; padding-right:10px; font-weight:bold;"><span id="titems">0</span></td>
                    <td style="padding-left:10px; text-align:left;"><?= lang('total'); ?></td>
                    <td style="border-right: 1px solid #ddd; text-align:right; padding-right:10px; font-weight:bold;">
                        <span id="total">0.00</span></td>
                </tr>
                <tr>
                    <td style="border-left: 1px solid #ddd; padding-left:10px; text-align:left; font-weight:normal;">
                        <?= lang('order_tax'); ?>
                    </td>
                    <td style="text-align:right; padding-right:10px; font-weight:bold;"><span id="ttax2">0.00</span>
                    </td>
                    <td style="padding-left:10px; text-align:left; "><?= lang('discount'); ?></td>
                    <td style="border-right: 1px solid #ddd; text-align:right; padding-right:10px; font-weight:bold;">
                        <span id="tds">0.00</span></td>
                </tr>
                <tr>
                    <td colspan="3"
                        style="padding: 5px 0px 5px 10px; text-align:left; font-size: 1.4em; border: 1px solid #333; font-weight:bold; background:#333; color:#FFF;">
                        <?= lang('total_payable'); ?> <?= $Settings->display_symbol ? $Settings->symbol : ''; ?>
                        <small id="tship"></small>
                    </td>
                    <td colspan="1"
                        style="text-align:right; padding:5px 10px 5px 0px; font-size: 1.4em; border: 1px solid #333; font-weight:bold; background:#333; color:#FFF;">
                        <span id="gtotal">0.00</span></td>
                </tr>
                </tbody>
            </table>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="main">
        <!-- If you don't want to display customer details, please remove the id from the div below -->
        <div class="content" id="rightside-content">
            <iframe class="preview_frame" src="<?= admin_url('welcome/promotions'); ?>" name="preview-frame" frameborder="0" noresize="noresize"></iframe>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<script type="text/javascript" src="<?= $assets ?>js/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?=$assets?>pos/js/plugins.min.js"></script>
<?php unset($Settings->setting_id, $Settings->smtp_user, $Settings->smtp_pass, $Settings->smtp_port, $Settings->update, $Settings->reg_ver, $Settings->allow_reg, $Settings->default_email, $Settings->mmode, $Settings->timezone, $Settings->restrict_calendar, $Settings->restrict_user, $Settings->auto_reg, $Settings->reg_notification); ?>
<script
        type="text/javascript">var site = <?= json_encode(array('base_url' => base_url(), 'settings' => $Settings, 'dateFormats' => $dateFormats)) ?>, pos_settings = <?= json_encode($pos_settings); ?>;</script>

<script type="text/javascript">
    var product_tax = 0, invoice_tax = 0, total_discount = 0, product_discount = 0, order_discount = 0, total = 0, tax_rates = <?php echo json_encode($tax_rates); ?>, pos_customer = localStorage.getItem('poscustomer'), shipping = 0;

    function widthFunctions(e) {
        var wh = $(window).height(),
                tT = $('#totalTable').outerHeight(true);
        $('#bill').css("height", (wh - 42));
        $('#product-list').css("height", (wh - tT - 42));
        $('.preview_frame').css("height", (wh - 35));
    }
    $(window).bind("resize", widthFunctions);
    $(window).bind("load", widthFunctions);
    $(document).ready(function () {
        if (localStorage.getItem('poscustomer')) {
            getCustomer(localStorage.getItem('poscustomer'));
        }
        loadItems();
        window.setInterval(function () {
            if (localStorage.getItem('poscustomer') && pos_customer != localStorage.getItem('poscustomer')) {
                getCustomer(localStorage.getItem('poscustomer'));
            }
            loadItems();
        }, 1000);
    });
    function formatDecimal(x) {
        return parseFloat(parseFloat(x).toFixed(site.settings.decimals));
    }
    function formatQuantity2(x) {
        return (x != null) ? parseFloat(parseFloat(x, site.settings.qty_decimals).toFixed(site.settings.qty_decimals)) : '';
    }
    function getCustomer(x) {
        $.getJSON('customers/get_customer_details/'+x, function(data) {
            $('#rightside-content').html('<div class="well"><h3><?= lang('customer'); ?>: '+(data.company && data.company != '-' ? data.company+' ('+data.name+')' : data.name)+'</h3><div class="table-responsive"><table class="ctable table table-striped"><tr><td><?= lang('company'); ?></td><td><strong>'+data.company+'</strong></td></tr><tr><td><?= lang('contact_person'); ?></td><td><strong>'+data.name+'</strong></td></tr><tr><td><?= lang('award_points'); ?></td><td><strong>'+data.award_points+'</strong></td></tr><tr><td><?= lang('deposit_amount'); ?></td><td><strong>'+formatMoney(data.deposit_amount)+'</strong></td></tr><tr><td><?= lang('vat_no'); ?></td><td><strong>'+data.vat_no+'</strong></td></tr><tr><td><?= lang('phone'); ?></td><td><strong>'+data.phone+'</strong></td></tr><tr><td><?= lang('email_address'); ?></td><td><strong>'+data.email+'</strong></td></tr><tr><td><?= lang('address'); ?></td><td><strong>'+data.address+' '+data.city+' '+data.postal_code+' '+data.state+' '+data.country+'</strong></td></tr><tr><td colspan="2">'+
                (data.cf1 ? '<?= lang('ccf1'); ?>: <strong>'+data.cf1+'</strong>,' : '') +
                (data.cf1 ? '<?= lang('ccf2'); ?>: <strong>'+data.cf2+'</strong>,' : '') +
                (data.cf1 ? '<?= lang('ccf3'); ?>: <strong>'+data.cf3+'</strong>,' : '') +
                (data.cf1 ? '<?= lang('ccf4'); ?>: <strong>'+data.cf4+'</strong>,' : '') +
                (data.cf1 ? '<?= lang('ccf5'); ?>: <strong>'+data.cf5+'</strong>,' : '') +
                (data.cf1 ? '<?= lang('ccf6'); ?>: <strong>'+data.cf6+'</strong>,' : '') +
                '</td></tr></table></div></div>');
        });
    }

    function loadItems() {

        if (localStorage.getItem('positems')) {
            total = 0;
            count = 1;
            an = 1;
            product_tax = 0;
            invoice_tax = 0;
            product_discount = 0;
            order_discount = 0;
            total_discount = 0;
            shipping = parseFloat(localStorage.getItem('posshipping') ? localStorage.getItem('posshipping') : 0);

            $("#billTable tbody").empty();

            positems = JSON.parse(localStorage.getItem('positems'));
            if (pos_settings.item_order == 1) {
                sortedItems = _.sortBy(positems, function(o){ return [parseInt(o.category), parseInt(o.order)]; } );
            } else if (site.settings.item_addition == 1) {
                sortedItems = _.sortBy(positems, function(o){return [parseInt(o.order)];})
            } else {
                sortedItems = positems;
            }
            var category = 0, print_cate = false;

            $.each(sortedItems, function () {

                var item = this;
                var item_id = site.settings.item_addition == 1 ? item.item_id : item.id;
                positems[item_id] = item;
                item.order = item.order ? item.order : new Date().getTime();
                var product_id = item.row.id, item_type = item.row.type, combo_items = item.combo_items, item_price = item.row.price, item_qty = item.row.qty, item_aqty = item.row.quantity, item_tax_method = item.row.tax_method, item_ds = item.row.discount, item_discount = 0, item_option = item.row.option, item_code = item.row.code, item_serial = item.row.serial, item_name = item.row.name.replace(/"/g, "&#034;").replace(/'/g, "&#039;");
                var product_unit = item.row.unit, base_quantity = item.row.base_quantity;
                var unit_price = item.row.real_unit_price;
                if(item.row.fup != 1 && product_unit != item.row.base_unit) {
                    $.each(item.units, function(){
                        if (this.id == product_unit) {
                            base_quantity = formatDecimal(unitToBaseQty(item.row.qty, this), 4);
                            unit_price = formatDecimal((parseFloat(item.row.base_unit_price)*(unitToBaseQty(1, this))), 4);
                        }
                    });
                }
                if(item.options !== false) {
                    $.each(item.options, function () {
                        if(this.id == item.row.option && this.price != 0 && this.price != '' && this.price != null) {
                            item_price = unit_price+(parseFloat(this.price));
                            unit_price = item_price;
                        }
                    });
                }

                var ds = item_ds ? item_ds : '0';
                if (ds.indexOf("%") !== -1) {
                    var pds = ds.split("%");
                    if (!isNaN(pds[0])) {
                        item_discount = formatDecimal((parseFloat(((unit_price) * parseFloat(pds[0])) / 100)), 4);
                    } else {
                        item_discount = formatDecimal(ds);
                    }
                } else {
                    item_discount = formatDecimal(ds);
                }
                product_discount += formatDecimal(item_discount * item_qty);

                unit_price = formatDecimal(unit_price-item_discount);
                var pr_tax = item.tax_rate;
                var pr_tax_val = 0, pr_tax_rate = 0;
                if (site.settings.tax1 == 1) {
                    if (pr_tax !== false) {
                        if (pr_tax.type == 1) {

                            if (item_tax_method == '0') {
                                pr_tax_val = formatDecimal(((unit_price) * parseFloat(pr_tax.rate)) / (100 + parseFloat(pr_tax.rate)), 4);
                                pr_tax_rate = formatDecimal(pr_tax.rate) + '%';
                            } else {
                                pr_tax_val = formatDecimal(((unit_price) * parseFloat(pr_tax.rate)) / 100, 4);
                                pr_tax_rate = formatDecimal(pr_tax.rate) + '%';
                            }

                        } else if (pr_tax.type == 2) {

                            pr_tax_val = formatDecimal(pr_tax.rate);
                            pr_tax_rate = pr_tax.rate;

                        }
                        product_tax += pr_tax_val * item_qty;
                    }
                }
                item_price = item_tax_method == 0 ? formatDecimal((unit_price-pr_tax_val), 4) : formatDecimal(unit_price);
                unit_price = formatDecimal((unit_price+item_discount), 4);
                var sel_opt = '';
                $.each(item.options, function () {
                    if(this.id == item_option) {
                        sel_opt = this.name;
                    }
                });

                if (pos_settings.item_order == 1 && category != item.row.category_id) {
                    category = item.row.category_id;
                    print_cate = true;
                    var newTh = $('<tr></tr>');
                    newTh.html('<td colspan="100%"><strong>'+item.row.category_name+'</strong></td>');
                    newTh.appendTo("#billTable");
                } else {
                    print_cate = false;
                }

                var row_no = (new Date).getTime();
                var newTr = $('<tr id="row_' + row_no + '" class="row_' + item_id + '" data-item-id="' + item_id + '"></tr>');
                tr_html = '<td><span class="sname" id="name_' + row_no + '">' + item_code +' - '+ item_name +(sel_opt != '' ? ' ('+sel_opt+')' : '')+'</span>';
                if (site.settings.product_serial == 1) {
                    tr_html += '<br><span>'+item_serial+'</span>';
                }
                tr_html += '</td>';
                tr_html += '<td class="text-right">' + formatMoney(parseFloat(item_price) + parseFloat(pr_tax_val)) + '</td>';
                tr_html += '<td class="text-center">'+formatQuantity2(item_qty) + '</td>';
                tr_html += '<td class="text-right">' + formatMoney(((parseFloat(item_price) + parseFloat(pr_tax_val)) * parseFloat(item_qty))) + '</td>';

                newTr.html(tr_html);
                if (pos_settings.item_order == 1) {
                    newTr.appendTo("#billTable");
                } else {
                    newTr.prependTo("#billTable");
                }
                total += formatDecimal(((parseFloat(item_price) + parseFloat(pr_tax_val)) * parseFloat(item_qty)), 4);
                count += parseFloat(item_qty);
                an++;
            });
            if (posdiscount = localStorage.getItem('posdiscount')) {
                var ds = posdiscount;
                if (ds.indexOf("%") !== -1) {
                    var pds = ds.split("%");
                    if (!isNaN(pds[0])) {
                        order_discount = formatDecimal((parseFloat(((total) * parseFloat(pds[0])) / 100)), 4);
                    } else {
                        order_discount = parseFloat(ds);
                    }
                } else {
                    order_discount = parseFloat(ds);
                }
            }
            if (site.settings.tax2 != 0) {
                if (postax2 = localStorage.getItem('postax2')) {
                    $.each(tax_rates, function () {
                        if (this.id == postax2) {
                            if (this.type == 2) {
                                invoice_tax = formatDecimal(this.rate);
                            }
                            if (this.type == 1) {
                                invoice_tax = formatDecimal((((total - order_discount) * this.rate) / 100), 4);
                            }
                        }
                    });
                }
            }

            total = formatDecimal(total);
            product_tax = formatDecimal(product_tax);
            total_discount = formatDecimal(order_discount + product_discount);

            var gtotal = parseFloat(((total + invoice_tax) - order_discount)) + shipping;

            $('#total').text(formatMoney(total));
            $('#titems').text((an - 1) + ' (' + formatQuantity2(parseFloat(count) - 1) + ')');
            $('#total_items').val((parseFloat(count) - 1));
            $('#tds').text('('+formatMoney(product_discount)+') '+formatMoney(order_discount));
            if (site.settings.tax2 != 0) {
                $('#ttax2').text(formatMoney(invoice_tax));
            }
            $('#tship').text(shipping > 0 ? ' + <?= lang('shipping'); ?>' : '');
            $('#gtotal').text(formatMoney(gtotal));

        } else {
            $("#billTable tbody").empty();
            $('#total').text('0.00');
            $('#titems').text('0.00');
            $('#tds').text('(0.00) 0.00)');
            if (site.settings.tax2 != 0) {
                $('#ttax2').text('0.00');
            }
            $('#gtotal').text('0.00');
        }
    }

    function formatMoney(x, symbol) {
        if (!symbol) {
            symbol = "";
        }
        return accounting.formatMoney(x, symbol, site.settings.decimals, site.settings.thousands_sep == 0 ? ' ' : site.settings.thousands_sep, site.settings.decimals_sep, "%s%v");
    }

    (function (p, z) {
        function q(a) {
            return !!("" === a || a && a.charCodeAt && a.substr)
        }

        function m(a) {
            return u ? u(a) : "[object Array]" === v.call(a)
        }

        function r(a) {
            return "[object Object]" === v.call(a)
        }

        function s(a, b) {
            var d, a = a || {}, b = b || {};
            for (d in b)b.hasOwnProperty(d) && null == a[d] && (a[d] = b[d]);
            return a
        }

        function j(a, b, d) {
            var c = [], e, h;
            if (!a)return c;
            if (w && a.map === w)return a.map(b, d);
            for (e = 0, h = a.length; e < h; e++)c[e] = b.call(d, a[e], e, a);
            return c
        }

        function n(a, b) {
            a = Math.round(Math.abs(a));
            return isNaN(a) ? b : a
        }

        function x(a) {
            var b = c.settings.currency.format;
            "function" === typeof a && (a = a());
            return q(a) && a.match("%v") ? {
                pos: a,
                neg: a.replace("-", "").replace("%v", "-%v"),
                zero: a
            } : !a || !a.pos || !a.pos.match("%v") ? !q(b) ? b : c.settings.currency.format = {
                pos: b,
                neg: b.replace("%v", "-%v"),
                zero: b
            } : a
        }

        var c = {
            version: "0.4.1",
            settings: {
                currency: {symbol: "$", format: "%s%v", decimal: ".", thousand: ",", precision: 2, grouping: 3},
                number: {precision: 0, grouping: 3, thousand: ",", decimal: "."}
            }
        }, w = Array.prototype.map, u = Array.isArray, v = Object.prototype.toString, o = c.unformat = c.parse = function (a, b) {
            if (m(a))return j(a, function (a) {
                return o(a, b)
            });
            a = a || 0;
            if ("number" === typeof a)return a;
            var b = b || ".", c = RegExp("[^0-9-" + b + "]", ["g"]), c = parseFloat(("" + a).replace(/\((.*)\)/, "-$1").replace(c, "").replace(b, "."));
            return !isNaN(c) ? c : 0
        }, y = c.toFixed = function (a, b) {
            var b = n(b, c.settings.number.precision), d = Math.pow(10, b);
            return (Math.round(c.unformat(a) * d) / d).toFixed(b)
        }, t = c.formatQuantity = c.format = function (a, b, d, i) {
            if (m(a))return j(a, function (a) {
                return t(a, b, d, i)
            });
            var a = o(a), e = s(r(b) ? b : {
                precision: b,
                thousand: d,
                decimal: i
            }, c.settings.number), h = n(e.precision), f = 0 > a ? "-" : "", g = parseInt(y(Math.abs(a || 0), h), 10) + "", l = 3 < g.length ? g.length % 3 : 0;
            return f + (l ? g.substr(0, l) + e.thousand : "") + g.substr(l).replace(/(\d{3})(?=\d)/g, "$1" + e.thousand) + (h ? e.decimal + y(Math.abs(a), h).split(".")[1] : "")
        }, A = c.formatMoney = function (a, b, d, i, e, h) {
            if (m(a))return j(a, function (a) {
                return A(a, b, d, i, e, h)
            });
            var a = o(a), f = s(r(b) ? b : {
                symbol: b,
                precision: d,
                thousand: i,
                decimal: e,
                format: h
            }, c.settings.currency), g = x(f.format);
            return (0 < a ? g.pos : 0 > a ? g.neg : g.zero).replace("%s", f.symbol).replace("%v", t(Math.abs(a), n(f.precision), f.thousand, f.decimal))
        };
        c.formatColumn = function (a, b, d, i, e, h) {
            if (!a)return [];
            var f = s(r(b) ? b : {
                symbol: b,
                precision: d,
                thousand: i,
                decimal: e,
                format: h
            }, c.settings.currency), g = x(f.format), l = g.pos.indexOf("%s") < g.pos.indexOf("%v") ? !0 : !1, k = 0, a = j(a, function (a) {
                if (m(a))return c.formatColumn(a, f);
                a = o(a);
                a = (0 < a ? g.pos : 0 > a ? g.neg : g.zero).replace("%s", f.symbol).replace("%v", t(Math.abs(a), n(f.precision), f.thousand, f.decimal));
                if (a.length > k)k = a.length;
                return a
            });
            return j(a, function (a) {
                return q(a) && a.length < k ? l ? a.replace(f.symbol, f.symbol + Array(k - a.length + 1).join(" ")) : Array(k - a.length + 1).join(" ") + a : a
            })
        };
        if ("undefined" !== typeof exports) {
            if ("undefined" !== typeof module && module.exports)exports = module.exports = c;
            exports.accounting = c
        } else"function" === typeof define && define.amd ? define([], function () {
            return c
        }) : (c.noConflict = function (a) {
            return function () {
                p.accounting = a;
                c.noConflict = z;
                return c
            }
        }(p.accounting), p.accounting = c)
    })(this);
</script>
<script>
    $('#myCarousel').carousel({
        interval: 0
    });

    var clickEvent = false;
    $('#myCarousel').on('click', '.nav a', function () {
        clickEvent = true;
        $('.nav li').removeClass('active');
        $(this).parent().addClass('active');
    }).on('slid.bs.carousel', function (e) {
        if (!clickEvent) {
            var count = $('.nav').children().length - 1;
            var current = $('.nav li.active');
            current.removeClass('active').next().addClass('active');
            var id = parseInt(current.data('slide-to'));
            if (count == id) {
                $('.nav li').first().addClass('active');
            }
        }
        clickEvent = false;
    });
    // setInterval(function() { shipping = parseFloat(localStorage.getItem('posshipping') ? localStorage.getItem('posshipping') : 0); loadItems() }, 2000);
</script>
</body>
</html>
