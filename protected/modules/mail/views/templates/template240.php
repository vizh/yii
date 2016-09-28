<?php

$eventId = 1512;

$text = new \application\components\utility\Texts();
$code = $text->getUniqString($eventId);

$invite = new \event\models\Invite();
$invite->EventId = $eventId;
$invite->RoleId = 1;
$invite->Code = $code;
$invite->save();

?>

<p><?=$user->getShortName()?>, здравствуйте!</p>
<p><strong>14 ноября состоится вручение премии Internet Media Awards.</strong></p>
<p>Церемония награждения лауреатов Internet Media Awards (IMA)&nbsp;состоится <strong>14 ноября 2014 года в рамках Russian Interactive Week (RIW 2014),&nbsp;</strong><strong>по адресу Москва, Кутузовский проспект, дом 12, строение 3</strong>. Ведущими&nbsp;церемонии выступят Александр Плющев и Татьяна Фельгенгауэр («Эхо&nbsp;Москвы»). Гостей мероприятия будет развлекать&nbsp;популярная музыкальная&nbsp;группа Guru Groove Foundation.</p>
<div style="border: 2px dashed yellow; padding: 10px 25px">
	<p>Регистрация на&nbsp;церемонию осуществляется на&nbsp;<a href="http://runet-id.com/event/imawards14/">странице мероприятия</a>, на&nbsp;которой нужно указать Ваш персональный код приглашения: <b style="display: inline-block; background-color: yellow; padding: 1px 3px;"><?=$code?></b>.</p>
</div>
<p>Напомним, что Internet Media Awards IMA - первая премия в области&nbsp;интернет-медиа, определяющая и оценивающая важнейшие достижения в&nbsp;современной информационной сфере. В этом году на конкурс поступило&nbsp;более 150 заявок от журналистов и представителей компаний (проектов)&nbsp;медиа-рынка России.</p>
<p>Internet Media Awards будет вручаться в двух номинациях:&nbsp;персоны и проекты. Заветную статуэтку вручат: журналистам Life-Style изданий, журналистам деловых изданий, журналистам новостных&nbsp;изданий, лучшим главным редакторам. Кроме того, Softkey вручит приз в&nbsp;номинациях «Открытие года», «Профессиональное признание», «Точно в&nbsp;цель».</p>
<p>Приза за лучший проект удостоятся лучшие Life-Style медиа, деловые&nbsp;медиа, интернет-версии радиостанций, корпоративные медиа, издания,&nbsp;посвящённые образованию и культуре, общественно-политические медиа, &nbsp;персональные медиа, спортивные медиа, издания, пишущие об экономике и бизнесе. Также Anews наградят самое динамично растущее СМИ, самое&nbsp;популярное интернет СМИ и самое читаемое интернет СМИ.&nbsp;</p>
<p>Гран При IMA вручается за самый большой вклад в развитие отрасли и&nbsp;медиа персоне года</p>
<p>Организаторы мероприятия - <strong><a href="http://www.raec.ru">РАЭК</a> (Российская Ассоциация&nbsp;Электронных Коммуникаций), Notamedia и «Эхо Москвы».</strong></p>
<p>Партнёры премии – <strong>Geometria.ru, Cossa , AdIndex, Нетология, Softkey и&nbsp;Anews.</strong></p>
<p>Официальный сайт <a href="http://imawards.ru/">http://imawards.ru/</a></p>