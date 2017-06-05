$(function () {
    $('.btn-toolbar').find('select[name*="Sort"], select[name*="PerPage"]').change(function (e) {
        var form = $(e.currentTarget).parents('form');
        form.trigger('submit');
    });
});