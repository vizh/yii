<?php
/**
 * @var \connect\models\Meeting $meeting
 * @var \user\models\User $user
 */
?>
<h2>Здравствуйте!</h2>
<p>
    <?= $meeting->Creator->getFullName(); ?> (<?= $meeting->Creator->getEmploymentPrimary()->Company->Name; ?>) приглашает Вас на деловую встречу
    в рамках <?= $meeting->Place->Event->Title; ?>
    в <?= $meeting->Date; ?>,
    место встречи: <?= $meeting->Place->Name?>.
</p>

<p>Цель встречи: <strong><?= $meeting->Purpose; ?></strong></p>

<p>Тема встречи: <strong><?= $meeting->Subject; ?></strong></p>

<?php if ($meeting->File): ?>
    <p>Приглашающая сторона прикрепила <?= CHtml::link('файл', $meeting->getFileUrl(true)); ?> с дополнительной информацией</a>.</p>
<?php endif; ?>
