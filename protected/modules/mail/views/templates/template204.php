<?php
$regLink = "http://riw.moscow/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'vyeavbdanfivabfdeypwgruqe'), 0, 16);

if (!function_exists("getRoleName")) {
	function getRoleName($roleId) {
		switch ($roleId) {
			case 3:
				return 'Докладчик';
			case 6:
				return 'Организатор';
			case 5:
				return 'Партнер';
			case 2:
				return 'СМИ';
			case 1:
				return 'Участник выставки';
			case 11:
			default:
				return 'Участник форума';
		}
	}
}

?>

<h3>Здравствуйте, <?=$user->getShortName()?>.</h3>

<p>Вы зарегистрированы на RIW 2014 со статусом <strong>&laquo;<?=getRoleName($user->Participants[0]->Role->Id)?>&raquo;</strong>.</p>

<p>Напоминаем, что мероприятие пройдет 12-14 ноября в московском Экспоцентре.</p>

<p>Управление статусом, услугами и регистрация коллег осуществляется в <a href="<?=$regLink?>">личном кабинете</a>.</p>
<p>Новости мероприятия, схема выставки, конференционная программа и многое другое - на <a href="http://riw.moscow/">официальном сайте</a>.</p>
