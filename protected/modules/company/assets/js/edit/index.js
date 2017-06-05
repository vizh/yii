var CCompanyEdit = function () {
    this.form = $('.company-edit form');
    this.iteterators = {
        phone:0,
        email:0
    }
    this.phoneItems = this.form.find('.phone-items');
    this.emailItems = this.form.find('.email-items');
    this.templates = {
        'phoneItem':_.template($('#phone-item-tpl').html()),
        'phoneItemWithData':_.template($('#phone-item-withdata-tpl').html()),
        'emailItem':_.template($('#email-item-tpl').html()),
        'emailItemWithData':_.template($('#email-item-withdata-tpl').html())
    }
    this.init();
}

CCompanyEdit.prototype = {
    init:function () {
        var self = this;

        CKEDITOR.replace('company\\models\\form\\Edit[FullInfo]');

        if (typeof phones !== 'undefined') {
            $.each(phones, function (i, data) {
                self.createPhoneFillItem(data);
            });
        }

        if (typeof emails !== 'undefined') {
            $.each(emails, function (i, data) {
                self.createEmailFillItem(data);
            });
        }

        self.phoneItems.find('.controls-add').click(function () {
            self.createPhoneEmptyItem();
            return false;
        });

        self.emailItems.find('.controls-add').click(function () {
            self.createEmailEmptyItem();
            return false;
        });
    },

    createPhoneEmptyItem:function () {
        var self = this;
        var template = self.templates.phoneItem({i:self.iteterators.phone});
        self.phoneItems.find('.controls-add').before(template);
        var item = self.phoneItems.find('.controls:last');
        item.find('input[name*="OriginalPhone"]').initPhoneInputMask();
        self.initDeleteBtn(item);
        self.iteterators.phone++;
    },

    createPhoneFillItem:function (data) {
        var self = this;
        data.i = self.iteterators.phone;
        var template = self.templates.phoneItemWithData(data);
        self.phoneItems.find('.controls-add').before(template);
        var item = self.phoneItems.find('.controls:last');
        item.find('input[name*="OriginalPhone"]').initPhoneInputMask();
        self.initDeleteBtn(item);
        if (typeof data.Errors != "undefined") {
            var errorUl = $('<ul>');
            $.each(data.Errors, function (field, error) {
                item.find('[name*=' + field + ']').addClass('error')
                errorUl.append('<li>' + error + '</li>');
            });
            item.find('.alert-error').append(errorUl);
        }
        self.iteterators.phone++;
    },

    createEmailEmptyItem:function () {
        var self = this;
        var template = self.templates.emailItem({i:self.iteterators.email});
        self.emailItems.find('.controls-add').before(template);
        var item = self.emailItems.find('.controls:last');
        self.initDeleteBtn(item);
        self.iteterators.email++;
    },

    createEmailFillItem:function (data) {
        var self = this;
        data.i = self.iteterators.email;
        var template = self.templates.emailItemWithData(data);
        self.emailItems.find('.controls-add').before(template);
        var item = self.emailItems.find('.controls:last');
        self.initDeleteBtn(item);
        if (typeof data.Errors != "undefined") {
            var errorUl = $('<ul>');
            $.each(data.Errors, function (field, error) {
                item.find('[name*=' + field + ']').addClass('error')
                errorUl.append('<li>' + error + '</li>');
            });
            item.find('.alert-error').append(errorUl);
        }
        self.iteterators.email++;
    },

    initDeleteBtn:function (item) {
        item.find('[data-action="remove"]').click(function (e) {
            if (item.find('input[name*="Id"]').size() > 0) {
                item.find('input[name*="Delete"]').val(1);
                item.hide();
            }
            else {
                item.remove();
            }
            return false;
        });
    }
}

$(function () {
    new CCompanyEdit();
});

