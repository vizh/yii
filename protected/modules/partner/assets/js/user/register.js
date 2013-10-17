$(function () {
  $('#EmailRandom').on('change', function(e){
    var target = $(e.currentTarget);
    $('#Email').prop('disabled', target.prop('checked'));
  });
});