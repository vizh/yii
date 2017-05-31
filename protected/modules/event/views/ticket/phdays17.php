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

        background: url("/img/ticket/phdays17/bg.png") no-repeat;
        background-size: contain;
    }

    p{
        color:#fff;
    }

</style>
<div class="main">

</div>
<div style="position: fixed; top: 12.3mm; left: 75mm; rotate: 90; color: #000; font-family: Arial; font-weight: normal; font-size: 5.8mm">
    <b><?=$user->LastName.'<br >'.$user->FirstName?></b>
</div>
<div style="padding-top:0;padding-left:0;width:80mm;overflow:hidden;position: fixed; top: 12.5mm; left: 65mm; rotate: 90; color: #000; font-family: Arial; font-size: 3.3mm">
    <?=\application\components\web\helpers\Html::limitedTag('div', $user->getEmploymentPrimary()->Company->Name, 15, 291, 60)?>
</div>
<div style="position: fixed; top: 12.3mm; left: 47mm; rotate: 90; font-family: Arial; font-size: 3.8mm; text-transform: uppercase">
    <?=$participant->Role->Title?>
</div>


<div style="position: fixed; top: 60.5mm; left: 16mm; rotate: 90;">

    <?=\CHtml::image(\ruvents\components\QrCode::getAbsoluteUrl($user, 70))?>
</div>

<div style="position: fixed; top: 12.5mm; left: 19mm; rotate: 90; color: #939598; font-weight: bold; font-family: Arial; font-size: 8.8mm; text-transform: uppercase">
    <?=$user->RunetId?>
</div>
