window.rIDAsyncInit = function() {
  rID.init({
    apiKey: $('meta[name="ApiKey"]').attr('content')
  });
  // Additional initialization code here
};

// Load the SDK Asynchronously
(function(d){
  var js, id = 'runetid-jssdk', ref = d.getElementsByTagName('script')[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement('script'); js.id = id; js.async = true;
  js.src = "//runet-id.com/javascripts/api/runetid.js";
  ref.parentNode.insertBefore(js, ref);
}(document));
