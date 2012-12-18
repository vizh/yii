var videoObj = null;
$(document).ready(function() {
  videoObj = new VideoIndex();
});


var VideoIndex = function()
{
  this.LastQuery = '';
  this.RequestNumber = 0;
  this.ResponseNumber = 0;

  this.init();
}

VideoIndex.prototype.init = function()
{
  var self = this;

  $('a.video-link').bind('click', function(event){
    self.VideoClick(event);
    return false;
  });
}

VideoIndex.prototype.VideoClick = function(event)
{
  var self = this;
  var href = $(event.currentTarget).attr('href');
  $('#video-player').modal({
    overlayClose: true,
		position: ["15%"],
		overlayId: 'video-player-overlay',
		containerId: 'video-player-container',
		onShow: function (dialog) {
			var modal = this;

      $.post(href, function(data){
        self.ShowVideo(data);
      }, 'json');
		}
	});
}

VideoIndex.prototype.ShowVideo = function(data)
{
  var url = data['video'];
  var params = { allowScriptAccess: "always",
    menu: false, allowFullScreen: true};
  var atts = { id: "myytplayer" };
  swfobject.embedSWF(url + "?enablejsapi=1&playerapiid=ytplayer&version=3",
      "ytapiplayer", "640", "480", "8", null, null, params, atts);
}