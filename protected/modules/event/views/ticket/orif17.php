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

<!--<style>-->
<!---->
<!--    .page {-->
<!---->
<!--        height: 420mm;-->
<!--        width: 281mm;-->
<!--        background: url("/img/ticket/orif17/bg.png") no-repeat;-->
<!--    }-->
<!---->
<!--</style>-->
<!--<div class="page">-->
<!---->
<!--</div>-->
<!---->
<!--<div style="position: fixed; top: 0mm; left: 90mm;  color: #eb038d; font-family: Arial; font-size: 5.8mm; rotate: 90; width: 281mm%; text-align: center;">-->
<!--    <b>--><?//=$user->LastName.' '.$user->FirstName?><!--</b>-->
<!--</div>-->

<style>

    .page {

        height: 420mm;
        width: 281mm;
        background: url("/img/ticket/orif17/bg.min.png") no-repeat;
        background-size: 100%;
    }

</style>
<div class="page">

</div>

<div style="position: fixed; top: 68mm; left: 0;  color: #eb038d; font-family: Arial; font-size: 5.8mm; width: 200mm; text-align: center;">
    <b><?=$user->LastName.' '.$user->FirstName?></b>
</div>