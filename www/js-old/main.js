/*
|---------------------------------------------------------------
| œ–Œ‘¿…À œŒÀ‹«Œ¬¿“≈Àﬂ
|---------------------------------------------------------------
*/
function getProjCache(element, userId, projId, roleId) {

  new Ajax('/system/remote/get.proj.php?user_id=' + userId + '&proj_id=' + projId + '&role_id=' + roleId, {
//	new Ajax('/system/remote/get.proj.cache.php?id=' + userId + '&proj=' + projId, {
		method: 'get',
		update: element,
		onComplete: function() {
			element.removeClass('projLink');
		}
	}).request();
	
}

/*
|---------------------------------
| rocID [‘Œ“Œ]
|---------------------------------
	œÓÒÚ‡ÌË˜Ì‡ˇ Ì‡‚Ë„‡ˆËˇ
*/
function photoPageListing(maxOnPage, page, uri) {

	new Ajax('/system/remote/photo.pagelisting.php?max_on_page=' + maxOnPage + '&page=' + page + '&uri=' + uri, {
		method: 'get',
		update: 'photoConteiner'
	}).request();

}

function contentUpdate(uri, place) {

  new Ajax(uri, {
    method: 'get',
    update: place
  }).request();

}

function contentUpdateLoading(url, place, loading) {
  var place = $(place).addClass('ajax-loading');
  new Ajax(url, {
    method: 'get',
    update: place,
    onComplete: function (response) {
      if (loading) place.removeClass('ajax-loading');
    }
  }).request();
}
/****************************************************************/

window.addEvent('domready', function() {

	/*
	|---------------------------------------------------------------
	| –≈√»—“–¿÷»ﬂ
	|---------------------------------------------------------------
	*/
	if ($('start_registration')) {
		if ($('start_registration').innerHTML != undefined) {
			$('start_registration').addEvent('click', function(e) {
				document.location="/profile.php?show=registration";
			});
		}
	}

});