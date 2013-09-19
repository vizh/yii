var oauthModuleObj = null;
$(function(){
  oauthModuleObj = new OAuthModule();

  $('input, textarea').placeholder();
});

var OAuthModule = function()
{
  this.fbUrl  = '';
  this.vkUrl  = '';
  this.twiUrl = '';
  this.gUrl   = '';
  this.viadeoUrl = '';
 
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
  
  $('#g_login').on('click', function (e) {
    e.preventDefault();
    self.twiLogin($(e.currentTarget).attr('href'));
  });

  $('#viadeo_login').on('click', function(e){
    e.preventDefault();
    self.viadeoLogin();
  });

  $('#btn_cancel').on('click', function(e){
    e.preventDefault();
    var warning = $('#cancel_warning');
    if (warning.data('warning') == 1)
    {
      window.close();
    }
    else
    {
      $('form p').css('display', 'none');
      warning.css('display', 'inline-block').data('warning', 1);
    }
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

OAuthModule.prototype.viadeoLogin = function()
{
  var self = this;

  VD.getLoginStatus(function(r) {
    if (!r.session) {
      VD.login(function(r) {
        if(r.session){
          window.location.href = self.viadeoUrl;
        }
      });
    } else {
      window.location.href = self.viadeoUrl;
    }
  });
};

OAuthModule.prototype.vkProcess = function()
{
  var self = this;
  window.location.href = self.vkUrl;
};

OAuthModule.prototype.gProcess = function ()
{
  var self = this;
  window.location.href = self.gUrl;
}

function loadScript(src, callback)
{
  var s,
    r,
    t;
  r = false;
  s = document.createElement('script');
  s.type = 'text/javascript';
  s.src = src;
  s.onload = s.onreadystatechange = function() {
    //console.log( this.readyState ); //uncomment this line to see which ready states are called.
    if ( !r && (!this.readyState || this.readyState == 'complete') )
    {
      r = true;
      callback();
    }
  };
  t = document.getElementsByTagName('script')[0];
  t.parentNode.insertBefore(s, t);
}
