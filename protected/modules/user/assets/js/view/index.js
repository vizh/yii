$(function () {
  /* USER ACCOUNT */
  /* User account -> Participated */
  var participatedYearSelector = $('.b-participated .title form select');
  participatedYearSelector.change(function(e) {
    var year = $(e.currentTarget).val();
    var figures = $('.b-participated .row figure');
    if (year == 0) {
      figures.show();
    }
    else {
      figures.hide();
      figures.filter('[data-year="'+year+'"]').show();
    }
  }).find('option:eq(1)').attr('selected', 'selected');
  participatedYearSelector.trigger('change');
  
  $('.b-participated .all a').click(function () {
    participatedYearSelector.val(0).trigger('change');
    return false;
  });
});