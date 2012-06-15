<div class="content">
  <?php echo $this->Submenu;?>

  <form id="add_vacancy" action="" method="post">
    <div class="vacancies add-vacancy">
      <!-- <div class="field_filter">
       <h3>Фильтр вакансий</h3>
     </div> -->

      <h2>Друзья.</h2>
      <p>Мы публикуем ваши вакансии совершенно бесплатно, если они
        соответствуют следующим требованиям:</p>
      <ol>
        <li>Ваша вакансия про рунет и digital</li>
        <li>Вы честно указали зарплату по этой позиции</li>
        <li>Вы указали, на какой пул кандидатов рассчитана ваша вакансия:
          middle-top management или студенты/выпускники ВУЗов.</li>
      </ol>
      <p>Обратите внимание: эти три пункта являются обязательными к соблюдению.
        PRUFFI имеет право без уведомления по собственному усмотрению удалить
        полностью размещенную пользователем вакансию, в частности, в случае
        размещения пользователем информации о вакансии, не соответствующей
        вышеперечисленным требованиям.</p>

        
<div class="cfldset">

<label>Название вакансии:</label>
<p><input name="data[title]" type="text" autocomplete="off" value="<?=$this->Data['title']?>"></p>


<label>Компания:</label>
<p><input name="data[company]" type="text" autocomplete="off" value="<?=$this->Data['company']?>"></p>

<label>Контактный email:</label>
<p><input name="data[email]" type="text" autocomplete="off" value="<?=$this->Data['email']?>"></p>


<label>Заработная плата:</label>
<table class="date">
              <tr>
                <td>От</td>
                <td><input name="data[salary_min]" type="text" autocomplete="off" value="<?=$this->Data['salary_min']?>"> </td>
                <td style="padding-right: 20px;">тыс. руб</td>
                <td>до</td>
                <td><input name="data[salary_max]" type="text" autocomplete="off" value="<?=$this->Data['salary_max']?>"></td>
                <td>тыс. руб</td>
              </tr>
            </table>
			
	<label>Обязанности:</label>
<p><textarea name="data[responsibility]" rows="3" cols="80"><?=$this->Data['responsibility']?></textarea></p>


<label>Требования к кандидату:</label>
<p><textarea name="data[requirements]" rows="3" cols="80"><?=$this->Data['responsibility']?></textarea></p>
      

	  <!-- end cfldset -->
</div>


      <div class="response">
        <a href="" onclick="$('#add_vacancy')[0].submit(); return false;">Отправить</a>
      </div>

    </div>

    <div id="sidebar" class="sidebar sidebarcomp">
      <?php echo $this->PartnerBanner;?>
      <?php echo $this->Banner;?>
    </div>
  </form>

</div>
 
