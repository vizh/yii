<?php
/**
 * @var User $user
 * @var Event $event
 * @var Participant|Participant[] $participant
 */

use user\models\User;
use event\models\Event;
use event\models\Participant;

use ruvents\components\QrCode;
?>
<div style="position: absolute; bottom: 40mm; right: 5mm; color: #ffffff; font-family: Arial; font-size: 10mm; rotate: 90;">
    <?if($participant->RoleId === 14):?>
        VIP
    <?endif?>
    <strong><?=$user->RunetId?></strong>
    <?=\CHtml::image(QrCode::getAbsoluteUrl($user, 70), '', ['style' => 'margin-bottom: -5mm;'])?>
</div>
<div style="text-align: center;">
    <img src="/img/ticket/premiaru15/invite.jpg" />
</div>

