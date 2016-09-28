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
    .root-col-4, table {
        font-family: 'Roboto', 'Helvetica Neue', Helvetica, Arial, sans-serif;
        color: #2F363E;
    }

    .pull-left {
        float: left;
    }

    .pull-right {
        float: right;
    }

    .text-left {
        text-align: left;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    .text-white {
        color: white;
    }

    .valign-middle {
        vertical-align: middle;
    }

    .text-black {
        color: black;
    }

    .text-uppercase {
        text-transform: uppercase;
    }

    .rotate {
        rotate: 90;
    }

    .hidden {
        display: none;
    }

    .root-col-4 {
        position: absolute;
        width: 89mm;
        height: 200mm;
    }

    .root-col-4 > * {
        width: 89mm;
    }

    .root-cut {
        position: absolute;
        left: 0;
        width: 100%;
        height: 10mm;
        background: url('/img/ticket/pdf/base/cutting.png') center center no-repeat;
    }

    .root-cut-line {
        height: 5.3mm;
        border-bottom: .3mm dashed #bbbbbb;
    }

    .root-round-top {
        border-radius: 2mm 2mm 0 0;
    }

    .root-round-bottom {
        border-radius: 0 0 2mm 2mm;
    }

    .bg-dark-gray {
        background: #3E3E3F;
    }

    .bg-gray {
        background: #939598;
    }

    .bg-black {
        background: black;
    }

    img {
        image-resolution: 120dpi;
    }

    .text-red {
        color: #EE1D23;
    }
</style>

<div class="root-col-4 rotate" style="top: 5mm;">
    <div class="root-round-top bg-dark-gray text-center" style="padding: 4mm; font-size: 5mm;">
        <img src="/img/ticket/pdf/base/logo.png" height="2mm">
    </div>
    <div style="margin-top: .5mm; overflow: hidden;">
        <img src="/img/event/phdays16/front.png" alt="" style="display: block;">
    </div>
    <div class="bg-black text-white" style="margin-top: .5mm; padding: 5mm;">
        <div style="font-size: 6mm;">
            <div><?=$user->LastName?></div>
            <div><?=$user->FirstName?></div>
            <div style="margin-top: 4mm;">
                <?if ($user->getEmploymentPrimary() !== null):?>
                    <?=$user->getEmploymentPrimary()->Company->Name?>
                <?else:?>
                    &nbsp;
                <?endif?>
            </div>
        </div>
        <table width="100%" class="text-white" style="margin-top: 4mm;">
            <tr>
                <td valign="bottom" style="font-size: 3mm;">
                    <?if (is_array($participant)):?>
                        <?foreach($participant as $item):?>
                            <strong><?=$item->Part->Title?>:</strong> <?=$item->Role->Title == 'Участник' ? 'Participant' : $item->Role->Title?><br>
                        <?endforeach?>
                    <?else:?>
                        <?=$participant->Role->Title?>
                    <?endif?>
                </td>
                <td align="right">
                    <img src="/img/event/phdays16/wtc_logo.png" width="18mm" alt="">
                </td>
            </tr>
        </table>
    </div>
    <table width="100%" style="margin-top: 6mm" cellpadding="0" cellspacing="0">
        <tr>
            <td valign="middle" align="left" style="color: #6C6D70; font-size: 14mm; padding-left: 5mm;" width="70%">
                <strong><?=$user->RunetId?></strong>
            </td>
            <td valign="middle" align="right" style="padding-right: 5mm;" width="30%">
                <?=\CHtml::image(QrCode::getAbsoluteUrl($user, 90))?>
            </td>
        </tr>
    </table>
    <div style="padding: 3mm 0 0;" class="text-center text-red">To pass to the event You must present a ticket</div>
</div>
<div class="root-cut" style="top: 94mm;">
    <div class="root-cut-line"></div>
</div>
<div class="root-col-4 rotate" style="top: 104mm;">
    <div class="root-round-top bg-dark-gray text-center" style="padding: 4mm; font-size: 5mm;">
        <img src="/img/ticket/pdf/base/logo.png" height="2mm">
    </div>
    <div style="margin-top: .5mm;">
        <img src="/img/event/phdays16/middle.png" alt="" style="display: block;">
    </div>
    <div class="bg-gray text-white root-round-bottom" style="margin-top: .5mm; padding: 6mm; font-size: 3mm;">
        The Forum is organized by Positive Technologies<br>
        <strong>phone:</strong> +7 495 744 01 44;<br>
        <strong>e-mail:</strong> <a class="text-white" href="mailto:phd@ptsecurity.com">phd@ptsecurity.com</a>;
        <div style="margin-top: 5mm">
            <img src="/img/event/phdays16/instagram.png" width="6mm" alt="" style="vertical-align: bottom;">
            #phdaysVI #phdays6 #phdays
            <img src="/img/event/phdays16/twitter.png" width="6mm" alt="" style="vertical-align: bottom" ;>
            @phdays
        </div>
    </div>
</div>
<div class="root-cut" style="top: 193mm;">
    <div class="root-cut-line"></div>
</div>
<div class="root-col-4 rotate" style="top: 203mm;">
    <div class="root-round-top bg-dark-gray text-center" style="padding: 4mm; font-size: 5mm;">
        <img src="/img/ticket/pdf/base/logo.png" height="2mm">
    </div>
    <div style="margin-top: 1mm">
        <img src="/img/event/phdays16/map.png" width="100%" class="root-round-bottom" alt="" style="display: block;">
    </div>
</div>
