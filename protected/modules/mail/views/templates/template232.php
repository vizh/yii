<?php

$eventId = 1512;

$text = new \application\components\utility\Texts();
$code = $text->getUniqString($eventId);

$invite = new \event\models\Invite();
$invite->EventId = $eventId;
$invite->RoleId = 1;
$invite->Code = $code;
$invite->save();

?>

<p>Приветствуем победителей Золотого Сайта 2014! Напоминаем, что обязательно ждем вас на&nbsp;Церемонии Награждения Конкурса уже послезавтра.</p>
<p><strong>Для регистрации вам необходимо зайти на&nbsp;страницу мероприятия <a href="http://runet-id.com/event/goldensite14">http://runet-id.com/event/goldensite14</a>. Один промо-код мы&nbsp;высылали вам ранее, а&nbsp;сейчас высылаем дополнительно еще один <span style="background: yellow; display: inline-block; padding: 1px 3px;"><?=$code?></span>. </strong></p>
<p>Место проведения Церемонии&nbsp;— развлекательный комплекс LOFT, Кутузовский проспект, д.&nbsp;12, стр.&nbsp;3&nbsp;(<a href="http://pmloft.ru/kontakty.html">http://pmloft.ru/kontakty.html</a>).</p>
<p>Программа Церемонии:</p>
<ul> 
	<li><nobr>18:30-19:30.</nobr> Сбор гостей, фуршет, анимация, приветственные слова организаторов и&nbsp;партнеров. </li>
	<li><nobr>19:30-21:00.</nobr> Церемония награждения победителей Золотого Сайта, раздача призов в&nbsp;основных и&nbsp;спонсорских номинациях.</li>
	<li><nobr>21:00-23:00.</nobr> Выступление группы, фуршет, танцы и&nbsp;чествование победителей.</li>
</ul>
<p>До&nbsp;встречи послезавтра!</p>
<p><em>С&nbsp;уважением, Андрей Терехов,<br/>
 Координатор Золотого Сайта 2014,<br/>
	<a href="http://2014.goldensite.ru">http://2014.goldensite.ru</a><br/>
	<a href="mailto:2014@goldensite.ru">2014@goldensite.ru</a></em>
</p>
<p><em><sub>Отдельная благодарность спонсорам Золотого Сайта&nbsp;— <a href="http://www.qb-interactive.ru/">qb&nbsp;interactive</a>, <a href="http://www.cubeline.ru/">CubeLine</a>, <a href="http://www.usabilitylab.ru/">UsabilityLab</a>, <a href="http://dotdeti.ru/">.DETI</a>, <a href="http://www.forsmi.ru/">FORSMI</a>, <a href="http://biz.mail.ru/">biz.mail.ru</a>, <a href="http://www.mobikit.ru/">Мобильная Кухня</a>, <a href="http://www.coalla.ru/">Coalla</a>.</sub></em></p>