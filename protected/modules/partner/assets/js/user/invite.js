$(function () {
    $('form#invite-generator').submit(function (e) {
        $.getJSON('?', $(e.currentTarget).serializeArray(), function (response) {
            if (response.success == true) {
                $(e.currentTarget).find('input[type="text"]').val(response.invite);
            }
        });
        return false;
    })
        .find('input[type="text"]').focus(function (e) {
        $(e.currentTarget).select();
    }).mouseup(function (e) {
        e.preventDefault();
    });
});