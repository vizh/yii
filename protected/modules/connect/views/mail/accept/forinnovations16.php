<?php
/**
 * @var \connect\models\Meeting $meeting
 * @var \user\models\User $user
 */
?>
<p>Здравствуйте!</p>
<p>
    <?= $user->getFullName(); ?> (<?= $user->getEmploymentPrimary()->Company->FullName; ?>) принимает Ваше приглашение к встречи
    в рамках форума «Открытые инновации 2016».
</p>

<p>
    Напоминаем, что все запланирована на <?= $meeting->Date; ?>, место встречи: <?= $meeting->Place->Name; ?>.
</p>

<p>Цель встречи: <strong><?= $meeting->Purpose; ?></strong></p>

<p>Тема встречи: <strong><?= $meeting->Subject; ?></strong></p>

<p>Посмотреть детали этой встречи и назначить другие Вы можете в своем <a href="https://forinnovations.ru/profile/connect/personal">личном кабинете</a>.</p>