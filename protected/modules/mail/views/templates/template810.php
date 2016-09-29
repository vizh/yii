<?php
$event = \event\models\Event::findOne(2413);
?>


<img alt="Cyber Security Forum / i-SAFETY 2016" src="http://runet-id.com/img/mail/2016/csfff16.png" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; max-width: 100%; margin: 0; padding: 0;" />
<h2><?=$user->getShortName()?>, здравствуйте!</h2>

<p>Уже во вторник (9 февраля) стартует i-SAFETY\Cyber Security Forum (CSF 2016) - международный Форум по кибербезопасности с участием международных и российских экспертов.&nbsp;</p>

<p>Регистрация открывается <b>9 февраля в 09:00</b>. &nbsp;</p>

<p>Основная задача Форума &ndash; это обмен опытом и выявление лучших практик в сфере информационной безопасности (технологии, законодательство и решения).<br/> С подробной программой форума можно ознакомиться на <a href="http://runet-id.com/event/csf16/">официальном сайте</a>.&nbsp;</p>

<p><b>ВНИМАНИЕ!</b> Если Вы еще не получили электронный билет - поторопитесь! &nbsp;Регистрация на мероприятие осуществляется по приглашениям от организаторов мероприятия.&nbsp;<br />
&nbsp;</p>


<div style="text-align: center; background: #F0F0F0; border: 2px dashed #FFF; padding: 20px 10px 10px;">
<p style="margin-top: 0"><a href="<?=$event->getFastRegisterUrl($user, \event\models\Role::findOne(1))?>" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #FFAA00; margin: 0 10px 0 0; padding: 0; border-color: #FFAA00; border-style: solid; border-width: 10px 40px;">Скачать электронный билет</a></p>
</div>

<p>&nbsp;</p>

<p>До встречи на Форуме!</p>

<p><strong>---------------------------</strong></p>

<p>С уважением,<br />
Оргкомитет CSF 2016<br />
<a href="http://cybersecurityforum.ru">www.CyberSecurityForum.ru</a><br />
<a href="mailto:csf16@raec.ru">csf16@raec.ru</a></p>
