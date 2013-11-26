$(function () {
  CKEDITOR.on('instanceLoaded', function(e) {
    e.editor.resize(700, 350)
  });
});