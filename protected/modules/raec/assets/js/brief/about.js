var CRaecBriefAbout = function () {
  this.$form = $('form#yw0');
  this.companySynonymIterator = 0;
  this.init();
}
CRaecBriefAbout.prototype = {
  'init' : function () {
    var self = this;

    this.initCompany();
    this.initCompanySynonyms();

    var datepicker = $.fn.datepicker.noConflict();
    $.fn.bootstrapDatePicker = datepicker;
    this.$form.find('input[name*="JurudicalOGRNDate"]').bootstrapDatePicker({
      'format' : 'dd.mm.yyyy',
      'language' : 'ru',
      'autoclose' : true
    });

    self.$form.find('input[name*="JuridicalAddressEqual"]').change(function (e) {
      var $target = $(e.currentTarget),
          $juridical = self.$form.find('textarea[name*="JuridicalAddress"]'),
          $actual = self.$form.find('textarea[name*="JuridicalAddressActual"]');

      if ($target.is(':checked')) {
        $actual.val($juridical.val()).attr('readonly', 'readonly');
      } else {
        $actual.removeAttr('readonly');
      }
    }).trigger('change');
  },

  'initCompany' : function () {
    var $label = this.$form.find('input[name*="CompanyLabel"]');
    var $id = this.$form.find('input[name*="CompanyId"]');
    $label.autocomplete({
      'source' : '/company/ajax/search',
      'select' : function (event, ui) {
        $label.val(ui.item.label);
        $id.val(ui.item.value);
        return false;
      }
    });

    $label.keydown(function () {
      $id.val('');
    });
  },

  'initCompanySynonyms' : function () {
    var self = this;

    if (typeof(companySynonyms) != "undefined") {
      $.each(companySynonyms, function (i, synonym) {
        self.createCompanySynonymRow(synonym);
      });
    }

    self.$form.find('.company-synonyms').find('.btn.add').click(function (e) {
      self.createCompanySynonymRow();
    });
  },

  'createCompanySynonymRow' : function(data) {
    var template = _.template($('#company-synonym-tpl').html());
    var $container = this.$form.find('.company-synonyms');

    if (typeof(data) == "undefined") {
      var data = [];
      data.Id = '';
      data.Label = '';
    }
    data.i = this.companySynonymIterator;

    $container.find('.btn.add').before(template(data));
    var $row = $container.find('div.row-fluid:last');

    var $label = $row.find('input[name*="Label"]');
    var $id = $row.find('input[name*="Id"]');

    $label.autocomplete({
      'source' : '/company/ajax/search',
      'select' : function (event, ui) {
        $label.val(ui.item.label);
        $id.val(ui.item.value);
        return false;
      }
    });
    $label.keydown(function () {
      $id.val('');
    });

    $row.find('.btn.btn-danger').click(function(e) {
      e.preventDefault();
      $row.remove();
    });
    this.companySynonymIterator++;
  }
}

$(function() {
  new CRaecBriefAbout();
});