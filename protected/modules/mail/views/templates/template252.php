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
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Вы зарегистрированы на RIW 2014 со статусом:<br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" /><big style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 22px; line-height: 1.4; font-weight: 200; margin: 0; padding: 0;"><span class="status" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; font-weight: bold; display: inline-block; background-color: #FFCE00; margin: 0; padding: 1px 5px;"><?=getRoleName($user->Participants[0]->Role->Id)?></span></big></p>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Все новости первого дня: <a href="http://tass.ru/riw" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">http://tass.ru/riw</a></p>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><img src="http://showtime.s3.amazonaws.com/20141113-riw14.jpg" alt="" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; height: auto; max-width: 100%; margin: 0; padding: 0;" /></p>&#13;
						<h3 style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 22px; line-height: 1.2; color: #000; font-weight: 200; margin: 40px 0 10px; padding: 0;">Главные акценты RIW второго дня (четверг 13 ноября):</h3>&#13;
						<ul style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;"><li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;"> &#13;
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Утром (в 11:00) конференционная программа RIW стартует с секции Министерства связи и массовых коммуникаций РФ «Государственная поддержка развития IT-отрасли». <br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" />&#13;
						 В секции примут участие Министр связи <b style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Николай Никифоров</b>, руководители институтов развития (РВК, ФРИИ, Сколково, АИРР, ФПИ, Росинфокоминвест), проведет секцию Директор РАЭК <b style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Сергей Плуготаренко</b>. <br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" /><br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" />&#13;
						 Секция пройдет в Presentation Hall (свободный доступ для всех категорий участия). &#13;
								</p>&#13;
							</li>&#13;
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;"> &#13;
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Подробная программа работы зала <a href="http://riw.moscow/program/2014-11-13/226/#s2032" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">Presentation Hall в четверг</a>.</p>&#13;
							</li>&#13;
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;"> &#13;
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Продолжат работу <a href="http://riw.moscow/expo/scheme/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">Выставка «Интернет 2014»</a> и выставка <a href="http://softool.ru/new_html/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">Softool 2014</a> (свободный доступ для всех категорий участия)</p>&#13;
							</li>&#13;
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;"> &#13;
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Конференционная программа Медиакоммуникационного Форума пройдет в <b style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">12 залах</b> в течение всего дня (доступ только для участников со статусом «Участник Форума»). Доступна подробная <a href="http://riw.moscow/program/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">программа Форума</a>.</p>&#13;
							</li>&#13;
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;"> &#13;
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Вечером пройдут специальные мероприятия <a href="http://riw.moscow/special/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">RIW-Night</a>.</p>&#13;
							</li>&#13;
						</ul><h3 style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 22px; line-height: 1.2; color: #000; font-weight: 200; margin: 40px 0 10px; padding: 0;">Вниманию участников RIW 2014: </h3>&#13;
						<ul style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;"><li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;"> &#13;
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Если Вы уже были на RIW в первый день (в среду 12 ноября) и получили бейдж участника, сообщаем, что бейдж выдается один раз, Вам необходимо предъявлять его все последующие дни посещения RIW 2014.</p>&#13;
							</li>&#13;
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;"> &#13;
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Если в четверг Вы поедете на плошадку RIW 2014 впервые, рекомендуем Вам распечатать и взять с собой Ваш персональный ПУТЕВОЙ ЛИСТ — это значительно ускорит Вашу регистрацию на месте: <br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" /></p><div style="text-align: center; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 5px 0 0; padding: 0;" align="center"><a href="<?=$user->Participants[0]->getTicketUrl()?>" class="btn-primary" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.2; color: #FFF; text-decoration: none; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #FA2045; margin: 0 10px 0 0; padding: 0; border-color: #fa2045; border-style: solid; border-width: 10px 25px 15px;"><b style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Путевой лист</b></a></div>&#13;
								&#13;
							</li>&#13;
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;"> &#13;
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">В случае необходимости — получить <b style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">отчетные документы для юридических лиц</b> и проставить отметку в <b style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">командировочных удостоверениях</b> — можно 13 и 14 ноября с 09:00 до 16:00 в отдельном окне «ФИНАНСОВАЯ ГРУППА» (расположено в самом конце линии регистрации, рядом с турникетами)</p>&#13;
							</li>&#13;
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;"> &#13;
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><b style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Презентации докладчиков</b>, фотографии и другие материалы первого дня собираются, обрабатываются и будут доступны на сайте уже со следующей недели, о чем мы обязательно проинформируем вас отдельным письмом.</p>&#13;
							</li>&#13;
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;">&#13;
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><img src="http://showtime.s3.amazonaws.com/20141113-riw14_3.jpg" style="float: right; width: 120px; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; height: auto; max-width: 100%; margin: 10px; padding: 0;" align="right" /><b style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Официальное мобильное приложение</b> RIW 2014 поможет вам получить всю актуальную информацию о секциях и докладах конференции, напомнит об интересных для вас мероприятиях, позволит легко сориентироваться на огромной территории выставки. </p>&#13;
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Приложение содержит представленную в удобном виде информацию о конференции, но также использует возможности технологии iBeacon, позволяющей обеспечить предоставление контента, релевантного вашим интересам и местоположению. Вы можете <a href="https://play.google.com/store/apps/details?id=com.mobecan.android.riw2014" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">скачать для Android</a></p>&#13;
							</li>&#13;
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;">&#13;
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><b style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Для оценки выступлений</b> на мероприятии RIW 2014 фирма «1С» представляет мобильное приложение Конферометр. Приложение Конферометр разработано для демонстрации возможностей мобильной платформы 1С:Предприятие 8.</p>&#13;
								<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Для того чтобы получить расписание актуальных мероприятий или проголосовать за понравившийся доклад — скачайте приложение для Вашего мобильного устройства: <a href="http://riw.moscow/play.google.com/store/apps/details?id=com.e1c.conferometer" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">Конферометр для Android</a> и <a href="https://itunes.apple.com/ru/app/id933155334" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">Конферометр для iOS</a>.</p>&#13;
							</li>&#13;
						</ul><p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><img src="http://showtime.s3.amazonaws.com/20141113-riw14_2.jpg" alt="" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; height: auto; max-width: 100%; margin: 0; padding: 0;" /></p>&#13;
						<h3 style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 22px; line-height: 1.2; color: #fff; font-weight: 200; margin: 40px 0 10px; padding: 0; padding: 5px 10px;
background: #FA2045;">Важная информация для тех, кто планирует посетить только второй и третий дни Форума на RIW 2014 (13 и 14 ноября):</h3>&#13;
						<ul style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;"><li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;">Сегодня <b style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0; ">мы снизили стоимость участия</b> в конференционной программе Форума на 2000 рублей: приобрести статус «Участник Форума» (посещение всех секций во всех залах, доступ в Бизнес-зону) на 2 оставшихся дня — можно всего за 6000 рублей.</li>&#13;
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;">Если Вы или Ваши коллеги еще не являются участниками Форума, приобрести статус «Участник Форума» для Вас или Ваших коллег можно в Личном Кабинете:</li>&#13;
						</ul><div class="frame center" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; text-align: center; border-bottom-width: 1px; border-bottom-color: #F6F6F6; border-bottom-style: solid; margin: 25px 0; padding: 0;" align="center">&#13;
							<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><a href="<?=$regLink?>" class="btn-primary" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.2; color: #FFF; text-decoration: none; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #FA2045; margin: 0 10px 0 0; padding: 0; border-color: #fa2045; border-style: solid; border-width: 10px 25px 15px;"><big style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 22px; line-height: 1.4; font-weight: 200; margin: 0; padding: 0;"><b style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">ЛИЧНЫЙ КАБИНЕТ</b></big><br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" /><small style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.6; margin: 0; padding: 0;">(персональная ссылка)</small></a></p>&#13;
							<p class="center margin-side small" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 70%; line-height: 1.4; text-align: center; color: #999999; font-weight: normal; margin: auto 10% 25px; padding: 0;" align="center">Посещение Выставки «Интернет 2014» и некоторых мероприятий Недели Российского Интернета — бесплатное для зарегистрированных участников.</p>&#13;
						</div>&#13;
&#13;
						&#13;
					</td>&#13;
				</tr></table></div>&#13;
			&#13;
			&#13;
		</td>&#13;
		<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>&#13;
	</tr></table></body>
</html>
