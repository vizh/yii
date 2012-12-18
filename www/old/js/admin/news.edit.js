var newsEditObj = null;
$(document).ready(function(){
  newsEditObj = new NewsEdit
});


var NewsEdit = function()
{
  this.init();
  this.initInputTitle();
}

NewsEdit.prototype.init = function()
{
  var self = this;
  $('#addcompany').autocomplete({
    source: "/company/ajax/get/",
    minLength: 2,
    select: function(event, ui){
      self.AddCompany(ui.item.id, ui.item.label);
      return false;
    }
  });

  $('ul.company_list div.delete').live('click', function(event){
    self.DeleteCompany(event);
  });

  $('#main_category').bind('change', function(event){
    self.ChangeMainCategory(event);
  });

  $('ul.second_category_list input').bind('change', function(event){
    self.SelectSecondCategory(event);
  });

  $('#button_save').bind('click', function(event){
    $('#form_editnews')[0].submit();
    return false;
  });

  $('#button_publish').bind('click', function(event){
    var select = $('div.pub-status select')[0];
    select.value = 'publish';
    $('#button_save').trigger('click');
    return false;
  });

  $('#addimage').bind('click', function(event){
    self.ShowAddImageInterface(event);
    return false;
  });
}

NewsEdit.prototype.initInputTitle = function()
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

NewsEdit.prototype.ShowAddImageInterface = function(event)
{

}

NewsEdit.prototype.AddCompany = function(id, label)
{
  var self = this;
  var element = $('#company_prototype').clone();
  element.attr('id', '');
  var aTag = $('a', element);
  aTag.html(label);
  aTag.attr('href', '/company/' + id + '/');

  var deleteTag = $('div', element);
  deleteTag.attr('data-company', id);
  $('ul.company_list').append(element);
  element.show(0);
  $('#addcompany').attr('value', '');
  var newsId = $('input[name="news_post_id"]').attr('value');

  $.post('/admin/news/company/add/', {
    CompanyId: id,
    NewsId: newsId
  }, function(data){

  }, 'json');
}

NewsEdit.prototype.DeleteCompany = function(event)
{
  var element = $(event.currentTarget);

  var companyId = element.attr('data-company');
  var newsId = $('input[name="news_post_id"]').attr('value');

  element.parent().remove();

  $.post('/admin/news/company/delete/', {
    CompanyId: companyId,
    NewsId: newsId
  }, function(data){

  }, 'json');
}

NewsEdit.prototype.ChangeMainCategory = function(event)
{
  var value = event.currentTarget.value;

  var checkbox = $('ul.second_category_list input[value="' + value +'"]');
  checkbox.attr('checked', 'checked');
}

NewsEdit.prototype.SelectSecondCategory = function(event)
{
  var element = $(event.currentTarget);
  var value = element.attr('value');
  var main = $('#main_category')[0].value;
  if (!element.attr('checked'))
  {
    if (value == main)
    {
      var elChecked = $('ul.second_category_list input:checked');
      if (elChecked.length == 0)
      {
        $('#main_category')[0].value = 0;
      }
      else
      {
        $('#main_category')[0].value = elChecked.attr('value');
      }
    }
  }
  else
  {
    if (main == 0)
    {
      $('#main_category')[0].value = value;
    }
  }
}

