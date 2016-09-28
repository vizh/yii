<?php
$regLink = "http://2015.russianinternetforum.ru/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'aihrQ0AcKmaJ'), 0, 16);
?>

<?$role = \event\models\Role::model()->findByPk(24)?>
<p><?=$user->getShortName()?>,</p>
<p>​Команда RUNET-ID поздравляет Вас с&nbsp;наступившим Новым 2015&nbsp;годом!</p>

<p>Чтобы Вам было легче войти в&nbsp;рабочий ритм&nbsp;&mdash;предлагаем начать год с&nbsp;планирования участия в&nbsp;главных отраслевых мероприятиях зимы-весны 2015 года&nbsp;&mdash; <a href="http://2015.runet-id.com">http://2015.runet-id.com</a></p>

<p>Ниже представлены три главных проекта, на&nbsp;которые мы&nbsp;обращаем Ваше особое внимание. Спешите&nbsp;&mdash; регистрация на&nbsp;них идет полным ходом!</p>
&nbsp;

<table>
	<tbody>
		<tr>
			<td style="background: #D9EAD3; font-size: 24px; padding: 0 10px;">РИФ+КИБ 2015</td>
			<td style="background: #B6D7A8; padding: 0 10px; width: 96px;">
			<p><b><nobr>22&ndash;24</nobr>апреля</b></p>
			<p><small>Лесные дали</small></p>
			</td>
			<td style="background: #38761D; padding: 0 10px;"><a href="<?=$regLink?>" style="color: #ffffff;">РЕГИСТРАЦИЯ</a></td>
		</tr>
		<tr>
			<td style="padding: 5px;">
			<p><nobr>19-й</nobr> Российский Интернет Форум &amp;&nbsp;Конференция &laquo;Интернет и&nbsp;Бизнес&raquo;&nbsp;&mdash; пройдут в&nbsp;апрее в&nbsp;Московской области в&nbsp;пансионате &laquo;Лесные дали&raquo;.</p>

			<p>Регистрация участников&nbsp;&mdash; идет полным ходом. Формируется программа Форума, пул партнеров и&nbsp;экспонентов.</p>

			<p><a href="http://www.rif.ru">www.rif.ru</a></p>
			<br />
			&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td style="background: #CFE2F3; font-size: 24px; padding: 0 10px;">Cyber Security Forum 2015, Russia</td>
			<td style="background: #9FC5E8; padding: 0 10px;">
			<p><b>12&nbsp;февраля</b></p>
			<p><small>МИА &laquo;Россия Сегодня&raquo;</small></p>
			</td>
			<td style="background: #0B5394; color: #ffffff; padding: 0 10px;">
				<?$event = \event\models\Event::model()->findByPk(1498)?>
				<a href="<?=$event->getFastRegisterUrl($user, $role)?>" style="color: #ffffff;">РЕГИСТРАЦИЯ</a>
			</td>
		</tr>
		<tr>
			<td style="padding: 5px;">
			<p>Международная Конференция про пользовательскую безопасность и&nbsp;приватность в&nbsp;интернете.</p>
			<p>Особый акцент этого года: Персональные данные и&nbsp;новые законодательные требования по&nbsp;их&nbsp;защите.</p>
			<p><a href="http://www.cybersecurityforum.ru">http://www.CyberSecurityForum.ru</a></p>
			<br />
			&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td style="background: #F4CCCC; font-size: 24px; padding: 0 10px;">
			<p><nobr>i-COMference</nobr> 2015: Social &amp;&nbsp;Mobile Communications</p>
			</td>
			<td style="background: #EA9999; padding: 0 10px;">
			<p><b>17&nbsp;марта</b></p>
			<p><small>Digital October</small></p>
			</td>
			<td style="background: #CC0000; color: #ffffff; padding: 0 10px;">
				<?$event = \event\models\Event::model()->findByPk(1574)?>
				<a href="<?=$event->getFastRegisterUrl($user, $role)?>" style="color: #ffffff;">РЕГИСТРАЦИЯ</a>
			</td>
		</tr>
		<tr>
			<td>
			<p>Главная ежегодная конференция, посвященная коммуникациям в&nbsp;интернете: социальные медиа, мобильные технологии и&nbsp;коммуникации, интернет-СМИ, медиапотребление и&nbsp;цифровые товары (Digital Goods), монетизация контента и&nbsp;сервисов, реклама.</p>

			<p><a href="http://2015.i-comference.ru">http://2015.i-COMference.ru</a></p>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</tbody>
</table>

<hr style="border: 0; border-top: 1px solid #eaeaea; margin: 25px 0;" />
<h3>Все мероприятия 2015&nbsp;года</h3>

<p>Перечень мероприятий, рекомендованных RUNET-ID:<br />
<a href="http://2015.runet-id.com">http://2015.runet-id.com</a></p>

<p>Интерактивный помесячный календарь всех мероприятий Рунета:<br />
<a href="http://runet-id.com/events/">http://runet-id.com/events/</a></p>
