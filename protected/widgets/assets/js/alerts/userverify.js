$(function () {
    var $widget = $('#application_widgets_alerts_UserVerify');
    $widget.find('a').click(function (e) {
        $.post('/user/ajax/verify');
        var success = $widget.find('.hide').html();
        $widget.find('.container').html(success);
        e.preventDefault();
    });
});