$(function () {
  var CWidgetAddressControls = function (widget) {
    this.form = $(widget);
    this.fields = {
      countryId : this.form.find('input[name*="CountryId"]'),
      regionId : this.form.find('input[name*="RegionId"]'),
      cityId : this.form.find('input[name*="CityId"]'),
      cityLabel : this.form.find('input[name*="CityLabel"]')
    }
    this.init();
  }
  CWidgetAddressControls.prototype = {
    init : function () {
      var self = this;
      
      if (self.fields.cityId.val().length !== 0) {
        $.getJSON('/contact/ajax/city', {cityId : self.fields.cityId.val()}, function (response) {
          self.fields.cityLabel.val(response.Name);
        });
      }
      else if (self.fields.regionId.val().length !== 0){
        $.getJSON('/contact/ajax/region', {regionId : self.fields.regionId.val()}, function (response) {
          self.fields.cityLabel.val(response.Name);
        });
      }
      
      self.fields.cityLabel.autocomplete({
        source : '/contact/ajax/search',
        select : function (event, ui) {
          self.fields.cityId.val(
            typeof ui.item.CityId !== "undefined" ? ui.item.CityId : ""
          );
          self.fields.regionId.val(ui.item.RegionId);
          self.fields.countryId.val(ui.item.CountryId);
        },
        response: function(event, ui) {
          self.fields.cityId.val('');
          self.fields.regionId.val('');
          self.fields.countryId.val('');
        }
      });
    }
  };
  
  $('.widget-address-controls').each(function (i, widget) {
    new CWidgetAddressControls(widget);
  });
});

