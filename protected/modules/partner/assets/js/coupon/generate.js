$(function(){
  $('.coupon-type input[type="radio"]').on('change', function(e){
    var target = $(e.currentTarget);
    $('[data-coupon-type]').hide(0);
    $('[data-coupon-type='+target.val()+']').show(0);
  });

  $('.coupon-type input[type="radio"]:checked').trigger('change');
});