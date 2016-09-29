<?php
	$event = \event\models\Event::model()->findByPk(1498);
?>

<h3><?=$user->getShortName()?>, здравствуйте!</h3>

<p>Приглашаем Вас принять участие в&nbsp;Форуме по&nbsp;Кибербезопасости.</p>

<p><b>Cyber Security Forum 2015, Russia</b><br />
пройдет в&nbsp;Москве (МИА &laquo;Россия Сегодня&raquo;)<br />
в&nbsp;четверг <b>12&nbsp;февраля 2015&nbsp;года</b>: <a href="http://cybersecurityforum.ru">www.CyberSecurityForum.ru</a></p>

<p>Вы&nbsp;можете зарегистрироваться как для виртуального участия (для получения доступа к&nbsp;материалам Форума), так и&nbsp;для посещения Форума в&nbsp;качестве участника.</p>

<div style="text-align: center; border: 3px dashed #D94332; margin: 20px 0;">
	<p style="margin-top: 10px 0; text-align: center;"><a href="<?=$event->getFastRegisterUrl($user, \event\models\Role::model()->findByPk(24))?>#event_widgets_Registration" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #D94332; margin: 0 10px 0 0; padding: 0; border-color: #D94332; border-style: solid; border-width: 10px 40px;">Быстрая регистрация</a></p>
	<p style="font-size: 80%">Персональная ссылка на сайт в авторизованном виде</p>
</div>

<p><img src="http://showtime.s3.amazonaws.com/201502101235-icomf12.jpg" style="height: auto; width: 100%;" /></p>

<p>Cyber Security Forum&nbsp;&mdash; это ежегодная площадка для диалога отрасли и&nbsp;государства, российских и&nbsp;зарубежных экспертов, пользователей и&nbsp;бизнеса. Также это площадка для обмена опытом и&nbsp;поиска решений в&nbsp;области информационной безопасности и&nbsp;борьбы с&nbsp;киберугрозами современности, для выработки практик по&nbsp;саморегулированию в&nbsp;сфере информационной безопасности.</p>

<p>Основная задача Форума&nbsp;&mdash; это обмен опытом и&nbsp;выявление лучших практик в&nbsp;сфере информационной безопасности по&nbsp;направлениям: технологии, законодательство, решения, контент и&nbsp;сервисы.</p>

<p>В&nbsp;<b>Открытии Форума</b> (12&nbsp;февраля, <nobr>10:00&ndash;11:30,</nobr> Пресс-центр МИА &laquo;Россия сегодня&raquo;) примут участие представители профильных организаций, органов госвласти, интернет-игроков.</p>

<p>Сразу после открытия и&nbsp;пленарного заседания&nbsp;&mdash; конференционные мероприятия Форума пройдут в&nbsp;течение дня в&nbsp;3&nbsp;параллельных залах.</p>


<div style="text-align: center; border: 3px dashed #D94332; margin-top: 20px;">
	<p style="margin-top: 10px 0; text-align: center;"><a href="http://runet-id.com/event/csf15/#event_widgets_ProgramGrid" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #D94332; margin: 0 10px 0 0; padding: 0; border-color: #D94332; border-style: solid; border-width: 10px 40px;">Подробная программа</a></p>
</div>

<p align="center">До встречи на Форуме!</p>