$(document).bind("mobileinit", function(){
  $.extend(  $.mobile , {
    loadingMessage: 'Загрузка'
  });
});

function OnChangeUserSearch(item)
{  
  if (mobUserList == null)
  {
    mobUserList = new MobileUserList();
  }
  
  mobUserList.InputChange(item);
}

var mobUserList = null;
var MobileUserList = function()
{
  this.itemText = '';
  this.request = false;
}

MobileUserList.prototype.init = function()
{
  var self = this;
}


MobileUserList.prototype.InputChange = function(item)
{
  if (this.request)
  {    
    return;
  }
  var self = this;
  
  $.mobile.pageLoading();
  //this.request = true;
  
  var idName = $(item).attr('eventidname');
  var NameSeq = $(item).attr('value');
//  $.post('/event/users/ajax/' + idName + '/', { NameSeq: NameSeq}, function(data){
//    self.ResponseChange(data);
//  });

  $.mobile.changePage({
	  url: '/event/users/' + idName + '/',
	  type: "post",
	  data: { NameSeq: NameSeq}
  }, 'pop', false, false);
  
}

MobileUserList.prototype.ResponseChange = function(data)
{
  page = $(data).page();
  list = $('.user-list-item', page);
  $('.user-list-item').remove();
  $('#user-list').append(list);
  
  $.mobile.pageLoading(true);  
  this.request = false;
  //alert(data);
}