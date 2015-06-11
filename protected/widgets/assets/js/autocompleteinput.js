var AutoCompleteInput = function (element) {
  this.textField = $(element);
  this.hiddenField = this.textField.nextAll('input[type="hidden"]');
  this.addOn = this.textField.next('.input-group-addon');
  this.init();
}
AutoCompleteInput.prototype = {
  init: function () {
    var self = this;
    self.textField.autocomplete({
      source: self.textField.data('source'),
      minLength: 1,
      select: function(event, ui){
        self.addOn.html(self.textField.data('add-on') + ' '+ui.item.value);
        self.hiddenField.val(ui.item.value);
        $(this).val(ui.item.label);
        return false;
      }
    });
    $('.ui-autocomplete').addClass('dropdown-menu');

    self.textField.keyup(function (e) {
      if ($(e.currentTarget).val() == '') {
        self.addOn.html('&ndash;');
        self.hiddenField.val('');
      }
    });
  }
}


$(function () {
  $('input[data-autocompleteinput="1"]').each(function(index, element){
    new AutoCompleteInput(element);
  });
});