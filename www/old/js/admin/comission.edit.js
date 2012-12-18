var ComissionEditObj = null;
$(function(){
  ComissionEditObj = new ComissionEdit();
});

var ComissionEdit = function()
{
  this.init();
}

ComissionEdit.prototype.init = function()
{
  var self = this;
  $('input[name="search"]').autocomplete({
    source: "/admin/user/ajax/get/",
    minLength: 2,
    select: function(event, ui){
      self.SetUser(ui.item.id, ui.item.label);
      return false;
    }
  });

  $('#add_user_to_comission').bind('click', function(event){
    if (!$('input[name="rocID"]').attr('value'))
    {
      alert('Необходимо выбрать пользователя rocID для добавления!');
      return false;
    }
  });
}

ComissionEdit.prototype.SetUser = function(id, label)
{
  $('input[name="rocID"]').attr('value', id);
  $('#span_rocid').html(id);
  $('input[name="search"]').attr('value', label);
}