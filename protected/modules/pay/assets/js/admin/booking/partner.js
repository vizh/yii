$(function () {
  $('form.bookings :checkbox').change(function () {
    var show = $('form.bookings input[type="checkbox"]:checked').size() > 0;
    if (show > 0) {
      $('form.bookings :submit').removeClass('hide');
    }
    else {
      $('form.bookings :submit').addClass('hide');
    }
  });
});
