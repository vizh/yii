$(document).ready(function(){
  // Раскрыть список прежних мест работы
  $('a#expand_work').bind('click', function (){
    $("tbody[class='workList tbl-invisible']").slideDown('slow');//css('display', 'block');
    
    $(this).css('display', 'none');
    $('a#collapse_work').css('display', 'block');
    
    return false;
  });

  // Свернуть список прежних мест работы
  $('a#collapse_work').bind('click', function (){
    $("tbody[class='workList tbl-invisible']").slideUp('slow', function() {
      $('a#collapse_work').css('display', 'none');
      $('a#expand_work').css('display', 'block');
    });
    
    return false;
  });




  if ($('table.user-commission').length > 0) {
    // Раскрыть список коммиссий
    $('a#expand_commission').bind('click', function () {
      $('tbody[class="commissionList tbl-invisible"]').slideDown('slow');
      $(this).css('display', 'none');
      $('a#collapse_commission').css('display', 'block');
      return false;
    });
    
    //Свернуть список коммисий
    $('a#collapse_commission').bind('click', function (){
      $("tbody[class='commissionList tbl-invisible']").slideUp('slow', function() {
        $('a#collapse_commission').css('display', 'none');
        $('a#expand_commission').css('display', 'block');
      });
      return false;
    });
  }
  
  
  

	// Раскрыть список мероприятий
	$('a#expand_event').bind('click', function (){
		$("tbody[class='eventList tbl-invisible']").slideDown('slow');//css('display', 'block');
		
		$(this).css('display', 'none');
		$('a#collapse_event').css('display', 'block');
		
		return false;
	});

	// Свернуть список мероприятий
	$('a#collapse_event').bind('click', function (){
    $("tbody[class='eventList tbl-invisible']").slideUp('slow', function() {
      $('a#collapse_event').css('display', 'none');
      $('a#expand_event').css('display', 'block');
    });
	
		return false;
	});

});
