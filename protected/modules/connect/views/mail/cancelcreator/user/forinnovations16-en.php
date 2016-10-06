<?php
/**
 * @var \connect\models\Meeting $meeting
 * @var \user\models\User $user
 * @var string $response
 */
?>
<h2>Hello!</h2>
<p>
    Unfortunately, <?= $user->getFullName(); ?> (<?= $user->getEmploymentPrimary()->Company->FullName; ?>)
    has cancelled a business meeting on <?= $meeting->Date; ?> within the forum 'Open Innovations 2016'.
</p>
<p>Reason: <?= $response; ?>.</p>