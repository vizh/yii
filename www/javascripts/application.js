$(function() {
  getValues();
  $('#section').css({'padding-bottom': footerHeight + 'px'});


  /* PLACEHOLDER */
  $('input[placeholder], textarea[placeholder]').placeholder();


  /* LOGIN */
  //  $('#header, #promo').find('.login').toggle(
  //    function() {
  //      $('.b-login').slideDown();
  //      $(this).addClass('active');
  //    }, function() {
  //      $('.b-login').slideUp();
  //      $(this).removeClass('active');
  //    }
  //  );


  /* INDEX PAGE */
  /* Index page -> Promo tabs */
  $('#promo-tabs').tabs();


  /* EVENTS */
  /* Event page -> Thumbs */
  $('#event-thumbs .thumb').click(function() {
    $('#event-thumbs').find('.thumb.current').removeClass('current');
    $(this).addClass('current');
    $('#event-photo').attr('src', $(this).attr('src'));
  });
  $('#event-thumbs_prev, #event-thumbs_next').on('selectstart', function() {
    return false;
  });

  /* Event page -> Tabs */
  $('#event-tabs').tabs();

  /* Event register -> Toggle */
  $('#event-register .table thead').click(function() {
    $(this).siblings('tbody').slideToggle(1);
    $(this).find('i').toggleClass('icon-chevron-up icon-chevron-down');
  });


  /* SEARCH PAGE */
  /* Event results -> Tabs */
  $('#search-tabs').tabs();


  /* COMPANIES */
  /* Company -> Account */
  $('#company-description_toggle').click(function() {
    $('#company-description').toggleClass('show', 500);
    return false;
  });


  /* USER ACCOUNT */
  /* User account -> Participated */
  $('.b-participated .row').each(function() {
    $(this).find('figcaption.cnt').fixMaxHeight();
  });

  $('.user-account .b-participated .a').mouseenter(function() {
    $(this).closest('.i').find('.popup').show();
  });

  $('.user-account .b-participated .popup').mouseleave(function() {
    $(this).hide();
  });
});


$(window).load(function() {
  /* INDEX PAGE */
  /* Index page -> Promo slider */
  $('#promo-slider .slider').iosSlider({
    keyboardControls: true,

    infiniteSlider: true,
    snapToChildren: true,
    navPrevSelector: $('#promo-slider_prev'),
    navNextSelector: $('#promo-slider_next')
  });


  /* EVENTS */
  /* Event page -> Thumbs slider init */
  $('#event-thumbs .slider').iosSlider({
    infiniteSlider: true,
    snapToChildren: true,
    navPrevSelector: $('#event-thumbs_prev'),
    navNextSelector: $('#event-thumbs_next')
  });


  /* USER ACCOUNT */
  /* Participate events -> Slider */
  $('#participate-events .slider').iosSlider({
    infiniteSlider: true,
    snapToChildren: true,
    navPrevSelector: $('#participate-events_prev'),
    navNextSelector: $('#participate-events_next')
  });  
});


/* FUNCTIONS */
function getValues() {
  footerHeight = $('#footer').outerHeight();
}