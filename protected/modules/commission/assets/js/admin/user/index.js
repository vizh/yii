var CCommissionUserList = function () {
  this.iterator = 0;
  this.templates = {
    'item' : _.template($('#commission-user-tpl').html()),
    'itemWithData' : _.template($('#commission-user-withdata-tpl').html())
  }
  this.form = $('form.form-horizontal');
  this.items = this.form.find('.commission-user-items tbody');
  this.init();
}

CCommissionUserList.prototype = {
  init : function () {
    var self = this;
    if (typeof commissionUsers !== 'undefined') {
      $.each(commissionUsers, function (i, data) {
        self.createFillItem(data);
      });
    }
    self.form.find('input[name*="RunetId"]').autocomplete({
      source : '/user/ajax/search',
      select : function( event, ui ) {
        $(this).val(ui.item.RunetId);
        $(this).nextAll('.help-inline').html(ui.item.FullName);
      }
    });
    self.form.find('input[name*="JoinDate"], input[name*="ExitDate"]').datepicker();
  },
          
  createFillItem : function (data) {
    var self = this;
    data.i = self.iterator;
    var template = self.templates.itemWithData(data);
    self.items.append(template);
  }
};

$(function () {
  new CCommissionUserList();
});