<div id="edit_contact" class="edit-block">
	<!-- Контактные данные -->
	<?php
			$editTexts = $this->words['editcompany'];
		?>
	<dl>
		<dt>Контактный email:</dt>
		<dd>
			<input id="email_<?=$this->EmailId;?>" type="text" name="email" value="<?=isset($this->Email) ? $this->Email : $editTexts['emailtext'];?>"
				onfocus="if(this.value=='<?=$editTexts['emailtext'];?>'){this.value=''}"
				onblur="if(this.value==''){this.value='<?=$editTexts['emailtext'];?>'}" size="53">
		</dd>
	</dl>
	<dl>
		<dt>Личный сайт:</dt>
		<dd>
			<input type="text" name="site" value="<?= !empty($this->Site) ? $this->Site : $editTexts['sitetext'];?>"
				onfocus="if(this.value=='<?=$editTexts['sitetext'];?>'){this.value=''}"
				onblur="if(this.value==''){this.value='<?=$editTexts['sitetext'];?>'}" size="53">
			<span class="required gray">(если сайтов несколько, укажите их через пробел)</span>
		</dd>
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