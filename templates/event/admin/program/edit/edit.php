<section class="main edit programedit">
  <h2>Редактировать пункт программы</h2>


  <form id="form_editprogram" enctype="multipart/form-data" action="" method="post">

    <aside class="col-l">
      <input type="text" class="title bordered" maxlength="250" name="data[ProgramTitle]"
             value="<?=htmlspecialchars($this->ProgramTitle);?>" placeholder="Название">

      <div class="main-block text bordered">
        <h4>Описание</h4>
        <div class="textarea-container">
          <textarea class="quote" name="data[Description]"><?=$this->Description;?></textarea>
        </div>
      </div>

      <div class="main-block text bordered">
        <h4>Комментарий</h4>
        <div class="textarea-container">
          <textarea class="quote" name="data[Comment]"><?=$this->Comment;?></textarea>
        </div>
      </div>

      <div class="main-block text bordered">
        <h4>Аудитория <small>(на которую меропрятие рассчитано)</small></h4>
        <div class="textarea-container">
          <textarea class="quote" name="data[Audience]"><?=$this->Audience;?></textarea>
        </div>
      </div>

      <div class="main-block text bordered">
        <h4>Темы рубрикатора
          <small>(каждая тема на новой строке)</small></h4>
        <div class="textarea-container">
          <textarea class="quote" name="data[Rubricator]"><?=$this->Rubricator;?></textarea>
        </div>
      </div>

      <div class="main-block text bordered">
        <h4>Партнёры</h4>
        <div class="textarea-container">
          <textarea class="quote" name="data[Partners]"><?=$this->Partners;?></textarea>
        </div>
      </div>

      <div class="main-block bordered">
        <h4>Материалы</h4>
        <div class="general-container">
          <h5>Ссылка на фоторепортаж</h5>
          <input class="bordered large" type="text" name="data[LinkPhoto]" value="<?=$this->LinkPhoto;?>" placeholder="Введите ссылку на фоторепортаж">

          <h5>Ссылка на видеорепортаж</h5>
          <input class="bordered large" type="text" name="data[LinkVideo]" value="<?=$this->LinkVideo;?>" placeholder="Введите ссылку на видеорепортаж">

          <h5>Ссылка на стенограмму</h5>
          <input class="bordered large" type="text" name="data[LinkShorthand]" value="<?=$this->LinkShorthand;?>" placeholder="Введите ссылку на стенограмму">

          <h5>Ссылка на аудиозапись</h5>
          <input class="bordered large" type="text" name="data[LinkAudio]" value="<?=$this->LinkAudio;?>" placeholder="Введите ссылку на аудиозапись">
        </div>
      </div>
    </aside>

    <aside class="col-r">
      <div class="bordered sidebar">
        <h4>Опубликовать</h4>
        <a id="button_save" class="button positive save big" onclick="$('#form_editprogram')[0].submit(); return false;"><span class="icon check"></span>Сохранить</a>
        <a class="button preview big" href="<?=RouteRegistry::GetAdminUrl('event', 'program', 'list', array('eventId' => $this->EventId));?>">Вернуться</a>
        <div class="cl"></div>

          <a class="button publish big" href="<?=RouteRegistry::GetAdminUrl('event', 'program', 'users', array('id' => $this->EventProgramId));?>">Редактировать участников</a>


        <div class="cl"></div>

      </div>
      <div class="bordered sidebar">
        <h4>Дата и время</h4>
        <div class="pub-date bordered-input sub-element">
          <h5>Дата пункта программы</h5>
          <select name="data[Date]" class="bordered span3">
            <?for ($i=$this->EventDateStart; $i<=$this->EventDateEnd; $i+= 24*60*60):?>
            <option value="<?=date('Y-m-d', $i);?>" <?=$this->Date == date('Y-m-d', $i) ? 'selected="selected"' : '';?>><?=strftime('%d %B', $i);?></option>
            <?endfor;?>
          </select>

          <h5>Время начала</h5>
          <input type="text" value="<?=$this->TimeStart['hours'];?>" maxlength="2" size="2" name="data[TimeStartHour]" placeholder="ЧЧ" class="span1">
          <input type="text" value="<?=$this->TimeStart['minutes'] < 10 ? '0' .$this->TimeStart['minutes'] : $this->TimeStart['minutes'] ;?>" maxlength="2" size="2" name="data[TimeStartMin]" placeholder="ММ" class="span1">

          <h5>Время окончания</h5>
          <input type="text" value="<?=$this->TimeEnd['hours'];?>" maxlength="2" size="2" name="data[TimeEndtHour]" placeholder="ЧЧ" class="span1">
          <input type="text" value="<?=$this->TimeEnd['minutes'] < 10 ? '0' . $this->TimeEnd['minutes'] : $this->TimeEnd['minutes'];?>" maxlength="2" size="2" name="data[TimeEndMin]" placeholder="ММ" class="span1">

        </div>
        <div class="cl"></div>
      </div>
      <div class="bordered sidebar">
        <h4>Настройки</h4>
        <div class="bordered-input sub-element">
          <h5>Тип мероприятия</h5>
          <ul class="inputs-list">
            <li><label><input type="radio" name="data[Type]" <?=$this->Type == EventProgram::ProgramTypeFull ? 'checked="checked"' : '';?> value="<?=EventProgram::ProgramTypeFull;?>">Кликабельное (в виде ссылки)</label></li>
            <li><label><input type="radio" name="data[Type]" <?=$this->Type != EventProgram::ProgramTypeFull ? 'checked="checked"' : '';?> value="<?=EventProgram::ProgramTypeShort;?>">Некликабельное</label></li>
          </ul>

          <h5>Тип-аббревиатура</h5>
          <input type="text" name="data[Abbr]" value="<?=$this->Abbr;?>" class="span4">
          <ul class="inputs-list">
            <li>
              <label><input type="checkbox" name="data[Fill]" value="fill" <?=$this->Fill == 1 ? 'checked="checked"' : '';?>>выделить</label>
            </li>
          </ul>

          <h5>Место проведения</h5>
          <input class="large" type="text" name="data[Place]" value="<?=$this->Place;?>">
        </div>
      </div>

      <div class="bordered sidebar">
        <h4>Доступ к докладам</h4>
        <div class="bordered-input sub-element">
          <p>Выберите роли участников, имеющих доступ к докладам. Для <strong>общего доступа</strong> оставьте поля пустыми.</p>
          <ul class="inputs-list">
            <?foreach ($this->EventUserRoles as $eventUser):?>
            <li><label><input type="checkbox" name="data[Access][]" <?=in_array($eventUser->EventRole->RoleId, $this->Access) ? 'checked="checked"' : '';?> value="<?=$eventUser->EventRole->RoleId;?>"><?=$eventUser->EventRole->Name;?></label></li>
            <?endforeach;?>
          </ul>
        </div>
      </div>



    </aside>
  </form>
</section>
 
