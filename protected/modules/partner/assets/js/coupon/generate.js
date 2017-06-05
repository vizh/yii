$(function () {
    $('input[name*="Generate[IsMultiple]"]').switcher({
        on_state_content:'<span class="fa fa-users"></span>',
        off_state_content:'<span class="fa fa-user"></span>',
        theme:'square'
    }).change(function (e) {
        var $target = $(e.currentTarget);
        if ($target.is(':checked')) {
            $('[data-for-multiple="true"]').removeClass('hide');
            $('[data-for-multiple="false"]').addClass('hide');
        } else {
            $('[data-for-multiple="true"]').addClass('hide');
            $('[data-for-multiple="false"]').removeClass('hide');
        }
    }).trigger('change');

    $('input[name*="Generate[EndTime]"]').datepicker({
        format:'dd.mm.yyyy',
        language:'ru'
    });

    var products = {
        all:$('input[name*="Generate[ProductsAll]"]'),
        list:$('input[name*="Generate[Products]"]')
    }

    products.all.change(function (e) {
        var $target = $(e.currentTarget);
        products.list.removeAttr('checked');
    });

    products.list.change(function (e) {
        var $target = $(e.currentTarget);
        if (!$target.is(':checked')) {
            products.all.removeAttr('checked');
        }

        var size = products.list.filter(':checked').size();

        if (size == products.list.size() || size == 0) {
            products.all.prop('checked', true);
        } else {
            products.all.removeAttr('checked');
        }
    });
});