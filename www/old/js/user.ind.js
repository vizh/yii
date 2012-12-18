$(document).ready(function() {
  var calendar_height = $("#calendar").height();
  var profile_height = $("#profile").height();
  var delta = Math.abs(calendar_height - profile_height);
  if (profile_height > calendar_height) {
    var height = $("#calendar div.center").height() + delta;
    $("#calendar div.center").height(height);
  }
  else {
    var height = $("#profile div.center").height() + delta;
    $("#profile div.center").height(height);
  };

  
});