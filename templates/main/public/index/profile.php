<div id="profile">
	<div class="top"><div class="header-link"><a href="/user/edit/">редактировать</a></div></div>
	<div class="center">
		<div class="user-title">
			<div><?php echo $this->FullName;?></div>
			<div class="job-title"><?if (!empty($this->LastCompany)):?><?php echo $this->LastPosition . ', ' . $this->LastCompany; ?><?else:?>&nbsp;<?endif;?></div>
			<div class="red-line"></div>
		</div>
		<div class="misc_info">
			<img width="90" class="user_photo" src="<?=$this->MediumPhoto;?>" alt="<?=$this->LastName;?> <?=$this->FirstName;?>">
			<h4>Основные контакты:</h4>
			<ul>
				<li>
					<?if(isset($this->Email)):?>
					<a class="icon email" href="mailto:<?=$this->Email;?>">
						<?=$this->Email;?>
					</a>
					<?else:?>
					<span class="icon email">email не задан</span>
					<?endif;?> <a href="/user/edit/#contact" class="edit">изменить</a></li>
				<li>
					<span class="icon phone">
						<?=isset($this->Phone) ? $this->Phone : 'номер телефона не задан';?>
					</span> <a href="/user/edit/#contact" class="edit">изменить</a></li>
			</ul>
		</div>
	</div>
	<div class="bottom"></div>
</div>
 
