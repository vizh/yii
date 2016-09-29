<p><?=$user->getShortName()?>, здравствуйте!</p>

<p>Международный Форум по Кибербезопасности — Cyber Security Forum 2014, Russia – состоится <b>19 февраля 2014 года</b> (вторник) в Москве в Торгово-Промышленной Палате РФ.</p>
<p>В настоящий момент опубликована <a href="http://runet-id.com/event/csf14/#event_widgets_tabs_Html">предварительная программа</a>, которая активно дорабатывается. Дополнительная информация на официальном сайте <a href="http://cybersecurityforum.ru/">CyberSecurityForum.ru</a>.</p>

<p><b>Среди основных тем Форума:</b></p>

<ul>
	<li>Информационная безопасность в Рунете и связанных сферах;</li>
	<li>Законодательство в сфере информационной безопасности;</li>
	<li>Стратегия кибербезопасности Российской Федерации;</li>
	<li>Технологии и решения;</li>
	<li>Международные практики и опыт Кибербезопасности;</li>
	<li>Нелегальный контент и методы борьбы с ним;</li>
	<li>Информационная безопасность в образовании (ЕГЭ);</li>
	<li>Безопасность платежных систем в Рунете;</li>
	<li>Корпоративная кибербезопасность: проблемы и решения;</li>
	<li>Детская безопасность в сети Интернет.</li>
</ul>

<p>Принять участие в Cyber Security Forum 19 февраля 2014 года – могут <b>только зарегистрированные участники</b>.</p>
<p><a href="<?=$user->getFastauthUrl('/event/csf14/#event_widgets_Users')?>">Проверить статус участия</a> и произвести регистрацию / дорегистрацию вы можете на официальном сайте мероприятия.</p>


<?
/*
$role = \event\models\Role::model()->findByPk(24);
$event = \event\models\Event::model()->findByPk(870);
$registerLink = $event->getFastRegisterUrl($user, $role, '/event/csf14/#event_widgets_Users');
?>
<a href="<?=$registerLink?>"><?=$registerLink?></a>
<?*/?>


<p>До встречи на Форуме!</p>


<p>--<br />
С уважением,<br />
Оргкомитет Cyber Security Forum 2014<br/>
<a href="http://CyberSecurityForum.ru">CyberSecurityForum.ru</a></p>

<p>--<br /><a href="<?=$user->getFastauthUrl('/user/setting/subscription/')?>">Отписаться</a> от рассылок RUNET-ID</p>
