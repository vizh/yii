$(function () {
    var ckeditorCount = 0;
    $('textarea[name*="Participant[ReportFullInfo]"], textarea[name*="Participant[ReportThesis]"]').each(function () {
        ckeditorCount++;
        var id = 'ckeditor' + ckeditorCount;
        $(this).attr('id', id);
        CKEDITOR.replace(id, {
            height:200,
            customConfig:'config_partner_program.js'
        })
    });
});
