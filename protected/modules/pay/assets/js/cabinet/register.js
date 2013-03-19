

var CPayRegister = function()
{
  this.itemsIterator = 0;
  this.form = $('#registration_form');
  this.eventIdName = this.form.data('event-id-name');
  this.templates = {
    row : _.template($('#row-tpl[type="text/template"]').html()),
    rowWithData : _.template($('#row-withdata-tpl[type="text/template"]').html()),
    rowDataFields : _.template($('#row-data-tpl[type="text/template"]').html()),
    rowRegister : _.template($('#row-register-tpl[type="text/template"]').html()),
    userAutocomlete : _.template($('#user-autocomlete-tpl[type="text/template"]').html())
  };
  this.init();
};
CPayRegister.prototype = {
  init: function () {
    var self = this;
    if (payItems !== undefined) {
      $.each(payItems, function (i, payItem) {
        self.createFillRow(payItem.productId, payItem.user, payItem.promoCode)
      });
    }
    this.calculate();
    
    self.form.find('table[data-product-id]').each(function () {
      for (var i = $(this).data('row-current'); i < $(this).data('row-max'); i++) {
        self.createEmptyRow($(this).data('product-id'));
      }
    });
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
  
  /**
   * 
   */
  initCouponField : function (row) {
    var self = this;
    row.find('.input-promo').change(function (e) {
      $.getJSON('/pay/ajax/couponactivate', {
        code : $(e.currentTarget).val(),
        ownerRunetId : row.find('input[name*="RunetId"]').val(),
        productId : row.parents('table[data-product-id]').data('product-id'),
        eventIdName : self.eventIdName
      }, function (response) {
        var alertContainer = row.find('.alert');
        alertContainer.attr('class', 'alert').html('');
        if (response.success) {
          alertContainer.addClass('alert-success').text(response.message);
        }
        else {
          alertContainer.addClass('alert-error').text(response.error);
        }
        setTimeout(function () {
          alertContainer.addClass('hide');
        }, 2000);
      });
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
    row.find('input.input-user').autocomplete({
      minLength: 2,
      position: {
        collision: 'flip'
      },
      source: '/user/ajax/search/',
      select: function(event, ui) {
        var rowDataFieldsTemplate = self.templates.rowDataFields({
          i : self.itemsIterator,
          productId : productId,
          runetId : ui.item.RunetId
        });
        row.find('.last-child').html(rowDataFieldsTemplate);
        $(this).attr('disabled', 'disabled').blur().after('<i class="icon-remove"></i>');
        self.calculate();
        self.initCouponField(row);
        self.initRemoveIcon(row);
        self.itemsIterator++;
      },
      response : function (event, ui) {
        $.each(ui.content, function (i) {
          ui.content[i].label = self.templates.userAutocomlete({
            item: ui.content[i]
          });
          ui.content[i].value = ui.content[i].FullName + ', RUNET-ID ' + ui.content[i].RunetId;
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
    self.itemsIterator++;
  },
          
  calculate : function () {
    var self     = this,
        sum      = 0,
        total    = 0,
        all      = 0,
        current  = 0;
        
    self.form.find('table[data-product-id]').each(function () {
      all = $(this).find('tbody .user-row').size();
      current = $(this).find('tbody input:disabled').size();
      if (all == current) {
        self.createEmptyRow($(this).data('product-id'));
        current++;
      } 
      $(this).data('row-current', current);
    });
  }
}

$(function () {
  payRegister = new CPayRegister();
});