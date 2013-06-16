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

  var radio = $('input[data-other="radio"]');
  if (radio.length != 0)
  {
    window.OtherValue = radio.attr('value');

    $('input[type="radio"]').bind('change', function(event){
      var target = $(event.currentTarget);

      var group = target.data('other-group');
      var input = $('input[data-other="input"][data-other-group="'+group+'"]');
      if (target.attr('value') == OtherValue)
      {
        input.prop('disabled', false);
      }
      else
      {
        input.prop('disabled', true);
      }
    });
  }
});