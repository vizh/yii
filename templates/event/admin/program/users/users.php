<section class="main edit programusers">
  <h2>Редактировать участников пункта программы</h2>

  <table class="persons">
    <?php echo $this->Users;?>
  </table>


</section>
<section class="main edit programusers">
  <a id="button_add" class="button positive" href=""><span class="plus icon"></span>Добавить пользователя</a>
  <a class="button" href="<?=RouteRegistry::GetAdminUrl('event', 'program', 'edit', array('id' => $this->EventProgramId));?>">Редактировать пункт программы</a>
  <a class="button preview" href="<?=RouteRegistry::GetAdminUrl('event', 'program', 'list', array('eventId' => $this->EventId));?>">Вернуться к программе</a>
</section>

<section id="add_form_container" class="main">
  <form id="user_edit" class="form-stacked" style="display: none;">
    <input type="hidden" name="EventProgramId" value="<?=$this->EventProgramId;?>">
    <input type="hidden" name="LinkId">
    <fieldset>
      <legend>Редактирование пользователя</legend>
      <div class="clearfix">
        <label for="NameOrRocid">Фамилия и Имя <small>или</small> rocID</label>
        <div class="input">
          <input type="hidden" name="RocId">
          <input type="text" name="NameOrRocid" id="NameOrRocid" class="span7">
          <span id="span_rocid" class="help-inline"></span>
        <span class="help-block">
          <strong>Заметка:</strong> Просто начните набирать фамилию и имя или rocID пользователя. Здесь автоматически будут отображаться результаты поиска.
        </span>
        </div>
      </div>
      <div class="clearfix">
        <label for="Order">№ в очереди</label>
        <div class="input">
          <input type="text" name="Order" id="Order" class="span3">
        </div>
      </div>
      <div class="clearfix">
        <label for="Role">Статус в программе</label>
        <div class="input">
          <select id="Role" name="Role" class="span4">
            <option value="0">Выберите форму участия</option>
            <?foreach ($this->Roles as $role):?>
            <option value="<?=$role->RoleId;?>"><?=$role->Name;?></option>
            <?endforeach;?>
          </select>
        </div>
      </div>

      </fieldset>
    <fieldset id="report">
      <div class="clearfix">
        <label for="Header">Название доклада</label>
        <div class="input">
          <input type="text" name="Header" id="Header" class="span12">
        </div>
      </div>

      <div class="clearfix">
        <label for="Thesis">Тезисы доклада</label>
        <div class="input">
          <textarea rows="15" name="Thesis" id="Thesis" class="span12"></textarea>
        </div>
      </div>

      <div class="clearfix">
        <label for="LinkPresentation">Презентация (ссылка)</label>
        <div class="input">
          <input type="text" name="LinkPresentation" id="LinkPresentation" class="span12">
        </div>
      </div>
    </fieldset>

    <a class="button positive save big" id="button_save"><span class="icon check"></span>Сохранить</a>

    <a class="button big" id="button_cancel">Отменить</a>

  </form>
</section>