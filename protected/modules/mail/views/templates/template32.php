<p><img src="http://runet-id.com/images/mail/rif14/header-bg.png" /></p>

<h2>Добрый день, <?=$user->getShortName()?>!</h2>

<p>Предлагаем Вам, как участнику РИФ+КИБ прошлых лет, информацию по подготовке Форума этого года, а также информацию о спецпредложениях, действующих <strong>до 28 февраля 2014 года включительно</strong>.</p>
<a href="http://www.rif.ru">18-й Российский Интернет Форум</a> (<strong>РИФ+КИБ 2014</strong>) пройдет <strong>23-25 апреля 2014 года</strong>, в подмосковных пансионатах &laquo;Поляны&raquo; и &laquo;Лесные дали&raquo;.

<p>В настоящий момент идет активная регистрация участников, формирование программы, списка партнеров и экспонентов выставки:</p>

<ul style="padding-left: 25px">
	<li style="margin: 10px 0;">В конференционной программе будут представлены все темы развития Рунета (<strong>около 100 секций</strong>, круглых столов и мастер-классов, всего <strong>более 500 докладчиков</strong>);</li>
	<li style="margin: 10px 0;">Кроме обычных выступлений в программе РИФ+КИБ запланированы уникальные <strong>ток-шоу с интернет-гуру</strong>, <strong>презентации новинок</strong> лидерами отрасли, конференция для инвесторов и стартапов <strong>UpStart Conf</strong>, конференция <strong>Crowd Conf</strong>, специальные треки <strong>&laquo;Brand Track&raquo; и &laquo;HR Track&raquo;</strong>, <strong>секции </strong>народной <strong>Программы 2.0</strong>, кулуарное общение и многое другое;</li>
	<li style="margin: 10px 0;">Все дни проведения РИФ+КИБ будет работать <strong>выставка лидеров Рунета</strong>, а все дни и вечера &ndash; будут проходить специальные мероприятия от партнеров Форума, открытые и закрытые встречи, вечеринки и развлекательные акции.</li>
</ul>

<p>РИФ+КИБ &ndash; это самое главное, самое полезное, самое позитивное и самое весеннее событие Рунета.</p>

<h3>ВНИМАНИЕ!</h3>

<p><strong>До 28 февраля включительно</strong> действуют <strong>специальные условия</strong> оплаты регистрационного взноса участника: <strong>6000 рублей, включая налоги</strong>.</p>
<p><strong>С 1 марта</strong> стоимость вырастет до <strong>7000 рублей</strong>.</p>

<?
$role = \event\models\Role::model()->findByPk(24);
$event = \event\models\Event::model()->findByPk(789);
$registerLink = $event->getFastRegisterUrl($user, $role, '/event/rif14/');
?>
<p><a href="<?=$registerLink?>" style="display: block; text-decoration: none; background: #3c3f41; color: #FFFFFF; font-family: Arial,Verdana,sans-serif; margin: 0 auto; padding: 12px; text-align: center; width: 250px;">Регистрация на РИФ+КИБ 2014</a></p>