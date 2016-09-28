<p>Здравствуйте, <?=$user->getShortName()?>.</p>

<p>Вы получили это письмо, т.к. ранее подтвердили свое желание войти в состав <b>Экспертное Сообщество Института Развития Интернета (ИРИ)</b>.</p>

<p>В понедельник стартует голосование этап голосования по списку кандидатов на вхождение в ЭС ИРИ. Вы имеете возможность порекомендовать еще как минимум одного кандидата <b>до 17 мая включительно</b>.</p>

<p>Для этого Вам необходимо перейти по ссылке ниже (Личный кабинет кандидата в эксперты ИРИ), после чего Вы сможете предложить третьего эксперта от Вашего имени.</p>

<?
 $salt = '71064386e1731ff1ceb2b4667ce67b8c';
    $hash = md5($user->RunetId . $salt . 'expert');
?>

<div style=" text-align: center; margin-top: 20px;">
	<p style="margin-top: 10px 0; text-align: center;"><a href="http://iri.runet-id.com/becomeexpert/?runetid=<?=$user->RunetId?>&hash=<?=$hash?>"  style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #222222; margin: 0; padding: 0; border-color: #222222; border-style: solid; border-width: 10px 40px; width: 75%;" target="_blank">ЛИЧНЫЙ КАБИНЕТ ЭКСПЕРТА</a></p>
</div>
