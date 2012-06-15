<h1>Профиль компании <?=$this->Company['Name']?> <iframe src="//www.facebook.com/plugins/like.php?app_id=246359005408073&amp;href=<?=$this->Url?>&amp;send=false&amp;layout=button_count&amp;width=135&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:135px; height:21px; margin-top: 2px; margin-left: 15px; position: absolute;" allowTransparency="true"></iframe></h1>

<div class="company-left">
	<div class="picture">
		<img class="c-logo" src="<?=$this->Logo?>" alt="" />
	</div>
	<h2 class="c-cont">Контакты</h2>
	<?if(!empty($this->Email) || !empty($this->Site) || !empty($this->Skype) || !empty($this->Phones) || !empty($this->Address)):?>
		<table class="comp-tbl">
				<?=$this->Email?>
				<?=$this->Site?>
				<?=$this->Skype?>
				<?=$this->Phones?>
				<?=$this->Address?>
		</table>
	<?else:?>
		<div class="c-empty">Контакты не указаны.</div>
	<?endif;?>
<!-- end company-left -->
</div>

<div class="company-mid">

	<?if(!empty($this->Company['FullName'])):?>
		<h2 class="c-h1"><span><?=$this->Company['FullName']?></span></h2>
	<?endif;?>

	<?=$this->Info;?>

	<?=$this->Users;?>

<!-- end company-mid -->
</div>

<div class="sidebar sidebarcomp">
	<?if ($this->Auth):?>
		<?if ($this->ShowEdit):?>
			<a class="interesting" href="/company/<?=$this->Company['CompanyId']?>/edit/">Редактировать</a>
		<?endif;?>
		<?if($this->InterestCompany):?>
			<a class="interesting active" href="/company/interest/delete/<?=$this->Company['CompanyId']?>/">Удалить из контактов</a>
		<?else:?>
			<a class="interesting" href="/company/interest/add/<?=$this->Company['CompanyId']?>/">Интересоваться компанией</a>
		<?endif;?>
	<?endif;?>

	<?php echo $this->Banner;?>
</div>

	<div class="clear"></div>