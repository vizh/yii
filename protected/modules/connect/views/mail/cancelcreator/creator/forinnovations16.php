<?php
/**
 * @var \connect\models\Meeting $meeting
 * @var \user\models\User $user
 * @var string $response
 */
?>
<h2>Здравствуйте!</h2>
<p>
    К сожалению, Вы отменили встречу с <?= $user->getFullName(); ?> (<?= $user->getEmploymentPrimary()->Company->FullName; ?>)
    на <?= $meeting->Date; ?> в рамках форума «Открытые инновации 2016».
</p>

<p>
    Причина, указанная Вами: <?= $response; ?>.
</p>