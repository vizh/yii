$.widget("ui.autocomplete", $.ui.autocomplete, {
  options : {
    create: function(event, ui) {
      $(this).autocomplete("widget").addClass("dropdown-menu");
    },
    open: function(){
      $(this).autocomplete('widget').css('z-index', 1000);
    }
  }
});