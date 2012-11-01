$(function() {
  getValues();
  $('#section').css({'padding-bottom': footerHeight + 'px'});

  /* EVENTS */
  /* Event page -> Thumbs */
  $('#event-thumbs .thumb').click(function() {
    $('#event-thumbs').find('.thumb.current').removeClass('current');
    $(this).addClass('current');
    $('#event-photo').attr('src', $(this).attr('src'));
  });
  $('#event-thumbs_prev, #event-thumbs_next').live('selectstart', function() {
    return false;
  });

  /* Event page -> Tabs */
  $('#event-tabs').tabs();

  /* COMPANIES */
  /* Company -> Account */
  $('#company-description_toggle').click(function() {
    $('#company-description').toggleClass('show', 1000);
    return false;
  });

  /* EVENT REGISTER */
  var evRegTbl = '#event-register .registration .table';

  /* Event Toggle */
  $(evRegTbl + ' .form-element_select').click(function() { return false; });
  $('#event-register .registration .table thead').click(function() {
    $(this).siblings('tbody').slideToggle(1);
    $(this).find('i').toggleClass('icon-chevron-up icon-chevron-down');
  });

  /* Continued in: event-registration.js */

});

$(window).load(function() {
  /* Equal height blocks in promo area */
  userDashboardBlocksEqualHeight();

  /* EVENTS */
  /* Event page -> Thumbs slider init */
  $('#event-thumbs .slider').iosSlider({
    infiniteSlider: true,
    snapToChildren: true,
    navPrevSelector: $('#event-thumbs_prev'),
    navNextSelector: $('#event-thumbs_next'),
  });
});

function getValues() {
  footerHeight = $('#footer').outerHeight();
}

function userDashboardBlocksEqualHeight() {
  var maxHeight = -1;
  $('.b-user-dashboard .span5').each(function() {
    maxHeight = maxHeight > $(this).outerHeight() ? maxHeight : $(this).outerHeight();
  });
  $('.b-user-dashboard .span5').each(function() {
    $(this).outerHeight(maxHeight);
  });
}