<?php
if (!function_exists("getRoleName")) {
	function getRoleName($roleId) {
		switch ($roleId) {
			case 3:
				return 'Докладчик';
			case 6:
				return 'Организатор';
			case 5:
				return 'Партнер';
			case 2:
				return 'СМИ';
			case 1:
				return 'Участник выставки';
			case 11:
			default:
				return 'Участник форума';
		}
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">
  <head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>RIW 2014</title>
    <style>
<![CDATA[
/* -------------------------------------
		GLOBAL
------------------------------------- */
* {
	margin: 0;
	padding: 0;
	font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
	font-size: 100%;
	line-height: 1.6;
}

img {
	height: auto;
	max-width: 100%;
}

body {
	background: #002061;
	-webkit-font-smoothing: antialiased;
	-webkit-text-size-adjust: none;
	width: 100%!important;
	height: 100%;
}

hr {
	border: 0;
	border-top: 1px solid #F6F6F6;
	height: 1px;
	margin: 25px 0;
}


/* -------------------------------------
		ELEMENTS
------------------------------------- */
a {
	color: #348eda;
}

.btn-primary {
	text-decoration: none;
	color: #FFF;
	background-color: #FA2045;
	border: solid #FA2045;
	border-width: 10px 25px 15px;
	line-height: 1.2;
	margin-right: 10px;
	text-align: center;
	cursor: pointer;
	display: inline-block;
	border-radius: 5px;
	text-transform: uppercase;
}

.btn-secondary {
	text-decoration: none;
	color: #FFF;
	background-color: #001D63;
	border: solid #001D63;
	border-width: 5px 10px;
	line-height: 2;
	font-weight: bold;
	margin-right: 10px;
	text-align: center;
	cursor: pointer;
	display: inline-block;
	border-radius: 25px;
}

.status {
	background: #FFCE00;
	font-weight: bold;
	display: inline-block;
	padding: 1px 5px;
}

.last {
	margin-bottom: 0;
}

.first {
	margin-top: 0;
}

.padding {
	padding: 10px 0;
}

.margin-side {
	margin: auto 10% 25px 10%;
}

.center {
	text-align: center;
}

.small {
	color: #999999;
	font-size: 70%;
	line-height: 1.4;
}
.frame {
	border-bottom: 1px solid #F6F6F6;
	margin: 25px 0;
}
.bordered {
	border: 1px dashed #FFCF00;
	margin: 25px 0;
	padding: 10px 25px;
}


/* -------------------------------------
		BODY
------------------------------------- */
table.body-wrap {
	width: 100%;
	padding: 20px;
}

table.body-wrap .container {
	border: 1px solid #f0f0f0;
}


/* -------------------------------------
		TYPOGRAPHY
------------------------------------- */
h1, h2, h3 {
	font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
	line-height: 1.1;
	margin-bottom: 15px;
	color: #000;
	margin: 40px 0 10px;
	line-height: 1.2;
	font-weight: 200;
}

h1 {
	font-size: 36px;
}
h2 {
	font-size: 28px;
}
h3 {
	font-size: 22px;
}

big {
	font-size: 22px;
	font-weight: 200;
	line-height: 1.4;
}

small {
	font-size: 11px;
}

p, ul, ol {
	margin-bottom: 10px;
	font-weight: normal;
	font-size: 14px;
}

p {
	margin: 15px 0 20px;
}

ul li, ol li {
	margin: 5px 0 5px 35px;
	list-style-position: outside;
}

/* ---------------------------------------------------
		RESPONSIVENESS
		Nuke it from orbit. It's the only way to be sure.
------------------------------------------------------ */

.container {
	display: block!important;
	max-width: 600px!important;
	margin: 0 auto!important; /* makes it centered */
	clear: both!important;
}

.body-wrap .container {
	padding: 20px;
}

.content {
	max-width: 600px;
	margin: 0 auto;
	display: block;
}

.content table {
	width: 100%;
}

/* Figure out where the breaks happen and use that in the media query */
@media (max-width: 400px) {
  .chunk {
    width: 100% !important;
  }
}

]]>
    </style>
  </head>
  <body bgcolor="#00225F" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; background-color: #002061; margin: 0; padding: 0;">&#13;
&#13;
&#13;
<table class="body-wrap" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; width: 100%; margin: 0; padding: 20px;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>&#13;
		<td class="container" bgcolor="#00225F" border="0" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto; padding: 20px; border: 0 solid #f0f0f0;">&#13;
			&#13;
			<br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" /><img src="http://showtime.s3.amazonaws.com/20141016005402_-_RIW_2014_Russian_Interactive_Week_2014__glavnoe_osennee_meropriyatie_treh_otraslei_Internet_Media_Telekom_-_qhvip.jpg" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; height: auto; max-width: 100%; margin: 0; padding: 0;" /><br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" /></td>&#13;
		<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>&#13;
	</tr><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>&#13;
		<td class="container" bgcolor="#FFFFFF" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto; padding: 20px; border: 1px solid #f0f0f0;">&#13;
			&#13;
			<div class="content" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; max-width: 600px; display: block; margin: 0 auto; padding: 0;">&#13;
			<table style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; width: 100%; margin: 0; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">&#13;
						<h3 style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 22px; line-height: 1.2; color: #000; font-weight: 200; margin: 0 0 10px; padding: 0;">Здравствуйте, <?=$user->getShortName()?>.</h3>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Мы рады, что Вы зарегистрировались на RIW 2014 (Russian Interactive Week), который пройдет <nobr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">12-14</nobr> ноября в московском Экспоцентре — <a href="http://www.riw.moscow" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">www.RIW.moscow</a></p>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Ваш статус на RIW 2014:<br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" /><b style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><?=getRoleName($user->Participants[0]->Role->Id)?></b></p>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">RIW — это большой Форум и масштабная Выставка. Но еще RIW — это множество специальных мероприятий, культурных и развлекательных проектов, вечеринок и after-parties.</p>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">И сегодня — в праздничный день — мы хотим рассказать о том, что RIW — это большой ПРАЗДНИК: </p>&#13;
						<h3 style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 22px; line-height: 1.2; color: #000; font-weight: 200; margin: 40px 0 10px; padding: 0;">RIW-Night: премии, награды и конкурсы</h3>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">RIW-Night — это целый блок вечерних мероприятий в формате ежегодных премий, наград и конкурсов, среди которых: </p>&#13;
						<ul style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;"><li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;"> &#13;
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><strong style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><a href="http://riw.moscow/special/goldensite/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">Золотой сайт 2014</a></strong><br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" />&#13;
						 Ежегодная премия, ключевой и старейший конкурс интернет-проектов в Рунете. <br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" />&#13;
						 В этом году к Михаилу Вахтерову (основателю и идеологу конкурса) и оргкомитету Золотого Сайта подключились в качестве соорганизаторов РАЭК и проект Ruward. Совместными усилиями мы выводим конкурс на новый уровень — мы обновили практически все аспекты проекта, начиная от статуэток и заканчивая новым списком номинаций — и ждем участников, которые готовы представить свои проекты на суд независимого жюри, которое возглавил Сергей Котырев! <a href="http://riw.moscow/special/goldensite/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;"><br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" /></a> &#13;
								</p>&#13;
						 	</li>&#13;
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;"> &#13;
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><strong style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><a href="http://riw.moscow/special/party/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">Вечеринка маркетинг-директоров</a></strong><br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" />&#13;
						 13 ноября 2014 года digital-агентство RTA и РАЭК проведут вторую закрытую вечеринку для маркетинг директоров — это уникальная вечерняя площадка для обмена опытом и экспертизой между топовыми маркетологами страны. &#13;
								</p>&#13;
						 	</li>&#13;
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;"> &#13;
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><a href="http://riw.moscow/special/ima/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;"><strong style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Internet Media Awards</strong></a>Первая интернет-медиа премия, определяющая и оценивающая важнейшие достижения в современной информационной сфере. Участие в конкурсе IMA 2014 — это отличный стимул «засветиться» для любого амбициозного проекта. Круг рассматриваемых форматов необычайно широк: и «классика» (новостные, деловые life-style, специализированные издания), и самые интересные онлайн-медиа, и самые выдающиеся медиа-персоны, и многое другое. &#13;
								</p>&#13;
						 	</li>&#13;
						 </ul><h3 style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 22px; line-height: 1.2; color: #000; font-weight: 200; margin: 40px 0 10px; padding: 0;">MediaNovation 2014</h3>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Специальная экспозиция проекта <a href="http://riw.moscow/special/medianovation/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">MediaNovation 2014</a> в рамках Russian Interactive Week представит арт-объекты, созданные с использованием новых технологий: интерактивные сайнз-арт инсталляции, необычные фотосеты и digital art объекты, выполненные специалистами разных дисциплин. </p>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Посетили смогут погрузиться в увлекательный квест-опыт, увидеть, что левитация возможна, приручить домашний торнадо, прочитать загадочный алфавит, заглянуть в код программы, и увидеть, что даже в простых и обыденных вещах таится магия творческого поиска и красоты.</p>&#13;
						<h3 style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 22px; line-height: 1.2; color: #000; font-weight: 200; margin: 40px 0 10px; padding: 0;">Музей мобильных технологий</h3>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Музей мобильных технологий — место, где будет представлена <a href="http://riw.moscow/special/mobile/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">уникальная коллекция мобильных телефонов</a>. Телефон-бритва, сотовый размером с дыню, легендарная Nokia 3310, телефоны из титана, первые коммуникаторы и смартфоны, телефон из фильма «Матрица» и многое-многое другое.</p>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Среди наших экспонатов все новые гаджеты: Google Glass, Oculus Rift, 3D-сканеры и принтеры, все виды носимой электроники, а также необычные концепты, которые можно увидеть только у нас.</p>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Музей покажет и расскажет, как работает сотовая связь и что внутри сотового телефона, здесь можно будет познакомиться с теми, кто разрабатывает смартфоны и послушать интересные лекции. А также принять участие в чемпионате по игре «Змейка» или просто выпить кофе!</p>&#13;
&#13;
						<hr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; border-top-color: #F6F6F6; border-top-style: solid; height: 1px; margin: 25px 0; padding: 0; border-width: 1px 0 0;" /><p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Ну и конечно, Вас ждем много интересного на Выставке «Интернет 2014» и в рамках спецмероприятий Форума: </p>&#13;
						<ul style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;"><li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;"> &#13;
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Форум и пространство <a href="http://riw.moscow/special/finovations/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">«Деньги Будущего»</a></p>&#13;
							</li>&#13;
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;"> &#13;
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><a href="http://riw.moscow/special/upstart/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">Зона стартапов</a> — «Аллея инноваций», «Стартап-поляна» и UpStart-конференция</p>&#13;
							</li>&#13;
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;"> &#13;
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Уникальные презентации / выступления и шоу в <a href="http://riw.moscow/forum/presentation-hall/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">Presentation Hall</a></p>&#13;
							</li>&#13;
						</ul><p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><a href="http://riw.moscow/info/guide/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">Подробная информация</a> для участников.</p>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">До встречи на RIW 2014! </p>&#13;
&#13;
						<hr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; border-top-color: #F6F6F6; border-top-style: solid; height: 1px; margin: 25px 0; padding: 0; border-width: 1px 0 0;" /><p class="center" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; text-align: center; font-weight: normal; margin: 15px 0 20px; padding: 0;" align="center">Остались вопросы?<br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" /><a href="http://riw.moscow" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">www.riw.moscow</a><br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" /><a href="mailto:users@russianinternetweek.ru" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">users@russianinternetweek.ru</a><br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" /><a href="tel:+79999910745" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">+7 (999) 991-0745</a> или <a href="tel:+79999977890" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">+7 (999) 997-7890</a>&#13;
						</p>&#13;
					</td>&#13;
				</tr></table></div>&#13;
			&#13;
			&#13;
		</td>&#13;
		<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>&#13;
	</tr></table></body>
</html>
