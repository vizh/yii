$(function () {
  var form = $('.event-create form');
  form.find('input[name*="OneDayDate"]').change(function (e) {
    var startDateInput = form.find('input[name*="StartDate"]'),
        endDateInput   = form.find('input[name*="EndDate"]');
        
    if ($(e.currentTarget).is(':checked')) {
      endDateInput.attr('readonly', 'readonly').val(startDateInput.val());
    }
    else {
      endDateInput.removeAttr('readonly').val('');
    }
  }).trigger('change');
});


