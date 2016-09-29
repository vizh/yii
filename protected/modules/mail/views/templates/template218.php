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
	border-top: 1px solid #F6F6F6;
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
	font-size: 16px;
	padding: 5px;
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
						<table align="right" style="float: right; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 25px 0 0; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><a href="http://riw.moscow/expo/scheme/" class="btn-link" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 13px; line-height: 2; color: #348eda; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; margin: 0 10px 0 0; padding: 0; border-width: 4px 8px;">Выставка</a></td>&#13;
								<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><a href="http://riw.moscow/program/" class="btn-link" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 13px; line-height: 2; color: #348eda; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; margin: 0 10px 0 0; padding: 0; border-width: 4px 8px;">Программа</a></td>&#13;
								<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><a href="<?=$regLink?>" class="btn-link" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 13px; line-height: 2; color: #348eda; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; margin: 0 10px 0 0; padding: 0; border-width: 4px 8px;">Кабинет</a></td>&#13;
							</tr></table></td>&#13;
				</tr></table></td>&#13;
		<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>&#13;
	</tr><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>&#13;
		<td class="container" bgcolor="#FFFFFF" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto; padding: 20px; border: 1px solid #f0f0f0;">&#13;
			&#13;
			<div class="content" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; max-width: 600px; display: block; margin: 0 auto; padding: 0;">&#13;
			<table style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; width: 100%; margin: 0; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">&#13;
						<h3 style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 22px; line-height: 1.2; color: #000; font-weight: 200; margin: 0 0 10px; padding: 0;">Здравствуйте, <?=$user->getShortName()?>.</h3>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Вы зарегистрированы на<br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" /><big style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 22px; line-height: 1.4; font-weight: 200; margin: 0; padding: 0;">RIW 2014 — Russian Interactive Week</big></p>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Ваш статус:<br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" /><big style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 22px; line-height: 1.4; font-weight: 200; margin: 0; padding: 0;"><span class="status" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; font-weight: bold; display: inline-block; background-color: #FFCE00; margin: 0; padding: 1px 5px;"><?=getRoleName($user->Participants[0]->Role->Id)?></span></big></p>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><b style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">RIW 2014 — стартует уже на следующей неделе:</b><br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" />Выставка, Форум и Спецмероприятия пройдут <nobr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">12–14</nobr> ноября 2014 года в московском Экспоцентре на Красной Пресне: <a href="http://riw.moscow" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">www.RIW.moscow</a></p>&#13;
&#13;
						<hr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; border-top-color: #F6F6F6; border-top-style: solid; height: 1px; margin: 25px 0; padding: 0; border-width: 1px 0 0;" /><h2 class="center" style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 28px; line-height: 1.2; text-align: center; color: #000; font-weight: 200; margin: 40px 0 0; padding: 0;" align="center">RIW 2014 сильно вырос в этом году.</h2>&#13;
						<h5 class="center" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; text-align: center; margin: 0 0 35px; padding: 0;" align="center">И чтобы не запутаться в программе Форума и не заблудиться на Выставке, мы подготовили ряд полезных советов и <div class="hint" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; font-weight: bold; display: inline-block; background-color: #CDE5C1; margin: 0; padding: 1px 5px;">подсказок</div>!</h5>&#13;
						<hr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; border-top-color: #F6F6F6; border-top-style: solid; height: 1px; margin: 25px 0; padding: 0; border-width: 1px 0 0;" /><h4 style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 1.6; color: #FFF; background-color: #00509E; margin: 0; padding: 5px;">1. Блоки, из которых состоит RIW:</h4>&#13;
						<table style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; width: 100%; margin: 0; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="vertical-align: top; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 15px 0 0;" valign="top">—</td>&#13;
								<td style="width: 10px; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>&#13;
								<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">&#13;
									<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 0; padding: 0;"><a href="http://riw.moscow/expo/scheme/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">Выставка «ИНТЕРНЕТ 2014»</a>, включая специальные зоны и проекты:<br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" />Более 100 компаний-экспонентов, Аллея инноваций (45 стартапов за 3 дня работы покажут свои решения), Стартап-гараж (серия лекций в зоне выставки для всех желающих начать свой бизнес), Музей мобильных технологий, MediaNovation 2014, Digital-зона, Introduction-зона.</p>&#13;
								</td>&#13;
							</tr><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="vertical-align: top; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 15px 0 0;" valign="top">—</td>&#13;
								<td style="width: 10px; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>&#13;
								<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">&#13;
									<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 0; padding: 0;"><a href="http://riw.moscow/program/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">Медиа-Коммуникационный Форум</a>:<br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" />Огромная трехдневная конференция, объединяющая 12 блок-конференций в 12 залах все 3 дня работы; более 600 топовых докладчиков из отраслей Интернет, Медиа, Телеком; более 120 секций, круглых столов, мастер-классов; море знаний, кейсов, ноу-хау и готовых решений.</p>&#13;
								</td>&#13;
							</tr><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="vertical-align: top; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 15px 0 0;" valign="top">—</td>&#13;
								<td style="width: 10px; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>&#13;
								<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">&#13;
									<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 0; padding: 0;"><a href="http://riw.moscow/special/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">Ряд специальных мероприятий</a>:<br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" />Награды и премии — Золотой сайт 2014, Internet Media Awards 2014, RIW Night 2014 — серия вечерних after-parties, Вечеринка маркетинг-директоров, Специальные мероприятия от партнеров RIW 2014.</p>&#13;
								</td>&#13;
							</tr><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="vertical-align: top; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 15px 0 0;" valign="top">—</td>&#13;
								<td style="width: 10px; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>&#13;
								<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">&#13;
									<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 0; padding: 0;">А также: <a href="http://riw.moscow/special/upstart/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">UpStart Conf</a> — Конференция для стартапов и инвесторов, <a href="http://riw.moscow/special/rad/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">Russian Afiliate Days 2014</a> — Конференция для рекламодателей, вебмастеров и рекламистов, <a href="http://riw.moscow/special/finovations/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">Форум «Деньги будущего 2014»</a>.</p>&#13;
								</td>&#13;
							</tr></table><p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><span class="hint" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; font-weight: bold; display: inline-block; background-color: #CDE5C1; margin: 0; padding: 1px 5px;">ПОДСКАЗКА:</span><br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" /><em style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Все новости RIW 2014, сообщения организаторов и партнеров и важная информация для участников — собраны а разделе <a href="http://riw.moscow/info/press/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">«Пресс-центр»</a>.</em></p>&#13;
						&#13;
						<hr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; border-top-color: #F6F6F6; border-top-style: solid; height: 1px; margin: 25px 0; padding: 0; border-width: 1px 0 0;" /><h4 style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 1.6; color: #FFF; background-color: #00509E; margin: 0; padding: 5px;">2. Программа Медиакоммуникационного Форума RIW 2014:</h4>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><a href="http://riw.moscow/program/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">Программа Форума</a> представлена <strong style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">12 блок-конференциями</strong>. Блок-Конференция — это, как правило, набор из 3 последовательных двухчасовых секций, проходящих в течение одного дня в одном и том же зале, с утра до вечера.</p>&#13;
						<table style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; width: 100%; margin: 0; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="vertical-align: top; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 15px 0 0;" valign="top">—</td>&#13;
								<td style="width: 10px; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>&#13;
								<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">&#13;
									<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 0; padding: 0;"><strong style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Блок-конференции первого дня (12 ноября):</strong><br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" />Утреннее Открытие RIW 2014 (10:00–11:00), Электронная коммерция, Медиа и Коммуникации, Веб-аналитика, Socila Media в зале VK-Hall, Государство и общество, Cерия мероприятий, посвященных стратегии развития отраслей: интернет, медиа, телеком.</p>&#13;
								</td>&#13;
							</tr><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="vertical-align: top; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 15px 0 0;" valign="top">—</td>&#13;
								<td style="width: 10px; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>&#13;
								<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">&#13;
									<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 0; padding: 0;"><strong style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Блок-конференции второго дня (13 </strong><strong style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">ноября):</strong><br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" />Рекламные технологии, Веб-технологии, Performance Marketing, UpStart Conference.</p>&#13;
								</td>&#13;
							</tr><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="vertical-align: top; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 15px 0 0;" valign="top">—</td>&#13;
								<td style="width: 10px; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>&#13;
								<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">&#13;
									<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 0; padding: 0;"><strong style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Блок-конференции третьего дня (14 </strong><strong style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">ноября):</strong><br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" />Digital Marketing, Мобильные технологии, продукты и решения, Usability: Дизайн и пользовательские интерфейсы, Веб-разработка, Social Media</p>&#13;
								</td>&#13;
							</tr><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"><td style="vertical-align: top; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 15px 0 0;" valign="top">—</td>&#13;
								<td style="width: 10px; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>&#13;
								<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">&#13;
									<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 0; padding: 0;">В отдельных залах будут работать конференции <a href="http://riw.moscow/special/rad/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">Russian Afiliate Days 2014</a> и <a href="http://riw.moscow/special/finovations/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">Форум «Деньги будущего 2014»</a>.</p>&#13;
								</td>&#13;
							</tr></table><p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><span class="hint" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; font-weight: bold; display: inline-block; background-color: #CDE5C1; margin: 0; padding: 1px 5px;">ПОДСКАЗКА:</span><br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" /><em style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Самая последняя <a href="http://riw.moscow/program/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">интерактивная версия</a> программы. Вы можете выбирать нужный Вам день (вверху страницы).</em></p>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Названия секций бывают зачастую сложными и загадочными, но Вы можете легко понять, чему посвящена секция — посмотрев на название Экосистемы, к которой она приписана (отображается синим цветом сразу после названия секции). Вы можете ознакомиться с полным <a href="http://riw.moscow/forum/ecosystems/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">списком Экосистем</a>.</p>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">При клике на секцию — вы попадаете на страницу с ее подробным описанием (ведущий, докладчики, темы и тезисы), и на этой же странице Вы можете увидеть все остальные секции, проходящие в этом зале в этот день (Блок-конференция).</p>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><span class="hint" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; font-weight: bold; display: inline-block; background-color: #CDE5C1; margin: 0; padding: 1px 5px;">ПОДСКАЗКА:</span><br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" /><em style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Специально для Вас мы реализовали опцию <strong style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">«Моя программа»</strong>. Это очень удобный сервис на сайте.</em></p>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Вот как он работает: вы авторизуетесь из-под своего аккаунта на сайте, переходите в раздел «Программа» и, в процессе просмотра детальной информации о блок-конференции, с помощью звездочек у названий секций можете отмечать понравившиеся — после этого вы всегда сможете настроить отображение программной сетки так, что бы показывались только выбранные вами секции. Также, выбранные секции будут доступны в мобильном приложении участника RIW, о котором мы скоро расскажем.</p>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><span class="hint" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; font-weight: bold; display: inline-block; background-color: #CDE5C1; margin: 0; padding: 1px 5px;">ПОДСКАЗКА:</span><br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" /><em style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Чтобы было легче ориентироваться в программе Форума, мы подготовили для Вас краткую <a href="http://riw.moscow/program/pdf/">PDF-версию программы</a>.</em></p>&#13;
						&#13;
						<hr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; border-top-color: #F6F6F6; border-top-style: solid; height: 1px; margin: 25px 0; padding: 0; border-width: 1px 0 0;" /><h4 style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 1.6; color: #FFF; background-color: #00509E; margin: 0; padding: 5px;">3. Специальные мероприятия RIW 2014:</h4>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">RIW — это большой Форум и <a href="http://riw.moscow/expo/scheme/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">масштабная Выставка</a>.</p>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Но еще RIW — это множество специальных мероприятий, целых блоков в программе, культурных и развлекательных проектов, специальных зон на выставке, вечеринок и after-parties.</p>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Специальные события в рамках RIW 2014 — проходят в дни проведения RIW 2014 и дополняют конференционную и выставочную программу.</p>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Часть таких мероприятий — открытые, посетить их может любой зарегистрированный участник RIW 2014 без каких-либо дополнительных шагов и усилий. А часть мероприятий — проходят в закрытом формате, только по спеицальным приглашениям или по дополнительной регистрации.</p>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><span class="hint" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; font-weight: bold; display: inline-block; background-color: #CDE5C1; margin: 0; padding: 1px 5px;">ПОДСКАЗКА:</span><br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" /><em style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Почти у каждого специального мероприятия — есть своя промо-страница. К примеру, страница Конкурса «Золотой сайт 2014» <a href="http://riw.moscow/special/goldensite/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">выглядит так</a>. А страница Закрытой Вечеринки маркетинг-директоров — <a href="http://riw.moscow/special/party/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">так</a>. </em></p>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><span class="hint" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; font-weight: bold; display: inline-block; background-color: #CDE5C1; margin: 0; padding: 1px 5px;">ПОДСКАЗКА:</span><br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" /><em style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Изучить мероприятия, политику их посещения и выбрать интересные Вам — можно <a href="http://riw.moscow/special/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">здесь</a>. </em></p>&#13;
&#13;
						<hr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; border-top-color: #F6F6F6; border-top-style: solid; height: 1px; margin: 25px 0; padding: 0; border-width: 1px 0 0;" /><h4 style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 1.6; color: #FFF; background-color: #00509E; margin: 0; padding: 5px;">4. Виды участия в RIW 2014:</h4>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><strong style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Посетитель Выставки «ИНТЕРНЕТ 2014» и Softool 2014</strong><br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" />Данный статус гарантирует получение бейджа на площадке, бесплатное посещение выставки все 3 дня и возможность участия в мероприятиях, проходящих в зале Presentation Hall.</p>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><strong style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Участник Медиа-Коммуникационного Форума</strong><br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" />&#13;
						 Все блок-конференции все 3 дня работы Форума, участие платное, стоимость пакета «Участник Форума» составляет 8 000 рублей включая налоги. &#13;
						</p>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Статус <span class="status" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; font-weight: bold; display: inline-block; background-color: #FFCE00; margin: 0; padding: 1px 5px;">Участник Форума</span> дает следующие привилегии:</p>&#13;
						<ul style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;"><li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;">Доступ во все залы Форума в течение 3 дней</li>&#13;
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;">Неограниченный доступ в Бизнес-зону и зону кофе-брейков</li>&#13;
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;">Посещение специальных мероприятий RIW 2014</li>&#13;
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;">Пакет Профессионального участника Форума с уникальными материалами</li>&#13;
							<li style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; list-style-position: outside; margin: 5px 0 5px 35px; padding: 0;">а также неограниченный онлайн-доступ ко всем материалам Форума после его завершения</li>&#13;
						 </ul><div class="bordered" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 25px 0; padding: 10px 25px; border: 1px dashed #ffcf00;"><p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;">Информируем участников RIW 2014, что безналичная оплата от юридических лиц принимается <b style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">до пятницы 7 ноября 2014 года</b> включительно.</p></div>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><span class="hint" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; font-weight: bold; display: inline-block; background-color: #CDE5C1; margin: 0; padding: 1px 5px;">ПОДСКАЗКА:</span><br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" /><em style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Подробная информация по <a href="http://riw.moscow/info/guide/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">видам участия и опциям</a>.</em> &#13;
						</p>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><span class="hint" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; font-weight: bold; display: inline-block; background-color: #CDE5C1; margin: 0; padding: 1px 5px;">ПОДСКАЗКА:</span><br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" /><em style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Вы можете проверить статус своего участия или статус участия Ваших коллег в разделе со <a href="http://riw.moscow/info/participants/" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">списком участников</a>.</em> &#13;
						</p>&#13;
						<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 15px 0 20px; padding: 0;"><span class="hint" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; font-weight: bold; display: inline-block; background-color: #CDE5C1; margin: 0; padding: 1px 5px;">ПОДСКАЗКА:</span><br style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;" /><em style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">Изменить Ваш статус и/или статус Ваших коллег — можно в <a href="<?=$regLink?>" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; color: #348eda; margin: 0; padding: 0;">Личном кабинете</a>.</em></p>&#13;
&#13;
						<div class="frame center" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; text-align: center; border-top-width: 1px; border-top-color: #F6F6F6; border-top-style: solid; margin: 25px 0; padding: 0;" align="center">&#13;
							<h6 style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 25px 7%; padding: 0;">Проверить Ваш статус, Вашу информацию для корректного отображения на бейдже – можно в Личном кабинете:</h6>&#13;
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
