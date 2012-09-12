$(function(){
  $('input#NameOrRocid').autocomplete({
    source: "/user/ajaxget/",
    minLength: 2,
    select: function(event, ui){
      $('input#RocId').val(ui.item.id);
      $('#span_rocid').html(ui.item.id).show();
      $('input#NameOrRocid').attr('value', ui.item.label);

      return false;
    }
  });

  $('#user-edit-tabs #event select').bind('change',
    function(e)
    {
      var target = $(e.currentTarget);
      var roleId = target.attr('value');
      var dayId = target.attr('data-day-id');
      var rocId = $('input[name="rocId"]').attr('value');

      target.after($('<span class="badge badge-warning">Сохранение...</span>'))
      $.post('/user/edit/event', {
        'roleId': roleId,
        'dayId': dayId,
        'rocId': rocId
      }, function(data){
        var next = target.next();
        next.removeClass('badge-warning');
        if (!data['error'])
        {
          next.addClass('badge-success');
          next.html('Изменения сохранены.');
        }
        else{
          next.addClass('badge-important');
          next.html('Ошибка при сохранении!');
        }
        setTimeout(function(){next.remove();}, 1000);
      }, 'json');
    }
  );
});
