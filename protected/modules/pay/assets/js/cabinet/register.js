

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
              var row = $(e.currentTarget).parents('.user-row');
              row.find('td').empty();
              row.html(
                '<td colspan="4"><div class="alert alert-success">'+response.message+'</div></td>'
              );
              self.itemsIterator--;
              self.calculate();
              runAlertTimer = false;
            }
            else {
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
    self.initCouponField(row);
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
      sum = current*$(this).data('price');
      total += sum;
      $(this).find('thead th .quantity').text(current);
      $(this).find('thead th .mediate-price').text(sum);
      if (all == current) {
        self.createEmptyRow($(this).data('product-id'));
        current++;
      } 
      $(this).data('row-current', current);
    });
    self.form.find('#total-price').text(total);
  }
};

$(function () {
  var payRegister = new CPayRegister();

  $('input, textarea').placeholder();
});