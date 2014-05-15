$(function () {
  $('input[name*="company"]').autocomplete({
    source : function (request, response) {
      $.getJSON('/company/ajax/search', {term : request.term},function(data) {
        response( $.map(data, function(item) {
          return {
            label: item.Name,
            value: item.Name
          }
        }));
      });
    }
  });

  //$('input[name*="birthday"]').datepicker();
});
