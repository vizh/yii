<?php
/**
 * @var \connect\models\Meeting $meeting
 * @var \user\models\User $user
 */
?>
<p>Hello!</p>
<p>
    You have accepted an invitation to hold a business meeting with
    <?= $user->getFullName(); ?> (<?= $user->getEmploymentPrimary()->Company->FullName; ?>)
    within the forum 'Open Innovations 2016'.
</p>
<p>This meeting is planned on <?= $meeting->Date; ?> in <?= $meeting->Place->Name; ?>.</p>
<p>Purpose: <strong><?= $meeting->Purpose; ?></strong></p>
<p>Subject: <strong><?= $meeting->Subject; ?></strong></p>
<p>
    You can see details of this business meeting and appoint other in your
    <a href="https://forinnovations.ru/profile/connect/personal">personal account</a>.
</p>