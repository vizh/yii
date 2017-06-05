$(function () {
    $('form.form-horizontal input[name*="Company"]').autocomplete({
        source:function (request, response) {
            $.getJSON('/job/ajax/searchcompany', {term:request.term}, function (data) {
                response($.map(data, function (item) {
                    return {
                        label:item.Name,
                        value:item.Name
                    }
                }));
            });
        }
    });

    $('form.form-horizontal input[name*="Position"]').autocomplete({
        source:function (request, response) {
            $.getJSON('/job/ajax/searchposition', {term:request.term}, function (data) {
                response($.map(data, function (item) {
                    return {
                        label:item.Title,
                        value:item.Title
                    }
                }));
            });
        }
    });

    $('form.form-horizontal input[name*="JobUp"]').change(function (e) {
        var inputs = $(e.currentTarget).next('div');
        if ($(e.currentTarget).is(':checked')) {
            inputs.removeClass('hide');
        }
        else {
            inputs.addClass('hide');
        }
    }).trigger('change');

    $('.ui-autocomplete').addClass('dropdown-menu');
});