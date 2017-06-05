$(function () {
    $('input[name*="[BackgroundColor]"], input[name*="[TextColor]"], input[name*="[TitleColor]"]').colpick({
        'layout':'hex',
        'submit':false,
        'onChange':function (hsb, hex, rgb, element) {
            $(element).val(hex);
            $(element).css('background-color', '#' + hex);
        }
    });
});