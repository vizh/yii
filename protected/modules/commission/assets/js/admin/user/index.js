var CCommissionUserList = function () {
    this.iterator = 0;
    this.templates = {
        'row':_.template($('#commission-user-tpl').html()),
        'rowWithData':_.template($('#commission-user-withdata-tpl').html())
    }
    this.form = $('form.form-horizontal');
    this.rows = this.form.find('table tbody');
    this.init();
}

CCommissionUserList.prototype = {
    init:function () {
        var self = this;
        if (typeof commissionUsers !== 'undefined') {
            $.each(commissionUsers, function (i, data) {
                self.createFillRow(data);
            });
        }

        self.form.find('input[type="button"]').click(function () {
            self.createEmptyRow()
        });
    },

    createFillRow:function (data) {
        var self = this;
        data.i = self.iterator;
        var template = self.templates.rowWithData(data);
        self.rows.append(template);
        var row = self.rows.find(':last-child');
        self.initDateField(row);
        self.initRunetIdField(row);
        self.iterator++;
    },

    createEmptyRow:function () {
        var self = this;
        var data = {
            i:self.iterator
        }
        var template = self.templates.row(data);
        self.rows.prepend(template);
        var row = self.rows.find(':first-child');
        self.initDateField(row);
        self.initRunetIdField(row);
        self.iterator++;
    },

    initRunetIdField:function (row) {
        row.find('input[name*="RunetId"]').autocomplete({
            source:'/user/ajax/search',
            select:function (event, ui) {
                $(this).val(ui.item.RunetId);
                $(this).nextAll('.help-inline').html(ui.item.FullName);
            }
        });
    },

    initDateField:function (row) {
        row.find('input[name*="JoinDate"], input[name*="ExitDate"]').datepicker();
    }
};

$(function () {
    new CCommissionUserList();
});