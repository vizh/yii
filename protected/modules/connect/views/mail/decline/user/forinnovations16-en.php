<?php
/**
 * @var \connect\models\Meeting $meeting
 * @var \user\models\User $user
 * @var string $response
 */
?>
<h2>Hello!</h2>
<p>
    Unfortunately, you have cancelled a business meeting with
    <?= $user->getFullName(); ?> (<?= $user->getEmploymentPrimary()->Company->FullName; ?>)
    on <?= $meeting->Date; ?> within the forum 'Open Innovations 2016'.
</p>
<p>Reason: <?= $response; ?>.</p>