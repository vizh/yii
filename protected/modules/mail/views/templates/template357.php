<?php
$regLink = "http://2015.i-comference.ru/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'vyeavbdanfivabfdeypwgruqe'), 0, 16);
?>
<h3><?=$user->getShortName()?>, здравствуйте!</h3>
<p><strong>Вы&nbsp;— зарегистрированный участник</strong> конференции <nobr>i-COMference</nobr> 2015, которая состоится уже завтра, 17&nbsp;марта 2015 года в&nbsp;Digital October (г. Москва, Берсеневская набережная, 6, стр.&nbsp;3).</p>
<p><strong>Регистрация участников и&nbsp;докладчиков на&nbsp;площадке стартует в&nbsp;9:30</strong>&nbsp;утра, регистрационные стойки будут работать весь день&nbsp;— до&nbsp;16:00.</p>
<p><strong>Первый блок секций стартует в&nbsp;10:30</strong>, сразу в&nbsp;4&nbsp;залах. Секции и&nbsp;круглые столы программы <nobr>i-COMference</nobr> пройдут с&nbsp;10:30 до&nbsp;18:00&nbsp;в 4&nbsp;параллельных потока.</p>

<div style="text-align: center; margin-top: 20px;">
	<p style="margin-top: 10px 0; text-align: center;">
		<a href="http://2015.i-comference.ru/program/" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #6C0C7A; margin: 10px 0; padding: 0; border-color: #6C0C7A; border-style: solid; border-width: 10px 40px; min-width: 220px; width: 40%;">Подробная программа</a>
	</p>
</div>

<p><b>ВНИМАНИЕ!</b><br/>Обязательно распечатайте или сохраните на мобильным устройстве – Ваш персональный Путевой лист участника Конференции, что поможет Вам быстрее пройти регистрацию. </p>
<div style="text-align: center; margin-top: 20px;">
	<p style="margin-top: 10px 0; text-align: center;">
		<a href="<?=$user->Participants[0]->getTicketUrl()?>" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #6C0C7A; margin: 10px 0; padding: 0; border-color: #6C0C7A; border-style: solid; border-width: 10px 40px; min-width: 220px; width: 40%;">Путевой лист</a>
	</p>
</div>

<p>С&nbsp;любыми вопросами относительно особенностей проведения Конференции и&nbsp;участия в&nbsp;нем&nbsp;— обращайтесь по&nbsp;адресу: <a href="mailto:users@i-comference.ru">users@i-comference.ru</a> </p>
<p>До&nbsp;встречи на&nbsp;<nobr>i-COMference</nobr> 2015!</p>
<p>---</p>
<p><em>С&nbsp;уважением,<br/>
 Оргкомитет конференции <nobr>i-COMference</nobr> 2015</em>
</p>