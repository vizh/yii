var AutoCompleteInput = function (element) {
  this.textField = $(element);
  this.hiddenField = this.textField.nextAll('input[type="hidden"]');
  this.addOn = this.textField.next('.add-on');
  this.init();
}
AutoCompleteInput.prototype = {
  init: function () {
    var self = this;
    self.textField.autocomplete({
      source: "/user/ajax/search/",
      minLength: 1,
      select: function(event, ui){
        self.addOn.html('RUNETID: '+ui.item.RunetId);
        self.hiddenField.val(ui.item.RunetId);
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
  $('input[data-userautocompleteinput="1"]').each(function(index, element){
    new AutoCompleteInput(element);
  });
});


