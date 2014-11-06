$(function () {
  var $form = $('form.form-horizontal');
  $form.find('[name*="[EventLabel]"]').autocomplete({
    'source' : '/event/ajax/search',
    'select' : function (event, ui) {
      $(this).val(ui.item.label);
      $form.find('[name*="[EventId]"]').val(ui.item.value);
      return false;
    }
  });
});
