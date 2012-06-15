<h1 class="company-name" id="company_<?=$this->CompanyId?>">Редактирование компании</h1>

<div class="editprofile-left">
	<ul class="edit-profile">
		<li id="menu_main" class="selected"><a href="#main">Основная информация</a></li>
		<li id="menu_contact"><a href="#contact">Контактные данные</a></li>
		<li id="menu_address"><a href="#address">Адрес</a></li>
		<li id="menu_logo"><a href="#logo">Логотип компании</a></li>
	</ul>
</div>

<div class="editprofile-right">
	<div class="top">&nbsp;</div>
	<div class="center">
		<?php echo $this->MainEdit;?>
		<?php echo $this->ContactEdit;?>
		<?php echo $this->AddressEdit;?>
		<?php echo $this->LogoEdit;?>

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

		<!-- logo resize -->
		<div id="imageresize">
			<img src="" alt="">
			<div class="imageresize-50"><img src="" alt=""></div>
			<a id="upload_logo_resized" class="load_logo" href="#">Сохранить изменения</a>&nbsp;
			<a id="cancel_resize" class="cancel_logo" href="#"><span>Отменить</span></a>
		</div>

	</div>
	<div class="bottom">&nbsp;</div>
</div>

<div class="clear"></div>