$(function () {
    $('[data-toggle="popover"]').not('.disabled')
        .popover({'html':true})
        .on('click', function (e) {
            $('[data-toggle="popover"]').not($(e.currentTarget)).popover('hide');
        });
});