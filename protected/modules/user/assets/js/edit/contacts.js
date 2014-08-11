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
    'accountItemWithData' : _.template($('#account-item-withdata-tpl').html()),
    'primaryPhoneVerifyFormTpl' : _.template($('#primaryphone-verify-form-tpl').html())
  }

  this.primaryPhoneVerify = $('#primaryphone-verify');
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

    self.form.find('[name*="[PrimaryPhone]"]').initPhoneInputMask();
    if (self.primaryPhoneVerify.size() > 0) {
      self.primaryPhoneVerifyInit();
    }
  },
  
  initDeleteBtn : function (item) {
    item.find('[data-action="remove"]').click(function (e) {
      if (item.find('input[name*="Id"]').size() > 0) {
        item.find('input[name*="Delete"]').val(1);
        item.hide();
      } 
      else {
        item.remove();
      }
    });
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
    item.find('input[name*="OriginalPhone"]').initPhoneInputMask();
    self.iteterators.phone++;
  },
          
  createPhoneFillItem : function (data) {
    var self = this;
    data.i = self.iteterators.phone;
    var template = self.templates.phoneItemWithData(data);
    self.phoneItems.find('.form-row-add').before(template);
    var item = self.phoneItems.find('.form-row:not(.form-row-add):last');
    self.initDeleteBtn(item);
    if (typeof data.Errors != "undefined") {
      var errorUl = $('<ul>');
      $.each(data.Errors, function (field, error) {
        item.find('[name*='+field+']').addClass('error')
        errorUl.append('<li>'+error+'</li>');
      });
      item.find('.alert-error').append(errorUl);
    }
    item.find('input[name*="OriginalPhone"]').initPhoneInputMask();
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
    if (typeof data.Errors != "undefined") {
      var errorUl = $('<ul>');
      $.each(data.Errors, function (field, error) {
        item.find('[name*='+field+']').addClass('error')
        errorUl.append('<li>'+error+'</li>');
      });
      item.find('.alert-error').append(errorUl);
    }
    self.iteterators.account++;
  },

  'primaryPhoneVerifyInit' : function () {
    var self = this;
    var $error = self.primaryPhoneVerify.find('p.text-error');
    var $sendBtn = self.primaryPhoneVerify.find('.btn.send');
    $sendBtn.click(function (e) {
      $error.addClass('hide');
      $.getJSON('/user/ajax/phoneverify', {'action' : 'send'}, function (response) {
        if (typeof (response.error) != "undefined") {
          $error.text(response.error).removeClass('hide');
        } else {
          $sendBtn.before(self.templates.primaryPhoneVerifyFormTpl());
          $sendBtn.remove();

          var $verifyForm = self.primaryPhoneVerify.find('form');
          var $repeatBtn  = $verifyForm.find('a.send');
          $repeatBtn.hide(0).delay($repeatBtn.data('delay')).show(0);
          $repeatBtn.click(function(e) {
            $.getJSON('/user/ajax/phoneverify', {'action' : 'send'}, function (response) {
              if (typeof (response.error) != "undefined") {
                $error.text(response.error).removeClass('hide');
              }
            });
            $repeatBtn.hide(0).delay($repeatBtn.data('delay')).show(0);
            e.preventDefault();
          });

          var $verifyBtn  = $verifyForm.find('button.btn').click(function (e) {
            $verifyBtn.addClass('disabled');
            $.getJSON('/user/ajax/phoneverify', {'action' : 'verify', 'code' : $verifyForm.find('input[type="text"]').val()}, function (response) {
              if (typeof (response.error) != "undefined") {
                $error.text(response.error).removeClass('hide');
                $verifyBtn.removeClass('disabled');
              } else {
                self.primaryPhoneVerify.remove();
              }
            });
            e.preventDefault();
          });
        }
      });
      e.preventDefault();
    });

    function initSendBtn(btn) {
      btn.click(function (e) {
        $error.addClass('hide');
        $.getJSON('/user/ajax/phoneverify', {'action' : 'send'}, function (response) {
          if (typeof (response.error) != "undefined") {
            $error.text(response.error).removeClass('hide');
          } else {
            $sendBtn.before(self.templates.primaryPhoneVerifyFormTpl());
            $sendBtn.remove();
            var $verifyForm = self.primaryPhoneVerify.find('form');
            var $repeatBtn  = $verifyForm.find('a.send').hide(0);
            $repeatBtn.delay($repeatBtn.data('delay')).show(0);
            var $verifyBtn  = $verifyForm.find('button.btn').click(function (e) {
              $verifyBtn.addClass('disabled');
              $.getJSON('/user/ajax/phoneverify', {'action' : 'verify', 'code' : $verifyForm.find('input[type="text"]').val()}, function (response) {
                if (typeof (response.error) != "undefined") {
                  $error.text(response.error).removeClass('hide');
                  $verifyBtn.removeClass('disabled');
                } else {
                  self.primaryPhoneVerify.remove();
                }
              });
              e.preventDefault();
            });
          }
        });
        e.preventDefault();
      });
    }
  }
}
$(function () {
  var userEditContacts = new CUserEditContacts();
});


