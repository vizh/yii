<?
	$salt = '71064386e1731ff1ceb2b4667ce67b8c';
	$hash = md5($user->RunetId . $salt . 'votepk');
	$link = "http://iri.center/vote/pk1.php?runetid=" . $user->RunetId . "&hash=" . $hash;
?>

<p><strong><?=$user->getShortName()?>, добрый день!</strong></p>

<p>Спасибо вам за то, что вы участвуете в Программном комитете ИРИ!<br />
Наша с вами задача написать программу развития Интернета в России.</p>

<p>Поскольку времени не очень много, то, для того, чтобы не создавать&nbsp;лишней суеты, мы будем действовать, как я рассказал на встрече&nbsp;программного комитета, одновременно в нескольких направлениях:&nbsp;групповая работа, личные&nbsp;интервью и групповые интервью в крупных&nbsp;компаниях.</p>

<p><a href="<?=$link?>"><strong>Сейчас я прошу вас заполнить анкету &raquo;</strong></a></p>

<p>Анкета состоит из 15 вопросов (довольно короткая), в ней мы спрашиваем&nbsp;ключевые идеи, концепции, болевые точки - все то, что может сделать&nbsp;государство для отрасли.</p>

<p>Пожалуйста, заполните те пункты, которые вы считаете нужным заполнить&nbsp;(нет никаких ограничений) настолько подробно, насколько вы считаете&nbsp;нужным.&nbsp;Наша задача сейчас - собрать спектр идей - тот список, который мы&nbsp;дальше сможем развивать и дополнять.</p>

<p>Важно это сделать до четверга включительно. Пожалуйста, не&nbsp;откладывайте на последний момент. Мы будем использовать эти результаты&nbsp;для работы в группах и для анализа предложений.</p>

<p>Спасибо!<br />
Ф.В.</p>
