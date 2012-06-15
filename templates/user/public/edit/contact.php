<div id="edit_contact" class="edit-block">
	<!-- Контактные данные -->
	<?php
			$editTexts = $this->words['edituser'];
		?>
	<dl>
		<dt>Контактный email:</dt>
		<dd>
			<input id="email_<?=$this->EmailId;?>" type="text" name="email" value="<?=isset($this->Email) ? htmlspecialchars($this->Email) : '';?>" placeholder="укажите действующий email" size="53">
			<span class="required">(обязательное поле)</span>
		</dd>
	</dl>
	<dl>
		<dt>Личный сайт:</dt>
		<dd>
			<input type="text" name="site" value="<?= !empty($this->Site) ? htmlspecialchars($this->Site) : '';?>" placeholder="укажите адрес сайта" size="53">
			<span class="required gray">(если сайтов несколько, укажите их через пробел)</span>
		</dd>
	</dl>
	<dl class="separator">
		<dt>&nbsp;</dt>
		<dd>&nbsp;</dd>
	</dl>
	<dl id="contact_fb<?=$this->FacebookContactId;?>" class="im_info">
		<dt>IM, соцсети:</dt>
		<dd>
			<input type="text" name="im_screenname" value="<?=htmlspecialchars($this->FacebookName);?>" size="23">
			<select name="im_list" disabled="disabled" class="contact">
				<?foreach($this->ServiceTypes as $type):?>
				<option value="<?=$type->ServiceTypeId;?>" <?=$this->FacebookTypeId == $type->ServiceTypeId ? 'selected="selected"' : '';?>><?=$type->Title;?></option>
				<?endforeach;?>
			</select>
      <?if (!$this->FbConnect):?>
			  <span class="connect">для связки аккаунтов нажмите: <a id="fb-connect" href="#" class="fb-connect" onclick="Social.FacebookConnect('/user/edit/connect/facebook/'); return false;">&nbsp;</a></span>
      <?else:?>
        <span class="connect"><a href="/user/edit/disconnect/facebook/" class="disconnect_account">Открепить аккаунт</a></span>
      <?endif;?>
		</dd>
	</dl>
	<dl id="contact_twi<?=$this->TwitterContactId;?>" class="im_info">
		<dt>&nbsp;</dt>
		<dd>
			<input type="text" name="im_screenname" value="<?=htmlspecialchars($this->TwitterName);?>" size="23">
			<select name="im_list" disabled="disabled" class="contact">
				<?foreach($this->ServiceTypes as $type):?>
				<option value="<?=$type->ServiceTypeId;?>" <?=$this->TwitterTypeId == $type->ServiceTypeId ? 'selected="selected"' : '';?>><?=$type->Title;?></option>
				<?endforeach;?>
			</select>
      <?if (!$this->TwiConnect):?>
			  <span class="connect">для связки аккаунтов нажмите: <a id="twi-connect" href="#" class="twi-connect" onclick="Social.TwitterConnect('/user/edit/connect/twitter/'); return false;">&nbsp;</a></span>
      <?else:?>
        <span class="connect"><a href="/user/edit/disconnect/twitter/" class="disconnect_account">Открепить аккаунт</a></span>
      <?endif;?>
		</dd>
	</dl>

	<?php echo $this->Contacts;?>
	
	<dl>
		<dt>&nbsp;</dt>
		<dd><a id="add_messenger" href="#" class="delete_work">добавить мессенджер или профиль соцсети</a></dd>
	</dl>
	<dl class="separator">
		<dt>&nbsp;</dt>
		<dd>&nbsp;</dd>
	</dl>

	<?php echo $this->Phones; ?>

	<dl>
		<dt>&nbsp;</dt>
		<dd><a id="add_phone" href="#" class="delete_work">добавить контактный телефон</a></dd>
	</dl>
	<dl class="separator">
		<dt>&nbsp;</dt>
		<dd>&nbsp;</dd>
	</dl>
	<dl>
		<dt>&nbsp;</dt>
		<dd><a id="save_contact" class="save_settings" href="#">Сохранить изменения</a></dd>
	</dl>
</div>