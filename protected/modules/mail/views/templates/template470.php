<p>Здравствуйте, <?=$user->getShortName()?>.</p>

<p>Подходит к завершению формирование списка кандидатов на вхождение в <b>Экспертное Сообщество Института Развития Интернета (ИРИ)</b>. Старт формированию ЭКС ИРИ был дан 22 апреля 2015 года &ndash; в ходе открытия РИФ+КИБ 2015. Завершится процесс выдвижения кандидатов 12 мая 2015 года, после чего стартует голосование за кандидатов.</p>

<p>Подробнее об ЭС ИРИ и этапах формирования: <a href="http://xn--h1aax.xn--p1ai/experts/" target="_blank">http://ири.рф/experts/</a></p>

<h3>Ранее Вы уже подтвердили Ваше желание войти в состав ЭС ИРИ.</h3>
<p>И у Вас была возможность делегировать дополнительно до 2 Ваших коллег &ndash; в кандидаты на вхождение в ЭС ИРИ.</p>

<p>Напоминаем, что до 12 мая включительно Вы можете делегировать еще одного, третьего, представителя &ndash; в кандидаты на вхождение в ЭС ИРИ.</p>

<p>Для этого Вам необходимо перейти по ссылке ниже (Личный кабинет кандидата в эксперты ИРИ), после чего Вы сможете пригласить (делегировать) третьего эксперта от Вашего имени.</p>

<?
 $salt = '71064386e1731ff1ceb2b4667ce67b8c';
    $hash = md5($user->RunetId . $salt . 'expert');
?>
<div style=" text-align: center; margin-top: 20px;">
<p style="margin-top: 10px 0; text-align: center;"><a href="http://iri.runet-id.com/becomeexpert/?runetid=<?=$user->RunetId?>&hash=<?=$hash?>"  style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #222222; margin: 0; padding: 0; border-color: #222222; border-style: solid; border-width: 10px 40px; width: 75%;" target="_blank">ПЕРЕЙТИ В ЛИЧНЫЙ КАБИНЕТ ЭКСПЕРТА</a></p>
</div>
