var userEditObj = null;
$(function(){
    userEditObj = new UserEdit();
});

var UserEdit = function()
{
    this.id = $('input[name="id"]').attr('value');
    this.editUrl = '/user/edit/?id=' + this.id;
    this.init();
    this.initUserDataTable();
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
            'class' : 'modal modal-blur'
        });
        $('body').append($modal);
        $modal.html(
            '<div class="modal-dialog modal-md">' +
            '<div class="modal-content">' +
            '<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4 class="modal-title">Укажите комментарий</h4></div>' +
            '<div class="modal-body"><textarea class="form-control"></textarea></div>' +
            '<div class="modal-footer"><button class="btn btn-primary">Сохранить</button></div>' +
            '</div>'+
            '</div>'
        )
        $modal.on('hidden', function () {
            $modal.remove();
        });
        $modal.find('.btn-primary').click(function () {
            var $controlGroup = target.parent('.form-group'),
                $helpBlock = $('<p/>', {'class' : 'help-block', 'text' : 'Сохранение...'});
            $controlGroup.addClass('has-warning dark');
            target.after($helpBlock);

            $.post(self.editUrl, {'do': 'changeParticipant', 'roleId': target.val(), 'partId': target.data('part-id'), 'message' : $modal.find('textarea').val()
            }, function(data) {
                $controlGroup.removeClass('has-warning');
                if (!data['error']) {
                    $controlGroup.addClass('has-success');
                    $helpBlock.text('Изменения сохранены!');
                }
                else{
                    $controlGroup.addClass('has-error');
                    $helpBlock.text('Ошибка при сохранении!');
                }
                setTimeout(function(){
                    $controlGroup.removeAttr('class').addClass('form-group');
                    $helpBlock.remove();
                }, 1000);
            }, 'json');
            $modal.modal('hide');
        });
        $modal.modal('show');
    },

    'initUserDataTable' : function () {
        var self = this;
        var $table = $('table.user-data');

        $table.find('tbody tr').each(function() {
            var $tr = $(this);

            var $edit = $tr.find('a.edit'),
                $save = $tr.find('a.save'),
                $delete = $tr.find('a.delete');

            $edit.click(function(e) {
                $tr.find('div.value').addClass('hide');
                $tr.find('div.input').removeClass('hide');
                $edit.parent('.btn-group').addClass('hide');
                $save.removeClass('hide');
                e.preventDefault();
            });

            $save.click(function(e) {
                e.preventDefault();
                var params = {'do' : 'editData', 'dataId' : $tr.data('id'), 'attributes' : {}};
                $tr.find('div.input').each(function() {
                    var $input = $(this).find('input,textarea,select');
                    params['attributes'][$input.data('name')] = $input.val();
                });

                $tr.find('p.text-error').remove();

                $.post(self.editUrl, params, function(response) {
                    if(typeof(response['errors']) == "undefined") {
                        $.each(response['values'], function (attr, value) {
                            $tr.find('div.value[data-name="' + attr + '"]').html(value);
                        });
                        $edit.parent('.btn-group').removeClass('hide');
                        $save.addClass('hide');
                        $tr.find('div.value').removeClass('hide');
                        $tr.find('div.input').addClass('hide');
                    } else {
                        $.each(response['errors'], function (attr, errors) {
                            $.each(errors, function(i, error) {
                                $tr.find('.input [data-name="' + attr +'"]').after('<p class="text-error">' + error + '</p>');
                            });
                        });
                    }
                }, 'json');
            });

            $delete.click(function () {
                if (confirm('Вы точно хотите удалить данные пользователя?')) {
                    $.post(self.editUrl, {'do' : 'deleteData', 'dataId' : $tr.data('id')});
                    $tr.remove();
                    if ($table.find('tbody tr').size() == 0) {
                        $table.remove();
                    }
                }
            });
        });
    }
};