<?php	
	$link = "http://2017.russianinternetforum.ru/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'Ke4SkEkDYRFZHYT5K6sDDZRGG'), 0, 16);
?>


<h3><?=$user->getShortName();?>, здравствуйте!</h3>
Вы зарегистрированный участник <a href="http://2017.russianinternetforum.ru">РИФ+КИБ 2017</a>.</p>

<p>Ваш статус: <b><?=$user->Participants[0]->Role->Title?></b></p>

<p>Мы&nbsp;видим, что у&nbsp;Вас есть выставленные, но&nbsp;неоплаченные счета за&nbsp;участие в&nbsp;конференции РИФ+КИБ 2017&nbsp;&mdash; <a href="http://2017.russianinternetforum.ru">www.rif.ru</a></p>

<p>И мы переживаем, поскольку мероприятие стартует уже завтра - 19 апреля. Важные советы, которые могут Вам помочь:</p>
<ol>
	<li>
	<p>Если <strong>вы&nbsp;не&nbsp;оплачивали счет</strong>, то&nbsp;сделать это можно в&nbsp;личном кабинете участника.</p>
	</li>
	<li>
	<p>Если <strong>вы&nbsp;оплатили счет</strong>, но&nbsp;подтверждение о&nbsp;присвоении статуса &laquo;Участник&raquo; так и&nbsp;не&nbsp;пришло, просьба выслать нам на&nbsp;<a href="mailto:info@rif.ru">info@rif.ru</a> скан-копию платежного поручения с&nbsp;отметкой банка. Мы&nbsp;все проверим.</p>
	</li>
	<li>
	<p>Если подтверждение о&nbsp;присвоении статуса участника не&nbsp;пришло, возьмите с&nbsp;собой на&nbsp;мероприятие распечатанную платежку с&nbsp;отметкой банка и&nbsp;предъявите на&nbsp;регистрации.</p>
	</li>
	<li>
	<p>Если вы&nbsp;оплатили другой счет или использовали иной способ оплаты, то&nbsp;ничего делать не&nbsp;нужно.</p>
	</li>
</ol>

<p><strong>Вы можете оплатить участие банковской картой или электронными деньгами.</strong></p>

<p>Управление Вашими счетами / статусами / оплата услуг / регистрация коллег &ndash; в Вашем Личном кабинете: &nbsp;</p>

<p style="margin-top: 10px 0; text-align: center;"><a href="<?=$link?>" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #D04727; margin: 0 10px 0 0; padding: 0; border-color: #D04727; border-style: solid; border-width: 10px 40px;">ЛИЧНЫЙ КАБИНЕТ</a></p>
