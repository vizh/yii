$(function () {
    var form = $('.event-create form');
    var fieldStartdate = form.find('input[name*="StartDate"]');
    var fieldEnddate = form.find('input[name*="EndDate"]');
    var checkboxOneDay = form.find('input[name*="OneDayDate"]');

    var datepicker = $.fn.datepicker.noConflict();
    $.fn.bootstrapDatePicker = datepicker;
    form.find('input[name*="StartDate"], input[name*="EndDate"]').bootstrapDatePicker({
        'format':'dd.mm.yyyy',
        'language':'ru',
        'autoclose':true
    });
    fieldStartdate.change(function (e) {
        if (checkboxOneDay.is(':checked')) {
            fieldEnddate.val($(e.currentTarget).val());
        }
    });
    checkboxOneDay.change(function (e) {
        if ($(e.currentTarget).is(':checked')) {
            fieldEnddate.val(fieldStartdate.val());
            fieldEnddate.attr('disabled', 'disabled');
        }
        else {
            fieldEnddate.removeAttr('disabled');
        }
    }).trigger('change');
});


