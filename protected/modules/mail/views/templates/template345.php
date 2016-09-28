<?php
$regLink = "http://2015.i-comference.ru/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'vyeavbdanfivabfdeypwgruqe'), 0, 16);
?>

<h3><?=$user->getShortName()?>, здравствуйте!</h3>

<p>Вы&nbsp;начали, но&nbsp;не&nbsp;завершили процедуру регистрации на&nbsp;конференцию <a href="http://2015.i-comference.ru/"><nobr>i-Comference</nobr> 2015</a>, которая состоится уже 17&nbsp;марта.</p>

<p>Ваш текущий статус:<br />
<strong>ВИРТУАЛЬНЫЙ УЧАСТНИК</strong></p>

<p><strong>Для завершения процедуры регистрации Вам необходимо оплатить регистрационный взнос.</strong> Сделать это можно в&nbsp;личном кабинете участника.</p>

<p>К&nbsp;оплате доступны <strong>все виды платежей</strong>: банковские карты, электронные деньги, безналичные платежи.</p>

<p>ВНИМАНИЕ!<br />
Возможность оплаты по&nbsp;безналичному счету для юридических лиц&nbsp;&mdash; будет доступна вплоть до&nbsp;15&nbsp;марта включительно.</p>

<div style="text-align: center; margin-top: 20px;">
	<p style="margin-top: 10px 0; text-align: center;">
		<a href="http://2015.i-comference.ru/program/" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #222222; margin: 10px 0; padding: 0; border-color: #222222; border-style: solid; border-width: 10px 40px; min-width: 200px; width: 30%;">Подробная программа</a>
		<a href="<?=$regLink?>" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #6C0C7A; margin: 10px 0; padding: 0; border-color: #6C0C7A; border-style: solid; border-width: 10px 40px; min-width: 200px; width: 30%;">Личный кабинет</a>
	</p>
</div>

<p align="center">Остались вопросы? Пишите нам, мы&nbsp;на&nbsp;связи: <a href="mailto:users@i-comference.ru">users@i-comference.ru</a></p>
