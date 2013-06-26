$(function () {
  CKEDITOR.replace('event\\models\\forms\\admin\\Edit[FullInfo]');
  $('input[name*="StartDate"], input[name*="EndDate"]').datepicker({});
});