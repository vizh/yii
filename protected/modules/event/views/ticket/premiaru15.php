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
    <?php if ($participant->RoleId === 14):?>
        VIP
    <?php endif;?>
    <strong><?=$user->RunetId;?></strong>
    <?=\CHtml::image(QrCode::getAbsoluteUrl($user, 70), '', ['style' => 'margin-bottom: -5mm;']);?>
</div>
<div style="text-align: center;">
    <img src="/img/ticket/premiaru15/invite.jpg" />
</div>

<?php $event = \event\models\Event::model()->findByPk(2000);?>
<a href="<?=$event->getFastRegisterUrl($user, \event\models\Role::model()->findByPk(168));?>">ТЕКСТ</a>
