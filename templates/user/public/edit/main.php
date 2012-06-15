<div id="edit_main" class="edit-block edit-block-active">
  <dl>
    <dt>Пол:</dt>
    <dd><select name="gender" id="gender">
      <option value="0" <?=$this->Sex == 0 ? 'selected' : ''?> >Не указан</option>
      <option value="1" <?=$this->Sex == 1 ? 'selected' : ''?> >Мужской</option>
      <option value="2" <?=$this->Sex == 2 ? 'selected' : ''?> >Женский</option>
    </select></dd>
  </dl>
  <dl class="separator">
    <dt>&nbsp;</dt>
    <dd>&nbsp;</dd>
  </dl>
  <dl>
    <dt>Фамилия:</dt>
    <dd><input id="lastname" type="text" name="lastname" value="<?=htmlspecialchars($this->LastName);?>" size="40"> <span class="required">(обязательное поле)</span></dd>
  </dl>
  <dl>
    <dt>Имя:</dt>
    <dd><input id="name" type="text" name="name" value="<?=htmlspecialchars($this->FirstName);?>" size="40"> <span class="required">(обязательное поле)</span></dd>
  </dl>
  <dl>
    <dt>Отчество:</dt>
    <dd>
        <input id="fathername" type="text" name="fathername" value="<?=htmlspecialchars($this->FatherName);?>" size="40">
        <label class="gray">
            <input type="checkbox" name="hidefathername" value="1" <?php if ($this->HideFatherName == 1):?>checked="checked"<?php endif;?>/> <span>не отображать в профиле</span>
        </label>
    </dd>
  </dl>
  <dl class="separator">
    <dt>&nbsp;</dt>
    <dd>&nbsp;</dd>
  </dl>
  <dl>
    <dt>Дата рождения:</dt>
    <dd>
      <select name="bday" id="bday">
        <option value="0">- День -</option>
        <?php
        for ($i=1;$i<=31;$i++)
        {
        ?>
        <option value="<?=$i;?>" <?= $i==$this->Birthday['day']? 'selected' : '';?>><?=$i;?></option>
        <?php
        }
        ?>
      </select>
      <select name="bmonth" id="bmonth">
        <option value="0">- Месяц -</option>
        <?php
    $months = $this->words['calendar']['months'][1];
    for ($i=1;$i<=12;$i++)
    {
      ?>
      <option value="<?=$i;?>" <?= $i==$this->Birthday['month']? 'selected' : '';?>><?=$months[$i];?></option>
      <?php
    }
      ?>
      </select>
      <!--<input type="text" name="byear" id="byear"
             value="<?php !empty($this->Birthday['year']) ? $this->Birthday['year']:''; ?>">-->
      <select name="byear" id="byear">
        <option value="0">- Год -</option>
        <?php
        $maxYear = intval(date('Y')) - 10;
    for ($i=1930;$i<=$maxYear;$i++)
    {
      ?>
      <option value="<?=$i;?>" <?= $i==$this->Birthday['year']? 'selected' : '';?>><?=$i;?></option>
      <?php
    }
      ?>
      </select>
        <label class="gray">
            <input type="checkbox" name="hidebyear" value="1" <?php if ($this->HideBirthdayYear == 1):?>checked="checked"<?php endif;?>/> <span>скрывать год рождения</span>
        </label>
    </dd>
  </dl>
  <dl class="separator">
    <dt>&nbsp;</dt>
    <dd>&nbsp;</dd>
  </dl>
  <dl>
    <dt>&nbsp;</dt>
    <dd><a id="save_main" class="save_settings" href="">Сохранить изменения</a></dd>
  </dl>
  <div id="loadwait" class="ajax-loader" ></div>
  <div id="loadsuccess" class="user_save_notice green">Данные успешно сохранены!</div>
  <div id="loadfailure" class="user_save_notice red">Ошибка сохранения! Обязательные параметры не заданы!</div>
</div>