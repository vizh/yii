<?php
	$event = \event\models\Event::model()->findByPk(1498);
	?>

<p><img src="http://showtime.s3.amazonaws.com/201502021039-csf15-logo.jpg" style="height: auto; width: 100%;" /></p>
<h3>Здравствуйте <?=$user->getShortName()?>!</h3>

<p>Напоминаем, что продолжается регистрация на&nbsp;Cyber Security Forum 2015, Russia, который пройдет в&nbsp;Москве ровно через неделю&nbsp;&mdash; 12&nbsp;февраля 2015&nbsp;года: <a href="http://cybersecurityforum.ru">www.CyberSecurityForum.ru</a></p>

<p>Cyber Security Forum&nbsp;&mdash; это ежегодный Международный Форум по&nbsp;вопросам информационной безопасности, пользовательской безопасности и&nbsp;кибербезопасности.</p>

<div style="text-align: center; border: 3px dashed #D94332; margin-top: 20px;">
	<p style="margin-top: 10px 0; text-align: center;"><a href="<?=$event->getFastRegisterUrl($user, \event\models\Role::model()->findByPk(24))?>#event_widgets_Registration" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #D94332; margin: 0 10px 0 0; padding: 0; border-color: #D94332; border-style: solid; border-width: 10px 40px;">Быстрая регистрация</a></p>
</div>

<p>Основная задача Форума&nbsp;&mdash; это обмен опытом и&nbsp;выявление лучших практик в&nbsp;сфере информационной безопасности по&nbsp;направлениям: технологии, законодательство, решения, контент и&nbsp;сервисы.</p>

<h3>ПРОГРАММА ФОРУМА</h3>

<p>В&nbsp;Открытии Форума (12&nbsp;февраля, <nobr>10:00&ndash;11:30,</nobr> Пресс-центр МИА &laquo;Россия сегодня&raquo;) примут участие представители профильных организаций, органов госвласти, интернет-игроков (Госдума, Совет Федерации, Минкомсвязь, Роскомнадзор, ФИД, Ростелеком, RU-CENTER, РАЭК, РБТП, РОЦИТ).</p>

<p>Сразу после открытия и&nbsp;пленарного заседания&nbsp;&mdash; конференционные мероприятия Форума пройдут в&nbsp;течение дня в&nbsp;3&nbsp;параллельных залах.</p>

<p><strong>Среди основных тем Форума:</strong></p>

<ul>
	<li>Кибербезопасность сегодня</li>
	<li>Безопасность корневой инфраструктуры Рунета</li>
	<li>Защита персональных данных в&nbsp;Сети</li>
	<li>Регулирование в&nbsp;области кибербезопасности</li>
	<li>Программно-технические угрозы: бизнес и&nbsp;пользователи</li>
	<li>Молодые пользователи Рунета</li>
	<li>Индекс медиаграмотности и&nbsp;медиаграмотность в&nbsp;образовании</li>
</ul>

<div style="text-align: center; border: 3px dashed #D94332; margin-top: 20px;">
	<p style="margin-top: 10px 0; text-align: center;"><a href="http://runet-id.com/event/csf15/#event_widgets_ProgramGrid" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #D94332; margin: 0 10px 0 0; padding: 0; border-color: #D94332; border-style: solid; border-width: 10px 40px;">Подробная программа</a></p>
</div>

<p>Форум соберет более 500 международных и&nbsp;российских экспертов, специалистов в&nbsp;области кибербезопасности, представителей интернет-отрасли (интернет-игроки, сервис-провайдеры, телеком-сегмент и&nbsp;провайдеры хостинга, производители программно-аппаратных решений), представителей СМИ, государства и&nbsp;пользовательского сообщества.</p>

<p>Организаторами и&nbsp;партнерами Форума выступают: РОЦИТ, РАЭК, Р-Спектр, Русско-Британская торповая палата, Лаборатория Касперского, RU-CENTER. Поддержка Форума: Минкомсвязь, Роскомнадзор.</p>

<div style="text-align: center; border: 3px dashed #D94332; margin-top: 20px;">
	<p><strong>ВНИМАНИЕ!</strong><br/>Принять участие в&nbsp;форуме могут только зарегистрированные участники.</p>
	<p style="margin-top: 10px 0; text-align: center;"><a href="<?=$event->getFastRegisterUrl($user, \event\models\Role::model()->findByPk(24))?>#event_widgets_Registration" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #D94332; margin: 0 10px 0 0; padding: 0; border-color: #D94332; border-style: solid; border-width: 10px 40px;">Быстрая регистрация</a></p>
	<p align="center">До&nbsp;встречи на&nbsp;Форуме!</p>
</div>
