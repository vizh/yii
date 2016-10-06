<?php
/**
 * @var \connect\models\Meeting $meeting
 * @var \user\models\User $user
 */
?>
<h2>Hello!</h2>
<p>
    <?= $meeting->Creator->getFullName(); ?> (<?= $meeting->Creator->getEmploymentPrimary()->Company->FullName; ?>)
    invites you to hold a business meeting within the forum 'Open Innovations 2016'
    on <?= $meeting->Date; ?>
    in <?= $meeting->Place->Name?>.
</p>
<p><strong>Purpose:</strong><br/><?= $meeting->Purpose; ?></p>
<p><strong>Subject:</strong><br/><?= $meeting->Subject; ?></p>

<?php if ($meeting->File): ?>
    <p>Inviting party has attached a <?= CHtml::link('file', $meeting->getFileUrl(true)); ?> with additional information.</p>
<?php endif; ?>

<p>
    You can accept or decline an invitation in your
    <a href="https://forinnovations.ru/profile/connect/personal">personal account</a>.
</p>