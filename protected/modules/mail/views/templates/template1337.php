<?php	
	$link = "http://2017.russianinternetforum.ru/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'Ke4SkEkDYRFZHYT5K6sDDZRGG'), 0, 16);
?>


<h3><?=$user->getShortName();?>, здравствуйте!</h3>
Вы зарегистрированный участник <a href="http://2017.russianinternetforum.ru">РИФ+КИБ 2017</a>.</p>

<p>Ваш статус: <b><?=$user->Participants[0]->Role->Title?></b></p>

<p>Мы видим, что у Вас есть выставленный, но неоплаченный счет за участие в конференции РИФ+КИБ 2017 – <a href="http://2017.russianinternetforum.ru">www.rif.ru</a></p>
<p>И хотим донести 2 важных сообщения для Вас:</p>
<ul>
<li><b>Номерной фонд пансионатов</b>, расположенных вблизи места проведения РИФ+КИБ, финализирует продажу проживания и питания участников <b>в эту среду 12 апреля</b></li>
<li><p><b>Окончание приема оплаты по безналичному расчету</b> за любые услуги (включая оплату рег.взноса) закрывается <b>в эту пятницу 15 апреля</b></p></li>
</ul>

<p>Советуем завершить регистрацию в ближайшие дни.</p>


<p>Управление Вашими счетами / статусами / оплата услуг / регистрация коллег &ndash; в Вашем Личном кабинете: &nbsp;</p>

<p style="margin-top: 10px 0; text-align: center;"><a href="<?=$link?>" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #D04727; margin: 0 10px 0 0; padding: 0; border-color: #D04727; border-style: solid; border-width: 10px 40px;">ЛИЧНЫЙ КАБИНЕТ</a></p>

<p>Остались вопросы? Пишите на <a href="mailto:info@rif.ru">info@rif.ru</a></p>