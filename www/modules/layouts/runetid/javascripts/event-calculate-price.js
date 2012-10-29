$(function() {
  
  var PriceItem = Backbone.Model.extend({
    defaults: {
      quantity: 0
    },

    getTotalPrice: function() {
      return this.get('price') * this.get('quantity');
    }
  });

  var PriceItems = Backbone.Collection.extend({
    model: PriceItem,

    getGrandTotal: function() {
      return this.reduce(function(memo, e) {
        return memo + e.getTotalPrice();
      }, 0);
    }
  });

  var PriceItemView = Backbone.View.extend({
    tagName: 'tr',
    events: {
      'change select' : 'updateQuantity'
    },

    initialize: function() {
      var bind = function (func, thisValue) {
         return function () {
                 return func.apply(thisValue, arguments);
              }
       };

      this.model.on('change:quantity', bind(this.render, this));
    },

    updateQuantity: function(e) {
      var 
        qty = parseInt($(e.target).find(':selected').val());

        this.model.set('quantity', qty);
    },

    render: function() {
      if (this.model.hasChanged('quantity')) {
        this.$el.find('.mediate-price').text(this.model.getTotalPrice().formatMoney());
      }
    }
  });
    
  var priceItems = (new PriceItems);

  $("form.registration").find('tr').each(function() {
    var price = $(this).attr('data-price');
    if (price) {
      var model = (new PriceItem);
      model.set('price', parseInt(price));

      priceItems.add([model]);

      var view = new PriceItemView({model: model});
      view.setElement(this);
    }
  });

  priceItems.on('change:quantity', function() {
    $('#total-price').text(priceItems.getGrandTotal().formatMoney());
  });

});