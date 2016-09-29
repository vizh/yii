<?php
$regLink = "http://2015.i-comference.ru/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'vyeavbdanfivabfdeypwgruqe'), 0, 16);
?>

<h3><?=$user->getShortName()?>, доброе утро! </h3>

<p>Мы&nbsp;видим, что у&nbsp;Вас<strong> есть выставленные, но&nbsp;неоплаченные счета</strong> за&nbsp;участие в&nbsp;конференции <a href="http://2015.i-comference.ru/"><nobr>i-COMference</nobr> 2015</a>. Мы&nbsp;переживаем, поскольку мероприятие уже в&nbsp;начале следующей недели.</p>

<h3>Что теперь делать?</h3>

<ol>
	<li>
	<p>Если вы&nbsp;не&nbsp;оплачивали счет, то&nbsp;сделать это можно в&nbsp;<a href="<?=$regLink?>">личном кабинете</a> участника.</p>
	</li>
	<li>
	<p>Если вы&nbsp;оплатили счет до&nbsp;12&nbsp;марта, но&nbsp;подтверждение о&nbsp;присвоении статуса &laquo;Участник&raquo; так и&nbsp;не&nbsp;пришло, просьба выслать нам на&nbsp;<a href="mailto:fin@ruvents.com">fin@ruvents.com</a> скан-копию платежного поручения с&nbsp;отметкой банка. Мы&nbsp;все проверим.</p>
	</li>
	<li>
	<p>Если вы&nbsp;оплатили счет 12&nbsp;или 13&nbsp;марта, то&nbsp;нужно немного подождать&nbsp;&mdash; Ваша оплата будет зачислена в&nbsp;понедельник. Однако, если подтверждение о&nbsp;присвоении статуса участника не&nbsp;придет, возьмите с&nbsp;собой на&nbsp;мероприятие распечатанную платежку с&nbsp;отметкой банка и&nbsp;предъявите ее на&nbsp;регистрации.</p>
	</li>
	<li>
	<p>Если вы&nbsp;оплатили участие по другому счету или использовали иной способ оплаты, то&nbsp;ничего делать не&nbsp;нужно.</p>
	</li>
</ol>

<p>К&nbsp;оплате доступны все виды платежей: банковские карты, электронные деньги, до&nbsp;15&nbsp;марта доступна возможность оплаты по&nbsp;счету для юридических лиц.</p>

<div style="text-align: center; margin-top: 20px;">
	<p style="margin-top: 10px 0; text-align: center;">
		<a href="<?=$regLink?>" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #6C0C7A; margin: 10px 0; padding: 0; border-color: #6C0C7A; border-style: solid; border-width: 10px 40px; min-width: 220px; width: 40%;">Личный кабинет</a>
	</p>
</div>
