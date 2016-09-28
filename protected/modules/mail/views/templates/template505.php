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

<p>Здравствуйте, <?=$user->getShortName()?>!</p>

<p><strong>Ваши работы на конкурсе &laquo;Золотое приложение&raquo; имеют очень высокий шанс войти в призовые места.</strong></p>

<p>Поэтому, если вы этого ещё не сделали, мы рекомендуем вам <a href="<?=$user->getFastAuthUrl('http://runet-id.com/event/gappceremony15')?>">зарегистрироваться на мероприятие</a> &nbsp;по промо-коду <span style="background: yellow; display: inline-block; padding: 1px 3px;"><?=$code?></span>. Для этого нужно быть залогиненным под Runet-ID того человека, который посетит Церемонию.</p>

<p>Напоминаем, что Церемония состоится 21 мая в Москве по адресу ул. Пятницкая, д. 71/5, стр. 2, Клуб Coin. Начало сбора гостей &mdash; 18:30.</p>
