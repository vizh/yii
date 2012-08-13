<h1>Профиль пользователя</h1>

<div class="company-left">
	<div class="picture">
		<?php if ($this->Self): ?>
			<a href="/user/edit/#photo" class="new_photo">Изменить фотографию</a>
		<?php endif; ?>
		<img src="<?php echo $this->User->GetPhoto();?>" width="200"  alt="" class="c-logo" />
	</div>
	<h2 class="c-cont">
		Контакты
		<?php if ($this->Self): ?>
			<a href="/user/edit/#contact" class="edit_info">изменить</a>
		<?php endif; ?>
	</h2>


	<table class="userpfile-tbl">
		<?=$this->Address?>
		<?=$this->Age?>
		<tr>
			<td class="f">Заходил:</td>
			<td>
				<?php if ($this->User->GetLastVisit() != 0):?>
					<?$lastVisit = getdate($this->User->GetLastVisit());?>
					<?=$lastVisit['mday']?> <?=$this->words['calendar']['months'][2][$lastVisit['mon']]?> в <?=strftime('%H:%M', $this->User->GetLastVisit());?>
				<?php else:?>
					Очень давно
				<?php endif;?>
			</td>
		</tr>
		<?=$this->Site;?>
		<?=$this->ServiceAccount;?>
	</table>




	<!-- end company-left -->
</div>
<div class="company-mid">

	<h2 class="c-h1 user"><?php echo $this->User->GetFullName();?> <sup><?php echo $this->User->GetRocId()?></sup><br />
		<span><?=$this->CurrentWork?></span></h2>

	<h2 class="c-cont">Профессиональный опыт <?php if ($this->Self): ?>
		<a href="/user/edit/#work" class="edit_info">изменить</a>
		<?php endif; ?></h2>

	<table class="user-experience">
		<?if (!empty($this->Work)):?>
			<?=$this->Work;?>
		<?else:?>
			<tr><td class="c-empty">Данные отсутствуют.</td></tr>
		<?endif;?>
	</table>

  <?php if (!empty($this->Commission)):?>
  <h2 class="c-cont">Профессиональная деятельность</h2>
  <table class="user-experience user-commission">
    <?php echo $this->Commission;?>
  </table>
  <?php endif;?>
  
	<h2 class="c-cont">Участие в профильных мероприятиях</h2>

	<table class="user-experience user-events"> <!-- Класс user-events идет какбе аддоном к основному -->
		<?if (!empty($this->Event)):?>
			<?=$this->Event;?>
		<?else:?>
			<tr><td class="c-empty">Данные отсутствуют.</td></tr>
		<?endif;?>
	</table>

	<!--<h2 class="c-cont">Проекты, публикации, "следы" в сети</h2>

<table class="user-experience user-events">
	<?=$this->Activity?>
</table>-->

	<!-- end company-mid -->
</div>

<div class="sidebar sidebarcomp">
	<?if ($this->Self):?>
	<a class="interesting" href="/user/edit/">Редактировать профиль</a>
	<?elseif($this->Auth):?>
	<?if($this->InterestPerson):?>
		<a href="/user/interest/delete/<?php echo $this->User->GetRocId();?>/" class="interesting active">Удалить из контактов</a>
		<?else:?>
		<a class="interesting" href="/user/interest/add/<?php echo $this->User->GetRocId();?>/">Добавить в контакты</a>
		<?endif;?>
	<!--<a class="invite" href="#">Пригласить на мероприятие</a>-->
	<?endif;?>
	<?php echo $this->Banner;?>
</div>

<div class="clear"></div>