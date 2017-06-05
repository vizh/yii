var CAdminUserEdit = function () {
    this.form = $('form.form-horizontal');
    this.iterators = {
        phone:0,
        employment:0
    }
    this.phones = this.form.find('.control-group.phones');
    this.employments = this.form.find('.control-group.employments');
    this.templates = {
        'phoneItem':_.template($('#phone-item-tpl').html()),
        'phoneItemWithData':_.template($('#phone-item-withdata-tpl').html()),
        'employmentItem':_.template($('#career-item-tpl').html()),
        'employmentItemWithData':_.template($('#career-item-withdata-tpl').html())
    }
    this.init();
}
CAdminUserEdit.prototype = {
    init:function () {
        var self = this;
        if (typeof phones !== 'undefined') {
            $.each(phones, function (i, data) {
                self.createPhoneFillItem(data);
            });
        }
        self.phones.find('div.add a.pseudo-link').click(function () {
            self.createPhoneEmptyItem();
            return false;
        });

        if (typeof employments !== 'undefined') {
            $.each(employments, function (i, data) {
                self.creatEmploymentFillItem(data);
            });
        }

        self.employments.find('div.add a.pseudo-link').click(function () {
            self.createEmploymentEmptyItem();
            return false;
        });

        if (self.form.find('.alert-success').length == 1) {
            var image = new Image();
            image.src = $('input[name*="Edit[Photo]"]').prev('.help-block').find('img').attr('src');
        }

        self.form.find('input[name*="PrimaryPhone"]').initPhoneInputMask();

        var $passwordControlGroup = self.form.find('.control-group.password');
        $passwordControlGroup.find('a[data-password]').click(function (e) {
            var $target = $(e.currentTarget);
            $passwordControlGroup.find('input[type="text"]').val($target.data('password'));
            $target.remove();
            e.preventDefault();
        });
    },

    initPhoneDeleteBtn:function (item) {
        item.find('[data-action="remove"]').click(function (e) {
            if (item.find('input[name*="Id"]').size() > 0) {
                item.find('input[name*="Delete"]').val(1);
                item.hide();
            }
            else {
                item.remove();
            }
        });
        item.find('[data-action="remove"]').click(function (e) {
            item.find('input[name*="Delete"]').val(1);
            item.hide();
            return false;
        });
    },

    initEmploymentItem:function (item) {
        var self = this;

        item.find('input[name*="Company"]').autocomplete({
            source:function (request, response) {
                $.getJSON('/company/ajax/search', {term:request.term}, function (data) {
                    response($.map(data, function (item) {
                        return {
                            label:item.Name,
                            value:item.Name
                        }
                    }));
                });
            }
        });

        item.find('.form-row-remove').click(function () {
            if (item.find('input[name*="Id"]').size() == 1) {
                if (confirm("Вы точно желаете удалить место работы?")) {
                    item.find('input[name*="Delete"]').val(1);
                    item.hide();
                }
                else
                    return false;
            }
            else {
                item.remove();
            }
            self.iterators.employment--;
        });

        item.find('select[name*="EndMonth"], select[name*="EndYear"]').change(function (e) {
            if (item.find('select[name*="EndYear"]').val() !== "") {
                item.removeClass('primary');
                item.find('.form-row').css('opacity', '0.5');
                item.find('input[name*="Primary"]').removeAttr('checked').parent('label').hide();
            }
            else if (item.find('select[name*="EndMonth"]').val() == ''
                && item.find('select[name*="EndYear"]').val() == '') {
                item.find('.form-row').css('opacity', '1');
                item.find('input[name*="Primary"]').parent('label').show();
            }
        });

        item.find('.form-row-date input[type="checkbox"]').change(function (e) {
            if ($(e.currentTarget).is(':checked')) {
                item.find('select[name*="EndMonth"]').attr('disabled', 'disabled').val('').trigger('change');
                item.find('select[name*="EndYear"]').attr('disabled', 'disabled').val('').trigger('change');
            }
            else {
                item.find('select[name*="EndMonth"]').removeAttr('disabled');
                item.find('select[name*="EndYear"]').removeAttr('disabled');
            }
        }).trigger('change');

        item.find('input[name*="Primary"]').change(function (e) {
            self.form.find('.user-career-item.primary').removeClass('primary');
            item.addClass('primary');
            self.form.find('input[name*="Primary"]').not($(e.currentTarget)).removeAttr('checked');
        });
    },

    createPhoneEmptyItem:function () {
        var self = this;
        var template = self.templates.phoneItem({i:self.iterators.phone});
        self.phones.find('div.add').before(template);
        var item = self.phones.find('div:not(.add):last');
        self.initPhoneDeleteBtn(item);
        item.find('input[name*="OriginalPhone"]').initPhoneInputMask();
        self.iterators.phone++;
    },

    createPhoneFillItem:function (data) {
        var self = this;
        data.i = self.iterators.phone;
        var template = self.templates.phoneItemWithData(data);
        self.phones.find('div.add').before(template);
        var item = self.phones.find('div.phone:not(.add):last');
        self.initPhoneDeleteBtn(item);
        if (typeof data.Errors != "undefined") {
            var errorUl = $('<ul>');
            $.each(data.Errors, function (field, error) {
                item.find('[name*=' + field + ']').addClass('error')
                errorUl.append('<li>' + error + '</li>');
            });
            item.find('.alert-error').append(errorUl);
        }
        item.find('input[name*="OriginalPhone"]').initPhoneInputMask();
        self.iterators.phone++;
    },

    creatEmploymentFillItem:function (data) {
        var self = this;
        data.i = self.iterators.employment;
        var template = self.templates.employmentItemWithData(data);
        self.employments.find('div.add').before(template);
        var item = self.employments.find('div.well:last');
        self.initEmploymentItem(item);
        item.find('select').each(function () {
            $(this).val($(this).data('selected')).trigger('change');
        });
        if (typeof data.Errors != "undefined") {
            var errorUl = $('<ul>');
            $.each(data.Errors, function (field, error) {
                item.find('[name*=' + field + ']').addClass('error')
                errorUl.append('<li>' + error + '</li>');
            });
            item.find('.alert-error').append(errorUl);
        }
        self.iterators.employment++;
    },

    createEmploymentEmptyItem:function () {
        var self = this;
        var template = self.templates.employmentItem({i:self.iterators.employment});
        self.employments.find('div.add').before(template);
        var item = self.employments.find('div.well:last');
        self.initEmploymentItem(item);
        self.iterators.employment++;
    }
}
$(function () {
    new CAdminUserEdit();
});
