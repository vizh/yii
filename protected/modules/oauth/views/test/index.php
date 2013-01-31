<a onclick="rID.login(); return false;" href="#">Авторизоваться</a>


<div id="fb-root"></div>
<script type="text/javascript">
  window.fbAsyncInit = function() {
    FB.init({
      appId      : 201234113248910, // App ID
      channelUrl : '//WWW.YOUR_DOMAIN.COM/channel.html', // Channel File
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });

    // Additional initialization code here
  };

  // Load the SDK Asynchronously
  (function(d){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all.js";
     ref.parentNode.insertBefore(js, ref);
   }(document));
</script>




<script type="text/javascript">
  window.rIDAsyncInit = function() {
    rID.init({
      apiKey: '12345',
      rState: '<?=$rState;?>'
    });
    // Additional initialization code here
  };

  // Load the SDK Asynchronously
  (function(d){
    var js, id = 'runetid-jssdk', ref = d.getElementsByTagName('script')[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement('script'); js.id = id; js.async = true;
    js.src = "//beta.rocid/js/runetid.js";
    ref.parentNode.insertBefore(js, ref);
  }(document));
</script>