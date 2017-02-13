<?php
$eventId = 2826;

$text = new \application\components\utility\Texts();
$code = $text->getUniqString($eventId);

$invite = new \event\models\Invite();
$invite->EventId = $eventId;
$invite->RoleId = 167;
$invite->Code = $code;
$invite->save();
?>

<p><?=$user->getShortName()?>, здравствуйте!</p>

<p>Как почетного участника мероприятий, проводимых при поддержке РАЭК в 2016 году, <strong>приглашаем вас на Церемонию Награждения Золотого Сайта 2016</strong>. Она пройдет уже сегодня вечером 14 декабря, в Москве в Клубе Deworkacy. &nbsp;Вся подробная информация находится на <a href="<?=$user->getFastAuthUrl('https://runet-id.com/event/goldensite16');?>">странице мероприятия</a>.</p>

<p>Для регистрации на Церемонию вам надо ввести на этой странице специальный промо-код:<br/><b><?=$code?></b></p>

<p>Эта регистрация позволит посетить Церемонию вам, а также одному вашему коллеге/другу/второй половинке (формат &laquo;+1&raquo;).</p>

<p>Спасибо, что помогали нам с судейством &ndash; и до встречи в среду вечером!</p>

<p><em>С уважением,<br />
Оргкомитет Золотого Сайта</em></p>
