var userEditObj = null;
$(function(){
  userEditObj = new UserEdit();
});


var UserEdit = function()
{
  this.init();
};

UserEdit.prototype = {
  init: function(){
    var self = this;

    $('select[name="roleId"]').bind('change', function(event){
      self.changeParticipant(event);
    });
  },

  changeParticipant: function(event){
    var self = this;
    var target = $(event.currentTarget);
    var roleId = target.val();
    var partId = target.data('part-id');
    var runetId = $('input[name="runetId"]').attr('value');

    target.after($('<span class="badge badge-warning">Сохранение...</span>'));
    $.post('/user/edit/?runetId='+runetId, {
      'roleId': roleId,
      'partId': partId,
      'do': 'changeParticipant'
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
};