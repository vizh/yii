<div id="edit_work" class="edit-block">
  <dl>
    <dt>&nbsp;</dt>
    <dd><a id="add_new_job" class="user_edit" href="#addjob">Добавить место работы</a></dd>
  </dl>

  <!-- Опыт работы -->
  <div id="new_job">
    <?php
      $workTexts = $this->words['edituser'];
    ?>
    <dl>
      <dt>Компания:</dt>
      <dd>
        <input type="text" name="company" value="" placeholder="<?=$workTexts['companytext'];?>" size="53">
        <span class="required">(обязательное поле)</span>
      </dd>
    </dl>
    <dl>
      <dt>Должность:</dt>
      <dd>
        <input type="text" name="position" value="" placeholder="<?=$workTexts['positiontext'];?>" size="53">
        <span class="required">(обязательное поле)</span>
      </dd>
    </dl>
    <dl>
      <dt>Период работы:</dt>
      <dd>
        <select name="start_month" class="start_month">
        <option value="0" selected>месяц</option>
        <?
        $months = $this->words['calendar']['months'][1];
        for($i=1;$i<=12;$i++):?>
          <option value="<?=$i;?>"><?=$months[$i];?></option>
        <?endfor;?>
      </select>
        <input type="text" name="start_year" value="" placeholder="<?=$workTexts['yeartext'];?>" class="start_year" size="4">

        — <select name="end_month" class="end_month">
        <option value="0">н. в.</option>
        <?
        $months = $this->words['calendar']['months'][1];
        for($i=1;$i<=12;$i++):?>
          <option value="<?=$i;?>"><?=$months[$i];?></option>
        <?endfor;?>
      </select> 

        <input type="text" name="end_year" placeholder="<?=$workTexts['yeartext'];?>" class="end_year" size="4" disabled="disabled">
        <span class="required">(обязательное поле)</span></dd>
    </dl>
    <dl>
      <dt>Приоритеты:</dt>
      <dd><label><input type="radio" name="work_priority" checked value=""> основное место работы</label></dd>
    </dl>
    <dl>
      <dt>&nbsp;</dt>
      <dd><a href="#deletejob" class="delete_work">удалить место работы</a></dd>
  </dl>
  </div>
  
  <div id="jobs_start" class="lseparator">
    &nbsp;
  </div>

  <?php echo $this->WorkCollection; ?>

  <dl class="separator">
    <dt>&nbsp;</dt>
    <dd>&nbsp;</dd>
  </dl>
  <dl>
    <dt>&nbsp;</dt>
    <dd><a id="save_work" class="save_settings" href="#">Сохранить изменения</a></dd>
  </dl>
</div>
