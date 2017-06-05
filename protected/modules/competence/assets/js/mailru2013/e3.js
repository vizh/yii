$(function () {
    var selects = $('.interview select');
    selects.each(function (index, element) {
        var next = $(element).nextAll('input');
        if ($(element).attr('value') == 6) {
            next.show(0);
            next.prop('disabled', false);
        }
    });
    selects.bind('change', function (e) {
        var target = $(e.currentTarget);
        var next = target.nextAll('input');
        if (target.attr('value') == 6) {
            next.show(0);
            next.prop('disabled', false);
        }
        else {
            next.hide(0);
            next.prop('disabled', true);
        }
    });
});