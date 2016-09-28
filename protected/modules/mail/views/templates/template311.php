<?php
	$event = \event\models\Event::model()->findByPk(1498);
?>

<p><img src="http://showtime.s3.amazonaws.com/201502021039-csf15-logo.jpg" style="height: auto; width: 100%;" /></p>
<h3>Здравствуйте <?=$user->getShortName()?>!</h3>

<p>Вы&nbsp;начали, но&nbsp;не&nbsp;завершили процедуру регистрации на&nbsp;<a href="http://www.CyberSecurityForum.ru">Cyber Security Forum 2015</a>, поэтому пока не&nbsp;имеете доступа на&nbsp;площадку Форума.</p>

<p>Для участия в&nbsp;мероприятии 12&nbsp;февраля и&nbsp;доступа на&nbsp;площадку (Пресс-центр МИА &laquo;Россия сегодня&raquo;) необходимо завершить регистрацию: оплатить участие или обратиться в&nbsp;Оргкомитет Форума для получения промо-кода (предоставляется партнерам мероприятия, докладчикам, представителями СМИ и&nbsp;ВУЗов и&nbsp;т.д.).</p>

<div style="text-align: center; border: 3px dashed #D94332; margin-top: 20px;">
	<p style="margin-top: 10px 0; text-align: center;"><a href="<?=$event->getFastRegisterUrl($user, \event\models\Role::model()->findByPk(24))?>#event_widgets_Registration" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #D94332; margin: 0 10px 0 0; padding: 0; border-color: #D94332; border-style: solid; border-width: 10px 40px;">Быстрая регистрация</a></p>
	<p style="font-size: 80%">Стоимость участия 1500&nbsp;рублей, включая налоги.</p>
</div>

<p>Для получения промо-кода необходимо обратиться в&nbsp;адрес Оргкомитета <a href="mailto:csf2015@raec.ru">csf2015@raec.ru</a>, сообщить Ваш статус участия и&nbsp;RUNET-ID номер и&nbsp;аргументировать право получения бесплатного доступа на&nbsp;площадку.</p>

<p>Форум соберет более 500 международных и&nbsp;российских экспертов, специалистов в&nbsp;области кибербезопасности, представителей интернет-отрасли (интернет-игроки, сервис-провайдеры, телеком-сегмент и&nbsp;провайдеры хостинга, производители программно-аппаратных решений), представителей СМИ, государства и&nbsp;пользовательского сообщества.</p>

<p>Организаторами и&nbsp;партнерами Форума выступают: РОЦИТ, РАЭК, Р-Спектр, Русско-Британская торповая палата, Лаборатория Касперского, RU-CENTER. Поддержка Форума: Минкомсвязь, Роскомнадзор.</p>
