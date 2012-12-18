var maskEditObj = null;
$(document).ready(function(){
  maskEditObj = new MaskEdit();
});


var MaskEdit = function()
{
  this.init();
  this.initInputTitle();
}

MaskEdit.prototype.init = function()
{
  var self = this;

  $('#button_save').bind('click', function(event){
    $('#form_editmask')[0].submit();
    return false;
  });

  $('input[type="checkbox"]').bind('change', function(event){
    self.RuleChanged(event);
  });
}

MaskEdit.prototype.initInputTitle = function()
{
  var input = $('input.title');
  var emptytitle = input.attr('data-empty');

  input.bind('focus', function(event){
    if (event.currentTarget.value == '' || event.currentTarget.value == emptytitle)
    {
      event.currentTarget.style.color = '#000000';
      event.currentTarget.value = '';
    }
  });

  input.bind('blur', function(event){
    if (event.currentTarget.value == '' || event.currentTarget.value == emptytitle)
    {
      event.currentTarget.style.color = '#C0C0C0';
      event.currentTarget.value = emptytitle;
    }
  });

  input.trigger('blur');
}

MaskEdit.prototype.RuleChanged = function(event)
{
  var element = $(event.currentTarget);
  var level = parseInt(element.attr('data-level'), 10);
  var elementLi = $('li[data-id="' + element.attr('data-id') + '"]');
  $('ul input[type="checkbox"]', elementLi).attr('checked', element.attr('checked'));
  switch (level){
    case 1:
      if (!element.attr('checked'))
      {
        var parent = elementLi.parent().parent();
        $('input[type="checkbox"]:first', parent).attr('checked', false);
      }
    break;
    case 2:
      if (!element.attr('checked'))
      {
        var parent = elementLi.parent().parent();
        $('input[type="checkbox"]:first', parent).attr('checked', false);
        $('input[type="checkbox"]:first', parent.parent().parent()).attr('checked', false);
      }
    break;
  }
}