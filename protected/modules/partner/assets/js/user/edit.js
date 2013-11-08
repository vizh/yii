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
    
    var $modal = $('<div/>', {
      'class' : 'modal'
    }); 
    $('body').append($modal);
    $modal.html(
       ' <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h3>Укажите комментарий</h3></div>'
      +'<div class="modal-body"><textarea class="input-block-level"></textarea></div>'
      +'<div class="modal-footer"><button class="btn btn-primary">Сохранить</button></div>'
    );
    $modal.on('hidden', function () {
      $modal.remove();
    });
    $modal.find('.btn-primary').click(function () {
      var runetId = $('input[name="runetId"]').attr('value');
      target.after($('<span class="badge badge-warning">Сохранение...</span>'));
      $.post('/user/edit/?runetId='+runetId, {
        'do': 'changeParticipant',
        'roleId': target.val(),
        'partId': target.data('part-id'),
        'message' : $modal.find('textarea').val()
      }, function(data) {
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
      $modal.modal('hide');
    });
    $modal.modal('show');
  }
};