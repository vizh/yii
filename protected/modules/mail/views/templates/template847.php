<?php
	$regLink = "http://2016.i-comference.ru/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'82skQfNnSRIA'), 0, 16);
?>

<h3>Здравствуйте, <?=$user->getShortName()?>.</h3>

<p>Вы&nbsp;начали, но&nbsp;не&nbsp;завершили процедуру регистрации на&nbsp;конференцию <nobr>i-CоM</nobr> 2016, которая состоится уже 14 —15&nbsp;марта. Уже сформирована <a href="http://2016.i-comference.ru/program/">программа конференции</a>.</p>
<p>Ваш текущий статус:<br/><strong>ВИРТУАЛЬНЫЙ УЧАСТНИК</strong></p>
<p>Для завершения процедуры регистрации Вам необходимо оплатить регистрационный взнос. Сделать это можно в&nbsp;личном кабинете участника. По&nbsp;итогам мероприятия Вам будут доступны презентации докладчиков.</p>
<p>К&nbsp;оплате доступны все виды платежей: банковские карты, электронные деньги, безналичные платежи.</p>

<div style="text-align: center; background: #F0F0F0; border: 2px dashed #FFF; padding: 20px 10px 10px;">
<p style="margin-top: 0"><a href="<?=$regLink?>" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #FEC026; margin: 0 10px 0 0; padding: 0; border-color: #FEC026; border-style: solid; border-width: 10px 40px;">ЛИЧНЫЙ КАБИНЕТ</a></p>
</div>

<p align="center"><b>ВНИМАНИЕ!</b><br/>
 Возможность оплаты по&nbsp;безналичному счету для юридических лиц&nbsp;— будет доступна до&nbsp;11&nbsp;марта включительно.
</p>