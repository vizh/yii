$(function () {
  $('#widget-link .participants .participant .suggest').click(function (e) {
    e.preventDefault();
    var $target = $(e.currentTarget);
    $.getJSON($target.attr('href'), function (response) {
      if (typeof response.error != "undefined") {
        var $modal = $('<div/>', {
          'class' : 'modal',
          'html'  : '<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h3 class="text-error">Ошибка!</h3></div><div class="modal-body"><p>'+response.error+'</p></div></div>'
        });

        $modal.modal('show');
        $modal.on('hidden', function () {
          $modal.remove();
        })
      }
      else if(response.success) {
        $target.next('a.btn').removeClass('hide');
        $target.remove();
      }
    });
  });
});
