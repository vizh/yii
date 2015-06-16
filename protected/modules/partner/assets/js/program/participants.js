$(function () {
  var ckeditorCount = 0;
  $('textarea[name*="Participant[ReportFullInfo]"]').each(function () {
    ckeditorCount++;
    var id = 'ckeditor'+ckeditorCount;
    $(this).attr('id', id);
    CKEDITOR.replace(id, {
      'height' :300,
      'customConfig' : 'config_partner_program.js'
    })
  });
});