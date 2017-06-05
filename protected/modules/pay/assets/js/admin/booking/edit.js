$(function () {
    $('.date-in, .date-out').datepicker({
        dateFormat:'yy-mm-dd',
        defaultDate:'2017-04-19',
        minDate:'2017-04-18',
        maxDate:'2017-04-21',
        hideIfNoPrevNext:true
    });

    $('.date-booked').datepicker({
        dateFormat:'yy-mm-dd',
        minDate:'2017-03-01',
        maxDate:'2017-04-30'
    });

    $('.booking-delete').on('click', function (e) {
        if (!confirm('Внимание! Указанная бронь будет удалена. Убедитесь, что нет счетов ожидающих оплаты.')) {
            e.preventDefault();
        }
    });

    $('.partnerName').autocomplete({
        source:partnerNames,
        delay:200
    });
});
