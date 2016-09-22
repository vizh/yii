<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 22.09.16
 * Time: 12:23
 */
use user\models\User;


?>
<style>



    .main{
        height: 296mm;
        width: 420mm;

        background: url("/img/ticket/mgnc-october16/ticket.jpg") no-repeat;
        background-size: cover;
    }

    p{
        color:#fff;
    }

</style>
<div class="main">

</div>
<div style="position: fixed; top: 15mm; left: 63mm; rotate: 90; color: #fff; font-family: Arial; font-size: 6.8mm"><?= $user->LastName.'<br >'.$user->FirstName?></div>
<div style="position: fixed; top: 37mm; left: 20mm; rotate: 90;">
    <?=\CHtml::image(\ruvents\components\QrCode::getAbsoluteUrl($user, 80));?>
</div>

