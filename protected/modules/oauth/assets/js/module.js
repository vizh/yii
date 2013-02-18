var oauthModuleObj = null;
$(function(){
  oauthModuleObj = new OAuthModule();
});

var OAuthModule = function()
{
  this.fbUrl = '';
  this.vkUrl = '';
  this.twiUrl = '';

  fillOAuthUrls(this);

  this.init();
};
OAuthModule.prototype.init = function()
{
  var self = this;

  $('#fb_login').on('click', function(e){
    e.preventDefault();
    self.fbLogin();
  });
};

OAuthModule.prototype.fbLogin = function()
{
  var self = this;

  FB.login(function(response) {
    if (response.authResponse) {
      window.location.href = self.fbUrl;
    } else {
      // cancelled
    }
  }, {perms:'email'});
};
