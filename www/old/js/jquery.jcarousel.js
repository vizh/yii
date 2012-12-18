	$(document).ready(function() {
		$('#carousel-big, #carousel-small').jcarousel({
			wrap: 'last',
			scroll: 1,
			buttonNextHTML: '<div class="next"><a href="javascript:void(0)"></a></div>',
			buttonPrevHTML: '<div class="prev"><a href="javascript:void(0)"></a></div>'
		});
		
		$('.jcarousel-item').hover(
			function(){
				$(this).addClass('setUrl');
			},
			function(){
				$(this).removeClass('setUrl');
			}
		);

    var items = $('#news-gallery div.fixbody');
    var maxHeight = 0;
    items.each(function()
    {
      if (maxHeight < $(this).height())
      {
        maxHeight = $(this).height();
      }
    });
//    for (var i=0; i < items.length; i++)
//    {
//      if (maxHeight < items[i].height())
//      {
//        maxHeight = items[i].height();
//      }
//    }
    items.height(maxHeight);
	});