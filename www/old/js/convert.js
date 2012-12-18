var convertObj = null;
var ConvertList = new Array("user", "event", "useractivity", "company", "useremployment", "contactaddress", "contactemail", "contactphone", "contactsite", "contactserviceaccount", "usersettings", "geoRegion", "geoCountry", "geoCity", "eventuser", "eventroles", "eventprogram", "eventprogramuserlink", "eventreports", "eventprogramroles", "group", "groupuser");
var current = 0;
$(document).ready(
  function()
  {
    convertObj = new Convert();
  }
);


var Convert = function()
{
  this.init();
}

Convert.prototype.init = function()
{
  
  if ($('#start'))
  {
    $('#start').bind('click', function() {
      ConvertRecursive();
    });
  }
}



function ConvertRecursive()
{
  length = ConvertList.length;
  if (current < length)
  {
    $('#start')[0].disabled = true;
    $('#result').append('Start: ' + ConvertList[current] + '&nbsp;&nbsp;&nbsp;');
    $.get('/convert/' + ConvertList[current], {}, GetResponse);
  }
  else
  {
    $('#result').append('<span style="color: #0f0;">Finished!</span> <br />');
  }
}

function GetResponse(data)
{
  if (data == "OK")
  {    
    $('#result').append('Complete: ' + ConvertList[current] + '<br/>');
    current = current + 1;
    ConvertRecursive();
  }
  else
  {
    $('#result').append('<span style="color: #f00;">Error:</span> ' + ConvertList[current] + '<br/>');
    $('#result').append(data);
  }
  
}