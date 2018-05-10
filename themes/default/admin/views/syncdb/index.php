<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-database"></i>Sync database</h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <p class="introtext">Please use the actions below to sync your old databse to match with new version.
                    Once you done, please visit your new dashboard</p>
                <?php if ($Settings->version < '3.0') { ?>
                    <div class="well">
                        <p>Please perform all these action one by one starting from first.</p>

                        <div class="form-group">
                            <div class="actions">
                                <div class="col-xs-3"><a href="#" class="btn btn-primary btn-block" id="user_groups">Correct
                                        User Groups</a></div>
                                <div class="performing" style="padding-top:7px;display:none;"><i
                                        class="fa fa-refresh fa-spin"></i></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <div class="actions">
                                <div class="col-xs-3"><a href="#" class="btn btn-primary btn-block" id="import_billers">Import
                                        Billers</a></div>
                                <div class="performing" style="padding-top:7px;display:none;"><i
                                        class="fa fa-refresh fa-spin"></i></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <div class="actions">
                                <div class="col-xs-3"><a href="#" class="btn btn-primary btn-block"
                                                         id="import_customers">Import Customers</a></div>
                                <div class="performing" style="padding-top:7px;display:none;"><i
                                        class="fa fa-refresh fa-spin"></i></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <div class="actions">
                                <div class="col-xs-3"><a href="#" class="btn btn-primary btn-block"
                                                         id="import_suppliers">Import Suppliers</a></div>
                                <div class="performing" style="padding-top:7px;display:none;"><i
                                        class="fa fa-refresh fa-spin"></i></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <div class="actions">
                                <div class="col-xs-3"><a href="#" class="btn btn-warning btn-block"
                                                         id="delete_extra_tables">Delete extra tables</a></div>
                                <div class="performing" style="padding-top:7px;display:none;"><i
                                        class="fa fa-refresh fa-spin"></i></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                <?php } ?>
                <div class="well">
                    <?php if ($Settings->version == '3.0') {
                        echo '<p class="text-danger">If you have added the new records, that will be updated too.</p>';
                    } ?>
                    <p>If you need to save the old sales, quotes, purchases and transfer please update the records for
                        these table by clicking the below buttons.</p>

                    <div class="form-group">
                        <div class="actions">
                            <div class="col-xs-3"><a href="#" class="btn btn-primary btn-block" id="update_sales">Update
                                    Sales Table</a></div>
                            <div class="performing" style="padding-top:7px;display:none;"><i
                                    class="fa fa-refresh fa-spin"></i></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <div class="actions">
                            <div class="col-xs-3"><a href="#" class="btn btn-primary btn-block" id="update_quotes">Update
                                    Quotes Table</a></div>
                            <div class="performing" style="padding-top:7px;display:none;"><i
                                    class="fa fa-refresh fa-spin"></i></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <div class="actions">
                            <div class="col-xs-3"><a href="#" class="btn btn-primary btn-block" id="update_purchases">Update
                                    Purchases Table</a></div>
                            <div class="performing" style="padding-top:7px;display:none;"><i
                                    class="fa fa-refresh fa-spin"></i></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <div class="actions">
                            <div class="col-xs-3"><a href="#" class="btn btn-primary btn-block" id="update_transfers">Update
                                    Transfers Table</a></div>
                            <div class="performing" style="padding-top:7px;display:none;"><i
                                    class="fa fa-refresh fa-spin"></i></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <p>OR - You can delete old data in these tables if you like. </p>

                    <div class="form-group">
                        <div class="actions">
                            <div class="col-xs-3"><a href="#" class="btn btn-danger btn-block" id="reset_sales">Reset
                                    Sales Table</a></div>
                            <div class="performing" style="padding-top:7px;display:none;"><i
                                    class="fa fa-refresh fa-spin"></i></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <div class="actions">
                            <div class="col-xs-3"><a href="#" class="btn btn-danger btn-block" id="reset_quotes">Reset
                                    Quotes Table</a></div>
                            <div class="performing" style="padding-top:7px;display:none;"><i
                                    class="fa fa-refresh fa-spin"></i></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <div class="actions">
                            <div class="col-xs-3"><a href="#" class="btn btn-danger btn-block" id="reset_purchases">Reset
                                    Purchases Table</a></div>
                            <div class="performing" style="padding-top:7px;display:none;"><i
                                    class="fa fa-refresh fa-spin"></i></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <div class="actions">
                            <div class="col-xs-3"><a href="#" class="btn btn-danger btn-block" id="reset_transfers">Reset
                                    Transfers Table</a></div>
                            <div class="performing" style="padding-top:7px;display:none;"><i
                                    class="fa fa-refresh fa-spin"></i></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <div class="actions">
                            <div class="col-xs-3"><a href="#" class="btn btn-danger btn-block" id="reset_deliveries">Reset
                                    Deliveries Table</a></div>
                            <div class="performing" style="padding-top:7px;display:none;"><i
                                    class="fa fa-refresh fa-spin"></i></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <div class="actions">
                            <div class="col-xs-3"><a href="#" class="btn btn-danger btn-block" id="reset_products">Reset
                                    Products Table</a></div>
                            <div class="performing" style="padding-top:7px;display:none;"><i
                                    class="fa fa-refresh fa-spin"></i></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <div class="actions">
                            <div class="col-xs-3"><a href="#" class="btn btn-danger btn-block"
                                                     id="reset_damage_products">Reset Damage Products Table</a></div>
                            <div class="performing" style="padding-top:7px;display:none;"><i
                                    class="fa fa-refresh fa-spin"></i></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('document').ready(function () {

        $('#delete_extra_tables').click(function (e) {
            var btn = $(this);
            e.preventDefault();
            bootbox.confirm("Please make sure you have perfomr all above actions before deleting tables. Procced?", function (res) {
                if (res == true) {
                    var perf = btn.parent().parent('.actions').children('.performing');
                    perf.show();
                    $.ajax({
                        url: '<?=admin_url('sync/delete_extra_tables')?>',
                        type: 'GET',
                        success: function (msg) {
                            perf.html(msg);
                            btn.attr('disabled', false);
                        },
                        error: function () {
                            perf.html('Request Failed!').show();
                            btn.attr('disabled', false);
                        }
                    });
                }
            });
        });

        $('#user_groups').click(function (e) {
            var btn = $(this);
            e.preventDefault();
            btn.attr('disabled', true);
            var perf = btn.parent().parent('.actions').children('.performing');
            perf.show();
            $.ajax({
                url: '<?=admin_url('sync/user_groups')?>',
                type: 'GET',
                success: function (msg) {
                    perf.html(msg);
                    btn.attr('disabled', false);
                },
                error: function () {
                    perf.html('Request Failed!').show();
                    btn.attr('disabled', false);
                }
            });
        });

        $('#import_billers').click(function (e) {
            var btn = $(this);
            e.preventDefault();
            btn.attr('disabled', true);
            var perf = btn.parent().parent('.actions').children('.performing');
            perf.show();
            $.ajax({
                url: '<?=admin_url('sync/import_billers')?>',
                type: 'GET',
                success: function (msg) {
                    perf.html(msg);
                    btn.attr('disabled', false);
                },
                error: function () {
                    perf.html('Request Failed!').show();
                    btn.attr('disabled', false);
                }
            });
        });

        $('#import_customers').click(function (e) {
            var btn = $(this);
            e.preventDefault();
            btn.attr('disabled', true);
            var perf = btn.parent().parent('.actions').children('.performing');
            perf.show();
            $.ajax({
                url: '<?=admin_url('sync/import_customers')?>',
                type: 'GET',
                success: function (msg) {
                    perf.html(msg);
                    btn.attr('disabled', false);
                },
                error: function () {
                    perf.html('Request Failed!').show();
                    btn.attr('disabled', false);
                }
            });
        });

        $('#import_suppliers').click(function (e) {
            var btn = $(this);
            e.preventDefault();
            btn.attr('disabled', true);
            var perf = btn.parent().parent('.actions').children('.performing');
            perf.show();
            $.ajax({
                url: '<?=admin_url('sync/import_suppliers')?>',
                type: 'GET',
                success: function (msg) {
                    perf.html(msg);
                    btn.attr('disabled', false);
                },
                error: function () {
                    perf.html('Request Failed!').show();
                    btn.attr('disabled', false);
                }
            });
        });

        $('#reset_sales').click(function (e) {
            var btn = $(this);
            e.preventDefault();
            bootbox.confirm("Are you sure to delete all the sales and reset the table?", function (res) {
                if (res == true) {
                    var perf = btn.parent().parent('.actions').children('.performing');
                    perf.show();
                    $.ajax({
                        url: '<?=admin_url('sync/reset_sales')?>',
                        type: 'GET',
                        success: function (msg) {
                            perf.html(msg);
                            btn.attr('disabled', false);
                        },
                        error: function () {
                            perf.html('Request Failed!').show();
                            btn.attr('disabled', false);
                        }
                    });
                }
            });
        });

        $('#reset_quotes').click(function (e) {
            var btn = $(this);
            e.preventDefault();
            bootbox.confirm("Are you sure to delete all the quotations and reset the table?", function (res) {
                if (res == true) {
                    var perf = btn.parent().parent('.actions').children('.performing');
                    perf.show();
                    $.ajax({
                        url: '<?=admin_url('sync/reset_quotes')?>',
                        type: 'GET',
                        success: function (msg) {
                            perf.html(msg);
                            btn.attr('disabled', false);
                        },
                        error: function () {
                            perf.html('Request Failed!').show();
                            btn.attr('disabled', false);
                        }
                    });
                }
            });
        });

        $('#reset_purchases').click(function (e) {
            var btn = $(this);
            e.preventDefault();
            bootbox.confirm("Are you sure to delete all the purchases and reset the table?", function (res) {
                if (res == true) {
                    var perf = btn.parent().parent('.actions').children('.performing');
                    perf.show();
                    $.ajax({
                        url: '<?=admin_url('sync/reset_purchases')?>',
                        type: 'GET',
                        success: function (msg) {
                            perf.html(msg);
                            btn.attr('disabled', false);
                        },
                        error: function () {
                            perf.html('Request Failed!').show();
                            btn.attr('disabled', false);
                        }
                    });
                }
            });
        });

        $('#reset_transfers').click(function (e) {
            var btn = $(this);
            e.preventDefault();
            bootbox.confirm("Are you sure to delete all the transfers and reset the table?", function (res) {
                if (res == true) {
                    var perf = btn.parent().parent('.actions').children('.performing');
                    perf.show();
                    $.ajax({
                        url: '<?=admin_url('sync/reset_transfers')?>',
                        type: 'GET',
                        success: function (msg) {
                            perf.html(msg);
                            btn.attr('disabled', false);
                        },
                        error: function () {
                            perf.html('Request Failed!').show();
                            btn.attr('disabled', false);
                        }
                    });
                }
            });
        });

        $('#reset_deliveries').click(function (e) {
            var btn = $(this);
            e.preventDefault();
            bootbox.confirm("Are you sure to delete all the deliveries and reset the table?", function (res) {
                if (res == true) {
                    var perf = btn.parent().parent('.actions').children('.performing');
                    perf.show();
                    $.ajax({
                        url: '<?=admin_url('sync/reset_deliveries')?>',
                        type: 'GET',
                        success: function (msg) {
                            perf.html(msg);
                            btn.attr('disabled', false);
                        },
                        error: function () {
                            perf.html('Request Failed!').show();
                            btn.attr('disabled', false);
                        }
                    });
                }
            });
        });

        $('#reset_products').click(function (e) {
            var btn = $(this);
            e.preventDefault();
            bootbox.confirm("Are you sure to delete all the products and reset the table?", function (res) {
                if (res == true) {
                    var perf = btn.parent().parent('.actions').children('.performing');
                    perf.show();
                    $.ajax({
                        url: '<?=admin_url('sync/reset_products')?>',
                        type: 'GET',
                        success: function (msg) {
                            perf.html(msg);
                            btn.attr('disabled', false);
                        },
                        error: function () {
                            perf.html('Request Failed!').show();
                            btn.attr('disabled', false);
                        }
                    });
                }
            });
        });

        $('#reset_damage_products').click(function (e) {
            var btn = $(this);
            e.preventDefault();
            bootbox.confirm("Are you sure to delete all the damage products and reset the table?", function (res) {
                if (res == true) {
                    var perf = btn.parent().parent('.actions').children('.performing');
                    perf.show();
                    $.ajax({
                        url: '<?=admin_url('sync/reset_damage_products')?>',
                        type: 'GET',
                        success: function (msg) {
                            perf.html(msg);
                            btn.attr('disabled', false);
                        },
                        error: function () {
                            perf.html('Request Failed!').show();
                            btn.attr('disabled', false);
                        }
                    });
                }
            });
        });

        $('#update_sales').click(function (e) {
            var btn = $(this);
            e.preventDefault();
            btn.attr('disabled', true);
            var perf = btn.parent().parent('.actions').children('.performing');
            perf.show();
            $.ajax({
                url: '<?=admin_url('sync/update_sales')?>',
                type: 'GET',
                success: function (msg) {
                    perf.html(msg);
                    btn.attr('disabled', false);
                },
                error: function () {
                    perf.html('Request Failed!').show();
                    btn.attr('disabled', false);
                }
            });
        });

        $('#update_quotes').click(function (e) {
            var btn = $(this);
            e.preventDefault();
            btn.attr('disabled', true);
            var perf = btn.parent().parent('.actions').children('.performing');
            perf.show();
            $.ajax({
                url: '<?=admin_url('sync/update_quotes')?>',
                type: 'GET',
                success: function (msg) {
                    perf.html(msg);
                    btn.attr('disabled', false);
                },
                error: function () {
                    perf.html('Request Failed!').show();
                    btn.attr('disabled', false);
                }
            });
        });

        $('#update_purchases').click(function (e) {
            var btn = $(this);
            e.preventDefault();
            btn.attr('disabled', true);
            var perf = btn.parent().parent('.actions').children('.performing');
            perf.show();
            $.ajax({
                url: '<?=admin_url('sync/update_purchases')?>',
                type: 'GET',
                success: function (msg) {
                    perf.html(msg);
                    btn.attr('disabled', false);
                },
                error: function () {
                    perf.html('Request Failed!').show();
                    btn.attr('disabled', false);
                }
            });
        });

        $('#update_transfers').click(function (e) {
            var btn = $(this);
            e.preventDefault();
            btn.attr('disabled', true);
            var perf = btn.parent().parent('.actions').children('.performing');
            perf.show();
            $.ajax({
                url: '<?=admin_url('sync/update_transfers')?>',
                type: 'GET',
                success: function (msg) {
                    perf.html(msg);
                    btn.attr('disabled', false);
                },
                error: function () {
                    perf.html('Request Failed!').show();
                    btn.attr('disabled', false);
                }
            });
        });

    });

</script>