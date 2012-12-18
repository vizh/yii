$(function(){
  $('input[name="Questions[113][]"]').bind('click', function(){
    var checked = $('input[name="Questions[113][]"]:checked');
    if (checked.length > 2)
    {
      alert('Вы не можете выбрать больше двух направлений');
      return false;
    }
  });
});