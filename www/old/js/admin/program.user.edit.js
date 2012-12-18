var ProgramUserEditObj = null;
$(function(){
  ProgramUserEditObj = new ProgramUserEdit();
});

var ProgramUserEdit = function()
{
  this.FormVisible = false;
  this.init();
}

ProgramUserEdit.prototype.init = function()
{
  var self = this;
  $('.button_edit').live('click', function(event){
    self.EditUserClick(event);
    return false;
  });

  $('#button_add').bind('click', function(event){
    self.AddUserClick(event);
    return false;
  });

  $('#button_save').bind('click', function(){
    self.SaveUser();
    return false;
  });

  $('#button_cancel').bind('click', function(event){
    self.HideEditForm();
    return false;
  });

  $('select[name="Role"]').bind('change', function(event){
    var report = $('#report');
    if (event.currentTarget.value == 3)
    {
      report.show(0);
    }
    else
    {
      report.hide(0);
    }
  });

  $('input[name="NameOrRocid"]').autocomplete({
    source: "/admin/user/ajax/get/",
    minLength: 2,
    select: function(event, ui){
      self.SetUser(ui.item.id, ui.item.label);
      return false;
    }
  });
}

ProgramUserEdit.prototype.SetUser = function(id, label)
{
  $('input[name="RocId"]').attr('value', id);
  $('#span_rocid').html(id);
  $('input[name="NameOrRocid"]').attr('value', label);
}

ProgramUserEdit.prototype.EditUserClick = function(event)
{
  var self = this;
  var target = $(event.currentTarget);
  var row = target.parent().parent();
  var linkId = row.attr('data-link-id');
  $.post('/admin/event/program/userinfo', {
      'LinkId': linkId
    },
    function(data){
      self.ShowEditForm(row, data);
    }, 'json');
}

ProgramUserEdit.prototype.ShowEditForm = function(row, data)
{
  if (this.FormVisible)
  {
    alert('Необходимо сначала завершить редактирование текущего пользователя.');
    return;
  }
  this.FormVisible = true;

  var newRow = $('<tr id="tmp_row"><td colspan="6"></td></tr>');
  var form = $('#user_edit');

  $('input[name="LinkId"]', form).attr('value', data['LinkId'] ? data['LinkId'] : '');
  $('input[name="RocId"]', form).attr('value', data['RocId'] ? data['RocId'] : '');
  $('input[name="NameOrRocid"]', form).attr('value', data['FullName'] ? data['FullName'] : '');
  $('input[name="Order"]', form).attr('value', data['Order'] ? data['Order'] : '');
  $('select[name="Role"]', form)[0].value = data['Role'] ? data['Role'] : 0;
  $('input[name="Header"]', form).attr('value', data['Header'] ? data['Header'] : '');
  $('textarea[name="Thesis"]', form).attr('value', data['Thesis'] ? data['Thesis'] : '');
  $('input[name="LinkPresentation"]', form).attr('value', data['LinkPresentation'] ? data['LinkPresentation'] : '');

  if (row)
  {
    $('td', newRow).append(form);
    row.after(newRow);
  }
  else
  {
    $('#add_form_container').append(form);
  }
  form.show(0);

  $('select[name="Role"]', form).trigger('change');
}

ProgramUserEdit.prototype.HideEditForm = function()
{
  var form = $('#user_edit');
  var height = $(window).scrollTop() - form.height();
  form.hide(0);
  $('#add_form_container').append(form);
  $('#tmp_row').remove();
  $(window).scrollTop(height);
  this.FormVisible = false;
}

ProgramUserEdit.prototype.AddUserClick = function()
{
  this.ShowEditForm(null, new Array());
}

ProgramUserEdit.prototype.SaveUser = function()
{
  var self = this;
  $.post('/admin/event/program/useredit', $('#user_edit').serialize(),
    function(data){
      if (!data['error'])
      {
        self.HideEditForm();
        window.location.reload();
      }
      else
      {
        alert(data['message'] ? data['message'] : 'Ошибка сохранения, проверьте введенные поля');
      }
    }, 'json');
}