$(function(){
  $('.date-in, .date-out').datepicker({
    dateFormat: 'yy-mm-dd',
    defaultDate: '2014-04-22',
    minDate: '2015-04-01',
    maxDate: '2015-04-30',
    hideIfNoPrevNext: true
  });

  $('.date-booked').datepicker({
    dateFormat: 'yy-mm-dd',
    minDate: '2015-03-01',
    maxDate: '2015-04-30'
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
