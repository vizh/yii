$.widget("ui.autocomplete", $.ui.autocomplete, {
  options : {
    create: function(event, ui) {
      $(this).autocomplete("widget").addClass("ui-autocomplete-bootstrap");
    },
    open: function(){
      $(this).autocomplete('widget').css('z-index', 1000);
    }
  }
});