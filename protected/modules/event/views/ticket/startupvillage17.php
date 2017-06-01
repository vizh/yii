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

    .page {

        height: 281mm;
        width: 420mm;
    }


    .page1{

        background: url("/img/ticket/startupvillage17/1.png") no-repeat;
        background-size: contain;
    }
    .page2{

        background: url("/img/ticket/startupvillage17/2.png") no-repeat;
        background-size: contain;
    }
    .page3{

        background: url("/img/ticket/startupvillage17/3.png") no-repeat;
        background-size: contain;
    }
    .page4{

        background: url("/img/ticket/startupvillage17/4.png") no-repeat;
        background-size: contain;
    }
    .page5{

        background: url("/img/ticket/startupvillage17/5.png") no-repeat;
        background-size: contain;
    }
    .page6{

        background: url("/img/ticket/startupvillage17/6.png") no-repeat;
        background-size: contain;
    }

    p{
        color:#fff;
    }

</style>
<div class="page page1">

</div>
<div style="position: fixed; top: 80mm; left: 60mm;  color: #000; font-family: Arial; font-size: 5.8mm">
    <b><?=$user->LastName.'<br >'.$user->FirstName?></b>
</div>
<div style="position: fixed; top: 103mm; left: 60mm;  color: #000; font-family: Arial; font-size: 5.8mm">
    <?=$user->employmentPrimary->Company->Name?>
</div>
<div style="position: fixed; top: 145mm; left: 95mm;  color: #000; font-family: Arial; font-size: 2.8mm; text-transform: uppercase">
    <?=$participant->Role->Title?>
</div>

<div style="position: fixed; top: 137mm; left: 20mm;  color: #000; font-family: Arial; font-size: 5.8mm; ">
    СТАТУС
</div>

<div style="position: fixed; top: 80mm; left: 20mm;">
    <div style="border: 1px solid #000">
    <?=\CHtml::image(\ruvents\components\QrCode::getAbsoluteUrl($user->RunetId, 117, true))?>
    </div>
</div>


<div class="page page2"></div>
<div class="page page3"></div>
<div class="page page4"></div>
<div class="page page5"></div>
<div class="page page6"></div>