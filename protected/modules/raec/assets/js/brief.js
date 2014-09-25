$(function() {
  var $brief = $('.brief');
  var $form  = $brief.find('form');

  $brief.find('.nav-tabs a').click(function(e) {
    var $target = $(e.currentTarget);
    var action = $target.data('action');
    if (typeof(action) != "undefined") {
      $form.find('input#NextAction').val(action);
      $form.submit();
    }
    e.preventDefault();
  });
});