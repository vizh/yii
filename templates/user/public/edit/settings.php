<div id="edit_settings" class="edit-block">
	<!-- Настройки аккаунта -->
	<dl>
		<dt>Уведомления:</dt>
		<dd>
			<input type="checkbox" <?=$this->ProjNews == 1 ? 'checked="checked"' : '';?> name="projnews" value="1" id="news"/> <label for="news">Получать новости системы rocID</label><br />
			<input type="checkbox" <?=$this->EventNews == 1 ? 'checked="checked"' : '';?> name="eventnews" value="1" id="digest"/> <label for="digest">Получать еженедельный дайджест событий на rocID</label><br />
			<input type="checkbox" <?=$this->NoticePhoto == 1 ? 'checked="checked"' : '';?> name="noticephoto" value="1" id="photos"/> <label for="photos">Уведомлять о фотографиях и видео, на которых вас отметили</label><br />
		</dd>
	</dl>
  <dl>
    <dt>Профиль</dt>
    <dd>
      <input type="checkbox" <?=$this->IndexProfile == 1 ? 'checked="checked"' : '';?> name="indexprofile" value="1" id="indexprofile"/> <label for="indexprofile">Не индексировать профиль в поисковых системах</label><br />
    </dd>
  </dl>
	<dl class="no_padding">
		<dt>&nbsp;</dt>
		<dd><a id="save_settings" class="save_settings" href="#">Сохранить изменения</a></dd>
	</dl>
	<div class="lseparator">
		&nbsp;
	</div>
	<dl>
		<dt>Смена пароля:</dt>
		<dd><input type="password" name="current_pass" value="" id="current_pass" size="25"> <label for="current_pass">старый пароль</label> <span class="required">(обязательное поле)</span></dd>
	</dl>
	<dl>
		<dt>&nbsp;</dt>
		<dd><input type="password" name="new_pass" value="" id="new_pass" size="25"> <label for="new_pass">новый пароль</label> <span class="required">(обязательное поле)</span></dd>
	</dl>
	<dl>
		<dt>&nbsp;</dt>
		<dd><input type="password" name="rnew_pass" value="" id="rnew_pass" size="25"> <label for="rnew_pass">новый пароль, ещё разок</label> <span class="required">(обязательное поле)</span></dd>
	</dl>
	<dl class="no_padding">
		<dt>&nbsp;</dt>
		<dd><a id="change_password" class="user_edit" href="#">Сохранить изменения</a></dd>
	</dl>
	<div class="lseparator">
		&nbsp;
	</div>
	<dl>
		<dt>Смена email:</dt>
		<dd><input type="text" name="current_email" value=""	 size="25"> <label>старый email</label>
			<span class="required">(обязательное поле)</span></dd>
	</dl>
  <dl>
		<dt>&nbsp;</dt>
		<dd><input type="text" name="new_email" value="" size="25"> <label>новый email</label> <span class="required">(обязательное поле)</span></dd>
	</dl>
	<dl>
		<dt>&nbsp;</dt>
		<dd><input type="text" name="rnew_email" value="" size="25"> <label>новый email, ещё разок</label> <span class="required">(обязательное поле)</span></dd>
	</dl>
	<dl class="no_padding">
		<dt>&nbsp;</dt>
		<dd><a id="change_email" class="user_edit" href="#">Сохранить изменения</a></dd>
	</dl>
	<div class="lseparator">
		&nbsp;
	</div>
  <form id="delete_account" action="<?=RouteRegistry::GetUrl('user', 'edit', 'delete');?>">
	<dl>
		<dt>Удаление аккаунта:</dt>
		<dd><input type="text" name="pass_delete" value="" id="pass_delete" size="25"> <label for="pass_delete">введите текущий пароль</label> <span class="required">(обязательное поле)</span></dd>
	</dl>
	<dl>
		<dt>&nbsp;</dt>
		<dd class="delete_account">Внимание: после удаления учётную запись восстановить не удастся!</dd>
	</dl>
	<dl class="no_padding">
		<dt>&nbsp;</dt>
		<dd><a id="delete_account" class="user_edit" href="#" onclick="$('#delete_account').submit(); return false;">Удалить учётную запись</a></dd>
	</dl>
  </form>
	<dl class="separator">
		<dt>&nbsp;</dt>
		<dd>&nbsp;</dd>
	</dl>
</div>