<?php
	$link = "http://mcf.moscow/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'v1ea8anfiv'), 0, 16) . '&redirect=http://mcf.moscow/vote/';
?>


<p><strong><?=$user->getShortName()?></strong>,<br />
<span style="line-height: 1.6em;">Спасибо за Ваше участие в Большоv Медиа-Коммуникационном Форуме &ndash; БМКФ 2016!</span></p>

<p>Мы высоко ценим мнение каждого участника Форума и будем признательны, если вы уделите 5 минут своего времени, чтобы принять участие в итоговом опросе участников.&nbsp;</p>

<p style="margin-top: 0; text-align: center;"><a href="<?=$link?>" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #25D0F7; margin: 0 10px 0 0; padding: 0; border-color: #25D0F7; border-style: solid; border-width: 10px 40px;">Перейти к опросу</a></p>

<p>Результаты опроса обязательно будут учитываться при подготовке БМКФ 2017.</p>