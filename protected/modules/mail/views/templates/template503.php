<h3><?=$user->getShortName()?>, здравствуйте!</h3>

<p>Завершен первый этап формирования списка кандидатов Экспертного Сообщества Института Развития Интернета (<a href="http://ири.рф/experts/">ЭС&nbsp;ИРИ</a>). На&nbsp;втором этапе, который стартует сегодня&nbsp;&mdash; 19&nbsp;мая&nbsp;&mdash; каждый кандидат в&nbsp;эксперты сможет проголосовать за&nbsp;коллег в&nbsp;своей Экосистеме Рунета.</p>

<p><strong>Вы&nbsp;&mdash; кандидат в&nbsp;ЭС&nbsp;ИРИ.</strong><br />
<strong>И&nbsp;с&nbsp;сегодняшнего дня&nbsp;Вы можете принять участие в&nbsp;онлайн-гдлосвании.</strong></p>

<p>Голосование продлится 1&nbsp;неделю. По&nbsp;итогам голосования будет определен состав Экспертного Совета ИРИ.</p>


<?$salt = '71064386e1731ff1ceb2b4667ce67b8c';
$votehash = md5($user->RunetId . $salt . 'voter')?>

<div style="text-align: center; margin-top: 20px;">
	<p style="margin-top: 10px 0; text-align: center;">
		<a href="http://xn--h1aax.xn--p1ai/vote/?runetid=<?=$user->RunetId?>&hash=<?=$votehash?>" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #6C0C7A; margin: 10px 0; padding: 0; border-color: #6C0C7A; border-style: solid; border-width: 10px 40px; min-width: 220px; width: 40%;">ПЕРЕЙТИ К ГОЛОСОВАНИЮ</a>
	</p>
</div>
