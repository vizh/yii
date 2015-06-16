$(function(){
    $('input[name*="Generate[IsMultiple]"]').switcher({
        on_state_content : '<span class="fa fa-users"></span>',
        off_state_content: '<span class="fa fa-user"></span>',
        theme: 'square'
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
        format: 'dd.mm.yyyy',
        language: 'ru'
    });
});