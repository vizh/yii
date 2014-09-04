$(function () {
  $('.widget-invite input[name*="FullName"]').autocomplete({
    source : '/user/ajax/search',
    select : function (event, ui) {
      $(this).parent().find('input[name*="RunetId"]').val(ui.item.RunetId);
    },
    minLength: 2,
    response : function (event, ui) {
      $.each(ui.content, function (i) {
        ui.content[i].label = ui.content[i].FullName + (typeof ui.content[i].Company != 'undefined' ? ', <span class="muted">'+ui.content[i].Company+'</span>' : '');
        ui.content[i].value = ui.content[i].FullName;
      });
    },
    html : true
  }).keypress(function (e) {
    if (e.which !== 13) {
      $(this).parent().find('input[name*="RunetId"]').val('');
    }
  });
});


