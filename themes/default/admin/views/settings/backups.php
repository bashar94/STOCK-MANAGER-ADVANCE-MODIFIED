<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box" style="margin-bottom: 15px;">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-database"></i><?= lang('database_backups'); ?> <small class="text-danger">(Only for small database, Please use your control panel to backup large database)</small></h2>

        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown"><a href="<?= admin_url('system_settings/backup_database') ?>"><i
                            class="icon fa fa-database"></i><span
                            class="padding-right-10"><?= lang('backup_database'); ?></span></a></li>
            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <p class="introtext"><?= lang('restore_heading'); ?></p>

                <div class="row">
                    <div class="col-md-12">
                        <?php
                        foreach ($dbs as $file) {
                            $file = basename($file);
                            echo '<div class="well well-sm">';
                            $date_string = substr($file, 13, 10);
                            $time_string = substr($file, 24, 8);
                            $date = $date_string . ' ' . str_replace('-', ':', $time_string);
                            $bkdate = $this->sma->hrld($date);
                            echo '<h3>' . lang('backup_on') . ' <span class="text-primary">' . $bkdate . '</span><div class="btn-group pull-right" style="margin-top:-12px;">' . anchor('admin/system_settings/download_database/' . substr($file, 0, -4), '<i class="fa fa-download"></i> ' . lang('download'), 'class="btn btn-primary"') . ' ' . anchor('admin/system_settings/restore_database/' . substr($file, 0, -4), '<i class="fa fa-database"></i> ' . lang('restore'), 'class="btn btn-warning restore_db"') . ' ' . anchor('admin/system_settings/delete_database/' . substr($file, 0, -4), '<i class="fa fa-trash-o"></i> ' . lang('delete'), 'class="btn btn-danger delete_file"') . ' </div></h3>';
                            echo '<div class="clearfix"></div></div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-folder"></i><?= lang('file_backups'); ?> <small class="text-danger">(<strong>Deprecated</strong>, Please use your control panel to backup files)</small></h2>

        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown"><a href="#" id="backup_files"><i class="icon fa fa-file-zip-o"></i><span
                            class="padding-right-10"><?= lang('backup_files'); ?></span></a></li>
            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <p class="introtext"><?= lang('restore_heading'); ?></p>

                <div class="row">
                    <div class="col-md-12">
                        <?php
                        foreach ($files as $file) {
                            $file = basename($file);
                            echo '<div class="well well-sm">';
                            $date_string = substr($file, 12, 10);
                            $time_string = substr($file, 23, 8);
                            $date = $date_string . ' ' . str_replace('-', ':', $time_string);
                            $bkdate = $this->sma->hrld($date);
                            echo '<h3>' . lang('backup_on') . ' <span class="text-primary">' . $bkdate . '</span><div class="btn-group pull-right" style="margin-top:-12px;">' . anchor('admin/system_settings/download_backup/' . substr($file, 0, -4), '<i class="fa fa-download"></i> ' . lang('download'), 'class="btn btn-primary"') . ' ' . anchor('admin/system_settings/restore_backup/' . substr($file, 0, -4), '<i class="fa fa-database"></i> ' . lang('restore'), 'class="btn btn-warning restore_backup"') . ' ' . anchor('admin/system_settings/delete_backup/' . substr($file, 0, -4), '<i class="fa fa-trash-o"></i> ' . lang('delete'), 'class="btn btn-danger delete_file"') . ' </div></h3>';
                            echo '<div class="clearfix"></div></div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
<div class="modal fade" id="wModal" tabindex="-1" role="dialog" aria-labelledby="wModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="wModalLabel"><?= lang('please_wait'); ?></h4>
            </div>
            <div class="modal-body">
                <?= lang('backup_modal_msg'); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#backup_files').click(function (e) {
            e.preventDefault();
            $('#wModalLabel').text('<?=lang('backup_modal_heading');?>');
            $('#wModal').modal({backdrop: 'static', keyboard: true}).appendTo('body').modal('show');
            window.location.href = '<?= admin_url('system_settings/backup_files'); ?>';
        });
        $('.restore_backup').click(function (e) {
            e.preventDefault();
            var href = $(this).attr('href');
            bootbox.confirm("<?=lang('restore_confirm');?>", function (result) {
                if (result) {
                    $('#wModalLabel').text('<?=lang('restore_modal_heading');?>');
                    $('#wModal').modal({backdrop: 'static', keyboard: true}).appendTo('body').modal('show');
                    window.location.href = href;
                }
            });
        });
        $('.restore_db').click(function (e) {
            e.preventDefault();
            var href = $(this).attr('href');
            bootbox.confirm("<?=lang('restore_confirm');?>", function (result) {
                if (result) {
                    window.location.href = href;
                }
            });
        });
        $('.delete_file').click(function (e) {
            e.preventDefault();
            var href = $(this).attr('href');
            bootbox.confirm("<?=lang('delete_confirm');?>", function (result) {
                if (result) {
                    window.location.href = href;
                }
            });
        });
    });
</script>