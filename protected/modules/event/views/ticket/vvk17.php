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
<style>

    .page {

        height: 420mm;
        width: 281mm;
    }

    p {
        line-height: 17px;
        font-family: "Times New Roman";
        font-size: 17px;
    }

</style>
<div class="page">
    <img src="/img/ticket/vvk17/header.png">
    <p style="text-align: center">Уважаемый участник конгресса!</p>

    <p style="text-align: center"><?=$user->LastName.' '.$user->FirstName.' '.$user->FatherName?></p>

    <p style="text-align: center"><?=$user->Employments[0]? $user->Employments[0]->Position : ''?></p>

    <p style="text-align: center"><?=$user->Employments[0] ? $user->Employments[0]->Company->Name : ''?></p>
    <p style="text-align: center"><?=$participant->Role->Title?></p>

    <p style="text-align: center"><barcode code="<?=$user->RunetId?>" type="C128A" class="barcode" size="1" height="2" text="1"/></p>
    <p style="text-align: center"><?=$user->RunetId?></p>

    <img src="/img/ticket/vvk17/down_part.png">


</div>