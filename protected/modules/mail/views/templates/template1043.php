<?php

$eventId = 2790;

$text = new \application\components\utility\Texts();
$code = $text->getUniqString($eventId);

$invite = new \event\models\Invite();
$invite->EventId = $eventId;
$invite->RoleId = 1;
$invite->Code = $code;
$invite->save();

?>

<p><strong>Здравствуйте, <?=$user->getShortName();?>!</strong></p>

<p>Оргкомитет конкурса &laquo;Золотое приложение&raquo; приглашает вас на&nbsp;Церемонию награждения конкурса, которая состоится 21&nbsp;июня в&nbsp;Москве в&nbsp;ресторане Coin (ул. Пятницкая, д. 71/5, стр.&nbsp;2).</p>

<p>Для посещения <strong>обязательна регистрация</strong>! Если вы&nbsp;планируете прийти на&nbsp;Церемонию, пройдите на&nbsp;<a href="<?=$user->getFastAuthUrl('https://runet-id.com/event/gappceremony16');?>">страницу регистрации</a> и&nbsp;введите промокод <span style="background: yellow; display: inline-block; padding: 1px 3px;"><?=$code?></span>.</p>

<p>Регистрация позволяет вам посетить Церемонию <strong>в&nbsp;сопровождении ещё одного гостя</strong> (+1)!</p>

<p><strong>В&nbsp;программе мероприятия:</strong></p>

<ul>
	<li><nobr>19:00&ndash;19:50 &mdash;</nobr> Сбор гостей, регистрация.</li>
	<li><nobr>20:00&ndash;20:15 &mdash;</nobr> Приветствие участников, открытие церемонии.</li>
	<li><nobr>20:15&ndash;21:45 &mdash;</nobr> Церемония награждения победителей &laquo;Золотого приложения&raquo;, раздача призов в&nbsp;золотых и&nbsp;тематических номинациях, а&nbsp;также вручение &laquo;Приза зрительских симпатий&raquo;.</li>
	<li><nobr>21:45&ndash;23:00 &mdash;</nobr> Празднование, свободное общение, фуршет.</li>
</ul>

<p>Подробности будут появляться на&nbsp;<a href="https://runet-id.com/event/gappceremony16">странице мероприятия</a>. Ждём вас 21&nbsp;июня и&nbsp;желаем победы в&nbsp;конкурсе!</p>

<p>P.S.: Не забудьте, что народное голосование за работы закончится <b>17 июня в 18:00</b>.</p>