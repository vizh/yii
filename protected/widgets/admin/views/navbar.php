<?php
/**
 * @var $this \application\widgets\admin\Navbar
 */
if (Yii::app()->user->getCurrentUser() === null) {
    return;
}
?>
<div class="navbar navbar-inverse">
	<div class="navbar-inner">
		<ul class="nav pull-right">
			<li class="dropdown" id="fat-menu">
				<a data-toggle="dropdown" class="dropdown-toggle" role="button" href="#">
					<i class="icon-user icon-white"></i> <?=Yii::app()->user->getCurrentUser()->getName()?>
					<i class="icon-chevron-down icon-white"></i>
				</a>
				<ul class="dropdown-menu">
					<li><a href="<?=Yii::app()->createUrl('/user/logout/index')?>" tabindex="-1">Logout</a></li>
				</ul>
			</li>
		</ul>
		<a href="<?=Yii::app()->createUrl('/main/admin/default/index')?>" class="brand">RUNET-ID: Администрирование</a>
	</div>
</div>