<?php

use user\models\User;
use event\models\Event;
use event\models\Participant;

/**
 * @var User                      $user
 * @var Event                     $event
 * @var Participant|Participant[] $participant
 */

if (is_array($participant)) {
    $participant = $participant[0];
}
?>



<style>



    .main{
        height: 281mm;
        width: 420mm;

        background: url("/img/ticket/nspkdec16/bg.jpg") no-repeat;
        background-size: contain;
    }

    p{
        color:#fff;
    }

</style>
<div class="main">

</div>
<div style="position: fixed; top: 7mm; left: 75mm; rotate: 90; color: #fff; font-family: Arial; font-size: 5.8mm">
    <b><?=$user->LastName.'<br >'.$user->FirstName?></b>
</div>
<div style="position: fixed; top: 7mm; left: 63mm; rotate: 90; color: #fff; font-family: Arial; font-size: 5.8mm">
    <?=$user->employmentPrimary->Company->Name?>
</div>
<div style="position: fixed; top: 7mm; left: 45mm; rotate: 90; color: #fff; font-family: Arial; font-size: 5.8mm; text-transform: uppercase">
    <?=$participant->Role->Title?>
</div>


<div style="position: fixed; top: 50mm; left: 13mm; rotate: 90; color: #000; font-family: Arial; font-size: 5.8mm; text-transform: uppercase">
    <?=$user->RunetId?>
</div>

<div style="position: fixed; top: 7mm; left: 15mm; rotate: 90;">
    <?=\CHtml::image(\ruvents\components\QrCode::getAbsoluteUrl($user, 70))?>
</div>
