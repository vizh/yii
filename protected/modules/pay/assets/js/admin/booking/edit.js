$(function(){
  $('.date-in, .date-out').datepicker({
    dateFormat: 'yy-mm-dd',
    defaultDate: '2016-04-13',
    minDate: '2016-04-01',
    maxDate: '2016-04-30',
    hideIfNoPrevNext: true
  });

  $('.date-booked').datepicker({
    dateFormat: 'yy-mm-dd',
    minDate: '2016-03-01',
    maxDate: '2016-04-30'
  });

  $('.booking-delete').on('click', function(e){
    if (!confirm('Внимание! Указанная бронь будет удалена. Убедитесь, что нет счетов ожидающих оплаты.'))
    {
      e.preventDefault();
    }
  });


  $('.partnerName').autocomplete({
    source: partnerNames,
    delay: 200
  });
});
