$(function () {
  var $table = $('form table.table');
  var $bookingCheckbox = $table.find('input[name*="BookingIdList"]');
  $bookingCheckbox.change(function () {
    var total = 0;
    $bookingCheckbox.filter(':checked').each(function () {
      total += $(this).data('price');
    });
    $table.find('thead th.total').html(total+'руб.');
  });
  $bookingCheckbox.trigger('change');
});
