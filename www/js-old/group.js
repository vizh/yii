function getReplyForm(id, show) {
  $('comment-reply-form-' + id).setStyle('display', (show) ? 'block' : 'none');
  $('comment-reply-button-' + id).setStyle('display', (!show) ? 'block' : 'none');
}

function getFileForm(id, show){
  $("comment-reply-file-" + id).setStyle('display', (show) ? 'block' : 'none');
}