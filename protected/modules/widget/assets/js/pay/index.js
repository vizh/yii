var CIndex = function () {
  this.$form = $('form.products');
  this.$products = this.$form.find('table.table-condensed tbody tr[data-price]');
  this.init();
}
CIndex.prototype = {
  'init' : function () {
    var self = this;
    self.$products.find('select').change(function () {
      self.calc();
    });
  },

  'calc' : function () {
    var self = this;
    var total = 0;
    $.each(self.$products, function () {
      var $tr = $(this);
      var sum = $tr.data('price') * $tr.find('select').val();
      $tr.find('b.mediate-price').text(sum);
      total += sum;
    });
    self.$form.find('#total-price').text(total);
  }
}

$(function () {
  $_ = new CIndex();
});
