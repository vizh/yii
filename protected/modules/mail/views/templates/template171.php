<?php
/**
 * @var User $user
 */
use user\models\User;
$key = substr(md5($user->RunetId.'AFWf4BwXVXpMUblVQDICoUz0'), 0, 16);
$goldenSiteRegLink = "http://2014.goldensite.ru/personal/introduce/?RUNETID=" . $user->RunetId . "&KEY=" . $key;



$hash = substr(md5('fiNAQ3t32RYn9HTGkEdKzRrYS'.$user->RunetId), 1, 16);
$mbltDevRegLink = sprintf('http://mbltdev.ru/?RunetId=%s&Hash=%s', $user->RunetId, $hash);

$RiwLink = "http://riw.moscow/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'vyeavbdanfivabfdeypwgruqe'), 0, 16);

?>
<h3><?=$user->getShortName()?>, здравствуйте!</h3>

<p style="font-size: 120%;">Представляем вашему вниманию очередную подборку мероприятий ИТ-отрасли, спланируйте свое посещение заранее!</p>

<hr style="border: 0; border-top: 1px solid #DDDDDD; height: 1px; margin: 50px 0; width: 100%;" />

<table style="border: 0; border-collapse: collapse; margin: 25px 0; width: 100%;">
	<tr>
		<td style="border: 0; padding: 10px; vertical-align: top;">
			<h1>Семинар тренинг<br/>&laquo;Digital-рейд: КАЗАНЬ&raquo;</h1>
		</td>
		<td style="border: 0; padding: 10px; vertical-align: top; width: 200px;">
			<img src="http://digital-raid.ru/templates/raid/images/logoRaid.png" style="border: 0; height: auto; width: 120px;" />
		</td>
	</tr>
	<tr>
		<td style="border: 0; padding: 10px; vertical-align: top;">
			<p>Серия мастер-классов для представителей веб-студий и digital-агентств Казани от ведущих экспертов российского рынка. Никаких клиентов, только представители агентского рынка – только практика, только по делу.</p>
		</td>
		<td style="border: 0; padding: 10px; vertical-align: top; width: 200px;">
			<h4>29 ноября 2014 г.</h4>
			<p><b>Место проведения:</b><br/>г. Казань, Петербургская, д. 52</p>
			<p><a href="http://digital-raid.ru/" target="_blank">digital-raid.ru</a></p>
		</td>
	</tr>
	<tr>
		<td style="background: #E1F4FD; border: 0; padding: 15px 20px; vertical-align: middle;">
			<b>Принять участие в &laquo;Digital-рейд: КАЗАНЬ&raquo;</b>
		</td>
		<td style="background: #E1F4FD; border: 0; padding: 15px 10px; text-align: center; vertical-align: middle; width: 200px;">
			<a href="<?=$user->getFastauthUrl('http://pay.runet-id.com/register/digitalkazan14/')?>" style="display: inline-block; background: #3B3B3B; color: #ffffff; padding: 10px 20px; border-radius: 4px; border-top: 1px solid #737373; border-left: 1px solid #737373; text-decoration: none;">Регистрация</a>
		</td>
	</tr>
</table>
<hr style="border: 0; border-top: 1px solid #DDDDDD; height: 1px; margin: 50px 0; width: 100%;" />

<table style="border: 0; border-collapse: collapse; margin: 25px 0; width: 100%;">
	<tr>
		<td style="border: 0; padding: 10px; vertical-align: top;">
			<h1>Конференция<br/>Russian App Day</h1>
		</td>
		<td style="border: 0; padding: 10px; vertical-align: middle; width: 200px;">
			<img src="http://c.s-microsoft.com/ru-ru/CMSImages/mslogo.png?version=856673f8-e6be-0476-6669-d5bf2300391d" style="border: 0; height: auto; width: 120px;" />
		</td>
	</tr>
	<tr>
		<td style="border: 0; padding: 10px; vertical-align: top;">
			<p>Russian App Day - это совершенно новое мероприятие о приложениях, облачных и мобильных технологиях!</p>
			<p> Мы расскажем всё про мобильные тренды и возможности для бизнеса
			<ul>
				<li>Что происходит в медиа (ТВ, принт, новости)?</li>
				<li>Как с помощью приложений банки и телекомы борются за аудиторию?</li>
				<li>Как меняются процессы проведения транзакций и денежных переводов?</li>
				<li>Что общего между игровой индустрией и Голливудом?</li>
				<li>Ждет ли нас скорое светлое будущее в транспорте и медицине?</li>
			</ul>
			</p>
		</td>
		<td style="border: 0; padding: 10px; vertical-align: top; width: 200px;">
			<h4>21 ноября 2014 г.</h4>
			<p><b>Место проведения</b><br/>г. Москва, Волгоградский проспект, д. 42/24, Технополис «Москва»</p>
			<p><a href="http://events.techdays.ru/appday/2014-11" target="_blank">events.techdays.ru/appday/2014-11</a></p>
		</td>
	</tr>
	<tr>
		<td style="background: #E1F4FD; border: 0; padding: 15px 20px; vertical-align: middle;">
			<b>Принять участие в Russian App Day</b>
		</td>
		<td style="background: #E1F4FD; border: 0; padding: 15px 10px; text-align: center; vertical-align: middle; width: 200px;">
			<a href="http://events.techdays.ru/AppDay/2014-11/" style="display: inline-block; background: #3B3B3B; color: #ffffff; padding: 10px 20px; border-radius: 4px; border-top: 1px solid #737373; border-left: 1px solid #737373; text-decoration: none;">Регистрация</a>
		</td>
	</tr>
</table>

<hr style="border: 0; border-top: 1px solid #DDDDDD; height: 1px; margin: 50px 0; width: 100%;" />

<table style="border: 0; border-collapse: collapse; margin: 25px 0; width: 100%;">
	<tr>
		<td style="border: 0; padding: 10px; vertical-align: top;">
			<h1>Конференция<br/>&laquo;Формула интернет-торговли&raquo;</h1>
		</td>
		<td style="border: 0; padding: 10px; vertical-align: top; width: 200px;">
			<img src="http://getlogo.org/img/1c-bitrix/13/200x/" style="border: 0; height: auto; width: 120px;" />
		</td>
	</tr>
	<tr>
		<td style="border: 0; padding: 10px; vertical-align: top;">
			<p>Организаторами мероприятия выступают компании &laquo;1С-Битрикс&raquo;, &laquo;Аудиомания&raquo; и &laquo;Поставщик счастья&raquo;.</p>
			<p>На конференции будут рассмотрены следующие темы
			<ul>
				<li>Что обязательно надо знать о своих клиентах?</li>
				<li>Как контакт-центр может на треть увеличить конверсию?</li>
				<li>Почему персонализация в большинстве случаев не работает?</li>
				<li>Какие «фишки» на сайте помогают посетителю принять решение по покупке?</li>
				<li>Зачем и как сегментировать клиентскую базу?</li>
				<li>Когда срабатывает ремаркетинг?</li>
			</ul>
			</p>
		</td>
		<td style="border: 0; padding: 10px; vertical-align: top; width: 200px;">
			<h4>21 ноября 2014 г.</h4>
			<p><b>Место проведения:</b><br/>г. Москва, Савиннская набережная, д. 2, Бизнес-центр "Японский дом"</p>
			<p><a href="http://www.formula-internet.ru/2014/" target="_blank">www.formula-internet.ru/2014</a></p>
		</td>
	</tr>
	<tr>
		<td style="background: #E1F4FD; border: 0; padding: 15px 20px; vertical-align: middle;">
			<b>Принять участие в конференции &laquo;Формула интернет-торговли&raquo;</b>
		</td>
		<td style="background: #E1F4FD; border: 0; padding: 15px 10px; text-align: center; vertical-align: middle; width: 200px;">
			<a href="http://www.formula-internet.ru/2014/registration/?utm_source=raec&utm_medium=email&utm_campaign=raec_24102014" style="display: inline-block; background: #3B3B3B; color: #ffffff; padding: 10px 20px; border-radius: 4px; border-top: 1px solid #737373; border-left: 1px solid #737373; text-decoration: none;">Регистрация</a>
		</td>
	</tr>
</table>

<hr style="border: 0; border-top: 1px solid #DDDDDD; height: 1px; margin: 50px 0; width: 100%;" />

<table style="border: 0; border-collapse: collapse; margin: 25px 0; width: 100%;">
	<tr>
		<td style="border: 0; padding: 10px; vertical-align: top;">
			<h1>Конкурс премия<br/>&laquo;Премия Рунета 2014&raquo;</h1>
		</td>
		<td style="border: 0; padding: 10px; vertical-align: top; width: 200px;">
			<img src="http://runet-id.com/files/event/premiaru14/120.png" style="border: 0; height: auto; width: 120px;" />
		</td>
	</tr>
	<tr>
		<td style="border: 0; padding: 10px; vertical-align: top;">
			<p>&laquo;Премия Рунета 2014&raquo; является одним из самых знаковых событий российского интернет-пространства и символизирует признание заслуг победителей на государственном, общественном и отраслевом уровнях. Церемония вручения Премии – это ежегодное выявление лидеров Рунета и подведение итогов уходящего года, а также яркое, интересное и по-настоящему уникальное мероприятие. </p>
		</td>
		<td style="border: 0; padding: 10px; vertical-align: top; width: 200px;">
			<h4>25 ноября 2014 г.</h4>
			<p><b>Место проведения:</b><br/>г. Москва, Орджоникидзе, д. 11, ГЛАВCLUB</p>
			<p><a href="http://www.premiaruneta.ru" target="_blank">www.premiaruneta.ru</a></p>
		</td>
	</tr>
	<tr>
		<td style="background: #E1F4FD; border: 0; padding: 15px 20px; vertical-align: middle;">
			<b>Принять участие в &laquo;Премия Рунета 2014&raquo;</b>
		</td>
		<td style="background: #E1F4FD; border: 0; padding: 15px 10px; text-align: center; vertical-align: middle; width: 200px;">
			<a href="<?=$user->getFastauthUrl('http://pay.runet-id.com/register/premiaru14/')?>" style="display: inline-block; background: #3B3B3B; color: #ffffff; padding: 10px 20px; border-radius: 4px; border-top: 1px solid #737373; border-left: 1px solid #737373; text-decoration: none;">Регистрация</a>
		</td>
	</tr>
</table>

<hr style="border: 0; border-top: 1px solid #DDDDDD; height: 1px; margin: 50px 0; width: 100%;" />

<table style="border: 0; border-collapse: collapse; margin: 25px 0; width: 100%;">
	<tr>
		<td style="border: 0; padding: 10px; vertical-align: top;">
			<h1>Конференция<br/>Бизнес-завтрак – Правовое регулирование телеком-отрасли: итоги 2014 года</h1>
		</td>
		<td style="border: 0; padding: 10px; vertical-align: middle; width: 200px;">
			<img src="http://toplogos.ru/images/logo-kommersant.jpg" style="border: 0; height: auto; width: 120px;" />
		</td>
	</tr>
	<tr>
		<td style="border: 0; padding: 10px; vertical-align: top;">
			<p>Телекоммуникации, являясь одной из ведущих отраслей развития мировой экономики, всегда находятся под пристальным взором органов государственной власти.</p>
		</td>
		<td style="border: 0; padding: 10px; vertical-align: top; width: 200px;">
			<h4>25 ноября 2014 г.</h4>
			<p><b>Место проведения:</b><br/>г. Москва, Неглинная, д. 4, Арарат Парк Хаятт, зал Саргся</p>
			<p><a href="http://www.kommersant.ru/doc/2594358" target="_blank">www.kommersant.ru/doc/2594358</a></p>
		</td>
	</tr>
	<tr>
		<td style="background: #E1F4FD; border: 0; padding: 15px 20px; vertical-align: middle;">
			<b>Принять участие в конференции Бизнес-завтрак – Правовое регулирование телеком-отрасли: итоги 2014 года</b>
		</td>
		<td style="background: #E1F4FD; border: 0; padding: 15px 10px; text-align: center; vertical-align: middle; width: 200px;">
			<a href="<?=$user->getFastauthUrl('http://pay.runet-id.com/register/kombreak14/')?>" style="display: inline-block; background: #3B3B3B; color: #ffffff; padding: 10px 20px; border-radius: 4px; border-top: 1px solid #737373; border-left: 1px solid #737373; text-decoration: none;">Регистрация</a>
		</td>
	</tr>
</table>

<hr style="border: 0; border-top: 1px solid #DDDDDD; height: 1px; margin: 50px 0; width: 100%;" />

<table style="border: 0; border-collapse: collapse; margin: 25px 0; width: 100%;">
	<tr>
		<td style="border: 0; padding: 10px; vertical-align: top;">
			<h1>Конференция<br/>Интернет и Бизнес. Россия 2014</h1>
		</td>
		<td style="border: 0; padding: 10px; vertical-align: top; width: 200px;">
			<img src="http://runet-id.com/files/event/ibcrussia14/120.png" style="border: 0; height: auto; width: 120px;" />
		</td>
	</tr>
	<tr>
		<td style="border: 0; padding: 10px; vertical-align: top;">
			<p>Компания «Ашманов и партнеры» совместно с Российской ассоциацией электронных коммуникаций проведут в Москве Internet Business Conference Russia 2014 — крупнейшую отраслевую конференцию для бизнеса об интернет-маркетинге и веб-разработке.</p>
			<p>Объединяя в себе многолетние успешные проекты &laquo;Сайт&raquo; и Optimization, Конференция &laquo;Интернет и Бизнес. Россия&raquo; (IBC Russia) является ответом на заинтересованность бизнеса в единой экспертной площадке. Конференция призвана помочь менеджменту российских компаний разобраться в инструментах и методологиях интернет-маркетинга, чтобы сформировать целостную стратегию работы с аудиторией Интернета.</p>
		</td>
		<td style="border: 0; padding: 10px; vertical-align: top; width: 200px;">
			<h4>27-28 ноября 2014 г.</h4>
			<p><b>Место проведения:</b><br/>г. Москва, Берсеневская набережная, д. 6, стр. 3, Москва, Digital October</p>
			<p><a href="http://ibcrussia.com/" target="_blank">ibcrussia.com/</a></p>
		</td>
	</tr>
	<tr>
		<td style="background: #E1F4FD; border: 0; padding: 15px 20px; vertical-align: middle;">
			<b>Принять участие в конференции Интернет и Бизнес. Россия 2014</b>
		</td>
		<td style="background: #E1F4FD; border: 0; padding: 15px 10px; text-align: center; vertical-align: middle; width: 200px;">
			<a href="http://ibcrussia.com/registration/" style="display: inline-block; background: #3B3B3B; color: #ffffff; padding: 10px 20px; border-radius: 4px; border-top: 1px solid #737373; border-left: 1px solid #737373; text-decoration: none;">Регистрация</a>
		</td>
	</tr>
</table>

</table>

<hr style="border: 0; border-top: 1px solid #DDDDDD; height: 1px; margin: 50px 0; width: 100%;" />

<table style="border: 0; border-collapse: collapse; margin: 25px 0; width: 100%;">
	<tr>
		<td style="border: 0; padding: 10px; vertical-align: top;">
			<h1>Конференция<br/>Google-премия для молодых предпринимателей (в рамках GSEA-2014)</h1>
		</td>
		<td style="border: 0; padding: 10px; vertical-align: middle; width: 200px;">
			<img src="http://2014.gsea.bz/img/logo.png" style="border: 0; height: auto; width: 120px; background-color: black" />
		</td>
	</tr>
	<tr>
		<td style="border: 0; padding: 10px; vertical-align: top;">
			<p>В этом году премия GSEA вышла за рамки обычного конкурса и стала крупной networking-площадкой для интернет-проектов. Помимо финала премии GSEA и вручения специального приза от Google, в этом году пройдет конференция GSEA &laquo;Бизнес-герои: технологии взрывного роста&raquo;.</p>
			<p>Молодые предприниматели,  мэтры российского бизнеса, топ-менеджеры крупных компаний и бизнес-эксперты обсудят, как жить предпринимателям в России в эпоху нестабильностей.</p>

		</td>
		<td style="border: 0; padding: 10px; vertical-align: top; width: 200px;">
			<h4>4 декабря 2014 г.</h4>
			<p><b>Место проведения:</b><br/>г. Москва, Берсеневская наб., д. 6, стр. 3, Digital October</p>
			<p><a href="http://2014.gsea.bz/" target="_blank">2014.gsea.bz</a></p>
		</td>
	</tr>
</table>

<hr style="border: 0; border-top: 1px solid #DDDDDD; height: 1px; margin: 50px 0; width: 100%;" />

<table style="border: 0; border-collapse: collapse; margin: 25px 0; width: 100%;">
	<tr>
		<td style="border: 0; padding: 10px; vertical-align: top;">
			<h1>Конференция<br/>&laquo;Hello, Blogger!&raquo;</h1>
		</td>
		<td style="border: 0; padding: 10px; vertical-align: top; width: 200px;">
			<img src="http://hbconf.ru/static/img/logo2.png" style="border: 0; height: auto; width: 120px;" />
		</td>
	</tr>
	<tr>
		<td style="border: 0; padding: 10px; vertical-align: top;">
			<p>Главная задача конференции — показать широкой общественности, насколько плотно интернет-продвижение и реклама в целом связана с блогосферой и нишевыми социальными сетями.</p>
		</td>
		<td style="border: 0; padding: 10px; vertical-align: top; width: 200px;">
			<h4>10 декабря 2014 г.</h4>
			<p><b>Место проведения:</b><br/>г. Санкт-Петербург, Московский проспект, д. 97, Гостиница Holiday Inn Московские ворота</p>
			<p><a href="http://hbconf.ru" target="_blank">hbconf.ru</a></p>
		</td>
	</tr>
	<tr>
		<td style="background: #E1F4FD; border: 0; padding: 15px 20px; vertical-align: middle;">
			<b>Принять участие в &laquo;Hello, Blogger!&raquo;</b>
		</td>
		<td style="background: #E1F4FD; border: 0; padding: 15px 10px; text-align: center; vertical-align: middle; width: 200px;">
			<a href="<?=$user->getFastauthUrl('http://pay.runet-id.com/register/hb14/')?>" style="display: inline-block; background: #3B3B3B; color: #ffffff; padding: 10px 20px; border-radius: 4px; border-top: 1px solid #737373; border-left: 1px solid #737373; text-decoration: none;">Регистрация</a>
		</td>
	</tr>
</table>