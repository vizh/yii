var CUserEditContacts = function () {
  this.form = $('.user-account-settings form');
  this.iteterators = {
    phone   : 0,
    account : 0
  }
  this.phoneItems = this.form.find('.user-phone-items');
  this.accountItems = this.form.find('.user-account-items');
  this.templates = {
    'phoneItem' : _.template($('#phone-item-tpl').html()),
    'phoneItemWithData' : _.template($('#phone-item-withdata-tpl').html()),
    'accountItem' : _.template($('#account-item-tpl').html()),
    'accountItemWithData' : _.template($('#account-item-withdata-tpl').html())
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
    
    if (typeof accounts !== 'undefined') {
      $.each(accounts, function (i, data) {
        self.createAccountFillItem(data);
      });
    }
    self.accountItems.find('.form-row-add').click(function () {
      self.createAccountEmptyItem();
      return false;
    });
  },
  
  initDeleteBtn : function (item) {
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
    self.initDeleteBtn(item);
    self.iteterators.phone++;
  },
          
  createPhoneFillItem : function (data) {
    var self = this;
    data.i = self.iteterators.phone;
    var template = self.templates.phoneItemWithData(data);
    self.phoneItems.find('.form-row-add').before(template);
    var item = self.phoneItems.find('.form-row:not(.form-row-add):last');
    self.initDeleteBtn(item);
    self.iteterators.phone++;
  },
          
  createAccountEmptyItem : function () {
    var self = this;
    var template = self.templates.accountItem({i : self.iteterators.account});
    self.accountItems.find('.form-row-add').before(template);
    var item = self.accountItems.find('.form-row:not(.form-row-add):last');
    self.initDeleteBtn(item);
    self.iteterators.account++;
  },
          
  createAccountFillItem : function (data) {
    var self = this;
    data.i = self.iteterators.account;
    var template = self.templates.accountItemWithData(data);
    self.accountItems.find('.form-row-add').before(template);
    var item = self.accountItems.find('.form-row:not(.form-row-add):last');
    self.initDeleteBtn(item);
    self.iteterators.account++;
  },
}
$(function () {
  var userEditContacts = new CUserEditContacts();
});


