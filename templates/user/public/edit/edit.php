<?php echo $this->FbRoot; ?>
<h1>Редактирование профиля</h1>

<div class="editprofile-left">
	<ul class="edit-profile">
		<li id="menu_main" class="selected"><a href="#main">Основная информация</a></li>
		<li id="menu_work"><a href="#work">Опыт работы</a></li>
		<li id="menu_contact"><a href="#contact">Контактные данные</a></li>
		<li id="menu_address"><a href="#address">Место проживания</a></li>
		<!--<li id="menu_interest"><a href="#interest">Интересы и предпочтения</a></li>-->
		<li id="menu_photo"><a href="#photo">Фотография профиля</a></li>
		<li id="menu_settings"><a href="#settings">Настройки аккаунта</a></li>
	</ul>
</div>
<div class="editprofile-right">
	<div class="top">&nbsp;</div>
	<div class="center">
		<?php echo $this->MainEdit;?>
		<?php echo $this->WorkEdit;?>
		<?php echo $this->ContactEdit;?>
		<?php echo $this->AddressEdit;?>
		<!--<div id="edit_interest" class="edit-block"></div>-->
		<?php echo $this->PhotoEdit;?>
		<?php echo $this->SettingsEdit;?>

		<!-- modal content -->
		<div id='confirm'>
			<div class='header'><span>Внимание</span></div>
			<div class='message'>Некоторые данные <strong>не сохранены</strong>. После перехода на другую страницу они могут быть утеряны.</div>
			<div class='buttons'>
				<div class='no simplemodal-close'>Отмена</div>
				<div class='nosave'>Не сохранять</div>
				<div class='save'>Сохранить</div>
			</div>
		</div>

		<!-- photo resize -->
		<div id="imageresize">
			<img src="" alt="">
			<div class="imageresize-90"><img src="" alt=""></div>
			<div class="imageresize-50"><img src="" alt=""></div>
			<a id="upload_photo_resized" class="load_photo" href="#">Сохранить изменения</a>&nbsp;
			<a id="cancel_resize" class="cancel_photo" href="#"><span>Отменить</span></a>
		</div>

	</div>
	<div class="bottom">&nbsp;</div>
</div>

<div class="clear"></div>
 
