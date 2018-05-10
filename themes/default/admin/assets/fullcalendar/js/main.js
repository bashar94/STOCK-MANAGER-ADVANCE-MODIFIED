var fcDelay = 200, fcClicks = 0, fcTimer = null;
$(document).ready(function(){
    var startDate, endDate;
    var currentEvent;
    $('#color').colorpicker();
    // Fullcalendar
    $('#calendar').fullCalendar({
        lang: currentLangCode,
        isRTL: (site.settings.user_rtl == 1 ? true : false),
        eventLimit: true,
        timeFormat: 'H:mm',
        height: 550,
        // timezone: site.settings.timezone, // 'local', 'UTC' or timezone
        ignoreTimezone: false,
        selectable: true,
        selectHelper: true,
        select: function(start, end) {
            startDate = start.format();
            endDate = end.format();
            modal({
                buttons: {
                    add: {
                        id: 'add-event',
                        css: 'btn-primary submit',
                        label: cal_lang.add_event
                    }
                },
                title: cal_lang.add_event+' (' + start.format(moment_df) + ' - ' + end.format(moment_df) + ')'
            });
        },
        header: {
            left: 'prev, next, today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        // Get all events stored in database
        events: site.base_url+'calendar/get_events',
        // Handle Day Click
        // dayClick: function(date, event, view) {
        //     startDate = date.format();
        //     modal({
        //         buttons: {
        //             add: {
        //                 id: 'add-event',
        //                 css: 'btn-primary submit',
        //                 label: cal_lang.add_event
        //             }
        //         },
        //         title: cal_lang.add_event+' (' + date.format() + ')'
        //     });
        // },
        // Event Mouseover
        eventMouseover: function(calEvent, jsEvent, view){
            if (calEvent.description) {
            var tooltip = '<div class="event-tooltip">' + calEvent.description + '</div>';
            $("body").append(tooltip);
            $(this).mouseover(function(e) {
                $(this).css('z-index', 10000);
                $('.event-tooltip').fadeIn('500');
                $('.event-tooltip').fadeTo('10', 1.9);
            }).mousemove(function(e) {
                    $('.event-tooltip').css('top', e.pageY + 10);
                    $('.event-tooltip').css('left', e.pageX + 20);
                });
        }
        },
        eventMouseout: function(calEvent, jsEvent) {
            $(this).css('z-index', 8);
            $('.event-tooltip').remove();
        },
        // Handle Existing Event Click
        eventClick: function(calEvent, jsEvent, view) {
            currentEvent = calEvent;

            if( ! currentEvent.url) {
                modal({
                    buttons: {
                        delete: {
                            id: 'delete-event',
                            css: 'btn-danger pull-left',
                            label: cal_lang.delete
                        },
                        update: {
                            id: 'update-event',
                            css: 'btn-primary submit',
                            label: cal_lang.edit_event
                        }
                    },
                    title: cal_lang.edit_event+' "' + calEvent.title + '"',
                    event: calEvent
                });
            }
        }
    });

    function modal(data) {

        $('.modal-title').html(data.title);
        $('.modal-footer button:not(".btn-default")').remove();
        $('#title').val(data.event ? data.event.title : '');
        if(data.event) {
            var start = data.event.start.format(moment_df);
            var end = data.event.end ? data.event.end.format(moment_df) : '';
        } else {
            var start = moment(startDate).format(moment_df);
            var end = endDate ? moment(endDate).format(moment_df) : '';
        }
        
        if (data.event) { $('#eid').val(data.event.id); }
        $('#start').val(start);
        $('#end').val(end);
        $('#description').val(data.event ? data.event.description : '');
        $('#color').val(data.event ? data.event.color : '#3a87ad');

        $.each(data.buttons, function(index, button){
            $('.modal-footer').prepend('<button type="button" id="' + button.id  + '" class="btn ' + button.css + '">' + button.label + '</button>')
        })

        $('.cal_modal').modal('show');
        
    }
    // Handle Click on Add Button
    $('.cal_modal').on('click', '#add-event',  function(e){
        if(validator(['title', 'start'])) {
            var edata = {
                title: $('#title').val(),
                description: $('#description').val(),
                color: $('#color').val(),
                start: $('#start').val(),
                end: $('#end').val(),
            };
            edata[tkname] = tkvalue;
            $.post(site.base_url+'calendar/add_event', edata, function(result){
                $('.cal_modal').modal('hide');
                addAlert(result.msg, (result.error == 1 ? 'danger' : 'success'));
                $('#calendar').fullCalendar("refetchEvents");
            });
        }
    });
    // Handle click on Update Button
    $('.cal_modal').on('click', '#update-event',  function(e){
        if(validator(['title', 'start'])) {
            var edata = {
                id: $('#eid').val(),
                title: $('#title').val(),
                description: $('#description').val(),
                color: $('#color').val(),
                start: $('#start').val(),
                end: $('#end').val(),
            };
            edata[tkname] = tkvalue;
            $.post(site.base_url+'calendar/update_event', edata, function(result){
                $('.cal_modal').modal('hide');
                addAlert(result.msg, (result.error == 1 ? 'danger' : 'success'));
                $('#calendar').fullCalendar("refetchEvents");
            });
        }
    });
    // Handle Click on Delete Button
    $('.cal_modal').on('click', '#delete-event',  function(e){
        $.get(site.base_url+'calendar/delete_event/' + currentEvent._id, function(result){
            $('.cal_modal').modal('hide');
            addAlert(result.msg, (result.error == 1 ? 'danger' : 'success'));
            $('#calendar').fullCalendar("refetchEvents");
        });
    });
    $('#color').on('changeColor', function () {
        $('#event-color-addon').css('background', $(this).val()).css('borderColor', $(this).val());
    });
    $('.cal_modal').on('show.bs.modal', function () {
        $('#event-color-addon').css('background', $('#color').val()).css('borderColor', $('#color').val());
    });
    $('.cal_modal').on('shown.bs.modal', function () {
        $(this).keypress(function(e) {
            if (! $(e.target).hasClass('skip')) {
                if (e.which == '13') {
                    $('.submit').trigger('click');
                }
            }
        });
    });
    $('.cal_modal').on('hidden.bs.modal', function () {
        $('.error').html('');
    });
    // Basic Validation For Inputs
    function validator(elements) {
        var errors = 0;
        $.each(elements, function(index, element){
            if($.trim($('#' + element).val()) == '') errors++;
        });
        if(errors) {
            $('.error').html(cal_lang.event_error);
            return false;
        }
        return true;
    }
});