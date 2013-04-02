var CUserEditContacts = function () {
  this.form = $('.user-account-settings form');
  this.iteterators = {
    phone   : 0,
    account : 0
  }
  this.phoneItems = this.form.find('.user-phone-items');
  this.templates = {
    'phoneItem' : _.template($('#phone-item-tpl').html()),
    'phoneItemWithData' : _.template($('#phone-item-withdata-tpl').html())
  }
  this.init();
}
CUserEditContacts.prototype = {
  init : function () {
    var self = this;
    if (typeof phones !== 'undefined') {
      $.each(phones, function (i, data) {
        self.createPhoneFillItem(data);
      });
    }
    
    self.phoneItems.find('.form-row-add').click(function () {
      self.createPhoneEmptyItem();
      return false;
    });
  },
  
  initPhoneItem : function (item) {
    item.find('[data-action="remove"]').click(function (e) {
      item.find('input[name*="Delete"]').val(1);
      item.hide();
      return false;
    });
  },
  
  createPhoneEmptyItem : function () {
    var self = this;
    var template = self.templates.phoneItem({i : self.iteterators.phone});
    self.phoneItems.find('.form-row-add').before(template);
    var item = self.phoneItems.find('.form-row:not(.form-row-add):last');
    self.initPhoneItem(item);
    self.iteterators.phone++;
  },
          
  createPhoneFillItem : function (data) {
    var self = this;
    data.i = self.iteterators.phone;
    var template = self.templates.phoneItemWithData(data);
    self.phoneItems.find('.form-row-add').before(template);
    var item = self.phoneItems.find('.form-row:not(.form-row-add):last');
    self.initPhoneItem(item);
    self.iteterators.phone++;
  }
}
$(function () {
  var userEditContacts = new CUserEditContacts();
});


