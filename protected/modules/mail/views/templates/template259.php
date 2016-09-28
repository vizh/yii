<?php
if (!function_exists("getRoleName")) {
	function getRoleName($roleId) {
		switch ($roleId) {
			case 3:
				return 'Докладчик';
			case 6:
				return 'Организатор';
			case 5:
				return 'Партнер';
			case 2:
				return 'СМИ';
			case 1:
				return 'Посетитель выставки';
			case 11:
			default:
				return 'Участник форума';
		}
	}
}
?>
<h3><?=$user->getShortName()?>, здравствуйте!</h3>

<p>Вы&nbsp;&mdash; зарегистрированный участник RIW 2014: <a href="http://www.riw.moscow">www.RIW.moscow</a></p>

<p>Ваш статус: «<?=getRoleName($user->Participants[0]->Role->Id)?>»</p>

<p>RIW 2014 проходил <nobr>12-14</nobr> ноября 2014 года в&nbsp;московском Экспоцентре, в&nbsp;укрупненном формате: впервые площадка объединила все отрасли высоких технологий: Интернет, Телеком и&nbsp;Медиа. Одновременно с&nbsp;RIW на&nbsp;одной площадке проходила выставка производителей ПО&nbsp;&mdash; Softool 2014, и&nbsp;это тоже было впервые.</p>

<p><b>Мы&nbsp;благодарны за&nbsp;Ваш интерес, поддержку и&nbsp;внимание к&nbsp;мероприятию.</b> Надеемся, что в&nbsp;этом году RIW 2014 оставил у&nbsp;Вас самые приятные впечатления и&nbsp;оказался полезен Вам с&nbsp;профессиональной стороны! С&nbsp;Вашей помощью мы&nbsp;хотим определить сильные и&nbsp;слабые места проекта, построить рейтинг секций Форума и&nbsp;получить дополнительные идеи на&nbsp;будущее.</p>

<p><b>Просим Вас принять участие в&nbsp;итоговом опросе RIW 2014.</b> Опрос займет у&nbsp;Вас не&nbsp;более 5&nbsp;минут, а&nbsp;его результаты помогут нам детально проанализировать все стороны мероприятие и&nbsp;сделать его еще лучше в&nbsp;следующем году.</p>

<p>Cсылка на&nbsp;Вашу персональную анкету:<br />
<a href="<?=$user->getFastauthUrl('/test/riw14/')?>"><?=$user->getFastauthUrl('/test/riw14/')?></a></p>

<p>P.S.<br />
Мы&nbsp;активно занимаемся обработкой материалов RIW 2014 и&nbsp;по&nbsp;мере готовности публикуем их&nbsp;на&nbsp;сайте:<br />
&mdash;&nbsp;Фоторепортаж<br />
&mdash;&nbsp;Презентации докладчиков: <a href="http://riw.moscow/program/">http://riw.moscow/program/</a><br />
&mdash;&nbsp;Новости: <a href="http://tass.ru/riw">http://tass.ru/riw</a></p>

<p>Следите за&nbsp;новостями и&nbsp;анонсами: <a href="http://www.riw.moscow">www.RIW.moscow</a></p>
