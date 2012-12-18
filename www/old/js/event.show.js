var eventShowObj;
$(document).ready(function(){
  eventShowObj = new EventShow();
});

var EventShow = function()
{
  this.init();
}

EventShow.prototype.init = function()
{
  var self = this;

  $('#facebook-export').bind('click', function()
  {
    FB.login(function(response){
    if (response.session)
    {
      self.AddEventToFb();
    }
  }, {perms:'create_event'});
    return false;
  });

  this.InitYaShare();
}

EventShow.prototype.InitYaShare = function()
{
  var self = this;
  $('#share_friends').bind('click', function(){
    self.ShowYaShare();
    return false;
  });

  $('body').bind('click', function(){
    self.HideYaShare();
  });

  var eventName = $('#ya_share_container').attr('data-event-name');
  var eventUrl = $('#ya_share_container').attr('data-event-url');

  new Ya.share({
    element: 'ya_share',
    elementStyle: {
      'type': 'button',
      'border': true,
      'quickServices': ['facebook', 'twitter', '|', 'vkontakte', 'linkedin']
    },
    link: eventUrl,
    title: eventName,
    popupStyle: {
      blocks: {
        'Поделитесь с друзьями': ['facebook', 'twitter', 'vkontakte', 'linkedin', 'lj', 'moikrug',
          'odnoklassniki', 'yaru']
      },
      copyPasteField: true
    }
  });
}

EventShow.prototype.ShowYaShare = function()
{
  $('#ya_share_container').show(300);
}

EventShow.prototype.HideYaShare = function()
{
  $('#ya_share_container').hide(300);
}

EventShow.prototype.AddEventToFb = function()
{
  var self = this;
  //var exportTag = $('#facebook-export');
  var name = $('#facebook-export').attr('event-name');
  var start = $('#facebook-export').attr('event-start');
  var finish = $('#facebook-export').attr('event-finish');
  var description = $('#facebook-export').attr('event-description');
  var picture = $('#facebook-export').attr('event-picture');
  FB.api('/me/events', 'post', {name: name, start_time: start,
    end_time: finish, description: description, picture: picture}, function(response){
    if (!response || response.error) {
      self.ConfirmDialog('При добавление мероприятия в календарь Facebook произошла ошибка.');
    } else {
      self.ConfirmDialog('Мероприятие успешно добавлено в ваш календарь событий на Facebook.');
    }
  });
}

EventShow.prototype.ConfirmDialog = function(text) {
  $('#confirm div.message').html(text);

	$('#confirm').modal({
    overlayClose: true,
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

