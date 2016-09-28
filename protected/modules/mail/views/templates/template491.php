<?php

$eventId = 1916;

$text = new \application\components\utility\Texts();
$code = $text->getUniqString($eventId);

$invite = new \event\models\Invite();
$invite->EventId = $eventId;
$invite->RoleId = 1;
$invite->Code = $code;
$invite->save();

?>

<p><strong>Здравствуйте, <?=$user->getShortName()?>!</strong></p>
<p>Оргкомитет конкурса «Золотое приложение» приглашает вас на&nbsp;Церемонию награждения конкурса, которая состоится 21&nbsp;мая в&nbsp;Москве в&nbsp;ресторане Coin (ул. Пятницкая, д. 71/5, стр.&nbsp;2). Церемония объединена с&nbsp;афтепати конференции о&nbsp;мобильной разработке MBLT ’15.</p>
<p>Для посещения обязательна регистрация! Если вы&nbsp;планируете прийти на&nbsp;Церемонию, пройдите на&nbsp;<a href="<?=$user->getFastAuthUrl('http://runet-id.com/event/gappceremony15')?>">страницу регистрации</a> и&nbsp;введите промокод <span style="background: yellow; display: inline-block; padding: 1px 3px;"><?=$code?></span>.</p>
<p><strong>В&nbsp;программе мероприятия:</strong></p>
<ul>

<li><nobr>18:30–19:30 —</nobr> Сбор гостей, фуршет.</li>

<li><nobr>19:30–21:00 —</nobr> Церемония награждения победителей «Золотого приложения», раздача призов в&nbsp;основных и&nbsp;тематических номинациях, а&nbsp;также вручение «Приза зрительских симпатий».</li>

<li><nobr>21:00–23:00 —</nobr> Выступление группы, фуршет, танцы, чествование победителей, отмечание конференции MBLT ’15.</li>
</ul>
<p>Подробности будут появляться на&nbsp;<a href="<?=$user->getFastAuthUrl('http://runet-id.com/event/gappceremony15')?>">странице мероприятия</a>. Ждём вас 21&nbsp;мая и&nbsp;желаем победы в&nbsp;конкурсе!</p>