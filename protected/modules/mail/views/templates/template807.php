<p><a href="http://runet-id.com/event/csf-press16"><img alt="Регистрация" src="http://runet-id.com/img/mail/2016/csfpr16.png" style="width: 630px; height: auto; margin: 0 auto" /></a></p>

<h3>Здравствуйте, <?=$user->getShortName();?>!</strong></h3>

<p><strong>Напоминаем вам, что вы зарегистрированы на пресс-конференцию&nbsp;<a href="http://runet-id.com/event/csf-press16/" target="_blank">“Безопасность в Интернете: итоги 2015 года и планы на 2016 год”.</a></strong></p>

<p><strong>Ваш статус:&nbsp;</strong><?=$user->Participants[0]->Role->Title;?></p>

<p><strong>Дата проведения:</strong>&nbsp;03 февраля 2016 года (среда)</p>

<p><strong>Начало мероприятия:</strong>&nbsp;13:00, сбор гостей с 12:10</p>

<p><strong>Место проведения:</strong>&nbsp;<strong>Пресс-центр МИА “Россия сегодня” (</strong>Зубовский бульвар д. 4)</strong></p>


<p><strong>Внимание!<br/>
Для прохода на территорию пресс-центра МИА “Россия Сегодня” при себе ОБЯЗАТЕЛЬНО иметь паспорт, распечатать и взять с собой ваш личный электроный билет:.</strong></p>

<div style="text-align: center; background: #F0F0F0; border: 2px dashed #FFF; padding: 20px 10px 10px;">
<p style="margin-top: 0"><a href="<?=$user->Participants[0]->getTicketUrl();?>" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #FFAA00; margin: 0 10px 0 0; padding: 0; border-color: #FFAA00; border-style: solid; border-width: 10px 40px;">Электронный билет</a></p>

<p style="text-align:center">Ваш билет уникален и не подлежит передаче третьим лицам.</p>
</div>

<p>&nbsp;</p>

<p><strong>До встречи на мероприятии!</strong></p>