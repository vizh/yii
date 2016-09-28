<?php
$regLink = "http://riw.moscow/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'vyeavbdanfivabfdeypwgruqe'), 0, 16);
?>

<div style="margin: 25px auto; max-width: 520px;">

	<h3><?=$user->getShortName()?>, здравствуйте!</h3>
	<p><strong>Вы&nbsp;зарегистрированы на&nbsp;RIW 2015&nbsp;со статусом УЧАСТНИК ВЫСТАВКИ.</strong></p>
	<p>Этот статус позволяет Вам посещать выставку RIW 2015 и&nbsp;Softool 2015&nbsp;в московском Экспоцентре на&nbsp;Красной Пресне все 3&nbsp;дня работы: <nobr>21-23 октября 2015 года.</nobr></p>
	<p>Если Вы&nbsp;планируете также принять участие в&nbsp;конференционной программе Медиа-Коммуникационного Форума и&nbsp;стать Профессиональным участником RIW 2015&nbsp;— Вам нужно спешить!</p>
	<p><strong>Только при оплате до&nbsp;30&nbsp;сентября 2015 года включительно действует специальная цена Проф.участия: 7&nbsp;000&nbsp;рублей, включая все налоги&nbsp;— за&nbsp;безлимитное посещение всех 9&nbsp;залов Форума и&nbsp;Бизнес-зоны в&nbsp;</strong><strong>течение всех дней.</strong></p>
	<h3>В&nbsp;дальнейшем стоимость участия будет повышена.</h3>
	<p>Оплатить участие в&nbsp;Форуме (своё и&nbsp;коллег) Вы&nbsp;можете в&nbsp;Вашем Личном кабинете. Принимаются все виды платежей, включая пластиковые карты, электронные деньги, безналичные платежи.</p>

	<div style="text-align: center; margin-top: 20px;">
	<p style="margin-top: 10px 0; text-align: center;"><a href="<?=$regLink?>" style="font-size: 100%; color: #fff; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #222222; margin: 0 10px 0 0; padding: 0; border-color: #222222; border-style: solid; border-width: 10px 40px;">ЛИЧНЫЙ КАБИНЕТ</a></p>
	</div>

	<p align="center">До&nbsp;встречи на&nbsp;RIW 2015! </p>

</div>