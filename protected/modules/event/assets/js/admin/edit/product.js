CEventEditProduct =  function () {
  this.table = $('.well table.table');
  this.forms = this.table.find('tr.form form');
  this.init();
};

CEventEditProduct.prototype = {
  init : function () {
    var self = this;
    $(this.forms).each(function () {
      var form = $(this);      
      var priceI = form.data('price-iterator');
    
      $.each(form.data('prices'), function (i, price) {
        self.createPriceControlGroup(form, price);
      });
      
      form.find('a.new-price').click(function () {
        var data = {'Id' : '', 'Price' : '', 'Title' : '', 'StartDate' : '', 'EndDate' : '', 'ProductId' : $(form).find('input[id*="Product_Id"]').val()};
        self.createPriceControlGroup(form, data)
        return false;
      });

      $.each(form.data('additional-attributes'), function (i, attribute) {
        self.createAdditionalAttributeControlGroup(form, attribute);
      });

      form.find('a.new-additional-attribute').click(function () {
        var data = {'Name' : '', 'Label' : '', 'Type' : '', 'Order' : 0};
        self.createAdditionalAttributeControlGroup(form, data);
        return false;
      });
    });
    
    self.table.find('td>a.btn-mini[href="#"]').click(function (e) {
      self.table.find('tr.form').hide();
      $(e.currentTarget).parents('tr').next('tr.form').show();
      return false;
    });
    
    self.table.find('.errorSummary').parents('tr.form').show();
  },
  
  createPriceControlGroup : function (form, data) {
    var iterator = form.data('price-iterator'); 
    data.i = iterator;
    var cg = $('<div/>', {
      'class' : 'control-group',
      'html'  : _.template($('#tpl__price-control-group').html(), data)
    });
    
    cg.find('.btn.btn-danger').click(function (e) {
      cg.find('input[name*="Delete"]').val(1);
      cg.hide();
      return false;
    });
    
    cg.find('input[name*="StartDate"],input[name*="EndDate"]').datepicker();
    
    iterator++;
    form.data('price-iterator', iterator);
    form.find('.prices').append(cg);
  },

  createAdditionalAttributeControlGroup : function (form, data) {
    var iterator = form.data('additional-attribute-iterator');
    data.i = iterator;
    var cg = $('<div/>', {
      'class' : 'control-group',
      'html'  : _.template($('#tpl__additional-attribute-control-group').html(), data)
    });

    cg.find('.btn.btn-danger').click(function (e) {
      cg.remove();
      return false;
    });

    iterator++;
    form.data('additional-attribute-iterator', iterator);
    form.find('.additional-attributes').append(cg);
  }
};

$(function () {
  new CEventEditProduct();
});

