$(function() {
    //Q2
    $('input[type="radio"][data-group="Q2"]').change(function (event) {
        var target = $(event.currentTarget);
        var platforms = $('#Q2_platforms');
        if (target.val() == "q2_5") {
            platforms.css('display', 'block');
            platforms.find('input[type="radio"]').attr('disabled', null);
            platforms.find('input[type="radio"][data-group]:checked').trigger('change');
        } else {
            platforms.find('input').attr('disabled', 'disabled');
            platforms.css('display', 'none');
        }
    });


//    $('[data-target="#Q2_right_1"]').bind('change', function(event) {
//
//    });
});
