$(function () {
    CJobDefaultIndex = function () {
        this.filter = $('.form-filter');
        this.init();
    };
    CJobDefaultIndex.prototype = {
        init:function () {
            var self = this;
            self.filter.find('select.form-filter_category').change(function (e) {
                self.filter.find('select.form-filter_position').hide().attr('disabled', 'disabled')
                self.filter.find('select.form-filter_position[data-category=' + $(e.currentTarget).val() + ']').removeAttr('disabled').show();
            }).trigger('change');

            self.filter.find('.form-filter_salary a').click(function (e) {
                $(e.currentTarget).next('input').show();
                $(e.currentTarget).remove();
            });
        }
    }

    var jobDefaultIndex = new CJobDefaultIndex();
});