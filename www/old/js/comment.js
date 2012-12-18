$(document).ready(function(){
  var Hash = '#comment';
  var DeltaTop = 200;

  $('#leave-comment').bind('click', function(){
    $('#leave-comment').hide(0);
    $('#comment-form').slideDown(500);
    return false;
  });

  $('#post-comment').bind('click', function(){
    $('#comment-form form').submit();
    return false;
  });

  $('#comment_auth').bind('click', function(){
    window.location.hash = Hash;
    $('#userbar .loginButton').trigger('click');
    return false;
  });

  if (window.location.hash == Hash && $('#leave-comment').length != 0)
  {
    var top = $('#leave-comment').position().top - DeltaTop;
    $(window).scrollTop(top);
    $('#leave-comment').trigger('click');
  }
});
