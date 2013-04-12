$(function () {
  var CAddressControls = function () {
    this.country = $('select[name*="CountryId"]');
    this.region = $('select[name*="RegionId"]');
    this.city = $('select[name*="CityId"]');
    this.changed = false;
    this.init();
  }
  CAddressControls.prototype = {
    init : function () {
      var self = this;
      
      self.country.attr('disabled', 'disabled').html('');
      $.getJSON('/contact/ajax/countries', function (response) {
        $.each(response, function (id, name) {
          var option = $('<option>').html(name).attr('value', id);
          self.country.append(option);
        });
        if (typeof self.country.data('value') !== "undefined" && self.country.data('value') != '') {
          self.country.find('option[value="'+ self.country.data('value') +'"]').attr('selected', 'selected');
          self.country.data('value', '');
        }
        self.country.removeAttr('disabled').trigger('change');
      });
      
      self.country.change(function (e) {
        self.region.attr('disabled', 'disabled').html('');
        $.getJSON('/contact/ajax/regions', {countryId : $(e.currentTarget).val()}, function (response) {
          $.each(response, function (id, name) {
            var option = $('<option>').html(name).attr('value', id);
            self.region.append(option);
          });
          if (typeof self.region.data('value') !== "undefined" && self.region.data('value') != '') {
            self.region.find('option[value="'+ self.region.data('value') +'"]').attr('selected', 'selected');
            self.region.data('value','');
          }
          self.region.removeAttr('disabled').trigger('change');
        });
      });
      
      self.region.change(function (e) {
        self.city.attr('disabled', 'disabled').html('');
        $.getJSON('/contact/ajax/cities', {regionId : $(e.currentTarget).val()}, function (response) {
          $.each(response, function (id, name) {
            var option = $('<option>').html(name).attr('value', id);
            self.city.append(option);
          });
          if (typeof self.city.data('value') !== "undefined" && self.city.data('value') !== '') {
            self.city.find('option[value="'+ self.city.data('value') +'"]').attr('selected', 'selected');
            self.city.data('value', '');
          }
          self.city.removeAttr('disabled');
        });
      });
    }
  };
  
  var addressControls = new CAddressControls();
});

