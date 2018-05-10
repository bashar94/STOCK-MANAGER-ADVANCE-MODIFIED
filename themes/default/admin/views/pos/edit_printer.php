<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-print"></i><?= lang('edit_printer'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <p><?= lang('update_info'); ?></p>

                <?php echo admin_form_open_multipart("pos/edit_printer/".$printer->id);?>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="title"><?= $this->lang->line("title"); ?></label>
                        <?= form_input('title', set_value('title', $printer->title), 'class="form-control input-sm" id="title"'); ?>
                    </div>

                    <div class="form-group">
                        <?= lang('type', 'type'); ?>
                        <?php
                        $topts = array('network' => lang('network'), 'windows' => lang('windows'), 'linux' => lang('linux'));
                        ?>
                        <?= form_dropdown('type', $topts, set_value('type', $printer->type), 'class="form-control select2" id="type" required="required" style="width:100%;"'); ?>
                    </div>

                    <div class="form-group">
                        <?= lang('profile', 'profile'); ?>
                        <?php
                        $popts = array('default' => lang('default'), 'simple' => lang('simple'), 'SP2000' => lang('star_branded'), 'TEP-200M' => lang('epson_tep'), 'P822D' => lang('P822D'));
                        ?>
                        <?= form_dropdown('profile', $popts, set_value('profile', $printer->profile), 'class="form-control select2" id="profile" required="required" style="width:100%;"'); ?>
                    </div>

                    <div class="form-group">
                        <?= lang('char_per_line', 'char_per_line'); ?>
                        <?= form_input('char_per_line', $printer->char_per_line, 'class="form-control" id="char_per_line" required="required"'); ?>
                    </div>

                    <div class="path" style="display:none;">
                        <div class="form-group">
                            <?= lang('path', 'path'); ?> <strong>*</strong>
                            <?= form_input('path', $printer->path, 'class="form-control" id="path"'); ?>
                            <span class="help-block">
                                <strong>For Windows:</strong> (Local USB, Serial or Parallel Printer): Share the printer and enter the share name for your printer here or for Server Message Block (SMB): enter as a smb:// url format such as <code>smb://computername/Receipt Printer</code><br>
                                <strong>For Linux:</strong> Parallel as <code>/dev/lp0</code>, USB as <code>/dev/usb/lp1</code>, USB-Serial as <code>/dev/ttyUSB0</code>, Serial as <code>/dev/ttyS0</code><br>
                            </span>
                        </div>
                    </div>

                    <div class="network">
                        <div class="form-group">
                            <?= lang('ip_address', 'ip_address'); ?> <strong>*</strong>
                            <?= form_input('ip_address', set_value('ip_address', $printer->ip_address), 'class="form-control" id="ip_address"'); ?>
                        </div>

                        <div class="form-group">
                            <?= lang('port', 'port'); ?> <strong>*</strong>
                            <?= form_input('port', set_value('port', $printer->port), 'class="form-control" id="port"'); ?>
                            <span class="help-block">Most printers are open on port <strong>9100</strong></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo form_submit('update_printer', $this->lang->line("update_printer"), 'class="btn btn-primary"');?>
                    </div>
                </div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        $('#type').change(function () {
            var type = $(this).val();
            if (type == 'network') {
                $('.network').slideDown();
                $('.path').slideUp();
            } else {
                $('.network').slideUp();
                $('.path').slideDown();
            }
        });
        var type = $('#type').val();
        if (type == 'network') {
            $('.network').slideDown();
            $('.path').slideUp();
        } else {
            $('.network').slideUp();
            $('.path').slideDown();
        }
    });
</script>
