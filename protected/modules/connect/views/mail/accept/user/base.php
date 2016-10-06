<?php
/**
 * @var \connect\models\Meeting $meeting
 * @var \user\models\User $user
 */
?>
<p>Здравствуйте!</p>
<p>
    Вы подтвердили приглашение на встречу с <?= $user->getFullName(); ?> (<?= $user->getEmploymentPrimary()->Company->FullName; ?>)
    в рамках <?= $meeting->Place->Event->Title; ?>.
</p>
<p>Эта встреча запланирована на <?= $meeting->Date; ?>, место: <?= $meeting->Place->Name; ?>.</p>
<p>Цель встречи: <strong><?= $meeting->Purpose; ?></strong></p>
<p>Тема встречи: <strong><?= $meeting->Subject; ?></strong></p>