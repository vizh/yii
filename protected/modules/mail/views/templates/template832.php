<?php
/**
 * @var \user\models\User $user
 */
?>

<h3><?=$user->getShortName()?>, здравствуйте!</h3>

<p>В настоящее время мы проводим опрос, посвященный современному интернет-сообществу и компаниям, работающим в информационной сфере.</p>

<p>Мы будем признательны, если вы найдете возможность принять участие этом опросе. Заполнение анкеты займет <b>не более 10 минут</b>.</p>

<p>Вся информация, которую мы получим от вас, останется строго конфиденциальной и будет использована только для статистического анализа.</p>

<div style="border-top: 1px solid #eaeaea; border-bottom: 1px solid #eaeaea; text-align: center; padding-top: 15px; padding-bottom: 15px; margin: 25px 0;">
<p>Для начала опроса перейдите по ссылке:</p>

<p align="center"><a href="<?=$user->getFastauthUrl('/proftest2016/')?>" style="font-size: 100%; color: #fff; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #53A753; margin: 0 10px 0 0; padding: 0; border-color: #53A753; border-style: solid; border-width: 10px 40px;">Начать опрос</a></p>
</div>

<p>Заполнившим анкету, мы подарим <b>50% скидку на <a href="http://2016.i-comference.ru/">i-CoM 2016</a></b> — двухдневное профессиональное мероприятие, посвященное коммуникациям в интернете и цифровому маркетингу.</p>

<p>Ваше мнение крайне важно для нас!</p>