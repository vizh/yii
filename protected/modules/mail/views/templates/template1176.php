<?php	
	$link = "http://riw.moscow/auth/fast?runet_id=" . $user->RunetId . "&key=" . substr(md5($user->RunetId.'awjdn2iuh4i3hudaiubdiwuabd'), 0, 16) . "&redirect=/my";
?>

<p><strong><?=$user->getShortName();?>, здравствуйте!</strong></p>
<p>Вы&nbsp;— зарегистрированный участник <a href="http://www.riw.moscow">RIW 2016</a> и&nbsp;выставки <a href="http://riw.moscow/expo/scheme">INTERNET 2016</a> <nobr>(1–3 ноября,</nobr> Экспоцентр).</p>
<p style="font-size: 18px"><strong>Ваш статус: <br/><?=($user->Participants[0]->Role->Title == 'Участник') ? 'Посетитель Выставки INTERNET 2016 / RIW 2016' : $user->Participants[0]->Role->Title?></b></strong>
</p>
<p>С&nbsp;этим статусом&nbsp;Вы можете посещать все 3&nbsp;дня главную выставку <a href="http://riw.moscow/expo/scheme">INTERNET 2016</a>, а&nbsp;также выставки Softool 2016 и&nbsp;партнерские выставки HI-TECH Building и&nbsp;Integrated Systems Russia (организатор Midexpo).</p>
<p>Также Вы&nbsp;можете посещать <a href="http://riw.moscow/forum/presentation_hall">Ток-шоу INTERNET. FUTURE. RED&nbsp;DOT в&nbsp;Presentation Hall</a>, где все 3&nbsp;дня будут идти лекции и&nbsp;презентации и&nbsp;выступления харизматичных гуру отрасли и&nbsp;некоторые мини-форумы: <a href="http://riw.moscow/special/buduguru">BuduGuru Academy</a>, Конференция «<a href="http://riw.moscow/special/next">Поколение NEXT</a>», <a href="http://riw.moscow/special/upstart">конференция UpStart и&nbsp;Аллея Инноваций</a>...</p>
<p>Но&nbsp;Вы&nbsp;не&nbsp;сможете принимать участие в&nbsp;Профессиональной программе RIW 2016, посещать 9&nbsp;остальных залов (включая блок-конференции, форумы User eXperience, Интернет вещей в&nbsp;Умном городе, RIW 4&nbsp;beginners: введение в&nbsp;Digital), посещать бизнес-зоны&nbsp;— все эти и&nbsp;многие другие опции доступны для тех, кто приобрел статус «Проф.участник RIW 2016». </p>
<p style="font-size: 18px"><strong>Если Вы&nbsp;или Ваши коллеги еще не&nbsp;получили статус «Проф.участник», но&nbsp;планируете это сделать&nbsp;— СПЕШИТЕ!</strong></p>
<p><strong>Сделать это можно в&nbsp;Вашем <a href="<?=$link?>">личном кабинете</a>.</strong></p>
<p>К&nbsp;оплате доступны все виды платежей: банковские карты, электронные деньги, безналичная оплата от&nbsp;организации.</p>
<p><strong>Внимание!<br/>
Советуем спешить&nbsp;— безналичный способ оплаты статуса будет возможен только до&nbsp;конца дня пятницы 28&nbsp;октября.</strong>
</p>