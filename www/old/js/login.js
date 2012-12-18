$(document).ready(function()
{
  $('#select_registration').bind('click', function (){
    $('#login-block').css('display', 'none');
    $('#registration-block').css('display', 'block');
    return false;
  });

  $('#select_login').bind('click', function (){
    $('#registration-block').css('display', 'none');
    $('#login-block').css('display', 'block');
    return false;
  });

  $('#login-block #AuthForm #password').bind('keypress', function(event){
    if (event.which == '13')
    {
      $('#login-block #AuthForm').submit();
    }
  });

  /*$('#send_pwd').bind('click', function(){
    $('#confirm').modal({
      closeHTML: "<a href='#' title='Close' class='modal-close'>x</a>",
      overlayClose: true,
      position: ["30%"],
      overlayId: 'imageresize-overlay',
      containerId: 'confirm-container',
      onShow: function (dialog) {
        var modal = this;
        $('#upload_photo_resized').unbind('click');
        $('#upload_photo_resized').bind('click', function(){
          self.UploadResizeImage();
          modal.close();
          return false;
        });

        $('#cancel_resize').unbind('click');
        $('#cancel_resize').bind('click', function(){
          modal.close();
          return false;
        });
      }
    });
    return false;
  });*/
});

var popUpWindow = null;
function TwitterConnect(callback)
{
  if (popUpWindow)
  {
    popUpWindow.close();
    popUpWindow = null;
  }

  var width = 790;
  var height = 360;
  var left = ($(window).width() - width) / 2;
  var top = ($(window).height() - height) / 2;
  popUpWindow = window.open('/main/twitter/connect/?call='+encodeURIComponent('/main/auth/twitter/'),
      'Twitter', 'menubar=no,width='+width+',height='+height+',toolbar=no,left='+left+',top='+top);
}

function TwitterCallbackConnect(call)
{
  if (popUpWindow)
  {
    popUpWindow.close();
    popUpWindow = null;
  }

  if (typeof(call) != 'undefined')
  {
    window.location.href = call;
  }
  else
  {
    window.location.reload();
  }
}

function FacebookConnect()
{
  FB.login(function(response){
        if (response.session)
        {
          var url = '/main/auth/facebook/?call=' + encodeURIComponent('/');
          window.location.href = url;
        }
      }, {perms:'email'});
}

function FacebookRegister()
{
  FB.login(function(response){
        if (response.session)
        {
          var url = '/main/register/facebook/';
          window.location.href = url;
        }
      }, {perms:'email'});
}

function TwitterRegister()
{
  if (popUpWindow)
  {
    popUpWindow.close();
    popUpWindow = null;
  }

  var width = 790;
  var height = 360;
  var left = ($(window).width() - width) / 2;
  var top = ($(window).height() - height) / 2;
  popUpWindow = window.open('/main/twitter/connect/?call='+encodeURIComponent('/main/register/twitter/'),
      'Twitter', 'menubar=no,width='+width+',height='+height+',toolbar=no,left='+left+',top='+top);
}