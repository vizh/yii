<?php
/**
 * @var \connect\models\Meeting $meeting
 * @var \user\models\User $user
 */
?>
<h2>Здравствуйте!</h2>
<p>
    <?= $user->getFullName(); ?> (<?= $user->getEmploymentPrimary()->Company->FullName; ?>) принимает Ваше приглашение на встречу
    в рамках форума «Открытые инновации 2016».
</p>
<p>Напоминаем, что у Вас на <?= $meeting->Date; ?> запланирована встреча, место: <?= $meeting->Place->Name; ?>.</p>
<p>Цель встречи: <strong><?= $meeting->Purpose; ?></strong></p>
<p>Тема встречи: <strong><?= $meeting->Subject; ?></strong></p>
<p>
    Посмотреть детали этой встречи и назначить другие Вы можете в своем
    <a href="https://forinnovations.ru/profile/connect/personal">личном кабинете</a>.
</p>