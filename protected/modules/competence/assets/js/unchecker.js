$(function(){
  $('input[data-unchecker="1"]').bind('change', function(event){
    var target = $(event.currentTarget);
    var negative = target.data('unchecker-negative');
    var group = target.data('unchecker-group');

    if (negative == 1)
    {
      $('input[data-unchecker-group="'+group+'"][data-unchecker-negative="0"]').prop('checked', false);
    }
    else
    {
      $('input[data-unchecker-group="'+group+'"][data-unchecker-negative="1"]').prop('checked', false);
    }
  });

  $('input[data-other="checkbox"]').bind('change', function(event){
    var target = $(event.currentTarget);
    var group = target.data('other-group');

    var input = $('input[data-other="input"][data-other-group="'+group+'"]');
    if (target.prop('checked'))
    {
      input.prop('disabled', false);
    }
    else
    {
      input.prop('disabled', true);
    }
  });


  $('input[type="radio"][data-group]').change(function (e) {
    var target = $(e.currentTarget);
    var group = target.data('group');
    $('input[type="text"][data-group="'+group+'"]').attr('disabled', 'disabled');
    if (typeof target.data('target') != "undefined") {
      $(target.data('target')).removeAttr('disabled');
    }
  });

  $('input[type="text"][data-group]').attr('disabled', 'disabled');
  $('input[type="radio"][data-group]:checked').trigger('change');
});