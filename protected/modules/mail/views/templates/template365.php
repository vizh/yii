<?php

	$coupon = \pay\models\Coupon::model()->byCode('RIF15ICOMF15R7FNQU')->find();
	$coupon->activate($user, $user);

	$regLink = "http://2015.russianinternetforum.ru/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'aihrQ0AcKmaJ'), 0, 16);
?>

<p><img src="http://showtime.s3.amazonaws.com/201503190924-rif15-icomf15-25.jpg" style="height: auto; width: 100%;" /></p>
<h3><?=$user->getShortName()?>, здравствуйте!</h3>
<p>Конференция <nobr>i-COMference</nobr> 2015&nbsp;завершена, и&nbsp;она удалась&nbsp;— <a href="http://www.i-comf.ru">www.i-COMf.ru</a></p>
<p>Спасибо, что были среди участников! Уже через месяц&nbsp;— с&nbsp;22&nbsp;по&nbsp;24&nbsp;апреля&nbsp;— в&nbsp;пансионате «Лесные дали» в&nbsp;<nobr>19-й</nobr> раз пройдет главное весеннее мероприятие российской ИТ-отрасли&nbsp;— РИФ+КИБ 2015&nbsp;— <a href="http://www.rif.ru">www.rif.ru</a></p>
<p><strong>ВНИМАНИЕ!<br/>
 Спецпредложение для участников <nobr>i-COMference</nobr> 2015</strong>
</p>
<p>Для участников <nobr>i-COMference</nobr> 2015&nbsp;мы подготовили специальное предложение: пока мы&nbsp;обрабатываем материалы с&nbsp;прошедшей конференции, Вы&nbsp;можете успеть зарегистрироваться на&nbsp;РИФ+КИБ 2015&nbsp;<strong>по специальным условиям со скидкой 25%</strong>.</p>
<p>По специальному предложению стоимость участия составит 5250 рублей включая налоги, при том что цена для обычных участников&nbsp;— 7000&nbsp;рублей. Но Вам необходимо успеть воспользоваться предложением <b>до&nbsp;22&nbsp;марта включительно</b>.</p>
<p>Регистрация осуществляется в&nbsp;личном кабинете участника. RUNET-ID сам определит, что вы&nbsp;регистрировались на&nbsp;<nobr>i-COMference</nobr> и&nbsp;пересчитает для вас стоимость регистрационного взноса.</p>

<div style="text-align: center; margin-top: 20px;">
	<p style="margin-top: 10px 0; text-align: center;">
		<a href="<?=$regLink?>" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #6C0C7A; margin: 10px 0; padding: 0; border-color: #6C0C7A; border-style: solid; border-width: 10px 40px; min-width: 220px; width: 40%;">Зарегистрироваться</a>
	</p>
</div>
<hr style="border: 0; border-top: 1px solid #eaeaea; height: 1px; margin: 25px 0;" />

<p>Конференционные мероприятия РИФ+КИБ 2015 пройдут в&nbsp;течение 3&nbsp;дней в&nbsp;7&nbsp;параллельных потоков. Всего планируется около 80&nbsp;секций.</p>
<p>Все 3&nbsp;дня на&nbsp;территории форума будет работать Выставка, а&nbsp;помимо Программы и&nbsp;Выставки, во&nbsp;время конференции пройдут другие интересные мероприятия, соорганизаторами которых выступают партнеры РИФ+КИБ 2015.</p>
<p>До&nbsp;встречи на&nbsp;РИФе 2015!</p>