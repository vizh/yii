<?php
/**
 * @var \connect\models\Meeting $meeting
 * @var \user\models\User $user
 * @var string $response
 */
?>
<h2 style='font-family: HelveticaNeue-Light,"Helvetica Neue Light","Helvetica Neue",Helvetica,Arial,"Lucida Grande",sans-serif; color: rgb(0, 0, 0); font-weight: 500; font-size: 23px; margin: 10px 0px; padding: 0px; line-height: 1.3;'>Здравствуйте!</h2>
<p style="line-height: 20.7999992370605px;">
    К сожалению, <?= $user->getFullName(); ?> (<?= $user->getEmploymentPrimary()->Company->FullName; ?>) не имеет возможности
    принять Ваше приглашение и встретится в рамках форума «Открытые инновации 2016».
</p>

<p style="line-height: 20.7999992370605px;">
    Причина: <?= $response; ?>.
</p>