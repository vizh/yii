<?php
/**
 * @var \connect\models\Meeting $meeting
 * @var \user\models\User $user
 */
?>
<h2>Hello!</h2>
<p>
    <?= $user->getFullName(); ?> (<?= $user->getEmploymentPrimary()->Company->FullName; ?>)
    accepts your invitation to hold a business meeting within the forum 'Open Innovations 2016'.
</p>
<p>We remind you that you have planned a business meeting at <?= $meeting->Date; ?>, <?= $meeting->Place->Name; ?>.</p>
<p>Purpose: <strong><?= $meeting->Purpose; ?></strong></p>
<p>Subject: <strong><?= $meeting->Subject; ?></strong></p>
<p>
    You can see details of this business meeting and appoint other in your
    <a href="https://forinnovations.ru/profile/connect/personal">personal account</a>.
</p>