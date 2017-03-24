<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 22.12.16
 * Time: 9:25
 * @var Participant|Participant[] $participant
 */
use user\models\User;
use application\components\web\helpers\Html;
use event\models\Participant;


?>
<?if(Yii::app()->language === 'ru'):?>
    <style>
        .main{
            background: url("/img/ticket/ipheb17/bg.png") no-repeat;
        }
    </style>
<? else :?>
    <style>
        .main{
            background: url("/img/ticket/ipheb17/bg-en.png") no-repeat;
        }
    </style>
<? endif?>
<style>
    .main{
        height: 281mm;
        width: 420mm;

        background-size: cover;
    }

    p{
        color:#fff;
    }

</style>
<div class="main">

</div>
<div style="position: fixed; top: 15mm; left: 73mm; rotate: 90; color: #fff; font-family: Arial; font-size: 6.8mm">
    <?=$user->LastName.'<br >'.$user->FirstName.'<br >'.$user->FatherName?>
</div>

<div style="position: fixed; top: 15mm; left: 60mm; rotate: 90; color: #fff; font-family: Arial; font-size: 6.8mm">
    <?=Html::limitedTag('td', $user->getEmploymentPrimary()->Company->Name, 20, 291, 60, [
        'style' => 'padding-top: 5mm;'
    ])?>
</div>
<div style="position: fixed; top: 15mm; left: 47mm; rotate: 90; color: #fff; font-family: Arial; font-size: 6.8mm">
    <span style="text-transform: uppercase">
        <?=$participant->Role->Title?>
    </span>
</div>

<div style="position: fixed; top: 15mm; left: 20mm; rotate: 90;">
    <barcode code="<?=$user->RunetId?>" type="C128A" class="barcode" size="1" height="1" text="1"/>
</div>
<div style="position: fixed; top: 30mm; left: 10mm; rotate: 90;">
    <?=$user->RunetId?>
</div>

<div style="position: fixed; top: 63mm; left: 9mm; rotate: 90;">
    <?=\CHtml::image(\ruvents\components\QrCode::getAbsoluteUrl($user, 85))?>
</div>