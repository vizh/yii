<?php
/**
 * @var \user\models\User $user
 */
?>

<p>Здравствуйе,&nbsp;<?=$user->getFullName()?>!</p>

<p>Спасибо за регистрацию на научно-деловую программу международной выставки&nbsp;&quot;Дни инноваций Министерства Обороны Российской Федерации&quot;.</p>

<p><strong>Дата проведения: </strong>5 - 6 октября 2015 года.</p>

<p><strong>Место проведения:&nbsp;</strong>г. Кубинка, 57 км. минского шоссе, Парк &laquo;Патриот&raquo; &mdash; военно-патриотический парк культуры и отдыха Вооруженных Сил Российской Федерации.</p>

<p>Для прохода на научно-деловую часть &nbsp;вам необходимо распечатать и взять с собой ваш личный электроный билет:&nbsp;</p>

<div style="text-align: center; background: #F0F0F0; border: 2px dashed #FFF; padding: 20px 10px 10px;">
<p style="margin-top: 0"><a href="<?=$participant->getTicketUrl()?>" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #348eda; margin: 0 10px 0 0; padding: 0; border-color: #348eda; border-style: solid; border-width: 10px 40px;">Электронный билет</a></p>

<p style="text-align:center; margin: 0; padding-bottom: 10px;">Ваш билет уникален и не подлежит передаче третьим лицам.</p>
</div>

<p>&nbsp;</p>

<p>По ссылке ниже вы можете просмотреть программу мероприятия и секции на которые вы зарегистрировались.</p>

<div style="text-align: center; background: #F0F0F0; border: 2px dashed #FFF; padding: 20px 10px 10px;">
<p style="margin-top: 0; padding-bottom: 10px;"><a href="<?=$user->getFastauthUrl('/event/moinnovationday15#event_widgets_registration_Program')?>" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #348eda; margin: 0 10px 0 0; padding: 0; border-color: #348eda; border-style: solid; border-width: 10px 40px;">Ваша программа</a></p>
</div>

<p>&nbsp;</p>

<p><strong><span style="line-height: 20.8px;">До встречи на мероприятии!</span></strong></p>

<p>&nbsp;</p>

<p>&nbsp;</p>

<p>&nbsp;</p>
