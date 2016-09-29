<?php
/**
 * @var User $user
 */
use user\models\User;

?>
<h3><?=$user->getShortName()?>, добрый день!</h3>

<p>Спасибо за Ваше участие в конференции User Experience Russia 2014.</p>

<p>Мы высоко ценим мнение каждого участника Форума и будем признательны, если вы уделите 5 минут своего времени, что бы принять участие в итоговом опросе участников. Результаты опроса обязательно будут учитываться при подготовке в User Experience Russia 2015.</p>

<p style="text-align: center;">
    <a href="<?=$user->getFastauthUrl('/test/userexp14/')?>" style="display: inline-block; background: #3B3B3B; color: #ffffff; padding: 10px 20px; border-radius: 4px; border-top: 1px solid #737373; border-left: 1px solid #737373; text-decoration: none;">Перейти к опросу</a>
</p>

<p>В Ближайшее время мы опубликуем на сайте видео и презентации докладчиков</p>

<h3>Что дальше?</h3>

<p>Приглашаем Вас посетить RIW 2014 (12-14 ноября, Москва, Экспоцентр) &ndash; главную выставку и форум российской интернет-, телеком- и медиа-отраслей.</p>

<p>Участие в Выставке: бесплатное. Участие в Профессиональной программе: платное, участникам User Experience Russia 2014 предоставляется скидка в размере 10% от стоимости участия. Запросить скидку можно по адресу <a href="mailto:users@russianinternetweek.ru">users@russianinternetweek.ru</a></p>
