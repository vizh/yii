/* LIVE SEARCH CATEGORIES */
$.widget("custom.catcomplete", $.ui.autocomplete, {
  _renderMenu: function(ul, items) {
    var that = this,
        currentCategory = "";
    $.each(items, function(index, item) {
      if (item.category != currentCategory) {
        ul.append("<li class='ui-autocomplete-category'>" + item.category + "</li>");
        currentCategory = item.category;
      }
      that._renderItemData(ul, item);
    });
  }
});

/* DOM READY */
$(function() {
  getValues();
  $('#section').css({'padding-bottom': footerHeight + 'px'});


  /* PLACEHOLDER */
  $('input[placeholder], textarea[placeholder]').placeholder();

  /* INDEX PAGE */
  /* Index page -> Promo tabs */
  $('#promo-tabs').tabs();


  /* EVENTS */
  /* Event page -> Thumbs */
  $('#event-thumbs .thumb').click('click',function() {
    $('#event-photo').attr('src', $(this).data('240px'));
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


  /* LIVE SEARCH */
  $("#live-search").catcomplete({
    delay: 300,
    minLength: 1,
    dataType: "json",
    source: "/search/ajax/index",
    position: {collision: 'flip'},
    create: function(event, ui) {
      $(this).catcomplete("widget").addClass("ui-autocomplete_live-search");
    },
    open: function(event, ui) {
      $(".ui-autocomplete_live-search").append("<li class='results-all'><a href=''>Все результаты</a></li>");
      $('.results-all > a').on('click', function(e){
        e.preventDefault();
        $('form#search').submit();
      });
    }
  }).data("catcomplete")._renderItem = function(ul, item) {
    if (item.category == "Пользователи") {
      return $("<li>").append('<a href="' + item.url + '">' + item.value + ', <span class="muted">' + item.runetid + '</span></a>').appendTo(ul);
    } else if (item.category == "Компании") {
      return $("<li>").append('<a href="' + item.url + '">' + item.value + (item.locality !== undefined ? ', <span class="muted">' + item.locality + '</span>' : '')+'</a>').appendTo(ul);
    } else {
      return $("<li>").append('<a href="' + item.url + '">' + item.value).appendTo(ul);
    }
  };


  /* SEARCH PAGE */
  /* Event results -> Tabs */
  $('#search-tabs').tabs();

  /* USER ACCOUNT */
  /* User account -> Tabs */
  $('#user-account-tabs').tabs();

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
    autoSlide : true,
    autoSlideTimer : 5000,
    onSlideChange : function (args) {
      args.currentSlideObject.trigger('click');
    },
    navPrevSelector: $('#event-thumbs_prev'),
    navNextSelector: $('#event-thumbs_next')
  });
  $('#event-thumbs .thumb:eq(0)').trigger('click');


  /* USER ACCOUNT */
  /* Participate events -> Slider */
  $('#participate-events .slider').iosSlider({
    infiniteSlider: true,
    snapToChildren: true,
    navPrevSelector: $('#participate-events_prev'),
    navNextSelector: $('#participate-events_next')
  });  
});


/* WINDOW RESIZE */
$(window).resize(function() {
  $(".ui-autocomplete-input").autocomplete("close");
});


/* FUNCTIONS */
function getValues() {
  footerHeight = $('#footer').outerHeight();
}

