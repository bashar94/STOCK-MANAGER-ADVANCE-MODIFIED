<script>
    $(document).ready(function () {
        $('#PData').dataTable({
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?= lang('all'); ?>']],
            "aaSorting": [[ 0, "asc" ]], "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= admin_url('pos/get_printers') ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            "aoColumns": [null, null, null, null, null, null, {"bSortable":false, "bSearchable": false}]
        }).fnSetFilteringDelay();
    });
</script>

<div class="box">
    <div class="box-header">
    <h2 class="blue"><i class="fa-fw fa fa-print"></i><?= lang('printers'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <p><?= lang('list_results'); ?></p>
                <div class="table-responsive">
                    <table id="PData" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th class="col-xs-2"><?= lang("title"); ?></th>
                                <th class="col-xs-1"><?= lang("type"); ?></th>
                                <th class="col-xs-2"><?= lang("profile"); ?></th>
                                <th class="col-xs-3"><?= lang("path"); ?></th>
                                <th class="col-xs-2"><?= lang("ip_address"); ?></th>
                                <th class="col-xs-1"><?= lang("port"); ?></th>
                                <th style="width:65px;"><?= lang("actions"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
