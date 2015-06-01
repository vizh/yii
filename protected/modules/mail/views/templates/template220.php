<?php

$eventId = 1506;

$text = new \application\components\utility\Texts();
$code = $text->getUniqString($eventId);

$invite = new \event\models\Invite();
$invite->EventId = $eventId;
$invite->RoleId = 1;
$invite->Code = $code;
$invite->save();

?>

<p>Привет всем участникам <a href="http://2014.goldensite.ru/">Золотого сайта</a>!</p>
<p>У&nbsp;нас несколько важных моментов:</p>
<p>1. Мы&nbsp;приглашаем вас на&nbsp;Церемонию Награждения Золотого Сайта, которая пройдет 13&nbsp;ноября в&nbsp;Москве.</p>
<p><strong>Для регистрации вам необходимо зайти на&nbsp;<a href="http://runet-id.com/event/goldensite14">страницу мероприятия</a> и&nbsp;ввести ваш персональный промо-код <span style="background: yellow; display: inline-block; padding: 1px 3px;"><?=$code?></span>. </strong></p>
<p>Место проведения Церемонии&nbsp;— развлекательный комплекс LOFT, Кутузовский проспект, д.&nbsp;12, стр.&nbsp;3&nbsp;(<a href="http://pmloft.ru/kontakty.html">схема проезда</a>).</p>
<p><b>Программа Церемонии:</b></p>
<ul> 
	<li><nobr><em>18:30&nbsp;— 19:30</em></nobr><br/>Сбор гостей, фуршет, анимация, приветственные слова организаторов и&nbsp;партнеров.<br/><br/></li>
	<li><nobr><em>19:30&nbsp;— 21:00</em></nobr><br/>Церемония награждения победителей Золотого Сайта, раздача призов в&nbsp;основных и&nbsp;спонсорских номинациях.<br/><br/></li>
	<li><nobr><em>21:00&nbsp;— 23:00</em></nobr><br/>Выступление группы, фуршет, танцы и&nbsp;чествование победителей.<br/></li>
</ul>
<p>2. Завершился этап народного голосования (на&nbsp;страницах работ можно увидеть итоговый балл) и&nbsp;в&nbsp;данные минуты завершается голосование жюри. Председатель жюри Сергей Котырев приступил к&nbsp;определению победителей.</p>
<p>3. В&nbsp;понедельник мы&nbsp;отправим дополнительную рассылку по&nbsp;тем компаниям, чьи работы предположительно что-то выиграли на&nbsp;Золотом Сайте&nbsp;— чтобы победители и&nbsp;призеры знали заранее, что им&nbsp;обязательно нужно приходить на&nbsp;Церемонию&nbsp;— не&nbsp;пропустите!</p>
<p>Удачи на&nbsp;Золотом Сайте&nbsp;— и&nbsp;до&nbsp;встречи на&nbsp;Церемонии!</p>
<p><em>С&nbsp;уважением, Андрей Терехов,<br/>
 Координатор Золотого Сайта 2014,<br/>
	<a href="http://2014.goldensite.ru">http://2014.goldensite.ru</a><br/>
 	</em><a href="mailto:2014@goldensite.ru"><em>2014@goldensite.ru</em></a>
</p>
<p><em><sub>Отдельная благодарность спонсорам Золотого Сайта&nbsp;— <a href="http://www.qb-interactive.ru/">qb&nbsp;interactive</a>, <a href="http://www.cubeline.ru/">CubeLine</a>, <a href="http://www.usabilitylab.ru/">UsabilityLab</a>, <a href="http://dotdeti.ru/">.DETI</a>, <a href="http://www.forsmi.ru/">FORSMI</a>, <a href="http://biz.mail.ru/">biz.mail.ru</a>, <a href="http://www.mobikit.ru/">Мобильная Кухня</a>, <a href="http://www.coalla.ru/">Coalla</a>.</sub></em></p>