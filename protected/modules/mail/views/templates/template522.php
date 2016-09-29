<?php
$regLink = "http://2015.sp-ic.ru/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'xggMpIQINvHqR0QlZgZa'), 0, 16);

$discount = new \pay\models\Coupon();
$discount->EventId  = 1580;
$discount->Code = $discount->generateCode();
$discount->EndTime  = null;
$discount->Discount = (float) 50 / 100;
$discount->save();
?>

<p><b><?=$user->getShortName()?>, здравствуйте!</b></p>

<p>В&nbsp;честь юбилейного СПИКа мы&nbsp;отобрали некоторое количество случайных участников прошлых лет для того, чтобы сделать приятный подарок.</p>

<p>У&nbsp;нас есть для вас отличная новость&nbsp;&mdash; вы&nbsp;вошли в&nbsp;число этих счастливчиков!</p>

<p>Мы&nbsp;дарим Вам <b>скидку&nbsp;50% на&nbsp;участие в&nbsp;профессиональной программе</b>, воспользоваться которой можно до&nbsp;26&nbsp;мая, 00:00 по&nbsp;московскому времени:<br/><span style="background-color: #FFDB4C; padding: 3px 5px; line-height: 25px; font-weight: bold; font-size: 16px;"><?=$discount->Code?></span></p>

<p>Активировать промо-код и оплатить дополнительные услуги можно в&nbsp;<strong><a href="<?=$regLink?>">Личном кабинете</a></strong>.</p>

<p>До&nbsp;встречи на&nbsp;конференции!</p>
