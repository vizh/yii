<?php	
	$link = "http://2017.russianinternetforum.ru/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'Ke4SkEkDYRFZHYT5K6sDDZRGG'), 0, 16);
?>


<h3><?=$user->getShortName();?>, здравствуйте!</h3>

<p style="line-height: 25px;">РИФ+КИБ 2017 стартует уже в следующую среду &ndash; 19 апреля: <a href="http://www.rif.ru">www.rif.ru</a></p>

<p style="line-height: 25px;">Ваш статус: <b><?=$user->Participants[0]->Role->Title?></b></p>

<p style="line-height: 25px;">Этот статус позволяет Вам получать информацию о мероприятии, рассылки Форума, доступ к видеотрансляциям из некоторых залов программы Форума в дни его проведения.</p>

<p style="line-height: 25px;">Но он не позволяет Вам посещать Форум лично и не дает права на доступ к главным итоговым материалам РИФ+КИБ 2017.</p>


<h3>Если Вы планируете принять личное участие в РИФе, Вам необходимо завершить процедуру регистрации, оплатить регистрационный взнос и получить статус &ldquo;Участник РИФ+КИБ 2017&rdquo;.</h3>


<p style="line-height: 25px;">Получить статус &ldquo;Участник&rdquo; Вы можете в Вашем Личном кабинете участника:</p>
<p style="margin-top: 10px 0; text-align: center;"><a href="<?=$link?>" style="font-size: 100%; color: #111111; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #00FF66; margin: 0 10px 0 0; padding: 0; border-color: #00FF66; border-style: solid; border-width: 10px 40px;">ЛИЧНЫЙ КАБИНЕТ</a></p>

<p style="line-height: 25px;">К оплате доступны все виды платежей: банковские карты, электронные деньги, безналичная оплата от организации. Вы можете оплатить как свое личное участие, так и участие Ваших коллег.</p>



<div style="text-align: left; background: #D04727; border: 2px dashed #D04727; padding: 0px 10px 10px; border-radius: 5px;">
<h3 style="text-align: center; color: #ffffff; font-size: 20px"><strong>Внимание!</strong></h3>
<h3 style="margin-top: 0; color: #ffffff; text-align: center;"><strong>Сегодня (пятница 14 апреля) &ndash; последний день для выставления и оплаты регистрации по безналичному расчету (оплата по счету от юридического лица).</strong></h3>
</div>


<p style="line-height: 25px;">С любыми вопросами относительно особенностей проведения Форума и участия в нем &ndash; обращайтесь по адресу: <a href="mailto:users@rif.ru">users@rif.ru</a></p>

<p><b>До встречи на РИФ+КИБ 2017!</b></p>