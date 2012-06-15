var News = {
	
	start: function() {
		if ($('comments')) News.getComments();
	},
	
	editPost: function (postId) {
		var complete = function () {
			tinyMCE.init({
				// General options
				mode : "textareas",
				theme : "advanced",
				plugins : "safari,pagebreak,style,layer,table,advhr,advimage,advlink,searchreplace,print,contextmenu,paste,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups",

				// Theme options
				theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontsizeselect",
				theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,",
				theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,advhr,|,print,fullscreen",
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
				theme_advanced_statusbar_location : "bottom",
				theme_advanced_resizing : true,
			});
		}
		wu.Ajax('/system/modules/news/remoteEditPost.php?id=' + postId, 'postText', true, complete);
	},
	
	deletePost: function (postId) {
		if (confirm('Вы уверены, что хотите удалить запись?')) {
			window.location = '/news/manage/?type=deletePost&id=' + postId;
		}
	},

	getComments: function () {
		var postId = $('comments').getProperty('name');
		$('comments').empty().setHTML('<i>Терпение! Идет загрузка комментариев...</i>');
		wu.Ajax('/system/modules/news/remoteGetComments.php?id=' + postId, 'comments', true, '');
	},
	
	saveComment: function (commentId) {
		var log = (commentId > 0) ? new Element('div').injectAfter($('comment' + commentId)).addClass('ajax-loading') : new Element('div').injectInside($('comments')).addClass('ajax-loading');
		$('saveCommentForm').send({
			update: log,
			onComplete: function() {
				log.removeClass('ajax-loading');
				if (commentId > 0) $('comment' + commentId).remove();
				if ($('commentEmpty')) $('commentEmpty').remove();
			}
		});
	},
	
	editComment: function (commentId) {
		wu.Ajax('/system/modules/news/remoteEditComment.php?id=' + commentId, 'commentText' + commentId, true, '');
	},
	
	deleteComment: function (commentId) {
		if (confirm('Вы уверены, что хотите удалить комментарий?')) {
			wu.Ajax('/news/manage/?type=deleteComment&id=' + commentId, 'comment' + commentId, true, '');
		}
	}

};

window.addEvent('domready', function() {
	News.start();
});