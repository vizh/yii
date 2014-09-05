

var CPayRegister = function()
{
  this.itemsIterator = 0;
  this.form = $('.register form');
  this.scenario = 'User';

  this.eventIdName = this.form.data('event-id-name');
  this.eventId = this.form.data('event-id');
  this.sandBoxUser = this.form.data('sandbox-user');
    this.templates = {
        row : _.template($('#row-tpl[type="text/template"]').html()),
        rowWithData : _.template($('#row-withdata-tpl[type="text/template"]').html()),
        rowDataFields : _.template($('#row-data-tpl[type="text/template"]').html()),
        rowRegister : _.template($('#row-register-tpl[type="text/template"]').html()),
        userAutocomlete : _.template($('#user-autocomlete-tpl[type="text/template"]').html()),
        discount: _.template($('#row-discount[type="text/template"]').html()),
        rowEditUserData: _.template($('#row-userdataedit-tpl[type="text/template"]').html())
    };
  this.init();
};
CPayRegister.prototype = {
  init: function () {
    var self = this;
    self.form.find('input[name*="Scenario"]').change(function (e) {
      self.initScenario($(e.currentTarget).val());
    }).filter(':checked').trigger('change');

    if (payItems !== undefined) {
      $.each(payItems, function (i, payItem) {
        var row = self.createFillRow(payItem.productId, payItem.user, payItem.promoCode);
        self.initDiscount(row, payItem.discount);
      });
    }
    this.calculate('User');
    this.calculate('Ticket');

    self.form.find('table[data-product-id]').each(function () {
      for (var i = $(this).data('row-current'); i < $(this).data('row-max'); i++) {
        self.createEmptyRow($(this).data('product-id'));
      }
    });

    self.form.find('div[data-scenario="Ticket"] select[name*="Count"]').change(function () {
      self.calculate();
    });

    self.form.submit(function () {
      if (self.form.find('.nav-buttons a.btn-large').hasClass('disabled')) {
        return false;
      }
    });
  },

  initScenario : function (scenario) {
    var self = this;
    self.scenario = scenario;
    this.form.find('div[data-scenario]').hide().find(':input').prop('disabled', true);
    this.form.find('div[data-scenario="'+self.scenario+'"]').show().find(':input').not('.no-disabled').prop('disabled', false);
    this.form.find('.nav-buttons a.btn-large').removeClass('disabled');
  },
  
  /**
   * 
   */
  initRegisterButton : function (row) {
    var self = this,
        table = row.parents('table[data-product-id]');

    row.find('button.btn-register').on('click', function (e) {
      var registerRowTemplate = self.templates.rowRegister();
      $(e.currentTarget).hide();
      row.after(registerRowTemplate);
      row.hide();
      
      var registerForm = row.next('tr').find('form');
      registerForm.find('input[name*="RegisterForm[Phone]"]').initPhoneInputMask();
      registerForm.find('.form-actions .btn-submit').click(function () {
        var alertContainer = registerForm.find('.alert-error');
        alertContainer.html('').hide();
        $.post('/user/ajax/register', registerForm.serialize(), function (response) {
          if (response.success) {
            registerForm.parents('tr').remove();
            self.createFillRow(table.data('product-id'), response.user);
            row.remove();
            self.calculate();
          }
          else {
            alertContainer.show().html('');
            $.each(response.errors, function (field, messsage) {
              alertContainer.append(messsage+'<br/>');
            });
          }
        }, 
        'json');
        return false;
      });
      
      registerForm.find('.form-actions .btn-cancel').click(function () {
        registerForm.parents('tr').remove();
        row.show();
      });
      return false;
    });
  },

  initDiscountRemote: function(row){
    var self = this;

    $.getJSON('/pay/ajax/couponinfo', {
      runetId : row.find('input[name*="RunetId"]').val(),
      productId : row.parents('table[data-product-id]').data('product-id'),
      eventIdName : self.eventIdName
    }, function(response){
      self.initDiscount(row, response.Discount);
      self.calculate();
    });
  },

  initDiscount: function(row, discount){
    var td = $('td.discount', row);
    td.data('discount', discount);

    if (discount == 0)
      return;
    var discountSum = Math.round(row.parents('table[data-product-id]').data('price') * discount);
    var rowDiscount = this.templates.discount({
      discount: discountSum
    });
    td.html(rowDiscount);
  },
  
  /**
   * 
   */
  initCouponField : function (row) {
    var self = this,
        promoInput  = row.find('.input-promo>input'),
        promoSubmit = row.find('.input-promo>.btn'),
        promoAlert  = row.find('.input-promo>.alert');

    promoInput.placeholder();
    
    promoInput.keyup(function(e) {
      if ($(e.currentTarget).val().length > 0) {
        promoSubmit.addClass('btn-success').removeClass('disabled');
      }
      else {
        promoSubmit.removeClass('btn-success').addClass('disabled');
      }
    });
    
    promoSubmit.click(function(e) {
      var row = $(e.currentTarget).parents('.user-row');

      if (!$(e.currentTarget).hasClass('disabled')) {
        $.getJSON('/pay/ajax/couponactivate', {
          code : promoInput.val(),
          ownerRunetId : row.find('input[name*="RunetId"]').val(),
          productId : row.parents('table[data-product-id]').data('product-id'),
          eventIdName : self.eventIdName
        }, function (response) {
          var runAlertTimer = true;
          promoAlert.attr('class', 'alert').html('');
          if (response.success) {
            if (response.coupon.Discount == 1) {
              row.find('td').empty();
              row.html(
                '<td colspan="4"><div class="alert alert-success">'+response.message+'</div></td>'
              );
              self.itemsIterator--;
              self.calculate();
              runAlertTimer = false;
            }
            else {
              self.initDiscount(row, response.coupon.Discount);
              self.calculate();
              promoAlert.addClass('alert-success').text(response.message);
              promoSubmit.addClass('disabled');
            }
          }
          else {
            promoAlert.addClass('alert-error').text(response.error);
          }
          
          if (runAlertTimer) {
            setTimeout(function () { promoAlert.addClass('hide'); }, 2000);
          }
        });
      }
    });
  },
  
  /**
   * 
   */
  initRemoveIcon : function (row) {
    var self = this;
    row.find('i.icon-remove').click(function () {
      row.empty().remove();
      self.itemsIterator--;
      self.calculate();
    });
  },
  
  /**
   *
   */
  createEmptyRow : function (productId) {
    var self = this,
        rowTemplate = this.templates.row();
 
    var table = self.form.find('table[data-product-id="'+ productId +'"] tbody');
    table.append(rowTemplate);
    var row = table.find('tr:last-child');
    var source = '/user/ajax/search/' + (self.sandBoxUser ? '?eventId=' + self.eventId : '');
    row.find('input.input-user').autocomplete({
      minLength: 2,
      position: {
        collision: 'flip'
      },
      source: source,
      select: function(event, ui) {
          row.find('button.btn-register').hide();
          self.processUserDataRow(row, productId, ui.item.RunetId);
      },
      response : function (event, ui) {
        $.each(ui.content, function (i) {
          ui.content[i].label = self.templates.userAutocomlete({
            item: ui.content[i]
          });
          var runetIdTitle = self.sandBoxUser ? 'ID ' : 'RUNET-ID ';
          ui.content[i].value = ui.content[i].FullName + ', '+ runetIdTitle + ui.content[i].RunetId;
        });
        row.find('button.btn-register').show();
      },
      html : true
    });
    self.initRegisterButton(row);
  },
  
  /**
   * 
   */
  createFillRow: function (productId, item, promoCode) {
    var self = this;
    var rowTemplate = this.templates.rowWithData({
      i : self.itemsIterator++,
      productId : productId,
      item : item,
      promoCode : promoCode
    });


   
    var table = self.form.find('table[data-product-id="'+ productId +'"] tbody');
    table.append(rowTemplate);
    var row = table.find('tr:last-child');
    self.initRemoveIcon(row);
    self.initCouponField(row);
    self.itemsIterator++;

    return row;
  },

    processUserDataRow: function(row, productId, runetId) {
        var self = this;
        var inputUser = row.find('.input-user');

        $.get('/pay/ajax/userdata', {
                runetId: runetId,
                eventIdName: self.eventIdName
            }, function (response) {
                if (response.showEditArea) {
                    var editUserDataTemplate = self.templates.rowEditUserData({
                        userInfo: inputUser.val(),
                        editArea: response.editArea
                    });
                    row.after(editUserDataTemplate);
                    row.hide();

                    var editForm = row.next('tr').find('form');
                    editForm.find('.form-actions .btn-submit').click(function () {
                        var alertContainer = editForm.find('.alert-error');
                        alertContainer.html('').hide();
                        $.post('/pay/ajax/edituserdata/?eventIdName='+self.eventIdName+'&runetId='+runetId,
                            editForm.serialize(),
                            function (response) {
                                if (response.success) {
                                    editForm.parents('tr').remove();
                                    self.processEmptyRow(row, productId, runetId);
                                    row.show();
                                }
                                else {
                                    alertContainer.show().html('');
                                    $.each(response.errors, function (field, messsage) {
                                        alertContainer.append(messsage+'<br/>');
                                    });
                                }
                            },
                            'json');
                        return false;
                    });

                    editForm.find('.form-actions .btn-cancel').click(function () {
                        editForm.parents('tr').remove();
                        inputUser.val('');
                        row.show();
                    });
                } else {
                    self.processEmptyRow(row, productId, runetId);
                }
            },
            'json');
    },

    processEmptyRow: function(row, productId, runetId) {
        var self = this;

        var rowDataFieldsTemplate = self.templates.rowDataFields({
            i : self.itemsIterator,
            productId: productId,
            runetId: runetId
        });
        row.find('.last-child').html(rowDataFieldsTemplate);
        row.find('.input-user').attr('disabled', 'disabled').addClass('no-disabled').blur().after('<i class="icon-remove"></i>');
        self.calculate();
        self.initCouponField(row);
        self.initRemoveIcon(row);
        self.initDiscountRemote(row);
        self.itemsIterator++;
    },
          
  calculate : function (scenario) {
    var self     = this,
        total    = 0;

    if (typeof(scenario) == "undefined")
      scenario = self.scenario;

    var form = self.form.find('div[data-scenario="'+scenario+'"]');

    switch (scenario) {
      case 'User':
        form.find('table[data-product-id]').each(function () {
          var price = $(this).data('price'),
            all = $(this).find('tbody .user-row').size(),
            rows = $(this).find('tbody input:disabled'),
            current = rows.size(),
            sum = 0;

          rows.each(function(){
            var discount = $(this).parents('tr.user-row').find('td.discount').data('discount');
              if (typeof(discount) == "undefined")
              discount = 0;
            sum += Math.round(price * (1 - discount));
          });
          total += sum;
          $(this).find('thead th .quantity').text(current);
          $(this).find('thead th .mediate-price').text(sum);
          if (all == current) {
            self.createEmptyRow($(this).data('product-id'));
            current++;
          }
          $(this).data('row-current', current);
        });
        break;

      case 'Ticket':
        form.find('tr[data-product-id]').each(function () {
          var sum = $(this).find('select[name*="Count"]').val() * $(this).data('price');
          $(this).find('.mediate-price').text(sum);
          total += sum;
        });
        break;
    }
    form.find('#total-price').text(total);
  }
};

$(function () {
  var payRegister = new CPayRegister();

  $('input, textarea').placeholder();
});