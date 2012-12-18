var AjaxLoadingObject = null;
$(document).ready(function(){
  AjaxLoadingObject = new AjaxLoading();
});

var AjaxLoading = function()
{
  var ajaxLoading = null;

  this.init();
}

AjaxLoading.prototype.init = function()
{
  this.ajaxLoading = $('<div id="ajax-loading">Загрузка</div>');
  $('body').append(this.ajaxLoading);

  this.ajaxLoading.ajaxStart(function(){
    $(this).show(0);
  });

  this.ajaxLoading.ajaxComplete(function(){
    $(this).hide(0);
  });
}
