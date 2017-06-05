$(function () {
    $('#avatar-upload-button').click(function () {
        $("#avatar-upload-input")
            .change(function (e) {
                $(e.currentTarget).parents('form').trigger('submit');
            })
            .trigger('click')
        return false;
    });
});

