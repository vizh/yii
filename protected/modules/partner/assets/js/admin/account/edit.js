var CApiAccountEdit = function () {
    this.form = $('form.form-horizontal');
    this.init();
};
CApiAccountEdit.prototype = {
    init:function () {
        var self = this;
        self.form.find('input[id*="Account_EventTitle"]').autocomplete({
            'source':'/event/ajax/search',
            'select':function (event, ui) {
                self.form.find('input[id*="Account_EventId"]').val(ui.item.value);
                $(this).val(ui.item.label);
                return false;
            },
            response:function (event, ui) {
                for (var i = 0; i < ui.content.length; i++) {
                    ui.content[i].label = ui.content[i].Id + ', ' + ui.content[i].IdName + ', ' + ui.content[i].Title;
                }
            }
        });

        $('#generatePassword').on('click', function (e) {
            if (!confirm('Внимание! После генерации проля старые доступы будут не валидны.')) {
                e.preventDefault();
            }
        });
    }
};

$(function () {
    new CApiAccountEdit();
});