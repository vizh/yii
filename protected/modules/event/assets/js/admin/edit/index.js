$(function () {
  CKEDITOR.replace('event\\models\\forms\\admin\\EditForm[FullInfo]');
  $('input[name*="StartDate"], input[name*="EndDate"]').datepicker({});
});