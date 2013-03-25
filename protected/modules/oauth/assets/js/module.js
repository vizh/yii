var oauthModuleObj = null;
$(function(){
  oauthModuleObj = new OAuthModule();

  $('input, textarea').placeholder();
});

var OAuthModule = function()
{
  this.fbUrl = '';
  this.vkUrl = '';
  this.twiUrl = '';

  this.popUpWindow = null;

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

  $('#twi_login').on('click', function(e){
    e.preventDefault();
    self.twiLogin($(e.currentTarget).attr('href'));
  });

  $('#vk_login').on('click', function(e){
    e.preventDefault();
    self.twiLogin($(e.currentTarget).attr('href'));
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

OAuthModule.prototype.twiLogin = function(url)
{
  var self = this;

  if (self.popUpWindow)
  {
    self.popUpWindow.close();
    self.popUpWindow = null;
  }

  var width = 790;
  var height = 360;
  var left = ($(window).width() - width) / 2;
  var top = ($(window).height() - height) / 2;
  self.PopUpWindow = window.open(url, 'Twitter', 'menubar=no,width='+width+',height='+height+',toolbar=no,left='+left+',top='+top);
};
OAuthModule.prototype.twiProcess = function()
{
  var self = this;

  window.location.href = self.twiUrl;
};

OAuthModule.prototype.vkLogin = function(url)
{
  var self = this;

  if (self.popUpWindow)
  {
    self.popUpWindow.close();
    self.popUpWindow = null;
  }

  var width = 790;
  var height = 360;
  var left = ($(window).width() - width) / 2;
  var top = ($(window).height() - height) / 2;
  self.PopUpWindow = window.open(url, 'Twitter', 'menubar=no,width='+width+',height='+height+',toolbar=no,left='+left+',top='+top);
};
OAuthModule.prototype.vkProcess = function()
{
  var self = this;

  window.location.href = self.vkUrl;
};