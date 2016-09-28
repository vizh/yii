<?php
/**
 * @var User $user
 */
use user\models\User;

?>
<h3><?=$user->getShortName()?>, здравствуйте!</h3>

<p>В настоящее время мы проводим онлайн-опрос, посвященный современному интернет-сообществу и компаниям, работающим в информационной сфере.<br>Мы хотели бы предложить вам принять участие в опросе этом опросе.</p>

<p>Заполнение анкеты займет не более 15 минут.</p>

<p>Вся информация, которую мы получим от вас, останется строго конфиденциальной и будет использована только для статистического анализа.</p>

<p>Мы будем рады видеть вас среди участников нашего исследования!<br>Ваше мнение крайне важно для нас!</p>

<p style="text-align: center;"><a href="<?=$user->getFastauthUrl('/proftest2014/')?>" style="font-size: 100%; color: #FFF; text-decoration: none; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: uppercase; background-color: #348eda; margin: 0 10px 0 0; padding: 0; border-color: #348eda; border-style: solid; border-width: 10px 40px;"><strong>Начать опрос &raquo;</strong></a></p>

<p>Спасибо за участие.</p>

<p><em>--<br />
        С уважением,<br />
        команда &ndash;RUNET&ndash;ID&ndash;</em></p>