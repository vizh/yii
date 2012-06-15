<h2 class="c-cont">Сотрудники компании</h2>

<div class="rocid-persons">

<?if($this->Users->IsEmpty()):?>
	<div class="c-users-empty">Сотрудников не найдено.</div>
<?else:?>
	<?=$this->Users?>
<?endif;?>

<!-- end rocid-persons -->
</div>

<div class="clear"></div>

<h2 class="c-cont">Работали раньше</h2>

<div class="rocid-persons">

<?if($this->UsersOld->IsEmpty()):?>
	<div class="c-users-empty">Сотрудников не найдено.</div>
<?else:?>
	<?=$this->UsersOld?>
<?endif;?>

<!-- end rocid-persons -->
</div>