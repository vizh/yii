var CUserEditEducation = function () {
    this.form = $('.user-account-settings form');
    this.iterator = 0;
    this.items = this.form.find('.user-career-items');
    this.templates = {
        'item':_.template($('#education-item-tpl').html()),
        'itemWithData':_.template($('#education-item-withdata-tpl').html())
    }
    this.init();
}
CUserEditEducation.prototype = {
    init:function () {
        var self = this;
        if (typeof educations !== 'undefined') {
            $.each(educations, function (i, data) {
                self.createFillItem(data);
            });
        }

        self.form.find('.form-row-add a').click(function () {
            self.createEmptyItem();
            return false;
        });
    },

    initItem:function (item) {
        var self = this;

        var CityIdHidden = item.find('input[name*="CityId"]');
        var CityNameInput = item.find('input[name*="CityName"]');

        var UniversityIdHidden = item.find('input[name*="UniversityId"]');
        var UniversityNameInput = item.find('input[name*="UniversityName"]');

        var FacultyIdHidden = item.find('input[name*="FacultyId"]');
        var FacultyNameInput = item.find('input[name*="FacultyName"]');

        var SpecialtyInput = item.find('input[name*="Specialty"]');

        CityNameInput.autocomplete({
            minLength:0,
            source:function (request, response) {
                if (request.term == '') {
                    response(CityNameInput.data('default-source'));
                } else {
                    $.getJSON('/geo/ajax/search', {term:request.term}, function (data) {
                        response(data);
                    });
                }
            },
            select:function (event, ui) {
                CityIdHidden.val(ui.item.CityId);
                self.resetPartOfItem(item, ['UniversityName', 'UniversityId', 'FacultyName', 'FacultyId', 'Specialty']);
                UniversityNameInput.focus();
                UniversityNameInput.autocomplete("search", "");
            },
            search:function (event, ui) {
                UniversityNameInput.removeAttr('disabled');
            }
        }).focus(function () {
            CityNameInput.autocomplete('search', $(this).val());
        });

        UniversityNameInput.autocomplete({
            minLength:0,
            source:function (request, response) {
                $.getJSON('/education/ajax/universities', {term:request.term, cityId:CityIdHidden.val()}, function (data) {
                    response($.map(data, function (item) {
                        return {
                            label:item.label,
                            value:item.Name,
                            id:item.UniversityId
                        }
                    }));
                });
            },
            select:function (event, ui) {
                UniversityIdHidden.val(ui.item.id);
                self.resetPartOfItem(item, ['FacultyName', 'FacultyId', 'Specialty']);
                FacultyNameInput.focus();
                FacultyNameInput.autocomplete("search", "");
            },
            search:function (event, ui) {
                FacultyNameInput.removeAttr('disabled');
            }
        });

        FacultyNameInput.autocomplete({
            minLength:0,
            source:function (request, response) {
                $.getJSON('/education/ajax/faculties', {term:request.term, universityId:UniversityIdHidden.val()}, function (data) {
                    response($.map(data, function (item) {
                        return {
                            label:item.label,
                            value:item.Name,
                            id:item.FacultyId
                        }
                    }));
                });
            },
            select:function (event, ui) {
                FacultyIdHidden.val(ui.item.id);
            },
            search:function (event, ui) {
                SpecialtyInput.removeAttr('disabled');
            }
        });

        item.find('.form-row-remove a').click(function (e) {
            e.preventDefault();
            if (item.find('input[name*="[Id]"]').size() == 1) {
                if (confirm("Вы точно желаете удалить место образования?")) {
                    item.find('input[name*="Delete"]').val(1);
                    item.hide();
                }
            } else {
                item.remove();
            }
        });

        item.find('.form-row-date input[type="checkbox"]').change(function (e) {
            if ($(e.currentTarget).is(':checked')) {
                item.find('select[name*="EndYear"]').attr('disabled', 'disabled').val('').trigger('change');
            } else {
                item.find('select[name*="EndYear"]').removeAttr('disabled');
            }
        }).trigger('change');
    },

    resetPartOfItem:function (item, fields) {
        $.map(fields, function (field) {
            item.find('input[name*="' + field + '"]').val('');
        });
    },

    createFillItem:function (data) {
        var self = this;
        data.i = self.iterator;
        var template = self.templates.itemWithData(data);
        self.items.append(template);
        var item = self.items.find('div.user-career-item:last-child');
        self.initItem(item);
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
        self.iterator++;
    },

    createEmptyItem:function () {
        var self = this;
        var template = self.templates.item({i:self.iterator});
        self.items.append(template);
        var item = self.items.find('div.user-career-item:last-child');
        self.initItem(item);
        self.iterator++;
    }
}
$(function () {
    var userEditEducation = new CUserEditEducation();
});


