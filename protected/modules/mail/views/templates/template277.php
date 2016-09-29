<?php
$regLink = "http://ibcrussia.com/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'xggMpIQINvHqR0QlZgZa'), 0, 16);
?>

<p>Здравствуйте, <?=$user->getShortName()?>!</p>

<p>Рады сообщить, что у&nbsp;Вас появилась возможность просмотреть <b>видеозаписи выступлений на&nbsp;конференции &laquo;Интернет и&nbsp;Бизнес. Россия&raquo;</b>, которая состоялась <nobr>27&ndash;28</nobr> ноября в&nbsp;Москве.</p>

<p>Для этого Вам необходимо зайти в&nbsp;<a href="<?=$regLink?>">личный кабинет</a> на&nbsp;сайте конференции, выбрать пакет &laquo;Видеоучастие&raquo; и&nbsp;сформировать счет на&nbsp;оплату. Стоимость пакета&nbsp;&mdash; 5000&nbsp;рублей.</p>

<p>С&nbsp;программой прошедшей конференции вы&nbsp;можете ознакомиться на&nbsp;странице <a href="http://ibcrussia.com/program/?utm_source=runetidrass">http://ibcrussia.com/program/</a>.</p>

<p><small><i>С&nbsp;уважением,<br />
<span>Оргкомитет конференции &laquo;Интернет и</span>&nbsp;</i><span><i>Бизнес. Россия&raquo;</i></span></small></p>
