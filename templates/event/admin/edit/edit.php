<script type="text/javascript">
  tinyMCE.init({
    theme   : "advanced",
    mode    : "textareas",
    theme_advanced_font_sizes : "20px",
    theme_advanced_buttons1   : "bold,italic,underline,strikethrough",
    theme_advanced_buttons2   : "",
    theme_advanced_buttons3   : ""
  });
</script>

<section class="main edit eventedit">
  <h2>Редактировать мероприятие</h2>
  <form id="form_editevent" enctype="multipart/form-data" action="" method="post">

    <aside class="col-l">
      <input type="text" class="title bordered" maxlength="250" name="data[Name]"
             value="<?=htmlspecialchars($this->Name);?>" placeholder="Название">
      <div class="aftertitle">
        <strong>ID мероприятия:</strong>
        <input autocomplete="off" class="middle bordered" type="text" maxlength="250" name="data[IdName]" value="<?=$this->IdName;?>">
      </div>
      <div class="aftertitle">
        <strong>Краткое название:</strong>
        <input autocomplete="off" class="middle bordered" type="text" maxlength="250" name="data[ShortName]" value="<?=$this->ShortName;?>">
      </div>

      <div class="main-block text bordered">
        <h4>Краткое описание</h4>
        <div class="textarea-container">
          <textarea class="quote" name="data[Info]"><?=$this->Info;?></textarea>
        </div>
      </div>

      <div class="main-block text bordered">
        <h4>Полное описание</h4>
        <div class="textarea-container">
          <textarea name="data[FullInfo]" id="edit"><?=$this->FullInfo;?></textarea>
        </div>
      </div>

      <div class="main-block bordered">
        <h4>Материалы</h4>
        <div class="general-container">
          <h5>Сайт мероприятия</h5>
          <input class="bordered large" type="text" name="data[Url]" value="<?=htmlspecialchars($this->Url);?>" placeholder="Введите ссылку на сайт мероприятия">

          <h5>Ссылка на регистрацию</h5>
          <input class="bordered large" type="text" name="data[UrlRegistration]" value="<?=htmlspecialchars($this->UrlRegistration);?>" placeholder="Введите ссылку на регистрацию">

          <h5>Ссылка на программу</h5>
          <input class="bordered large" type="text" name="data[UrlProgram]" value="<?=htmlspecialchars($this->UrlProgram);?>" placeholder="Введите ссылку на программу">

        </div>
      </div>

      <div class="main-block bordered">
        <h4>Материалы</h4>
        <div class="general-container">
          <h5>Логотип в список мероприятий <small>(только PNG)</small></h5>
          <input type="file" name="logo">
          <div class="image-desc">
            <br>
            <img src="<?=$this->Logo;?>">
            <br>
          </div>

          <h5>Логотип в профайл пользователя <small>(только PNG)</small></h5>
          <input type="file" name="minilogo">
          <div class="image-desc">
            <br>
            <img src="<?=$this->MiniLogo;?>">
            <br>
          </div>

        </div>
      </div>
    </aside>

    <aside class="col-r">
      <div class="pub bordered sidebar">
        <h4>Опубликовать</h4>
        <a id="button_save" class="button positive save big" onclick="$('#form_editevent')[0].submit(); return false;"><span class="icon check"></span>Сохранить</a>
        <!--<a class="button preview big" href="<?=RouteRegistry::GetAdminUrl('event', 'program', 'list', array('eventId' => $this->EventId));?>">Вернуться</a>-->
        <div class="cl"></div>

      </div>
      <div class="pub bordered sidebar">
        <h4>Дата и место проведения</h4>

        <div class="pub-date bordered-input sub-element">
          <h5>Начало</h5>
          <input type="text" value="<?=!empty($this->DateStart['day'])?$this->DateStart['day']:'';?>" maxlength="2" size="2" name="data[DateStartDay]" placeholder="ДД" class="span1">
          <select name="data[DateStartMonth]" class="bordered span2">
            <?foreach ($this->words['calendar']['months'][1] as $key => $value ):?>
            <option value="<?=$key?>" <?=$this->DateStart['month'] == $key ? 'selected="selected"' : '';?>  ><?=$value?></option>
            <?endforeach;?>
          </select>
          <input type="text" value="<?=!empty($this->DateStart['year'])?$this->DateStart['year']:'';?>" maxlength="4" size="4" name="data[DateStartYear]" placeholder="ГГГГ" class="span1">
        </div>

        <div class="pub-date bordered-input sub-element">
          <h5>Окончание</h5>
          <input type="text" value="<?=!empty($this->DateEnd['day'])?$this->DateEnd['day']:'';?>" maxlength="2" size="2" name="data[DateEndDay]" placeholder="ДД" class="span1">
          <select name="data[DateEndMonth]" class="bordered span2">
            <?foreach ($this->words['calendar']['months'][1] as $key => $value ):?>
            <option value="<?=$key?>" <?=$this->DateEnd['month'] == $key ? 'selected="selected"' : '';?>  ><?=$value?></option>
            <?endforeach;?>
          </select>
          <input type="text" value="<?=!empty($this->DateEnd['year'])?$this->DateEnd['year']:'';?>" maxlength="4" size="4" name="data[DateEndYear]" placeholder="ГГГГ" class="span1">
        </div>

        <div class="bordered-input sub-element">
          <h5>Место проведения</h5>
          <input class="large" type="text" name="data[Place]" value="<?=htmlspecialchars($this->Place);?>">
        </div>

        <div class="form-stacked bordered-input sub-element">
          <h3>Точный адрес</h3>
          <fieldset>

            <div class="clearfix">
              <label for="country">Страна</label>
              <div class="input">
                <select id="country" name="data[Address][]">
                  <option>1</option>
                </select>
              </div>
            </div>
            <div class="clearfix">
              <label for="region">Регион</label>
              <div class="input">
                <select id="region" name="data[Address][]">
                  <option>1</option>
                </select>
              </div>
            </div>
            <div class="clearfix">
              <label for="city">Город</label>
              <div class="input">
                <select id="city" name="data[Address][]">
                  <option>1</option>
                </select>
              </div>
            </div>

            <div class="clearfix">
              <label for="data_Address_">Почтовый индекс</label>
              <div class="input">
                <input id="data_Address_" type="text" name="data[Address][]">
              </div>
            </div>

            <div class="clearfix">
              <label for="data_Address_">Улица</label>
              <div class="input">
                <input id="data_Address_" type="text" name="data[Address][]">
              </div>
            </div>

            <div class="clearfix">
              <label for="data_Address_">Дом</label>
              <div class="input">
                <input id="data_Address_" type="text" name="data[Address][]">
              </div>
            </div>

            <div class="clearfix">
              <label for="data_Address_">Строение</label>
              <div class="input">
                <input id="data_Address_" type="text" name="data[Address][]">
              </div>
            </div>

            <div class="clearfix">
              <label for="data_Address_">Корпус</label>
              <div class="input">
                <input id="data_Address_" type="text" name="data[Address][]">
              </div>
            </div>
          </fieldset>
          <input class="large" type="text" name="data[Place]" value="<?=htmlspecialchars($this->Place);?>">
        </div>

        <div class="cl"></div>
      </div>
      <div class="pub bordered sidebar">
        <h4>Настройки</h4>
        <div class="bordered-input sub-element">

          <h5>Видимость</h5>
          <ul class="inputs-list">
            <li>
          <label>
            <input type="checkbox" name="data[Visible]" value="visible" <?=$this->Visible == Event::EventVisibleY ? 'checked="checked"' : '';?>>
            <strong>Отображать в списке мероприятий</strong>
          </label>
              </li>
            </ul>

          <h5>Тип мероприятия</h5>
          <ul class="inputs-list">
            <li><label><input type="radio" name="data[Type]" <?=$this->Type != Event::EventTypePartner ? 'checked="checked"' : '';?> value="<?=Event::EventTypeOwn;?>">Собственное</label></li>
            <li><label><input type="radio" name="data[Type]" <?=$this->Type == Event::EventTypePartner ? 'checked="checked"' : '';?> value="<?=Event::EventTypePartner;?>">Партнёрское</label></li>
          </ul>

        </div>
      </div>
    </aside>
  </form>

</section>
