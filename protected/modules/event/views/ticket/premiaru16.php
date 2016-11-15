<?php

use ruvents\components\QrCode;
use user\models\User;
use event\models\Event;
use event\models\Participant;

/**
 * @var User                      $user
 * @var Event                     $event
 * @var Participant|Participant[] $participant
 */
?>


<style>
    
    body {
        background: #0e0c09;
    }
    
    .rotate {
        rotate: 90;
        position: absolute;
    }

    .list{

        width: 140mm;
        height: 200mm;
        background-size: contain;
    }
    
    .first {
        background: url("/img/ticket/premiaru16/1.jpg") center center no-repeat;
    }
    
    .second{
        top: 150mm;
        background: url("/img/ticket/premiaru16/2.jpg") center center no-repeat;
    }

    .qr{
        position: absolute;
        bottom: 155mm;
        left: 30mm;
    }

</style>
<div class="first list rotate">

</div>
<div class="second list rotate">

</div>
<div class="qr">
    <?=\CHtml::image(QrCode::getAbsoluteUrl($user, 90))?>
    <p style="text-align: center; color: #fffcb3; font-family: Arial">
        <?=$user->RunetId?>
    </p>
</div>