var CApiAccountEdit = function () {
    this.form = $('form.form-horizontal');
    this.init();
}
CApiAccountEdit.prototype = {
    init:function () {
        var self = this;
        self.form.find('input[id*="Account_EventTitle"]').autocomplete({
            'source':'/event/ajax/search',
            'select':function (event, ui) {
                self.form.find('input[id*="Account_EventId"]').val(ui.item.value);
                $(this).val(ui.item.label);
                return false;
            }
        });

        if (typeof domains !== 'undefined') {
            $.each(domains, function (i, value) {
                self.createDomainInput(value);
            });
        }

        if (typeof ips !== 'undefined') {
            $.each(ips, function (i, value) {
                self.createIpInput(value);
            });
        }

        self.form.find('.domains .btn-mini').click(function () {
            self.createDomainInput('');
        });
        self.form.find('.ips .btn-mini').click(function () {
            self.createIpInput('');
        });
    },

    createDomainInput:function (value) {
        var self = this;
        var template = _.template($('#domain-input-tpl').html());
        self.form.find('.domains>.controls>.btn.btn-mini').before(
            template({'value':value})
        );
        var input = self.form.find('.domains>.controls>.input-append:last');
        input.find('.btn.btn-danger').click(function () {
            input.remove();
        });
    },

    createIpInput:function (value) {
        var self = this;
        var template = _.template($('#ip-input-tpl').html());
        self.form.find('.ips>.controls>.btn.btn-mini').before(
            template({'value':value})
        );
        var input = self.form.find('.ips>.controls>.input-append:last');
        input.find('.btn.btn-danger').click(function () {
            input.remove();
        });
    }
}

$(function () {
    new CApiAccountEdit();
});