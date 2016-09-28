<?php
	$regLink = "http://2015.russianinternetforum.ru/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'aihrQ0AcKmaJ'), 0, 16);
?>

<p><?=$user->getShortName()?>, здравствуйте!</p>

<p>Мы&nbsp;видим, что у&nbsp;Вас есть выставленные, но&nbsp;неоплаченные счета за&nbsp;участие в&nbsp;конференции РИФ+КИБ 2015. И&nbsp;мы&nbsp;переживаем, поскольку <strong>мероприятие уже на&nbsp;следующей неделе</strong>.</p>

<h3>Что теперь делать?</h3>

<ol>
	<li>
	<p>Если вы&nbsp;<strong>не&nbsp;оплачивали счет</strong>, то&nbsp;сделать это можно в&nbsp; <a href="<?=$regLink?>">личном кабинете</a> участника.</p>
	</li>
	<li>
	<p>Если вы&nbsp;<strong>оплатили счет до&nbsp;16&nbsp;апреля</strong>, но&nbsp;подтверждение о&nbsp;присвоении статуса &laquo;Участник&raquo; так и&nbsp;не&nbsp;пришло, просьба выслать нам на&nbsp;<a href="mailto:fin@rif.ru">fin@rif.ru</a> скан-копию платежного поручения с&nbsp;отметкой банка. Мы&nbsp;все проверим.</p>
	</li>
	<li>
	<p>Если вы<strong>&nbsp;оплатили счет 16&nbsp;или 17&nbsp;апреля</strong>, то&nbsp;можно ничего не&nbsp;делать&nbsp;&mdash; ваша оплата будет зачислена в&nbsp;понедельник. Однако, если подтверждение о&nbsp;присвоении статуса участника не&nbsp;придет, возьмите с&nbsp;собой на&nbsp;мероприятие распечатанную платежку с&nbsp;отметкой банка и&nbsp;предъявите на&nbsp;регистрации.</p>
	</li>
	<li>
	<p>Если вы&nbsp;<strong>оплатили другой счет</strong> или использовали иной способ оплаты, то&nbsp;ничего делать не&nbsp;нужно.</p>
	</li>
</ol>

<p>К&nbsp;оплате доступны все виды платежей: банковские карты, электронные деньги, до&nbsp;конца сегодняшнего дня (17&nbsp;апреля) доступна возможность оплаты по&nbsp;счету для юридических лиц.</p>

<div style="text-align: center; margin-top: 20px;">
	<p style="margin-top: 10px 0; text-align: center;"><a href="<?=$regLink?>" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #222222; margin: 0; padding: 0; border-color: #222222; border-style: solid; border-width: 10px 40px; width: 75%;">ЛИЧНЫЙ КАБИНЕТ</a></p>
</div>
