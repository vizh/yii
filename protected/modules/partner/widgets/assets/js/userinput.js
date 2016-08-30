var UserAutoCompleteInput = function (element) {
    this.textField = $(element);
    this.hiddenField = this.textField.nextAll('input[type="hidden"]');
    this.addOn = this.textField.next('.input-group-addon');
    this.init();
}
UserAutoCompleteInput.prototype = {
    init: function () {
        var self = this;
        self.textField.autocomplete({
            source: self.textField.data("eventid") ? "/user/ajax/search/?eventId="+self.textField.data("eventid") : "/user/ajax/search/",
            minLength: 1,
            select: function(event, ui){
                self.textField.val(ui.item.FullName);
                self.addOn.html('RUNETID: '+ui.item.RunetId);
                self.hiddenField.val(ui.item.RunetId);
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
    $('input[data-userautocompleteinput="1"]').each(function(index, element){
        new UserAutoCompleteInput(element);
    });
});


