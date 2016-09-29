<?php
$regLink = "http://2014.russianinternetweek.ru/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'vyeavbdanfivabfdeypwgruqe'), 0, 16);
?>
<h3>Добрый день, <?=$user->getShortName()?>!</h3>

<p>Спасибо за Ваше участие в <strong>Первой интернет-конференция &laquo;РИФ-КРЫМ 2014&raquo;</strong>.</p>

<p>Мы высоко ценим мнение каждого участника Форума и будем признательны, если вы уделите <strong>5 минут</strong> своего времени, что бы принять участие в итоговом опросе участников. Результаты опроса обязательно будут учитываться при подготовке РИФ-Крым 2015.</p>

<p style="margin-top: 0; text-align: center;">
    <a href="<?=$user->getFastauthUrl('http://runet-id.com/rif-crimea14/')?>" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #348eda; margin: 0 10px 0 0; padding: 0; border-color: #348eda; border-style: solid; border-width: 10px 40px;">Перейти к опросу</a>
</p>

<p>Также все пожелания по формату мероприятия и по интересующим Вас темам Вы можете отправлять на почту <a href="mailto:pr@raec.ru">pr@raec.ru</a></p>

<p>Также предлагаем Вам ознакомится с  <a href="http://runet-id.com/event/rif-crimea14/">итоговыми материалами конференции</a>:</p>

<ul>
	<li>Итоговая новость</li>
	<li>Презентации докладчиков</li>
	<li>Фотоотчет</li>
</ul>

<h3>Что дальше?</h3>

<p>Приглашаем Вас посетить RIW 2014 (12-14 ноября, Москва, Экспоцентр) &ndash; главную выставку и форум российской интернет-, телеком- и медиа-отраслей.</p>

<p>Участие в Выставке: бесплатное. Участие в Профессиональной программе: платное, участникам РИФ-Крым предоставляется скидка в размере 50% от стоимости участия. Запросить скидку можно по адресу <a href="mailto:users@russianinternetweek.ru">users@russianinternetweek.ru</a></p>

<p style="margin-top: 0; text-align: center;">
    <a href="<?=$regLink?>" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #348eda; margin: 0 10px 0 0; padding: 0; border-color: #348eda; border-style: solid; border-width: 10px 40px;">Зарегистрироваться на RIW 2014</a>
</p>
