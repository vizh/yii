<?php
/**
 * @var User $user
 * @var Event $event
 * @var Participant|Participant[] $participant
 */

use user\models\User;
use event\models\Event;
use event\models\Participant;
?>
<div style="position: absolute; top: 70mm;  width: 100mm; left: 55mm; text-align: center; color: #464c9a; font-weight: bold; font-size: 10mm;">
    <?=$user->getFullName();?>
</div>
<div style="text-align: center;">
    <img src="/img/ticket/edcrunch15/sertificate.jpg" />
</div>