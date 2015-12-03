$(function () {
    $('input[id*="_JoinTime"]').datepicker();
    $('input[id*="_AllowVote"]:radio').change(function() {
        $('input[id*="_AllowVote"]:radio').not(this).prop('checked', false);
    });

    CKEDITOR.replace('company\\models\\forms\\admin\\Company[Info]', {
        customConfig : 'config_admin.js'
    });
});