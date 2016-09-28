<?php
$regLink = "http://2015.i-comference.ru/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'vyeavbdanfivabfdeypwgruqe'), 0, 16);
?>

<h3><?=$user->getShortName()?>, здравствуйте!</h3>

<p>Вы&nbsp;начали регистрацию на&nbsp;конференцию <a href="http://2015.i-comference.ru"><nobr>i-СOMference</nobr> 2015</a>, которая пройдет 17&nbsp;марта в&nbsp;Digital October.</p>

<p>В&nbsp;настоящий момент Ваш статус:<br />
<strong>ВИРТУАЛЬНЫЙ УЧАСТНИК</strong></p>

<p>Для того, чтобы получить статус УЧАСТНИК (дающий право посещения конференции, получения раздаточных материалов и&nbsp;доступа к&nbsp;видео-контенту конференции и&nbsp;презентациям докладчиков), Вам необходимо завершить регистрацию и&nbsp;осуществить оплату регистрационного взноса в&nbsp;Личном кабинете.</p>

<p><strong>До&nbsp;конца дня 19&nbsp;февраля действует специальная цена: 3&nbsp;490&nbsp;</strong><strong>рублей</strong>, включая все налоги. Принимаются любые виды электронных и&nbsp;безналичных платежей. С&nbsp;20&nbsp;февраля цена вырастет на&nbsp;15%.</p>

<div style="text-align: center; border: 3px dashed #222222; margin-top: 20px;">
	<p style="margin-top: 10px 0; text-align: center;"><a href="<?=$regLink?>" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #222222; margin: 0 10px 0 0; padding: 0; border-color: #222222; border-style: solid; border-width: 10px 40px;">Личный кабинет</a></p>
</div>

<p><em>С&nbsp;уважением,<br />
Оргкомитет <nobr>i-COMference</nobr> 2015 и&nbsp;RUNET&mdash;ID<br />
<a href="http://www.i-comference.ru">www.i-COMference.ru</a> </em><br />
<a href="mailto:users@i-COMference.ru"><em>users@i-COMference.ru</em></a></p>
