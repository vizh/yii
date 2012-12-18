var editObj = null;
var loadInfoObj = null;
$(document).ready(function(){
	editObj = new CompanyEdit();
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

LoadInfo.prototype.ShowFailure = function()
{
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

var CompanyEdit = function()
{
	this.AjaxRequest = false;

	this.ActiveTab = 'main';
	this.PrefixMenu = 'menu_';
	this.PrefixEdit = 'edit_';
	this.PrefixSave = 'save_';

	this.PrefixContact = 'contact_';
	this.PrefixPhone = 'phone_';
	
	this.PrefixCompany = 'company_';

	this.Data = new Object();

	this.Logo = null;
	this.Selection = new Object();

	this.PopUpWindow = null;

	this.init();
}

CompanyEdit.prototype.init = function()
{
	var self = this;
	//Переключение меню
	$('ul.edit-profile li').bind('click', function(event){
		self.MenuClick(event);
		//return false;
	});
	//Сохранение профиля
	$('a.save_settings').bind('click', function(event){
		self.SaveClick(event);
		return false;
	});
	
	this.initContacts();

	$('#load_logo').bind('click', function(){
		self.UploadImage();
		return false;
	});

	$('#delete_logo').bind('click', function(){
		self.DeleteLogo();
		return false;
	});

	this.FillData();
	this.initHref();
}

CompanyEdit.prototype.initContacts = function()
{
	var self = this;
	$('#add_phone').unbind('click');
	$('#add_phone').bind('click', function(){
		self.AddPhone();
		return false;
	});
	$('a.delete_phone').unbind('click');
	$('a.delete_phone').bind('click', function(event){
		self.DeleteContactOrPhone(event);
		return false;
	});
}

CompanyEdit.prototype.FillData = function()
{
	this.Data['main'] = this.GetMainData();
	this.Data['contact'] = this.GetContactData();
	this.Data['address'] = this.GetAddressData();
}

CompanyEdit.prototype.initHref = function()
{
	var url = document.location.href;
	var start = url.indexOf('#') + 1;
	if (url.length < start || start == 0 )
	{
		return;
	}
	url = url.substr(start);
	this.SetActiveTab(url);
}

CompanyEdit.prototype.GetDataByTag = function(tag)
{
	switch (tag)
	{
		case 'main':
				return this.GetMainData();
		break;
		case 'contact':
				return this.GetContactData();
		break;
		case 'address':
				return this.GetAddressData();
		break;
		default:
	}
	return null;
}

CompanyEdit.prototype.GetMainData = function()
{
	var MainData = new Object();

	MainData['name'] = $('#name')[0].value;
	MainData['fullname'] = $('#fullname')[0].value;
	MainData['info'] = $('#info')[0].value;

	return MainData;
}

CompanyEdit.prototype.GetContactData = function()
{
	var Data = new Object();
	var contact = $('#edit_contact');
	Data['email'] = $('input[name="email"]', contact)[0].value;
	Data['site'] = $('input[name="site"]', contact)[0].value;

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

CompanyEdit.prototype.GetAddressData = function()
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

CompanyEdit.prototype.MenuClick = function(event)
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
			self.SetActiveTab(menuItem);
		});
	}
	else
	{
		self.SetActiveTab(menuItem);
	}
	return false;
}

CompanyEdit.prototype.SetActiveTab = function(tabName)
{
	$(".edit-block").hide();
	$("#"+this.PrefixEdit+tabName).show();
	this.ActiveTab = tabName;

	$(".edit-profile li").removeClass('selected');
	$("#"+this.PrefixMenu+tabName).addClass('selected');
}

CompanyEdit.prototype.DataCompare = function(dataNew, dataOld)
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

CompanyEdit.prototype.SaveClick = function(event)
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

CompanyEdit.prototype.SaveData = function(tag)
{
	var self = this;
	var CompanyId = $('.company-name').attr('id').substr(this.PrefixCompany.length);
	var Data = this.GetDataByTag(tag);
	loadInfoObj.AddAfterAndShow($("#"+this.PrefixSave+tag));
	this.AjaxRequest = true;

	$.post('/company/' + CompanyId + '/edit/save/', {
		tag: tag,
		data: Data
	}, function(data){
		self.SaveResponse(data);
	}, 'json');
}

CompanyEdit.prototype.SaveResponse = function(data)
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
		this.Data[tag] = this.GetDataByTag(tag);
	}
	else
	{
		loadInfoObj.HideLoader();
		loadInfoObj.ShowFailure();
		if (data['tag'] != this.ActiveTab)
		{
			this.SetActiveTab(data['tag']);
		}
	}
}

/*
CompanyEdit.prototype.AddContact = function()
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
*/

CompanyEdit.prototype.DeleteContactOrPhone = function(event)
{
	
	var self = this;
	var CompanyId = $('.company-name').attr('id').substr(this.PrefixCompany.length);
	
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

	$.post('/company/' + CompanyId + '/edit/save/', {
		tag: 'DeleteContact',
		data: data
	}, function(data){
		self.DeleteContactOrPhoneResponse(data);
	}, 'json');
}

CompanyEdit.prototype.DeleteContactOrPhoneResponse = function(data)
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

CompanyEdit.prototype.AddPhone = function()
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

CompanyEdit.prototype.ContactAfterSave = function(data)
{
	$('#edit_contact dl.new').remove();
	if (data['contacts'].length != 0)
	{
		$('dl.im_template:first').before($(data['contacts']));
	}
	if (data['phones'].length != 0)
	{    
		$('dl.phone_template:first').before($(data['phones']));
	}
	this.initContacts();
}

CompanyEdit.prototype.UploadImage = function()
{
	var self = this;
	var CompanyId = $('.company-name').attr('id').substr(this.PrefixCompany.length);
	
	//this.AjaxRequest = true;
	loadInfoObj.AddAfterAndShow($('#load_logo'));
	$.ajaxFileUpload(
	{
		url: '/company/' + CompanyId + '/edit/save/?tag=addlogo',
		secureuri: false,
		fileElementId: 'profile_picture_logo',
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
				self.UploadImageResponse(data);
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

CompanyEdit.prototype.UploadImageResponse = function(data)
{
	this.AjaxRequest = false;
	loadInfoObj.HideLoader();
	if (!data['error'])
	{
		loadInfoObj.ShowSuccess();
		$('div.profile_picture_company img.medium').attr('src', data['image'] + '?' + Math.random());
		$('div.profile_picture_company img.small').attr('src', data['miniimage'] + '?' + Math.random());
	}
	else
	{
		loadInfoObj.ShowFailure();
	}
}

CompanyEdit.prototype.DeleteLogo = function()
{
	var self = this;
	var CompanyId = $('.company-name').attr('id').substr(this.PrefixCompany.length);
	this.AjaxRequest = true;
	loadInfoObj.AddAfterAndShow($('#load_logo'));

	$.post('/company/' + CompanyId + '/edit/save/', {
		tag: 'DeleteLogo',
		data: null
	}, function(data){
		self.DeleteLogoResponse(data);
	}, 'json');
}

CompanyEdit.prototype.DeleteLogoResponse = function(data)
{
	this.AjaxRequest = false;
	loadInfoObj.HideLoader();
	if (!data['error'])
	{
		loadInfoObj.ShowSuccess();
		$('div.profile_picture_company img.medium').attr('src', data['image'] + '?' + Math.random());
		$('div.profile_picture_company img.small').attr('src', data['miniimage'] + '?' + Math.random());
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
