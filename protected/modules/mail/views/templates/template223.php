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
	background: #ffffff;
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
	background-color: #999;
	border: solid #999;
	border-width: 5px 8px;
	line-height: 1.4;
	font-weight: bold;
	margin-right: 10px;
	text-align: center;
	cursor: pointer;
	display: inline-block;
	border-radius: 5px;
	font-size: 12px;
}

.btn-link {
	text-decoration: none;
	border-width: 4px 8px;
	line-height: 2;
	font-weight: bold;
	margin-right: 10px;
	text-align: center;
	cursor: pointer;
	display: inline-block;
	font-size: 14px;
}

.status {
	background: #FFCE00;
	font-weight: bold;
	display: inline-block;
	padding: 1px 5px;
}

.hint {
	background: #CDE5C1;
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
h4 {
	background: #00509E;
	color: #FFF;
  font-size: 18px;
  margin-top: 35px;
	padding: 5px 10px;
}
h5 {
	font-size: 14px;
	margin: 10px 0 0;
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
    min-width: 240px;
  }
}

]]>
    </style>
  </head>
  <body bgcolor="#FFFFFF" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; background-color: #ffffff; margin: 0; padding: 0;">&#13;
&#13;
&#13;
<table class="body-wrap" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; width: 100%; margin: 0; padding: 20px;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>&#13;
		<td class="container" bgcolor="#FFFFFF" border="0" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto; padding: 20px; border: 0 solid #f0f0f0;">&#13;
			<table width="100%" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">&#13;
						<a href="http://riw.moscow/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;"><img src="http://getlogo.org/img/riw/652/200x/" alt="RIW" title="RIW" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; height: auto; max-width: 100%; margin: 0; padding: 0;" /></a>&#13;
						<table align="right" style="float: right; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 25px 0 0; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><a href="http://riw.moscow/expo/scheme/" class="btn-link" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 12px; line-height: 2; color: #348eda; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; margin: 0 10px 0 0; padding: 0; border-width: 4px 8px;">Выставка</a></td>&#13;
								<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><a href="http://riw.moscow/program/" class="btn-link" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 12px; line-height: 2; color: #348eda; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; margin: 0 10px 0 0; padding: 0; border-width: 4px 8px;">Программа</a></td>&#13;
								<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><a href="<?=$regLink?>" class="btn-link" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 12px; line-height: 2; color: #348eda; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; margin: 0 10px 0 0; padding: 0; border-width: 4px 8px;">Кабинет</a></td>&#13;
							</tr></table></td>&#13;
				</tr></table></td>&#13;
		<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>&#13;
	</tr><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>&#13;
		<td class="container" bgcolor="#FFFFFF" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto; padding: 20px; border: 1px solid #f0f0f0;">&#13;
			&#13;
			<div class="content" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; max-width: 600px; display: block; margin: 0 auto; padding: 0;">&#13;
			<table style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; width: 100%; margin: 0; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">&#13;
						<h3 style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 22px; line-height: 1.2; color: #000; font-weight: 200; margin: 0 0 10px; padding: 0;">Здравствуйте, <?=$user->getShortName();?>.</h3>&#13;
            <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Вы зарегистрированы на RIW 2014 со статусом:<br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" /><big style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 22px; line-height: 1.4; font-weight: 200; margin: 0; padding: 0;"><span class="status" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; font-weight: bold; display: inline-block; background-color: #FFCE00; margin: 0; padding: 1px 5px;"><?=getRoleName($user->Participants[0]->Role->Id);?></span></big></p>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">RIW 2014 (Russian Interactive Week — <a href="http://www.riw.moscow" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">www.RIW.moscow</a>) стартует уже в эту в среду и пройдет <b style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><nobr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">12—13—14</nobr> ноября 2014 года</b> в московском Экспоцентре на Красной Пресне.</p>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">RIW — это Выставка «ИНТЕРНЕТ 2014», Медиа-Коммуникационный Форум, ряд специальных мероприятий и проектов.</p>&#13;
						<h2 style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 28px; line-height: 1.2; color: #000; font-weight: 200; margin: 0 0 10px; padding: 0;">Этот RIW станет самым большим за всю <nobr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">7-летнюю</nobr> историю!</h2>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Уже сейчас на RIW зарегистрировано около <a href="http://riw.moscow/info/participants/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">19 тысяч человек</a>. В выставке примут участие сотни компаний, а в форуме за 3 дня работы в 12 залах выступят с докладами около 700 спикеров.</p>&#13;
&#13;
            <hr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; border-top-color: #F6F6F6; border-top-style: solid; height: 1px; margin: 25px 0; padding: 0; border-width: 1px 0 0;" /><h3 style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 22px; line-height: 1.2; color: #000; font-weight: 200; margin: 0 0 10px; padding: 0;">Мы с радостью приглашаем Вас принять участие в этом грандиозном проекте:</h3>&#13;
						<h4 style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 18px; line-height: 1.6; color: #FFF; background-color: #00509E; margin: 35px 0 0; padding: 5px 10px;">Выставка «Интернет 2014» и Softool 2014</h4>&#13;
            <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">В рамках RIW работает болшая выставка «ИНТЕРНЕТ 2014», а также совместно с RIW проходит <nobr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">5-я</nobr> выставка программных решений Softool 2014.</p>&#13;
            <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Доступ на Выставку имеют ВСЕ зарегистрированные на RIW 2014 участники, неважно в каком статусе.</p>&#13;
            <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">На сайте представлена подробная <a href="http://riw.moscow/expo/scheme/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">схема выставки</a>.</p>&#13;
&#13;
            <h4 style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 18px; line-height: 1.6; color: #FFF; background-color: #00509E; margin: 35px 0 0; padding: 5px 10px;">Presentation Hall</h4>&#13;
            <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Все участники RIW, зарегистрированные в любом статусе, могут посещать конференционные мероприятия в зале «Presentation Hall» (в самом сердце выставки).</p>&#13;
            <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Именно в Presentation Hall в первый день работы RIW состоится официальное открытие Выставки и Форума, и Вы можете принять в нем участие! </p>&#13;
            <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Все события, проходящие в Presentation Hall, будут транслироваться в онлайн-режиме на сайте RIW 2014.</p>&#13;
            <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><a href="http://riw.moscow/forum/presentation-hall/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">Подробное расписание</a> мероприятий в Presentation Hall во все 3 дня работы. </p>&#13;
&#13;
						<h4 style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 18px; line-height: 1.6; color: #FFF; background-color: #00509E; margin: 35px 0 0; padding: 5px 10px;">Медиакоммуникационный Форум</h4>&#13;
            <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Также, если вы еще не приобрели статус «Участник Форума, Вы можете принять участие в Медиа-Коммуникационном Форуме, который пройдет в течение 3 дней в 12 параллельных залах и объединит все самые важные темы трех отраслей: Медиа, Интернет, Телеком (УЧАСТИЕ ПЛАТНОЕ): <a class="btn-secondary" href="<?=$regLink?>" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 12px; line-height: 1.4; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; background-color: #999; margin: 0 10px 0 0; padding: 0; border-color: #999; border-style: solid; border-width: 5px 8px;">Быстрая регистрация</a></p>&#13;
            <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Статус <span class="status" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; font-weight: bold; display: inline-block; background-color: #FFCE00; margin: 0; padding: 1px 5px;">Участник Форума</span> дает следующие привилегии:</p>&#13;
            <ul style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;"><li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;">Доступ во все конференционные залы в течение 3 дней</li>&#13;
              <li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;">Неограниченный доступ в Бизнес-зону и зону кофе-брейков</li>&#13;
              <li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;">Посещение специальных мероприятий RIW 2014</li>&#13;
              <li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;">Пакет Профессионального участника Форума с уникальными материалами</li>&#13;
              <li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;">а также неограниченный онлайн-доступ ко всем материалам Форума после его завершения</li>&#13;
            </ul><p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><a href="http://riw.moscow/program/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;"><strong style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Подробная программа Форума</strong></a> (12 залов все 3 дня) — практически необъятна, чтобы Вам было легче в ней ориентироваться, мы составили отдельный <a href="http://riw.moscow/forum/blocks/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">список крупных Блок-конференций</a> по дням.</p>&#13;
            <table style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; width: 100%; margin: 0; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="vertival-align: top; width: 32px; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><img src="http://showtime.s3.amazonaws.com/icon-info-bw_32x.png" alt="" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; height: auto; max-width: 100%; margin: 0; padding: 0;" /></td>&#13;
                <td style="width: 15px; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>&#13;
                <td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">&#13;
                  <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Также важно помнить о тех топовых докладах и выступлениях, которые пройдут в зале <a href="http://riw.moscow/forum/presentation-hall/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">Presentation Hall</a>.</p>&#13;
                </td>&#13;
              </tr></table><p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">А также на RIW будут представлены:</p>&#13;
            <ul style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;"><li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;"><a href="http://riw.moscow/special/upstart/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;"><b style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">UpStart Conf</b></a> — Конференция для стартапов и инвесторов</li>&#13;
              <li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;"><a href="http://riw.moscow/special/rad/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;"><b style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Russian Affiliate Days 2014</b></a> — Конференция для рекламодателей, вебмастеров и рекламистов</li>&#13;
              <li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;"><a href="http://riw.moscow/special/finovations/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;"><b style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Форум «Деньги будущего 2014»</b></a></li>&#13;
            </ul><p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">В <a href="http://riw.moscow/forum/committee/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">специальном разделе</a> Вы можете изучить всех докладчиков (по алфавиту) и членов Программного комитета Форума.</p>&#13;
&#13;
            <h4 style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 18px; line-height: 1.6; color: #FFF; background-color: #00509E; margin: 35px 0 0; padding: 5px 10px;">Онлайн-видео</h4>&#13;
            <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Все 3 дня работы RIW 2014 будет осуществляться онлайн-трансляция только событий, проходящих в Presentation Hall.</p>&#13;
            <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><a href="http://riw.moscow/forum/presentation-hall/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">Подробное расписание</a> мероприятий в Presentation Hall во все 3 дня работы.</p>&#13;
&#13;
            <hr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; border-top-color: #F6F6F6; border-top-style: solid; height: 1px; margin: 25px 0; padding: 0; border-width: 1px 0 0;" /><h3 style="font-size: 16px; font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; line-height: 1.2; color: #000; font-weight: 200; margin: 0 0 15px; padding: 0;">И не забудьте — RIW это не только Выставка и Форум, это еще и Праздник, а также множество специальных мероприятий:</h3>&#13;
            <ul style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;"><li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;"><strong style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">RIW Night 2014</strong> — серия ежедневных вечерних after-parties</li>&#13;
              <li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;">Награды и премии — <strong style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Золотой сайт 2014</strong>, <strong style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Internet Media Awards 2014</strong></li>&#13;
              <li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;">Специальные мероприятия от партнеров RIW 2014</li>&#13;
            </ul><p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Список <a href="http://riw.moscow/special/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">специальных мероприятий</a> и возможности их посещения.</p>&#13;
            <div class="bordered center" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; text-align: center; margin: 25px 0; padding: 10px 25px; border: 1px dashed #ffcf00;" align="center"><p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><b style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><a href="http://riw.moscow/info/guide/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">Подробная информация</a> для участников.</b></p></div>&#13;
&#13;
						<div class="frame center" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; text-align: center; margin: 25px 0; padding: 0;" align="center">&#13;
              <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><big style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 22px; line-height: 1.4; font-weight: 200; margin: 0; padding: 0;">Управлять своими настройками и регистрировать Ваших коллег – вы можете в Личном кабинете:</big></p>&#13;
							<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><a href="<?=$regLink?>" class="btn-primary" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.2; color: #FFF; text-decoration: none; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #FA2045; margin: 0 10px 0 0; padding: 0; border-color: #fa2045; border-style: solid; border-width: 10px 25px 15px;"><big style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 22px; line-height: 1.4; font-weight: 200; margin: 0; padding: 0;"><b style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">ЛИЧНЫЙ КАБИНЕТ</b></big><br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" /><small style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 11px; line-height: 1.6; margin: 0; padding: 0;">(персональная ссылка)</small></a></p>&#13;
						</div>&#13;
&#13;
					</td>&#13;
				</tr></table></div>&#13;
			&#13;
			&#13;
		</td>&#13;
		<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>&#13;
	</tr></table></body>
</html>