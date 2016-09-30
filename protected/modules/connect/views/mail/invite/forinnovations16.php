<?php
/**
 * @var \connect\models\Meeting $meeting
 * @var \user\models\User $user
 */
?>
<h2 style='font-family: HelveticaNeue-Light,"Helvetica Neue Light","Helvetica Neue",Helvetica,Arial,"Lucida Grande",sans-serif; color: rgb(0, 0, 0); font-weight: 500; font-size: 23px; margin: 10px 0px; padding: 0px; line-height: 1.3;'>Здравствуйте!</h2>
<p style="line-height: 20.7999992370605px;">
    <?= $meeting->Creator->getFullName(); ?> (<?= $meeting->Creator->getEmploymentPrimary()->Company->FullName; ?>) приглашает Вас на деловую встречу
    в рамках форума «Открытые инновации 2016»
    в <?= $meeting->Date; ?>,
    место встречи: <?= $meeting->Place->Name?>.
</p>

<p style="line-height: 20.7999992370605px;">Цель встречи: <strong><?= $meeting->Purpose; ?></strong></p>

<p style="line-height: 20.7999992370605px;">Тема встречи: <strong><?= $meeting->Subject; ?></strong></p>

<?php if ($meeting->File): ?>
    <p style="line-height: 20.7999992370605px;">Приглашающая сторона прикрепила <?= CHtml::link('файл', $meeting->getFileUrl(true)); ?> с дополнительной информацией</a>.</p>
<?php endif; ?>
