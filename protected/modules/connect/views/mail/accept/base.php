<?php
/**
 * @var \connect\models\Meeting $meeting
 * @var \user\models\User $user
 */
?>
<h2 style='font-family: HelveticaNeue-Light,"Helvetica Neue Light","Helvetica Neue",Helvetica,Arial,"Lucida Grande",sans-serif; color: rgb(0, 0, 0); font-weight: 500; font-size: 23px; margin: 10px 0px; padding: 0px; line-height: 1.3;'>Здравствуйте!</h2>
<p style="line-height: 20.7999992370605px;">
    <?= $user->getFullName(); ?> (<?= $user->getEmploymentPrimary()->Company->Name; ?>) принимает Ваше приглашение к встречи
    в рамках <?= $meeting->Place->Event->Title; ?>.
</p>

<p style="line-height: 20.7999992370605px;">
    Напоминаем, что все запланирована на <?= $meeting->Date; ?>, место встречи: <?= $meeting->Place->Name; ?>.
</p>

<p style="line-height: 20.7999992370605px;">Цель встречи: <strong><?= $meeting->Purpose; ?></strong></p>

<p style="line-height: 20.7999992370605px;">Тема встречи: <strong><?= $meeting->Subject; ?></strong></p>
