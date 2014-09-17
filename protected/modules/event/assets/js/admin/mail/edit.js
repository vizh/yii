var CEventMailEdit = function () {
  this.$form = $('form.form-horizontal');
  this.roles = [];
  if (typeof roles != "undefined") {
    this.roles = roles;
  }
  this.init();
};

CEventMailEdit.prototype = {
  'init' : function () {
    var self = this;
    self.$form.find('input#RoleSearch,input#RoleExceptSearch').autocomplete({
      source : self.roles,
      'select' : function (event, ui) {
        var field = $(this).data('field');
        self.createRoleLabel(ui.item.value, ui.item.label, field);
        this.value = '';
        return false;
      }
    });

    CKEDITOR.replace('event\\models\\forms\\admin\\mail\\Register_Body', {
      customConfig : 'config_mail_template.js',
      height : 500
    });
  },
  'createRoleLabel' : function (id, title, field) {
    var $label = $('<span/>', {
      'class' : 'label',
      'style' : 'margin: 5px 10px 0 0'
    });
    $label.html(title+' <a href="#">x</a><input type="hidden" value="'+id+'" name="event\\models\\forms\\admin\\mail\\Register['+field+'][]"></span>');
    $label.find('a').click(function (e) {
      e.preventDefault();
      $label.remove();
    });
    this.$form.find('.help-block.'+field.toLowerCase()).append($label);
  }
}

$(function () {
  EventMailEdit = new CEventMailEdit();
});
