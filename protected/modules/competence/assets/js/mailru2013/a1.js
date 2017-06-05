$(function () {
    var items = $('.interview li');

    items.each(function (index, element) {
        element = $(element);
        var css = element.data('key') != 49 ? 'know' : 'unknow';
        var input = $('input', element);
        if (input.attr('value') == 1) {
            element.addClass(css);
            input.prop('disabled', false);
        }
    });

    items.bind('click', function (e) {
        var target = $(e.currentTarget);
        var css = target.data('key') != 49 ? 'know' : 'unknow';
        var input;

        if (target.data('key') == 49) {
            items.each(function (index, element) {
                element = $(element);
                element.removeClass('know')
                var input = $('input', element);
                input.removeAttr('value');
                input.prop('disabled', true);
            });
        }
        else {
            var last = items.last();
            last.removeClass('unknow')
            input = $('input', last);
            input.removeAttr('value');
            input.prop('disabled', true);
        }

        input = $('input', target);
        if (!target.hasClass(css)) {
            target.addClass(css);
            input.attr('value', 1);
            input.prop('disabled', false);
        }
        else {
            target.removeClass(css);
            input.removeAttr('value');
            input.prop('disabled', true);
        }
    });
});
