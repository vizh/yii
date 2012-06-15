<div id="edit_main" class="edit-block edit-block-active">
	<dl>
		<dt>Краткое название:</dt>
		<dd><input id="name" type="text" name="name" value="<?=CHtml::encode($this->Name);?>" size="40"> <span class="required">(обязательное поле)</span></dd>
	</dl>
	<dl>
		<dt>Полное название:</dt>
		<dd><input id="fullname" type="text" name="fullname" value="<?=CHtml::encode($this->FullName);?>" size="40"></dd>
	</dl>
	<dl>
		<dt>О компании:</dt>
		<dd><textarea id="info" name="info" cols="26" rows="5"><?=$this->Info;?></textarea></dd>
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