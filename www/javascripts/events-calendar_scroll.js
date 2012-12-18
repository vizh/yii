$(document).scroll( function(){
  var fixed = $('#b-fixed').offset().top;
  $('.scroll').each(function() {
    var element      = $(this),
        parent       = element.parent(),
        parentTop    = parent.offset().top,
        parentBottom = parentTop + parent.outerHeight() - element.outerHeight();
    if (fixed <= parentTop) {
      element.removeClass('p-fixed').addClass('p-static');
    } else if (element.offset().top < fixed && fixed < parentBottom) {
      element.removeClass('p-static').addClass('p-fixed');
    } else if (fixed >= parentBottom) {
      element.removeClass('p-fixed').addClass('p-absolute');
    } else if (fixed < parentBottom) {
      element.removeClass('p-absolute').addClass('p-fixed');
    }
  });
});