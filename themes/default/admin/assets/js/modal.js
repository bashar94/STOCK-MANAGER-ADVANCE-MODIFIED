if(!window.jQuery) {
    var pn = window.location.pathname;
    var modal_exp = pn.split('/');
    window.location.replace(window.location.protocol+'//'+window.location.host+'/'+modal_exp[1]);
}
$(document).ready(function(e) {
    $('form[data-toggle="validator"]').bootstrapValidator({ feedbackIcons:{valid: 'fa fa-check',invalid: 'fa fa-times',validating: 'fa fa-refresh'}, excluded: [':disabled'] });
    fields = $('.modal-content').find('.form-control');
    $.each(fields, function() {
        var id = $(this).attr('id');
        var iname = $(this).attr('name');
        var iid = '#'+id;
        if (!!$(this).attr('data-bv-notempty') || !!$(this).attr('required')) {
            $("label[for='" + id + "']").append(' *');
            $(document).on('change', iid, function(){
                $('form[data-toggle="validator"]').bootstrapValidator('revalidateField', iname);
            });
        }
    });
    $('input[type="checkbox"],[type="radio"]').not('.skip').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });
    $("textarea").not('.skip').redactor({
        buttons: ["formatting", "|", "alignleft", "aligncenter", "alignright", "justify", "|", "bold", "italic", "underline", "|", "unorderedlist", "orderedlist", "|", "link", "|", "html"],
        formattingTags: ["p", "pre", "h3", "h4"],
        minHeight: 100,
        changeCallback: function(e) {
            var editor = this.$editor.next('textarea');
            if($(editor).attr('required')){
                $('form[data-toggle="validator"]').bootstrapValidator('revalidateField', $(editor).attr('name'));
            }
	   }
    });
    $(".input-tip").tooltip({placement: "top", html: true, trigger: "hover focus", container: "body",
        title: function() {
            return $(this).attr("data-tip");
        }
    });
    $(".input-pop").popover({placement: "top", html: true, trigger: "hover focus", container: "body",
        content: function() {
            return $(this).attr("data-tip");
        },
        title: function() {
            return "<b>" + $('label[for="' + $(this).attr("id") + '"]').text() + "</b>";
        }
    });
    $('select, select.select').select2({minimumResultsForSearch: 7});
    $('#date_range').daterangepicker({ format: site.dateFormats.js_sdate }, function(start, end, label) {
        $('#from_date').val(start.format('YYYY-MM-DD'));
        $('#to_date').val(end.format('YYYY-MM-DD'));
    });
    $('#myModal').on('shown.bs.modal', function() {
        $('.modal-body :input:first').focus();
    });
    $('#csv_file').change(function(e) {
	v = $(this).val();
	if (v != '') {
	    var validExts = new Array(".csv");
	    var fileExt = v;
	    fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
	    if (validExts.indexOf(fileExt) < 0) {
		e.preventDefault();
		bootbox.alert("Invalid file selected. Only .csv file is allowed.");
		$(this).val('');
		$('form[data-toggle="validator"]').bootstrapValidator('updateStatus', 'csv_file', 'NOT_VALIDATED');
		return false;
	    }
	    else
		return true;
	}
    });
});
$(function() {
    $('.datetime').datetimepicker({format: site.dateFormats.js_ldate, language: 'sma', weekStart: 1, todayBtn: 1, autoclose: 1, todayHighlight: 1, startView: 2, forceParse: 0});
    $('.date').datetimepicker({format: site.dateFormats.js_sdate, language: 'sma', todayBtn: 1, autoclose: 1, minView: 2 });
});
