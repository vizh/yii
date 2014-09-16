CWidgetPhoneControls = function (widget) {
  this.form  = $(widget);
  this.field = this.form.find('input[type="text"]');
  this.init();
};
CWidgetPhoneControls.prototype = {
  init : function () {
    this.field.initPhoneInputMask();
  }
};
$(function () {
  $('.widget-phone-controls').each(function (i, widget) {
    new CWidgetPhoneControls(widget);
  });
});