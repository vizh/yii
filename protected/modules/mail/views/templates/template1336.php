<?php	
	$link = "http://2017.russianinternetforum.ru/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'Ke4SkEkDYRFZHYT5K6sDDZRGG'), 0, 16);
?>


<h3><?=$user->getShortName();?>, здравствуйте!</h3>
Вы зарегистрированный участник <a href="http://2017.russianinternetforum.ru">РИФ+КИБ 2017</a>.</p>

<p>Ваш статус: <b><?=$user->Participants[0]->Role->Title?></b></p>

<p>Если Вы или Ваши коллеги планируете участвовать в РИФ+КИБ 2017 лично и раздумываете над проживанием / питанием на территории Форума в дни его проведения &ndash; эта информация для Вас!</p>

<p>Оргкомитет финализирует продажу номерного фонда пансионатов, расположенных вблизи места проведения РИФ+КИБ, а также продажу дополнительных опций для участников Форума:</p>

<ul>
	<li>
	<p><a href="https://2017.russianinternetforum.ru/about/memo/#participants-info--7">ПРОЖИВАНИЕ</a> в пансионатах &ldquo;Лесные Дали&rdquo;/ &ldquo;Поляны&rdquo; все в дни проведения РИФа (бронирование / оплата номеров)</p>
	</li>
	<li>
	<p><a href="https://2017.russianinternetforum.ru/food/">ПИТАНИЕ</a></li>
</ul>

<p><b>Спешите! Мы рекомендуем определиться с приобретением этих опций<br />
до конца дня среды 12 апреля 2017.</b></p>

<p>Обращаем Ваше внимание, что бронирование номеров доступно участникам, оплатившим регистрационный взнос.</p>

<p>Сегодня к оплате доступны все виды платежей: банковские карты, электронные деньги. Последний день для выставления и оплаты регистрации по безналичному расчету (оплата по счету от юридического лица) &ndash; 15 апреля.</p>


<p>Управление Вашими счетами / статусами / оплата услуг / регистрация коллег &ndash; в Вашем Личном кабинете: &nbsp;</p>


<p style="margin-top: 10px 0; text-align: center;"><a href="<?=$link?>" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #D04727; margin: 0 10px 0 0; padding: 0; border-color: #D04727; border-style: solid; border-width: 10px 40px;">ЛИЧНЫЙ КАБИНЕТ</a></p>


<p>Остались вопросы? Пишите на <a href="mailto:info@rif.ru">info@rif.ru</a></p>
