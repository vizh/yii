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
  this.ppUrl  = '';
  this.viadeoUrl = '';
  this.LinkedinUrl = '/oauth/social/request/22/';
 
  this.popUpWindow = null;

  fillOAuthUrls(this);

  this.init();
};
OAuthModule.prototype.init = function()
{
  var self = this;

  $('#twi_login').on('click', function(e){
      if (isFrame() || isUserEditAction() )
      {
          e.preventDefault();
          self.twiLogin($(e.currentTarget).attr('href'));
      }
  });

  $('#vk_login').on('click', function(e){
      if (isFrame() || isUserEditAction())
      {
          e.preventDefault();
          self.twiLogin($(e.currentTarget).attr('href'));
      }
  });

  $('#pp_login').on('click', function(e){
      if (isFrame() || isUserEditAction())
      {
          e.preventDefault();
          self.twiLogin($(e.currentTarget).attr('href'));
      }
  });
  
  $('#g_login').on('click', function (e) {
      if (isFrame() || isUserEditAction())
      {
          e.preventDefault();
          self.twiLogin($(e.currentTarget).attr('href'));
      }
  });

  $('#viadeo_login').on('click', function(e){
    e.preventDefault();
    self.viadeoLogin();
  });

    $('#li_login').on('click', function (e) {
        if (isFrame() || isUserEditAction())
        {
            e.preventDefault();
            self.twiLogin($(e.currentTarget).attr('href'));
        }
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

OAuthModule.prototype.ppLogin = function(url)
{
  var self = this;
  if (self.popUpWindow)
  {
    self.popUpWindow.close();
    self.popUpWindow = null;
  }
  var width = 400;
  var height = 500;
  var left = ($(window).width() - width) / 2;
  var top = ($(window).height() - height) / 2;
  self.PopUpWindow = window.open(url, 'PayPal', 'menubar=no,width='+width+',height='+height+',toolbar=no,left='+left+',top='+top);
};
OAuthModule.prototype.twiProcess = function()
{
  var self = this;

  window.location.href = self.twiUrl;
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

OAuthModule.prototype.ppProcess = function()
{
  var self = this;
  window.location.href = self.ppUrl;
};

OAuthModule.prototype.gProcess = function ()
{
  var self = this;
  window.location.href = self.gUrl;
}


OAuthModule.prototype.LIProcess = function()
{
    var self = this;
    window.location.href = self.LinkedinUrl;
};
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

function isFrame()
{
    var result = false,
        tmp = [];
    location.search
        .substr(1)
        .split("&")
        .forEach(function (item) {
            tmp = item.split("=");
            if (tmp[0] === 'frame') result = true;
        });
    return result;
}

function isUserEditAction()
{
    var url = location.search;
    if (url.indexOf('user/setting/connect') != -1)
    {
        return true;
    }
    else
    {
        return false;
    }
}