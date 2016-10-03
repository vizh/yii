<?php
/**
 * @var \connect\models\Meeting $meeting
 * @var \user\models\User $user
 */
?>
<h2>Здравствуйте!</h2>
<p>
    <?= $user->getFullName(); ?> (<?= $user->getEmploymentPrimary()->Company->Name; ?>) принимает Ваше приглашение к встречи
    в рамках <?= $meeting->Place->Event->Title; ?>.
</p>

<p>
    Напоминаем, что все запланирована на <?= $meeting->Date; ?>, место встречи: <?= $meeting->Place->Name; ?>.
</p>

<p>Цель встречи: <strong><?= $meeting->Purpose; ?></strong></p>

<p>Тема встречи: <strong><?= $meeting->Subject; ?></strong></p>
