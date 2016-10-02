<?php
/**
 * @var \connect\models\Meeting $meeting
 * @var \user\models\User $user
 */
?>
<p>Здравствуйте!</p>
<p>
    <?= $meeting->Creator->getFullName(); ?> (<?= $meeting->Creator->getEmploymentPrimary()->Company->FullName; ?>) приглашает Вас на деловую встречу
    в рамках форума «Открытые инновации 2016»
    в <?= $meeting->Date; ?>,
    место встречи: <?= $meeting->Place->Name?>.
</p>

<p>Цель встречи: <strong><?= $meeting->Purpose; ?></strong></p>

<p>Тема встречи: <strong><?= $meeting->Subject; ?></strong></p>

<?php if ($meeting->File): ?>
    <p>Приглашающая сторона прикрепила <?= CHtml::link('файл', $meeting->getFileUrl(true)); ?> с дополнительной информацией</a>.</p>
<?php endif; ?>

<p>Принять или отклонить встречу Вы можете в своем <a href="https://forinnovations.ru/profile/connect/personal">личном кабинете</a>.</p>