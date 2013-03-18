$(function () {
  var container = $('.event-register');
  var eventIdName = container.data('event-idname');

  $('.icon-trash', container).css('opacity', '0.2');
  $('td', container).hover(
    function (e) {
      $(e.currentTarget).parent('tr').find('.icon-trash').css('opacity', '0.7');
    },
    function (e) {
      $(e.currentTarget).parent('tr').find('.icon-trash').css('opacity', '0.2');
    }
  );

  var payButtons = $('.actions a:not(:first):not(:last)', container);
  var offerCheckbox = $('input[name="agreeOffer"]', container);
  offerCheckbox.change(function (e) {
    if ($(e.currentTarget).prop('checked')) {
      payButtons.removeAttr('disabled');
      payButtons.addClass('btn-primary');
    }
    else {
      payButtons.attr('disabled','disabled');
      payButtons.removeClass('btn-primary');
    }
    $.cookie('offerCheckboxEnabled'+eventIdName, $(e.currentTarget).prop('checked'), {expires:7});
  });
  if ($.cookie('offerCheckboxEnabled'+eventIdName) == 'true') {
    offerCheckbox.attr('checked', 'checked');
  }
  offerCheckbox.trigger('change');

  payButtons.click(function () {
    return offerCheckbox.prop('checked');
  });
});