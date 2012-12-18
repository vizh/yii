var Social = null;

$(function(){
  Social = new SocialModel();
})

var SocialModel = function()
{
  this.PopUpWindow = null;
}

SocialModel.prototype.FacebookConnect = function(callback)
{
  FB.login(function(response){
      if (response.authResponse)
      {
        window.location.href = callback;
      }
    }, {perms:'email'});
}

SocialModel.prototype.TwitterConnect = function(callback)
{
  var backUrl = window.location.href;
  if (this.PopUpWindow)
  {
    this.PopUpWindow.close();
    this.PopUpWindow = null;
  }

  var width = 790;
  var height = 360;
  var left = ($(window).width() - width) / 2;
  var top = ($(window).height() - height) / 2;
  this.PopUpWindow = window.open('/main/twitter/connect/?call='+encodeURIComponent(callback),
      'Twitter', 'menubar=no,width='+width+',height='+height+',toolbar=no,left='+left+',top='+top);
}

SocialModel.prototype.TwitterConnectCallback = function(callback)
{
  if (this.PopUpWindow)
  {
    this.PopUpWindow.close();
    this.PopUpWindow = null;
  }

  window.location.href = callback;
}