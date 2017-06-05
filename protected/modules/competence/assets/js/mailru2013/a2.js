$(function () {
    /*$('.interview-list li').draggable({ revert: "invalid" });

     var photoList = $('.interview-photo li');

     photoList.droppable({
     drop: function(event, ui){
     var element = $(ui.draggable);
     var newElement = $('<span class="name"></span>');
     newElement.data('key', element.data('key'));
     newElement.html(element.html());

     var target = $(this);
     target.addClass('know');
     target.append(newElement);
     element.remove();

     var input = $('input', target);
     input.attr('value', newElement.data('key'));
     input.prop('disabled', false);

     target.droppable("disable");

     target.tooltip({
     title: 'Нажмите на блок с изображением, чтобы отменить выбор',
     placement: 'bottom'
     });

     }
     });

     photoList.bind('click', function(e){
     var target = $(e.currentTarget);
     var element = $('span.name', target);

     var newElement = $('<li></li>');
     newElement.data('key', element.data('key'));
     newElement.html(element.html());
     $('.interview-list').append(newElement);
     newElement.draggable({ revert: "invalid" });

     var input = $('input', target);
     input.attr('value', '');
     input.prop('disabled', true);

     target.removeClass('know');
     target.tooltip('destroy');
     target.droppable('enable');

     element.remove();
     });*/

    var checkboxes = $('input[type="checkbox"]');
    checkboxes.bind('change', function (event) {
        var target = $(event.currentTarget);
        var input = target.parent().prev();
        if (target.prop('checked')) {
            input.prop('disabled', true);
        }
        else {
            input.prop('disabled', false);
        }
    });

    checkboxes.each(function (index, element) {
        var element = $(element);
        var input = element.parent().prev();
        if (element.prop('checked')) {
            input.prop('disabled', true);
        }
        else {
            input.prop('disabled', false);
        }
    });
});
