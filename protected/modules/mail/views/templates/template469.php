<p>Здравствуйте, <?=$user->getFullName()?>!</p>

<p>Подходит к завершению формирование списка кандидатов на вхождение в <b>Экспертное Сообщество Института Развития Интернета (ИРИ)</b>.</p>

<p>Старт формированию ЭКС ИРИ был дан 22 апреля 2015 года &ndash; в ходе открытия РИФ+КИБ 2015. Завершится процесс выдвижения кандидатов 12 мая 2015 года, после чего стартует голосование за кандидатов.</p>

<p>Подробнее об ЭС ИРИ и этапах формирования: <a href="http://xn--h1aax.xn--p1ai/experts/" target="_blank">http://ири.рф/experts/</a></p>

<h3>От имени учредителей ИРИ приглашаем Вас войти в состав кандидатов в ЭС Института Развития Интернета (ИРИ).</h3>

<p>Первоначальный состав Экспертного Совета сформирован по предложениям учредителей ИРИ.</p>

<p>Вы &ndash; один из примерно 500 экспертов, которые по мнению учредителей ИРИ доказали свой экспертный и профессиональный уровень, и кого мы хотели бы видеть в составе ЭС ИРИ, чтобы дать Вам возможность максимально использовать Ваш опыт для решения глобальных задач Рунета.</p>

<p>Если мы не ошиблись и Вы готовы принять участие в формировании Экспертного Сообщества ИРИ, Вам необходимо подтвердить свое участие, кликнув по кнопке ниже и указав свою специализацию.</p>

<p>Вы также можете делегировать еще до 3 кандидатов, которые должны представлять, по Вашему мнению, экспертное сообщество Рунета в составе ЭС ИР.</p>

<p><b>ВНИМАНИЕ!</b></p>

<p>Формирование списка кандидатов ЭС ИРИ завершится 12 мая. Рекомендуем подтвердить Ваше желание войти в ЭС ИРИ как можно оперативнее, чтобы мы имели достаточно времени на формирование списков, а те эксперты, кого Вы делегируете дополнительно &ndash; на подтверждение их участия в ЭС ИРИ.</p>

<?
 $salt = '71064386e1731ff1ceb2b4667ce67b8c';
    $hash = md5($user->RunetId . $salt . 'expert');
?>
<div style=" text-align: center; margin-top: 20px;">
<p style="margin-top: 10px 0; text-align: center;"><a href="http://iri.runet-id.com/becomeexpert/?runetid=<?=$user->RunetId?>&hash=<?=$hash?>"  style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #222222; margin: 0; padding: 0; border-color: #222222; border-style: solid; border-width: 10px 40px; width: 75%;" target="_blank">ПОДТВЕРДИТЬ УЧАСТИЕ И ДЕЛЕГИРОВАТЬ ДО 3 КОЛЛЕГ&ndash;ЭКСПЕРТОВ</a>&nbsp;</p>
</div>
