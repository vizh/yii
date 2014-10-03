<?

    $coupon = new \pay\models\Coupon();
    $coupon->EventId = 663;
    $coupon->Discount = (float) 15 / 100;
    $coupon->ProductId = 1462;
    $coupon->Code = $coupon->generateCode();
    $coupon->EndTime = '2014-05-23 23:59:59';
    $coupon->save();

    $regLink = "http://2014.sp-ic.ru/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'xggMpIQINvHqR0QlZgZa'), 0, 16);

?>

<p><img src="http://runet-id.com/img/mail/2014/20140506-spic14.jpg" alt="СПИК 2014"/></p>

<h3><?=$user->getShortName();?>, здравствуйте!</h3>

<p>Вы&nbsp;зарегистрировались на&nbsp;<nobr>Санкт-Петербургскую</nobr> Интернет Конференцию (СПИК 2014). Мероприятие пройдет 27&ndash;28&nbsp;мая 2014 года в&nbsp;<nobr>конференц-центре</nobr> гостиницы &laquo;Прибалтийская Park Inn&raquo; (ул.&nbsp;Кораблестроителей, д.14).</p>

<p><b>Ваш статус &laquo;Виртуальный участик&raquo; позволяет:</b></p>

<ul>
	<li>посещение Выставки</li>
	<li>посещение потока партнерских <nobr>мастер-классов</nobr></li>
</ul>

<p><b>Вы&nbsp;можете расширить опции в&nbsp;личном кабинете:</b></p>

<ul>
	<li>Участие в&nbsp;профессиональной <a href="http://2014.sp-ic.ru/program/">программе конференции</a></li>
	<li>Дистанционное участие (доступ к&nbsp;видео 2013 и&nbsp;2014 годов)</li>
	<li><a href="http://2014.sp-ic.ru/about/afterparty/">Вечернее мероприятие</a> на&nbsp;теплоходе</li>
	<li>Воспользоваться сервисом установления <a href="http://2014.sp-ic.ru/my/link/">деловых контактов</a> на мероприятии</li>
</ul>

<p>Только сегодня мы&nbsp;<b>дарим Вам скидку 15%</b> на&nbsp;участие в&nbsp;профессиональной программе, воспользоваться, которой можно до&nbsp;23&nbsp;мая включительно, 00:00 по&nbsp;московскому времени.</p>

<p align="center" style="text-align: center"><span style="display: inline-block; border: 1px dashed #4374A3; color: #4374A3; font-size: 18px; border-radius: 3px; margin: 0 auto; padding: 16px; line-height: 14px; text-align: center; width: 240px;"><?=$coupon->Code?></span></p>

<p>Также обращаем внимание, что 23&nbsp;мая до&nbsp;18:00&nbsp;&mdash; последний день оплаты счетов по&nbsp;безналичному расчету, в&nbsp;дальнейшем сохранится возможность оплаты участия только банковскими картами и&nbsp;электронными деньгами.</p>

<p align="center" style="text-align: center">Оплатить дополнительный услуги можно в&nbsp;Личном кабинете:</p>
<p align="center" style="text-align: center"><a href="<?=$regLink?>" style="display: inline-block; text-decoration: none; background: #D23000; color: #FFFFFF; font-size: 18px; border-radius: 3px; margin: 0 auto; padding: 16px; line-height: 14px; text-align: center; width: 240px;">ЛИЧНЫЙ КАБИНЕТ</a></p>