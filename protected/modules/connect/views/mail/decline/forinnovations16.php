<?php
/**
 * @var \connect\models\Meeting $meeting
 * @var \user\models\User $user
 * @var string $response
 */
?>
<p>Здравствуйте!</p>
<p>
    К сожалению, <?= $user->getFullName(); ?> (<?= $user->getEmploymentPrimary()->Company->FullName; ?>) не имеет возможности
    принять Ваше приглашение и встретится в рамках форума «Открытые инновации 2016».
</p>

<p>
    Причина: <?= $response; ?>.
</p>