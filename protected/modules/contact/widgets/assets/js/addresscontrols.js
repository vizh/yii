$(function () {
  var CWidgetAddressControls = function (widget) {
    this.form = $(widget);
    this.fields = {
      countryId: this.form.find('input[name*="CountryId"]'),
      regionId: this.form.find('input[name*="RegionId"]'),
      cityId: this.form.find('input[name*="CityId"]'),
      cityLabel: this.form.find('input[name*="CityLabel"]')
    }
    this.init();
  }
  CWidgetAddressControls.prototype = {
    init: function () {
      var self = this;

      if (self.fields.cityId.val().length !== 0) {
        $.getJSON('/geo/ajax/city', {'id': self.fields.cityId.val()}, function (response) {
          self.fields.cityLabel.val(response.Name);
        });
      }
      else if (self.fields.regionId.val().length !== 0) {
        $.getJSON('/geo/ajax/region', {'id': self.fields.regionId.val()}, function (response) {
          self.fields.cityLabel.val(response.Name);
        });
      }

      self.fields.cityLabel.autocomplete({
        source: '/geo/ajax/search',
        select: function (event, ui) {
          self.fields.cityId.val(
              typeof ui.item.CityId !== "undefined" ? ui.item.CityId : ""
          );
          self.fields.regionId.val(ui.item.RegionId);
          self.fields.countryId.val(ui.item.CountryId);
        },
        response: function (event, ui) {
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


  var GoogleMaps = new GoogleMapsUtil('map');
  window.GoogleMaps = GoogleMaps;

  GoogleMaps.setDefaultPoint(55.76284, 37.6391);

  GoogleMaps.setInitMarker(window.GeoPoint);

  GoogleMaps.setApiKey(window.GoogleMapsApiKey);

  GoogleMaps.setRequestCoordinatesUrl(window.requestCoordinatesUrl);

  GoogleMaps.onClick(function (event) {
    var pos, scale;
    scale = GoogleMaps.getMapScale();
    pos = GoogleMaps.getMarkerPos();

    setInputGeoCoordinates(pos.lat(), pos.lng(), scale);
  });

  GoogleMaps.appendApiScript();

  GoogleMaps.onFinishRequestCoordinates(function (resp) {
    if (resp.status == 'success') {
      setInputGeoCoordinates(resp.coordinates[0], resp.coordinates[1]);
      var location = GoogleMaps.createMarker(resp.coordinates);

      GoogleMaps.clearMarker();
      GoogleMaps.placeMarker(location);
      return false;
    }
    if (resp.msg) {
      alert(resp.msg);
      return;
    }

    alert('Сервер вернул неверный ответ. Обратитесь, пожалуйста, в нашу службу поддержки.');
  });

  GoogleMaps.onScaleChanged(function (scale) {
    setInputMapScale(scale);
    return false;
  });

  function setInputGeoCoordinates(lat, lng, scale) {
    document.getElementById('GeoPointCoordinatesLatitude').setAttribute('value', lat);
    document.getElementById('GeoPointCoordinatesLongitude').setAttribute('value', lng);
    if (scale) {
      window.setInputMapScale(scale);
    }
  }

  function setInputMapScale(scale) {
    document.getElementById('GeoPointCoordinatesMapScale').setAttribute('value', scale);
  }

  window.addGeocode = function (geocode, el, before) {
    var val = '';
    console.log(el, $(el));

    if ($(el).length == 1) {
      val = $(el).val();
    }
    ;

    if (val) {
      if (!before) {
        before = '';
      }
      geocode.push(before + val);
    }
    return geocode;
  }
  window.getAddress = function () {
    var city, street, house, wing, place, geocode;
    city = 'input[id*="Address_CityLabel"]';
    street = 'input[id*="Address_Street"]';
    house = 'input[id*="Address_House"]';
    wing = 'input[id*="Address_Wing"]';
    place = 'input[id*="Address_Place"]';

    geocode = [];
    geocode = addGeocode(geocode, city, 'г. ');
    geocode = addGeocode(geocode, street);
    geocode = addGeocode(geocode, house, 'д. ');
    geocode = addGeocode(geocode, wing, 'стр. ');
    geocode = addGeocode(geocode, place);

    return geocode.join(', ');
  }

  window.requestCoordinates = function () {
    var geocode = getAddress();

    GoogleMaps.requestCoordinates(geocode);
  }

  window.initMap = function () {
    GoogleMaps.init();
  }
});