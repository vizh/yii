var geoObj = null;
$(document).ready(
  function()
  {
    geoObj = new GeoDropDown();
  }
);

/*
|---------------------------------------------------------------
| РЕДАКТИРОВАНИЕ Местоположения
|---------------------------------------------------------------
*/   
var GeoDropDown = function ()
{
  this.init();  
}

GeoDropDown.prototype.init = function()
{
  if ($('#country')) 
  {
    $('#country').bind('change', function() {
      var value = $('#country')[0].value;
      $.getJSON('/geo/regionlist/' + value, function(data)
        {
          Utils.buildOptions(0, 'Выберите регион', data, $('#region'));
          Utils.buildOptions(0, 'Выберите город', Array(), $('#city'));
        });
    });
  }
  
  if ($('#region')) 
  {    
    $('#region').bind('change', function() {
      var value = $('#region')[0].value;
      $.getJSON('/geo/citylist/' + value, function(data)
        {
          Utils.buildOptions(0, 'Выберите город', data, $('#city'));
        });
    });
  }
  
  if ($('#geoSelect'))
  {
    $('#geoSelect').bind('submit', function(event){
      event.preventDefault();
      geoLocation = geoObj.GetLocation();
      path = '/' + letter + '/' + geoLocation + '/';
      location.href = url + path; 
    });
  }
}

GeoDropDown.prototype.GetLocation = function()
{
  var country = $('#country')[0].value;
  var region = $('#region')[0].value;
  var city = $('#city')[0].value;
  if (country == 0)
  {
    return '';
  }
  return country + '-' + region + '-' + city;
}