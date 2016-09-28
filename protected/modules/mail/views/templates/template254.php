<?php
$regLink = "http://riw.moscow/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'vyeavbdanfivabfdeypwgruqe'), 0, 16);
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
				return 'Посетитель выставки';
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
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Ваш текущий статус на RIW 2014:<br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" /><big style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 22px; line-height: 1.4; font-weight: 200; margin: 0; padding: 0;"><span class="status" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; font-weight: bold; display: inline-block; background-color: #FFCE00; margin: 0; padding: 1px 5px;"><?=getRoleName($user->Participants[0]->Role->Id)?></span></big></p>&#13;
						&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Первые два дня RIW запомнились участникам масштабом выставки и конференции, эксклюзивными презентациями (в том числе Концепции развития Медиа-коммуникационной отрасли до 2025 года и Экономики Рунета 2014), мероприятиями организаторов и партнеров. </p>&#13;
						<p><img src="http://showtime.s3.amazonaws.com/2014113-riw14_section2.jpg" style="height: auto; max-width: 100%; margin: 0; padding: 0;" /></p>
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Также за 2 дня работы RIW посетили высокопоставленные гости — в первый день: <strong style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Вячеслав Володин</strong> — первый заместитель руководителя Администрации Президента РФ; <strong style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Александр Жаров</strong> — глава Роскомнадзора, <strong style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Леонид Левин</strong> — глава профильного Комитета Госдумы по инфополитике, массовым коммуникациям и связи; во второй день: <strong style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Николай Никифоров</strong> — министр связи и массовых коммуникаций РФ, вице-спикер Госдумы <strong style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Сергей Железняк</strong>.</p>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Все новости первых двух дней RIW 2014: <a href="http://tass.ru/riw" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">http://tass.ru/riw</a></p>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Третий день работы RIW 2014 начнется в пятницу 14 ноября 2014 года в 10:00 утра.</p>&#13;
&#13;
						<hr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; border-top-color: #F6F6F6; border-top-style: solid; height: 1px; margin: 25px 0; padding: 0; border-width: 1px 0 0;" /><h3 style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 22px; line-height: 1.2; color: #000; font-weight: 200; margin: 40px 0 10px; padding: 0;">Не пропустите завершающий день работы RIW 2014 (пятница 14 ноября) — вот главные его акценты: </h3>&#13;
						<ul style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;"><li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;"> &#13;
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">В пятницу с 10 утра продолжат работу <a href="http://riw.moscow/expo/scheme/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">Выставка «Интернет 2014»</a> и выставка <a href="http://softool.ru/new_html/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">Softool 2014</a> (свободный доступ для всех категорий участия)</p>&#13;
							</li>&#13;
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;"> &#13;
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">В 11:00 утра сразу во всех 12 залах стартует конференционная программа RIW. </p>&#13;
							</li>&#13;
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;"> &#13;
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Программа зала Presentation Hall (свободный доступ для всех категорий участия) в пятницу будет посвящена вопросам <a href="http://riw.moscow/program/2014-11-14/226/#s2060" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">развития Видео в интернете</a></p>&#13;
							</li>&#13;
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;"> &#13;
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><a href="http://riw.moscow/program/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">Подробная программа</a> Медиакоммуникационного Форума (доступ только для участников со статусом «Участник Форума») будет представлена в пятницу блок-конференциями: <br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" />&#13;
						 Social Media, Веб-технологии и Менеджмент, Мобильные технологии, продукты и решения, Дизайи и пользовательские интерфейсы, Crowd Conf — Регионы, секциями Softool. &#13;
								</p>&#13;
							</li>&#13;
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;"> &#13;
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Вечером пройдут специальные мероприятия <a href="http://riw.moscow/special/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">RIW-Night</a></p>&#13;
							</li>&#13;
						</ul><div style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 25px; border: 2px solid #ffce00;">&#13;
							<h3 style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 22px; line-height: 1.2; color: #000; font-weight: 200; margin: 0 0 10px; padding: 0;">Важная информация для тех, кто планирует посетить только третий день Форума (пятница, 14 ноября):</h3>&#13;
							<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Сегодня мы снизили стоимость участия в конференционной программе Форума на <strong style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">4000 рублей</strong>: приобрести статус «Участник Форума» (посещение всех секций во всех залах, доступ в Бизнес-зону) в третий день — можно всего за 4000 рублей.</p>&#13;
							<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Если Вы или Ваши коллеги еще не являются участниками Форума, приобрести статус «Участник Форума» — для Вас или Ваших коллег — можно в Вашем Личном Кабинете: </p>&#13;
							<div style="text-align: center; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 5px 0 0; padding: 0;" align="center"><a href="<?=$regLink?>" class="btn-primary" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.2; color: #FFF; text-decoration: none; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #FA2045; margin: 0 10px 0 0; padding: 0; border-color: #fa2045; border-style: solid; border-width: 10px 25px 15px;"><b style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Личный кабинет</b></a></div>&#13;
						</div>&#13;
&#13;
						<h3 style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 22px; line-height: 1.2; color: #000; font-weight: 200; margin: 40px 0 10px; padding: 0;">Специальный анонс программы Форума:</h3>&#13;
						<ul style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;"><li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;">Если Вы только начинаете знакомиться с Digital-маркетингом, приглашаем Вас на новый проект ADLABS при поддержке РАЭК: Академию интернет-маркетинга. 14 ноября с самого утра и до позднего вечера признанные эксперты отрасли будут рассказывать об основах интернет-маркетинга.</li>&#13;
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;">На первой секции вы узнаете про <a href="http://riw.moscow/special/cctld/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">современные каналы интернет-маркетинга</a>, про то, как ставить KPI, какие этапы построения стратегии существуют, а также о перспективах развития рынка рекламы (11:00 — 13:00, Брифинг-зал КЦ в Бизнес-зоне).</li>&#13;
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;">Далее Вы узнаете про различные виды интернет-рекламы: контекстная, баннерная, реклама в социальных сетях, реклама с оплатой за действие (13:30 — 15:30, Зал: Softool Hall).</li>&#13;
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;">И в завершении дня в рамках Академии интернет-маркетинга специалисты раскроют вам <a href="http://riw.moscow/program/2014-11-14/236/#s2128" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">тонкости применения веб-аналитики</a> (16:00 — 18:00, Зал: Softool Hall).</li>&#13;
						 </ul><hr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; border-top-color: #F6F6F6; border-top-style: solid; height: 1px; margin: 25px 0; padding: 0; border-width: 1px 0 0;" /><h3 style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 22px; line-height: 1.2; color: #000; font-weight: 200; margin: 40px 0 10px; padding: 0;">Вниманию участников RIW 2014:</h3>&#13;
						<ul style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;"><li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;"> &#13;
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><a href="http://riw.moscow/info/guide/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">Памятка участника RIW 2014</a></p>&#13;
						 	</li>&#13;
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;"> &#13;
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Если Вы уже были на RIW в первый или второй день (12 или 13 ноября) и получили бейдж участника, сообщаем, что бейдж выдается один раз, Вам необходимо взять его с собой и предъявить на входе в третий день посещения RIW 2014.</p>&#13;
						 	</li>&#13;
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;"> &#13;
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">В случае необходимости — получить <b style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">отчетные документы для юридических лиц</b> и проставить отметку в <b style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">командировочных удостоверениях</b> — можно весь день 14 ноября с 09:00 до 16:00 в отдельном окне «ФИНАНСОВАЯ ГРУППА» (расположено в самом конце линии регистрации, рядом с турникетами)</p>&#13;
						 	</li>&#13;
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;"> &#13;
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Если в четверг Вы поедете на плошадку RIW 2014 впервые, рекомендуем Вам распечатать и взять с собой Ваш персональный ПУТЕВОЙ ЛИСТ (либо сохранить его на Ваше мобильное устройство) — это значительно ускорит Вашу регистрацию на месте:</p>&#13;
								<div style="text-align: center; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 5px 0 0; padding: 0;" align="center"><a href="<?=$user->Participants[0]->getTicketUrl()?>" class="btn-primary" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.2; color: #FFF; text-decoration: none; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #FA2045; margin: 0 10px 0 0; padding: 0; border-color: #fa2045; border-style: solid; border-width: 10px 25px 15px;"><b style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Путевой лист</b></a></div>&#13;
						 	</li>&#13;
						 </ul></td>&#13;
				</tr></table></div>&#13;
			&#13;
			&#13;
		</td>&#13;
		<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>&#13;
	</tr></table></body>
</html>
