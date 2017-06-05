$(function () {
    $('input[id*="_JoinTime"]').datepicker();
    $('input[id*="_AllowVote"]:checkbox').change(function () {
        $('input[id*="_AllowVote"]:checkbox').not(this).prop('checked', false);
    });

    CKEDITOR.replace('company\\models\\forms\\admin\\Company[Info]', {
        customConfig:'config_admin.js'
    });
});