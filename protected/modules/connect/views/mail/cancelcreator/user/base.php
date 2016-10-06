<?php
/**
 * @var \connect\models\Meeting $meeting
 * @var \user\models\User $user
 * @var string $response
 */
?>
<h2>Здравствуйте!</h2>
<p>
    К сожалению, <?= $user->getFullName(); ?> (<?= $user->getEmploymentPrimary()->Company->FullName; ?>) отменил встречу
    в рамках <?= $meeting->Place->Event->Title; ?>.
</p>

<p>
    Причина: <?= $response; ?>.
</p>
