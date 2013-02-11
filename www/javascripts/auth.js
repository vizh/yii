$(function(){

});

var Auth = function()
{
  this.url = 'http://login.runetid.local/main/auth/';
  this.backUrl = location.href;
};

Auth.prototype.getUrl = function()
{
  return this.url + '?&url='+encodeURIComponent(this.backUrl);
};


