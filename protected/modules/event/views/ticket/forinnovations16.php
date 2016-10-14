<?php

use user\models\User;
use event\models\Event;
use event\models\Participant;
use event\models\UserData;

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

        background: url("/img/ticket/forinnovations16/bg.png") no-repeat;
        background-size: contain;
    }

    p{
        color:#fff;
    }

</style>
<div class="main">

</div>
<div style="position: fixed; top: 15mm; left: 105mm; rotate: 90; color: #2b2954; font-family: Arial; font-size: 6.8mm">
    <b><?=$user->LastName.'<br >'.$user->FirstName?></b>
</div>
<div style="position: fixed; top: 15mm; left: 95mm; rotate: 90; color: #2b2954; font-family: Arial; font-size: 3.8mm">
    <?=$user->employmentPrimary->Company->Name?>
</div>
<div style="position: fixed; top: 15mm; width: 60mm; left: 70mm; rotate: 90; color: #2b2954; font-family: Arial; font-size: 5.8mm; text-transform: uppercase">
<!--    --><?php $attribs = UserData::getDefinedAttributeValues($event, $user) ?>
<!--    --><?=$attribs['status']?>


</div>


<div style="position: fixed; top: 52mm; left: 34mm; rotate: 90; color: #fff; font-family: Arial; font-size: 5.8mm; text-transform: uppercase">
    <?=$user->RunetId?>
</div>

<div style="position: fixed; top: 8mm; left: 10mm; rotate: 90;">
    <?=\CHtml::image(\ruvents\components\QrCode::getAbsoluteUrl($user, 138))?>
</div>
