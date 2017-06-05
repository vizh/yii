$(function () {
    $('#order_submit').on('click', function (event) {
        event.preventDefault();
        $(event.currentTarget).parents('form').submit();
    });
});