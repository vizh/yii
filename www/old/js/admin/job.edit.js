var jobEditObj = null;
$(document).ready(function(){
  jobEditObj = new JobEdit();
});


var JobEdit = function()
{
  this.init();
  this.initInputTitle();
  this.initInputCompany();
  this.initTinyMCE();
}

JobEdit.prototype.init = function()
{
  var self = this;

  $('#button_save').bind('click', function(event){
    $('#form_editjob')[0].submit();
    return false;
  });

  $('#button_publish').bind('click', function(event){
    var select = $('div.pub-status select')[0];
    select.value = 'publish';
    $('#button_save').trigger('click');
    return false;
  });
}

JobEdit.prototype.initInputTitle = function()
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

JobEdit.prototype.initInputCompany = function()
{
  var self = this;
  if ($('#selectcompany').length != 0)
  {
    $('#selectcompany').autocomplete({
      source: "/company/ajax/get/",
      minLength: 2,
      select: function(event, ui){
        self.SelectCompany(ui.item.id, ui.item.label);
      }
    });
  }
}

JobEdit.prototype.SelectCompany = function(id, label)
{
  $('input[name="data[companyId]"]').attr('value', id);
}

JobEdit.prototype.initTinyMCE = function()
{
  if (typeof(tinyMCE) != 'undefined')
  {
    tinyMCE.init({
      mode : "specific_textareas",
      editor_selector : "applyTinyMce",
      theme : "advanced",
      language : 'ru',

      // Theme options
      theme_advanced_buttons1 : "bullist,numlist,|,bold,italic,|,setdefault",
      theme_advanced_buttons2 : "",
      theme_advanced_buttons3 : "",
      theme_advanced_buttons4 : "",
      theme_advanced_toolbar_location : "top",
      theme_advanced_toolbar_align : "left",
      theme_advanced_statusbar_location : "none",
      theme_advanced_resizing : true,

      //visualisation
      content_css : "/css/tiny_mce.css",

      //Other options
      inline_styles : false,
      setup : function(ed) {
        ed.addButton('setdefault', {
          title : 'Вернуть значение по умолчанию',
          image : '/images/mce-temp-button.gif',
          onclick : function() {            
            ed.focus();
            if (confirm('Вы уверены, что сбросить содежимое на базовое заполнение?'))
            {
              ed.setContent('<strong>Требования:</strong><ul><li>&nbsp;</li></ul>' +
                  '<strong>Обязанности:</strong><ul><li>&nbsp;</li></ul>' +
                  '<strong>Плюсом будет:</strong><ul><li>&nbsp;</li></ul>');
            }

          }
        });
      }
    });
  }
}