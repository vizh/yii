<?php
/**
 * @var \connect\models\Meeting $meeting
 * @var \user\models\User $user
 */
?>
<p>Здравствуйте!</p>
<p><?= $meeting->Creator->getFullName(); ?> (<?= $meeting->Creator->getEmploymentPrimary()->Company->FullName; ?>) приглашает Вас на деловую встречу в рамках форума «Открытые инновации 2016» в <?= $meeting->Date; ?>, предлагаемое место встречи: <?= $meeting->Place->Name?>.</p>
<p><strong>Тема встречи:</strong><br/><?= $meeting->Subject; ?></p>
<p><strong>Цель встречи:</strong><br/><?= $meeting->Purpose; ?></p>

<?php if ($meeting->File): ?>
    <p>Приглашающая сторона прикрепила <?= CHtml::link('файл', $meeting->getFileUrl(true)); ?> с дополнительной информацией</a>.</p>
<?php endif; ?>

<p>Принять или отклонить встречу Вы можете в своем <a href="https://forinnovations.ru/profile/connect/personal">личном кабинете</a>.</p>