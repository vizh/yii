$(function () {
    CKEDITOR.replace('event\\models\\forms\\admin\\Edit[FullInfo]', {
        customConfig:'config_admin.js'
    });
    $('input[name*="StartDate"], input[name*="EndDate"]').datepicker({});
});