var editObj = null;
var loadInfoObj = null;
$(document).ready(function(){
  editObj = new UserEdit();
  setInterval("editObj.hashChangeEvent()", 50);

  loadInfoObj = new LoadInfo();
});

var LoadInfo = function()
{
  this.loaderId = '#loadwait';
  this.successId = '#loadsuccess';
  this.failureId = '#loadfailure';
}

LoadInfo.prototype.AddAfterAndShow = function(element)
{
  element.after($(this.loaderId));
  element.after($(this.successId));
  element.after($(this.failureId));
  this.ShowLoader();
}

LoadInfo.prototype.ShowLoader = function()
{
  $(this.loaderId).show(0);
}

LoadInfo.prototype.HideLoader = function()
{
  $(this.loaderId).css('display', 'none');
}

LoadInfo.prototype.ShowSuccess = function()
{
  $(this.successId).fadeIn(1000);
  setTimeout("loadInfoObj.HideSuccess()", 4000);
}

LoadInfo.prototype.HideSuccess = function()
{
  var self = this;
  $(this.successId).fadeOut(1000, function(){
    $(self.successId).css('display', 'none');
  });
}

LoadInfo.prototype.ShowFailure = function(message)
{
  $(this.failureId).html(message);
  $(this.failureId).fadeIn(1000);
  setTimeout("loadInfoObj.HideFailure()", 8000);
}

LoadInfo.prototype.HideFailure = function()
{
  var self = this;
  $(this.failureId).fadeOut(1000, function(){
    $(self.failureId).css('display', 'none');
  });
}

var UserEdit = function()
{
  this.AjaxRequest = false;

  this.ActiveTab = 'main';
  this.PrefixMenu = 'menu_';
  this.PrefixEdit = 'edit_';
  this.PrefixSave = 'save_';
  this.PrefixJob = 'job_';

  this.PrefixContact = 'contact_';
  this.PrefixPhone = 'phone_';

  this.AddNewJobId = '#add_new_job';
  this.ClearNewJobId = '#clear_new_job';
  this.Data = new Object();

  this.Photo = null;
  this.Selection = new Object();

  this.PopUpWindow = null;

  this.Hash = '';

  this.init();
}

UserEdit.prototype.init = function()
{
  var self = this;
  //Переключение меню
  $('ul.edit-profile li').bind('click', function(event){
    self.MenuClick(event);
    return false;
  });
  //Сохранение профиля
  $('a.save_settings').bind('click', function(event){
    self.SaveClick(event);
    return false;
  });
  //Добавление, очистка новой работы, удаление работы
  $(this.AddNewJobId).bind('click', function(){
    self.AddNewJob();
    return false;
  });
  $(this.ClearNewJobId).bind('click', function(){
    self.ClearNewJob();
    return false;
  });
  //Управление выбором времени работы
  this.initJobs();
  this.initContacts();

  $('[name="company"]').autocomplete({
			source: "/company/ajax/get/",
			minLength: 2
		});

  $('#load_photo').bind('click', function(){
    self.UploadImage();
    return false;
  });

  $('#delete_photo').bind('click', function(){
    self.DeletePhoto();
    return false;
  });

  $('#change_password').bind('click', function(event){
    self.ChangePassword(event)
    return false;
  });

  $('#change_email').bind('click', function(event){
    self.ChangeEmail(event)
    return false;
  });

  $('#delete_account').bind('click', function(event){
    self.DeleteAccount(event)
    return false;
  });

//  $('#twi-connect').bind('click', function(){
//    self.TwitterConnect();
//    return false;
//  });

//  $('#fb-connect').bind('click', function(){
//    self.FacebookConnect();
//    return false;
//  });

  this.FillData();
  this.initHref();
}

UserEdit.prototype.initJobs = function()
{
  var self = this;
  $('[name="end_month"]').unbind('change');
  $('[name="end_month"]').bind('change', function(event){
    self.EndJobChange(event);
  });

  $('#edit_work a.delete_work').unbind('click');
  $('#edit_work a.delete_work').bind('click', function(event){
    if (confirm('Вы действительно хотите удалить место работы?'))
    {
      self.DeleteJob(event);
    }
    return false;
  });
}

UserEdit.prototype.initContacts = function()
{
  var self = this;
  $('#add_messenger').unbind('click');
  $('#add_messenger').bind('click', function(){
    self.AddContact();
    return false;
  });

  $('#add_phone').unbind('click');
  $('#add_phone').bind('click', function(){
    self.AddPhone();
    return false;
  });

  $('a.delete_messenger').unbind('click');
  $('a.delete_messenger').bind('click', function(event){
    self.DeleteContactOrPhone(event);
    return false;
  });

  $('a.delete_phone').unbind('click');
  $('a.delete_phone').bind('click', function(event){
    self.DeleteContactOrPhone(event);
    return false;
  });
}

UserEdit.prototype.FillData = function()
{
  this.Data['main'] = this.GetMainData();
  this.Data['work'] = this.GetWorkData();
  this.Data['contact'] = this.GetContactData();
  this.Data['address'] = this.GetAddressData();
  this.Data['settings'] = this.GetSettingsData();
}

UserEdit.prototype.initHref = function()
{
  var hash = this.Hash == '' ? 'main' : this.Hash;
  this.SetActiveTab(hash);
};

UserEdit.prototype.hashChangeEvent = function()
{
  var newHash = location.hash.split('#');
  if (newHash.length == 1)
  {
    newHash[1] = '';
  }

  if (newHash[1] != this.Hash)
  {
    this.Hash = newHash[1];
    this.initHref();
  }
}

UserEdit.prototype.GetDataByTag = function(tag)
{
  switch (tag)
  {
    case 'main':
        return this.GetMainData();
    break;
    case 'work':
        return this.GetWorkData();
    break;
    case 'contact':
        return this.GetContactData();
    break;
    case 'address':
        return this.GetAddressData();
    break;
    case 'settings':
        return this.GetSettingsData();
    break;
    default:
  }
  return null;
}

UserEdit.prototype.GetMainData = function()
{
  var MainData = new Object();
  MainData['gender'] = $('#gender')[0].value;
  MainData['lastname'] = $('#lastname')[0].value;
  MainData['name'] = $('#name')[0].value;
  MainData['fathername'] = $('#fathername')[0].value;
  MainData['bday'] = $('#bday')[0].value;
  MainData['bmonth'] = $('#bmonth')[0].value;
  MainData['byear'] = $('#byear')[0].value;
  MainData['hidefathername'] = $('input[name="hidefathername"]')[0].checked ? 1 : 0;
  MainData['hidebirthdayyear'] = $('input[name="hidebyear"]')[0].checked ? 1 : 0;
  return MainData;
}

UserEdit.prototype.GetWorkData = function()
{
  var WorkData = new Object();
  var jobs = $('div.job');
  for (var i=0;i<jobs.length;i++)
  {
    var job = $(jobs[i]);
    var id = job.attr('id').substr(this.PrefixJob.length);
    WorkData[id] = this.GetJobDataByElement(job);
  }
  return WorkData;
}

UserEdit.prototype.GetJobDataByElement = function(element)
{
  var Data = new Object();
  Data['company'] = $('input[name="company"]', element)[0].value;
  Data['position'] = $('input[name="position"]', element)[0].value;
  Data['start'] = $('[name="start_month"]', element)[0].value +
      '.' + $('[name="start_year"]', element)[0].value;
  Data['end'] = $('[name="end_month"]', element)[0].value +
      '.' + $('[name="end_year"]', element)[0].value;
  Data['primary'] = $('[name="work_priority"]:first', element).prop('checked') ? 1 : 0;

  return Data;
}


UserEdit.prototype.GetContactData = function()
{
  var Data = new Object();
  var contact = $('#edit_contact');
  Data['email'] = $('input[name="email"]', contact)[0].value;
  Data['site'] = $('input[name="site"]', contact)[0].value;
  var Contacts = new Object();
  var imInfos = $('dl.im_info');
  for (var i=0; i<imInfos.length;i++)
  {
    var info = $(imInfos[i]);
    var id = info.attr('id').substr(this.PrefixContact.length);
    var mes = new Object();
    mes['type'] = $('[name="im_list"]', info)[0].value;
    mes['value'] = $('[name="im_screenname"]', info)[0].value;
    Contacts[id] = mes;
  }
  Data['contacts'] = Contacts;

  var Phones = new Object();
  var phoneInfos = $('dl.phone_info');
  for (i=0; i<phoneInfos.length;i++)
  {
    var info = $(phoneInfos[i]);
    var id = info.attr('id').substr(this.PrefixPhone.length);
    var phone = new Object();
    phone['type'] = $('[name="phone_list"]', info)[0].value;
    phone['value'] = $('[name="phone"]', info)[0].value;
    Phones[id] = phone;
  }
  Data['phones'] = Phones;

  return Data;
}

UserEdit.prototype.GetAddressData = function()
{
  var Data = new Object();
  var address = $('#edit_address');
  Data['city'] = $('[name="city"]', address)[0].value;
  
  Data['postalindex'] = $('input[name="postalindex"]', address)[0].value;
  Data['street'] = $('input[name="street"]', address)[0].value;
  Data['housenum'] = $('input[name="housenum"]', address)[0].value;
  Data['building'] = $('input[name="building"]', address)[0].value;
  Data['housing'] = $('input[name="housing"]', address)[0].value;
  Data['apartment'] = $('input[name="apartment"]', address)[0].value;

  return Data;
}

UserEdit.prototype.GetSettingsData = function()
{
  var Data = new Object();
  var settings = $('#edit_settings');

  Data['projnews'] = $('input[name="projnews"]', settings)[0].checked ? 1 : 0;
  Data['eventnews'] = $('input[name="eventnews"]', settings)[0].checked ? 1 : 0;
  Data['noticephoto'] = $('input[name="noticephoto"]', settings)[0].checked ? 1 : 0;
  Data['indexprofile'] = $('input[name="indexprofile"]', settings)[0].checked ? 1 : 0;

  return Data;
}

UserEdit.prototype.MenuClick = function(event)
{
  if (this.AjaxRequest)
  {
    return false;
  }
  var self = this;
  var target = event.currentTarget;
  target = $(target);
  var menuItem = target.attr('id').substr(this.PrefixMenu.length);
  if (menuItem == this.ActiveTab)
  {
    return;
  }

  var compare = this.DataCompare(this.GetDataByTag(this.ActiveTab), this.Data[this.ActiveTab]);
  if (!compare)
  {
    ConfirmDialog(function(){
      self.SaveData(self.ActiveTab);
      //self.SetActiveTab(menuItem);
    }, function(){
      //self.SetActiveTab(menuItem);
      window.location.hash = '#' + menuItem;
    });
  }
  else
  {
    //self.SetActiveTab(menuItem);
    window.location.hash = '#' + menuItem;
  }
  return false;
}

UserEdit.prototype.SetActiveTab = function(tabName)
{
  $(".edit-block").hide();
  $("#"+this.PrefixEdit+tabName).show();
  this.ActiveTab = tabName;

  $(".edit-profile li").removeClass('selected');
  $("#"+this.PrefixMenu+tabName).addClass('selected');
}

UserEdit.prototype.DataCompare = function(dataNew, dataOld)
{
  var flag = true;
  var key;
  for (key in dataNew)
  {
    if (! (key in dataOld))
    {
      return false;
    }
    if (typeof(dataNew[key]) == 'object')
    {
      flag = flag && this.DataCompare(dataNew[key], dataOld[key])
    }
    else
    {
      flag = flag && dataNew[key] == dataOld[key];
    }
  }

  return flag;
}

UserEdit.prototype.SaveClick = function(event)
{
  if (this.AjaxRequest)
  {
    return false;
  }

  var target = event.currentTarget;
  target = $(target);
  var saveItem = target.attr('id').substr(this.PrefixSave.length);
  this.SaveData(saveItem);
  return false;
}

UserEdit.prototype.SaveData = function(tag)
{
  var self = this;
  var Data = this.GetDataByTag(tag);
  loadInfoObj.AddAfterAndShow($("#"+this.PrefixSave+tag));
  this.AjaxRequest = true;

  $.post('/user/edit/save/', {
    tag: tag,
    data: Data
  }, function(data){
    self.SaveResponse(data);
  }, 'json');
}

UserEdit.prototype.SaveResponse = function(data)
{
  this.AjaxRequest = false;
  if (!data['error'])
  {
    loadInfoObj.HideLoader();
    loadInfoObj.ShowSuccess();
    var tag = data['tag'];
    if (tag == 'contact')
    {
      this.ContactAfterSave(data);
    }
    else if (tag == 'work')
    {
      this.WorkAfterSave(data);
    }
    this.Data[tag] = this.GetDataByTag(tag);
  }
  else
  {
    loadInfoObj.HideLoader();
    loadInfoObj.ShowFailure(data['message']);
    if (data['tag'] != this.ActiveTab)
    {
      this.SetActiveTab(data['tag']);
    }
  }
}

UserEdit.prototype.ClearNewJob = function()
{
  $('#new_job input[name="company"]')[0].value = '';
  $('#new_job input[name="position"]')[0].value = '';
  $('#new_job [name="start_month"]')[0].value = 0;
  $('#new_job [name="start_year"]')[0].value = '';
  $('#new_job [name="end_month"]')[0].value = 0;
  $('#new_job [name="end_year"]')[0].value = '';
  $('#new_job [name="work_priority"]:first').prop('checked', false);
}

UserEdit.prototype.AddNewJob = function()
{
//  if (this.AjaxRequest)
//  {
//    return false;
//  }
//  var self = this;
  var newJob = $('#new_job').clone();
  var length = Object.keys(this.Data['work']).length;
  var separator;
  var id = 'new_'+length;
  newJob.attr('id', 'job_'+id);
  newJob.addClass('job');
  newJob.addClass('new_job');
  $('#jobs_start').after(newJob);
  $('input[name=company]',newJob).autocomplete({
			source: "/company/ajax/get/",
			minLength: 2
		});
  separator = $('dl.bseparator:first');
  if (separator)
  {
    separator = separator.clone();
    separator.attr('id', 'separator_'+id);
    newJob.after(separator);
  }

  this.initJobs();
}

UserEdit.prototype.WorkAfterSave = function(data)
{
  for (key in data['newjobs'])
  {
    $('#job_' + key).removeClass('new_job');
    $('#job_' + key).attr('id', 'job_' + data['newjobs'][key]);
    $('#separator_' + key).attr('id', 'separator_' + data['newjobs'][key]);
  }
}

UserEdit.prototype.EndJobChange = function(event)
{
  var element = event.currentTarget;
  var yearInput = $('[name="end_year"]', $(element).parent());
  if (element.value == 0)
  {
    yearInput.prop("disabled", true);
  }
  else
  {
    yearInput.prop("disabled", false);
  }
}

UserEdit.prototype.DeleteJob = function(event)
{
  var self = this;
  if (this.AjaxRequest)
  {
    return false;
  }

  var element = $(event.currentTarget);
  var job = element.parent().parent().parent();
  var id = job.attr('id').substr(this.PrefixJob.length);
  if (job.hasClass('new_job'))
  {
    job.remove();
    $('#separator_'+id).remove();
    return;
  }

  loadInfoObj.AddAfterAndShow(job);

  $.post('/user/edit/save/', {
    tag: 'DeleteJob',
    data: id
  }, function(data){
    self.DeleteJobResponse(data);
  }, 'json');
}

UserEdit.prototype.DeleteJobResponse = function(data)
{
  this.AjaxRequest = false;
  if (!data['error'])
  {
    loadInfoObj.HideLoader();
    loadInfoObj.ShowSuccess();

    var id = data['id'];
    delete this.Data['work'][id];
    $('#' + this.PrefixJob+id).remove();
    $('dl#separator_'+id).remove();
    //todo: подкорректировать удаление разделителя, проверять - если разделителя нет, то удалить последний из имеющихся
  }
  else
  {
    loadInfoObj.HideLoader();
    loadInfoObj.ShowFailure();
  }
}

UserEdit.prototype.AddContact = function()
{
  var template = $('dl.im_template:first');
  template = template.clone();
  var last = $('dl.im_info:last');
  if (last.length != 0)
  {
    var id = last.attr('id');
    if (id.indexOf(this.PrefixContact+'new') != -1)
    {
      id = id.substr((this.PrefixContact+'new').length);
      id = parseInt(id)+1;
    }
    else
    {
      id = 1;
    }
  }
  else
  {
    id = 1;
  }
  template.attr('id', this.PrefixContact + 'new'+id.toString());
  template.removeClass('im_template');
  template.addClass('im_info');
  template.addClass('new');
  $('dl.im_template:first').before(template);
  this.initContacts();
}

UserEdit.prototype.DeleteContactOrPhone = function(event)
{
  var self = this;
  if (this.AjaxRequest)
  {
    return false;
  }
  if (!confirm('Вы действительно хотите удалить контакт?'))
  {
    return;
  }
  var element = $(event.currentTarget).parent().parent().parent();
  if (element.hasClass('new'))
  {
    element.remove();
    return;
  }
  var id = element.attr('id');
  var data = new Object();
  this.AjaxRequest = true;
  loadInfoObj.AddAfterAndShow(element);
  if (id.search(this.PrefixContact) != -1)
  {
    data['id'] = id.substr((this.PrefixContact).length);
    data['type'] = 'contact';
  }
  else
  {
    data['id'] = id.substr((this.PrefixPhone).length);
    data['type'] = 'phone';
  }

  $.post('/user/edit/save/', {
    tag: 'DeleteContact',
    data: data
  }, function(data){
    self.DeleteContactOrPhoneResponse(data);
  }, 'json');
}

UserEdit.prototype.DeleteContactOrPhoneResponse = function(data)
{
  this.AjaxRequest = false;
  if (!data['error'])
  {
    loadInfoObj.HideLoader();
    loadInfoObj.ShowSuccess();

    var id = data['id'];
    var element;
    if (data['type'] == 'contact')
    {
      element = $('#' + this.PrefixContact + id);
      delete this.Data['contact']['contacts'][id];
    }
    else
    {
      element = $('#' + this.PrefixPhone + id);
      delete this.Data['contact']['phones'][id];
    }
    element.remove();
  }
  else
  {
    loadInfoObj.HideLoader();
    loadInfoObj.ShowFailure();
  }
}

UserEdit.prototype.AddPhone = function()
{
  var template = $('dl.phone_template:first');
  template = template.clone();
  var last = $('dl.phone_info:last');
  if (last.length != 0)
  {
    var id = last.attr('id');
    if (id.indexOf(this.PrefixPhone+'new') != -1)
    {
      id = id.substr((this.PrefixPhone+'new').length);
      id = parseInt(id)+1;
    }
    else
    {
      id = 1;
    }
  }
  else
  {
    id = 1;
  }
  template.attr('id', this.PrefixPhone + 'new'+id.toString());
  template.removeClass('phone_template');
  template.addClass('phone_info');
  template.addClass('new');
  $('dl.phone_template:first').before(template);
  this.initContacts();
}

UserEdit.prototype.ContactAfterSave = function(data)
{
  $('#edit_contact dl.new').remove();
  if (data['contacts'].length != 0)
  {
    $('dl.im_template:first').before($(data['contacts']));
  }
  if (typeof data['fb'] != "undefined")
  {
    $('dl#' + this.PrefixContact + 'fb').attr('id', this.PrefixContact + 'fb' + data['fb']);
  }
  if (typeof data['twi'] != "undefined")
  {
    $('dl#' + this.PrefixContact + 'twi').attr('id', this.PrefixContact + 'twi' + data['twi']);
  }
  if (data['phones'].length != 0)
  {    
    $('dl.phone_template:first').before($(data['phones']));
  }
  this.initContacts();
}

UserEdit.prototype.UploadImage = function()
{
  var self = this;
  //this.AjaxRequest = true;
  loadInfoObj.AddAfterAndShow($('#load_photo'));
  $.ajaxFileUpload(
  {
    url: '/user/edit/save/?tag=addphoto',
    secureuri: false,
    fileElementId: 'profile_picture_photo',
    dataType: 'json',
    complete: function()
    {
      loadInfoObj.HideLoader();
    },
    success: function (data, status)
    {
      self.AjaxRequest = false;
      if (! data['error'])
      {
        var src = data['image'] + '?' + Math.random();
        self.Photo = new Image();
        self.Photo.onload = OnLoadPhoto;
        self.Photo.src = src;
        self.ResizeImage();
        $('div.profile_picture img.medium').attr('src', src);
        $('div.profile_picture img.small').attr('src', data['miniimage'] + '?' + Math.random());
        var element = ('#imageresize');
        $('img', element).attr('src', src);
      }
      else
      {
        loadInfoObj.ShowFailure();
      }
    },
    error: function (data, status, e)
    {
      alert(e);
    }
  });
}

UserEdit.prototype.ResizeImage = function()
{
  var self = this;
  $('#imageresize').modal({
    overlayClose: true,
		position: ["30%"],
		overlayId: 'imageresize-overlay',
		containerId: 'imageresize-container',
		onShow: function (dialog) {
			var modal = this;
      $('#upload_photo_resized').unbind('click');
      $('#upload_photo_resized').bind('click', function(){
        self.UploadResizeImage();
        modal.close();
        return false;
      });

      $('#cancel_resize').unbind('click');
      $('#cancel_resize').bind('click', function(){
        modal.close();
        return false;
      });
		}
	});
}

function OnLoadPhoto()
{
  editObj.OnLoadPhoto();
}

UserEdit.prototype.OnLoadPhoto = function()
{
  var self = this;
  var min = Math.min(this.Photo.width, this.Photo.height);
  $('#imageresize img:first').imgAreaSelect(
  {
    aspectRatio: '1:1',
    handles: true,
    x1: 0, y1: 0, x2: min, y2: min,
    onSelectChange: function(img, selection){
      self.PhotoPreview(selection);
    },
    parent: '#imageresize'
  });

  //var selection = new Object();
  this.Selection['x1'] = 0;
  this.Selection['y1'] = 0;
  this.Selection['width'] = min;
  this.Selection['height'] = min;
  this.PhotoPreview(this.Selection);
}

UserEdit.prototype.PhotoPreview = function(selection)
{
  var self = this;

  var scaleX = 90 / (selection.width || 1);  
  var scaleY = 90 / (selection.height || 1);

  $('div.imageresize-90  img').css({
    width: Math.round(scaleX * self.Photo.width) + 'px',
    height: Math.round(scaleY * self.Photo.height) + 'px',
    marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
    marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
  });

  scaleX = 50 / (selection.width || 1);
  scaleY = 50 / (selection.height || 1);

  $('div.imageresize-50 img').css({
    width: Math.round(scaleX * self.Photo.width) + 'px',
    height: Math.round(scaleY * self.Photo.height) + 'px',
    marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
    marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
  });

  this.Selection['x1'] = selection.x1;
  this.Selection['y1'] = selection.y1;
  this.Selection['width'] = selection.width;
  this.Selection['height'] = selection.height;
}

UserEdit.prototype.UploadResizeImage = function()
{
  var self = this;
  this.AjaxRequest = true;
  loadInfoObj.ShowLoader();

  $.post('/user/edit/save/', {
    tag: 'ResizePhoto',
    data: self.Selection
  }, function(data){
    self.UploadResizeImageResponse(data);
  }, 'json');
}

UserEdit.prototype.UploadResizeImageResponse = function(data)
{
  this.AjaxRequest = false;
  loadInfoObj.HideLoader();
  if (!data['error'])
  {
    loadInfoObj.ShowSuccess();
    $('div.profile_picture img.medium').attr('src', data['image'] + '?' + Math.random());
    $('div.profile_picture img.small').attr('src', data['miniimage'] + '?' + Math.random());
  }
  else
  {
    loadInfoObj.ShowFailure();
  }
}

UserEdit.prototype.DeletePhoto = function()
{
  var self = this;
  this.AjaxRequest = true;
  loadInfoObj.AddAfterAndShow($('#load_photo'));

  $.post('/user/edit/save/', {
    tag: 'DeletePhoto',
    data: null
  }, function(data){
    self.DeletePhotoResponse(data);
  }, 'json');
}

UserEdit.prototype.DeletePhotoResponse = function(data)
{
  this.AjaxRequest = false;
  loadInfoObj.HideLoader();
  if (!data['error'])
  {
    loadInfoObj.ShowSuccess();
    $('div.profile_picture img.medium').attr('src', data['image'] + '?' + Math.random());
    $('div.profile_picture img.small').attr('src', data['miniimage'] + '?' + Math.random());
  }
  else
  {
    loadInfoObj.ShowFailure();
  }
}

function ConfirmDialog(callbackWithSave, callbackWithoutSave) {
	$('#confirm').modal({
		closeHTML: "<a href='#' title='Close' class='modal-close'>x</a>",
		position: ["30%"],
		overlayId: 'confirm-overlay',
		containerId: 'confirm-container',
		onShow: function (dialog) {
			var modal = this;

			//$('.message', dialog.data[0]).append(message);

			// if the user clicks "nosave"
			$('.nosave', dialog.data[0]).click(function () {
				// call the callback
				if ($.isFunction(callbackWithoutSave)) {
					callbackWithoutSave.apply();
				}
				// close the dialog
				modal.close(); // or $.modal.close();
			});

      // if the user clicks "save"
			$('.save', dialog.data[0]).click(function () {
				// call the callback
				if ($.isFunction(callbackWithSave)) {
					callbackWithSave.apply();
				}
				// close the dialog
				modal.close(); // or $.modal.close();
			});
		}
	});
}

UserEdit.prototype.TwitterConnect = function()
{
  if (this.PopUpWindow)
  {
    this.PopUpWindow.close();
    this.PopUpWindow = null;
  }

  var width = 790;
  var height = 360;
  var left = ($(window).width() - width) / 2;
  var top = ($(window).height() - height) / 2;
  this.PopUpWindow = window.open('/main/twitter/connect/?call='+encodeURIComponent('/user/edit/connect/twitter/'),
      'Twitter', 'menubar=no,width='+width+',height='+height+',toolbar=no,left='+left+',top='+top);
}

UserEdit.prototype.TwitterCallbackConnect = function()
{
  var self = this;
  if (this.PopUpWindow)
  {
    this.PopUpWindow.close();
    this.PopUpWindow = null;
  }

  window.location.reload();
}

function TwitterCallbackConnect()
{
  editObj.TwitterCallbackConnect();
}

UserEdit.prototype.FacebookConnect = function()
{
  FB.login(function(response){
    if (response.session)
    {
      var url = '/user/edit/connect/facebook/';
      window.location.href = url;
    }
  }, {perms:'email'});
}

UserEdit.prototype.ChangePassword = function(event)
{
  loadInfoObj.AddAfterAndShow($(event.currentTarget));

  var Data = new Object();
  Data['current_pass'] = $('input[name="current_pass"]')[0].value;
  Data['new_pass'] = $('input[name="new_pass"]')[0].value;
  Data['rnew_pass'] = $('input[name="rnew_pass"]')[0].value;

  $.post('/user/edit/save/', {
    tag: 'ChangePassword',
    data: Data
  }, function(data){

    if (!data['error'])
    {
      //window.location.reload();
      loadInfoObj.HideLoader();
      loadInfoObj.ShowSuccess();
      $('input[name="current_pass"]')[0].value = '';
      $('input[name="new_pass"]')[0].value = '';
      $('input[name="rnew_pass"]')[0].value = '';
    }
    else
    {
      loadInfoObj.HideLoader();
      loadInfoObj.ShowFailure(data['message']);
    }
  }, 'json');
}

UserEdit.prototype.ChangeEmail = function(event)
{
  loadInfoObj.AddAfterAndShow($(event.currentTarget));

  var Data = new Object();
  Data['current_email'] = $('input[name="current_email"]')[0].value;
  Data['new_email'] = $('input[name="new_email"]')[0].value;
  Data['rnew_email'] = $('input[name="rnew_email"]')[0].value;

  $.post('/user/edit/save/', {
    tag: 'ChangeEmail',
    data: Data
  }, function(data){

    if (!data['error'])
    {
      //window.location.reload();
      loadInfoObj.HideLoader();
      loadInfoObj.ShowSuccess();
      $('input[name="current_email"]')[0].value = '';
      $('input[name="new_email"]')[0].value = '';
      $('input[name="rnew_email"]')[0].value = '';
    }
    else
    {
      loadInfoObj.HideLoader();
      loadInfoObj.ShowFailure(data['message']);
    }
  }, 'json');
}

UserEdit.prototype.DeleteAccount = function(event)
{
  
}