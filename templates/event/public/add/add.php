<script type="text/javascript">
  $(document).ready(function(){
    if ($('#one_day').prop('checked'))
    {
      $('#second_day').attr('disabled', 'disabled');
    }
    $('#one_day').bind('change', function(event){
      if ($(event.currentTarget).prop('checked'))
      {
        $('#second_day').attr('disabled', 'disabled');
      }
      else
      {
        $('#second_day').attr('disabled', false);
      }
    });

    if ($('#no_site').prop('checked'))
    {
      $('input.site').attr('disabled', 'disabled');
    }
    $('#no_site').bind('change', function(event){
      if ($(event.currentTarget).prop('checked'))
      {
        $('input.site').attr('disabled', 'disabled');
      }
      else
      {
        $('input.site').attr('disabled', false);
      }
    });

    $.datepicker.setDefaults($.datepicker.regional['ru']);
    $( "#first_day" ).datepicker({changeMonth: true, changeYear: true});
    $( "#second_day" ).datepicker({changeMonth: true, changeYear: true});
  });
</script>
<div class="content">

  <form id="add_event" action="" method="post">
    <div class="vacancies add-vacancy">
      <!-- <div class="field_filter">
       <h3>Фильтр вакансий</h3>
     </div> -->

      <h2>Добавление события</h2>
      <p>Сервис ROCID://Календарь предназначен для организаторов конференций, семинаров, лекций, выставок и других мероприятий, посвященных IT-тематике, Интернету, технологиям и медиа.</p>
      <p>С помощью нашего календаря вы можете не только анонсировать событие, но и организовать регистрацию на мероприятие, а также приём оплаты за участие. Сегодня на портале ROCID:// зарегистрированно почти 100 тысяч профессионалов IT и медиа, которых может заинтересовать ваш проект. </p>
      <p>Пожалуйста заполните все поля формы ниже и наши сотрудники обязательно свяжутся с вами. </p>



<div class="cfldset">
<h3>Контактное лицо:</h3>


<label>ФИО:</label>
<p><input name="data[fio]" type="text" autocomplete="off" value="<?=$this->Data['fio']?>"></p>

<label>Контактный телефон:</label>
<p><input name="data[phone]" type="text" autocomplete="off" value="<?=$this->Data['phone']?>"></p>

<label>Контактный email:</label>
<p><input name="data[email]" type="text" autocomplete="off" value="<?=$this->Data['email']?>"></p>


<!-- end cfldset -->
</div>





<div class="cfldset">
<h3>Мероприятие:</h3>

<label>Название мероприятия:</label>
<p><input name="data[title]" type="text" autocomplete="off" value="<?=$this->Data['title']?>"></p>

<label>Место проведения:</label>
<p><input name="data[place]" type="text" autocomplete="off" value="<?=$this->Data['place']?>"></p>


<p>Дата проведения:</p>

<table class="date">
<tr>
	<td><input id="first_day" name="data[date_start]" type="text" autocomplete="off" value="<?=$this->Data['date_start']?>">
<label>начало</label></td>
	<td><input id="second_day" name="data[date_end]" type="text" autocomplete="off" value="<?=$this->Data['date_end']?>">
<label>завершение</label></td>
	<td style="vertical-align: top !important; padding-top: 4px;"><label><input id="one_day" type="checkbox" name="data[one_day]" value="1"
                    <?=$this->Data['one_day']?'checked="checked"':'';?> >один день</label></td>
</tr>
</table>



<label>Сайт мероприятия:</label>


<p> <input class="site" name="data[site]" type="text" autocomplete="off" value="<?=$this->Data['site']?>"></p>
<p class="chbxs"><label><input id="no_site" type="checkbox" name="data[no_site]" value="1"
                                  <?=$this->Data['no_site']?'checked="checked"':'';?> >нет сайта</label></p>
								  
								  
								  
<label>Краткое описание:</label>
<p><textarea name="data[info]" rows="3" cols="80"><?=$this->Data['info']?></textarea></p>


<label>Подробное описание:</label>
<p><textarea name="data[full_info]" rows="3" cols="80"><?=$this->Data['full_info']?></textarea></p>


<p><label>Выберите необходимые вашему мероприятию опции:</label></p>
<p class="chbxs"> <label><input type="checkbox" name="data[options][o1]" value="размещение информации в календаре"
                <?=isset($this->Data['options']['o1'])?'checked="checked"':'';?> >размещение информации в календаре</label><br />
            <label><input type="checkbox" name="data[options][o2]" value="регистрация участников"
                <?=isset($this->Data['options']['o2'])?'checked="checked"':'';?> >регистрация участников</label><br />
            <label><input type="checkbox" name="data[options][o3]" value="прием оплаты"
                <?=isset($this->Data['options']['o3'])?'checked="checked"':'';?> >прием оплаты</label><br />
            <label><input type="checkbox" name="data[options][o4]" value="реклама и маркетинг"
                <?=isset($this->Data['options']['o4'])?'checked="checked"':'';?> >реклама и маркетинг</label><br /></p>
				
				<!-- end cfldset -->
				</div>



      <div class="response">
        <a href="" onclick="$('#add_event')[0].submit(); return false;">Отправить</a>
      </div>

    </div>

    <div id="sidebar" class="sidebar sidebarcomp">
      <?php echo $this->Banner;?>
    </div>
  </form>

</div>