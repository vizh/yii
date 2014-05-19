$(function () {
  var $preloader = $('#preloader'),
      datepickerMinDate = new Date($('meta[name="EventStartDate"]').attr('content')),
      datepickerMaxDate = new Date($('meta[name="EventEndDate"]').attr('content'));

  $('#widget-link .cabinet .link-row').each(function () {
    var $dtform = $(this).find('form'),
        $buttons = $(this).find('.btn-group');

    $dtform.find('input[name*="[Date]"]').datepicker({
      'minDate' : datepickerMinDate,
      'maxDate' : datepickerMaxDate
    });
    $buttons.find('.settime').click(function(e) {
      e.preventDefault();
      $buttons.remove();

      $dtform.show().submit(function (e) {
        $preloader.show();
        $dtform.find('input[type="text"]').removeClass('error');
        $.getJSON($dtform.data('url'), $dtform.serializeArray(), function (response) {
          if (typeof response.error != "undefined") {
            $.each(response.error, function (i, error) {
              $dtform.find('input[name*="'+i+'"]').addClass('error');
            });
            $preloader.hide();
          }
          else if (response.success) {
            document.location.reload();
          }
        });
        return false;
      });
    });

    $buttons.find('.reject').click(function (e) {
      e.preventDefault();
      $preloader.show();
      var $target = $(e.currentTarget);
      $target.addClass('disabled');
      $.getJSON($target.data('url'), function () {
        document.location.reload();
      });
    });
  });
});