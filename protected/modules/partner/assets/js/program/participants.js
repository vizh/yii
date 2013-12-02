$(function () {
  var ckeditorCount = 0;
  $('textarea[name*="Participant[ReportFullInfo]"]').each(function () {
    ckeditorCount++;
    var id = 'ckeditor'+ckeditorCount;
    $(this).attr('id', id);
    CKEDITOR.replace(id, {
      'width'  : 700,
      'height' : 500,
      'customConfig' : 'config_partner_program.js'
    })
  });
});