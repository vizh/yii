<?php

use user\models\User;
use event\models\Event;
use event\models\Participant;
use ruvents\components\QrCode;

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
    /* global fonts */
    .root-col-4, table {
        font-family: 'Roboto', 'Helvetica Neue', Helvetica, Arial, sans-serif;
        color: black;
    }

    p {
        padding: 0;
        margin: 0;
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

    .root-col-4 {
        position: absolute;
        width: 89mm;
        height: 200mm;
        rotate: 90;
        /*background: red;*/
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
        border-bottom: .3mm dashed black;
    }

    .root-round-top {
        border-radius: 7mm 7mm 0 0;
    }

    .root-round-bottom {
        border-radius: 0 0 7mm 7mm;
    }
</style>

<div class="root-col-4" style="top: 5mm;">
    <div class="text-center text-white root-round-top" style="padding: 3mm 0;background-color: #3E6A7E;">
        <img src="/img/ticket/pdf/base/logo.png" style="padding-right: 3mm; image-resolution: 110dpi;">
        eTicket
    </div>
    <div style="background: #EAEAEB; padding: 4mm 4mm;">
        <table border="0" cellspacing="0" cellpadding="10">
            <tr>
                <td width="60%">
                    <table cellpadding="0" cellspacing="10" width="100%" border="0">
                        <tr>
                            <td>
                                <img src="/img/event/rii16/logo.png" width="25mm" alt="">
                            </td>
                            <td style="padding-top: 2mm">
                                <strong style="font-size: 5mm">Индустриальный<br>Интернет</strong>
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="40%">
                    <table cellpadding="0" cellspacing="10" width="100%" border="0">
                        <tr>
                            <td>
                                <img src="/img/event/rii16/rostelekom.png" width="14mm" alt="">
                            </td>
                            <td style="padding-top: 6mm">
                                <strong style="color: #019BDE; font-size: 6mm">Ростелеком</strong>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div class="text-center text-white" style="background: #019BDE; padding: 3mm 0; font-size: 6mm">
        Развитие индустриального Интернета в России
    </div>
    <div class="text-center" style="font-size: 2.5mm; padding: 2mm 0;">
        При поддержке <strong>Правительства Российской Федерации</strong>
    </div>
    <div style="background: #EAEAEB; padding-top: 15mm">
        <img src="/img/event/rii16/left_scheme.png" width="100%" alt="">
    </div>
    <div class="text-center text-white" style="background: #F17102; padding: 7mm 0;">
        <p style="font-size: 5.5mm"><?= $user->LastName; ?> <?= $user->FirstName; ?>
            <br> &nbsp;<?= $user->FatherName; ?>&nbsp;</p>
        <p style="margin-top: 6mm"><?= $user->getEmploymentPrimary()->Company->Name ?></p>
    </div>
    <div class="text-center text-uppercase text-white" style="background: #019BDE;padding: 5mm 0;font-size: 5.5mm;">
        <?= $participant->Role->Title ?>
    </div>
    <div style="padding: 4mm 6mm; background: #EAEAEB;" class="root-round-bottom">
        <table border="0" cellpadding="0" cellspacing="10" width="100%" style="">
            <tr>
                <td width="40%">
                    <?= \CHtml::image(QrCode::getAbsoluteUrl($user, 70)); ?>
                </td>
                <td width="60%">
                    <span style="font-size: 5mm"> RUNET&mdash;ID<br>
                        <?= $user->RunetId ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-uppercase text-center"
                    style="color: #999; font-size: 2mm">Для прохода на мероприятие предъявите билет в распечатанном или электронном виде
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="root-cut" style="top: 94mm;">
    <div class="root-cut-line"></div>
</div>
<div class="root-col-4" style="top: 104mm;">
    <div class="text-center text-white root-round-top" style="padding: 3mm 0;background-color: #3E6A7E;">
        <img src="/img/ticket/pdf/base/logo.png" style="padding-right: 3mm; image-resolution: 110dpi;">
        eTicket
    </div>
    <div style="background: #EAEAEB; padding-top: 5mm;">
        <table border="0" cellspacing="0" cellpadding="10" width="100%" style="margin: 5mm 0;">
            <tr>
                <td class="text-right" width="40%">
                    <img src="/img/event/rii16/logo.png" style="width: 24mm" alt="">
                </td>
                <td width="60%">
                    <strong style="font-size: 5mm">Индустриальный<br>Интернет</strong>
                </td>
            </tr>
        </table>
        <p class="text-right" style="margin: 0 10mm; font-size: 5mm;">
            <strong>13 апреля</strong> // 2016
        </p>
        <img style="margin-top: 5mm" src="/img/event/rii16/center_scheme.png" width="100%" alt="">
    </div>
    <div style="padding: 1mm 0">
        <p class="text-center text-uppercase" style="font-size: 2.8mm;">Партнеры конференции</p>
        <table width="100%" cellspacing="0" cellpadding="0" style="margin: 2mm 0 0">
            <tr>
                <td width="40%" class="text-right">
                    <img src="/img/event/rii16/free.png" alt="" style="width: 18mm;">
                </td>
                <td width="4%">&nbsp;</td>
                <td valign="top" width="56%" class="text-left" style="padding-bottom: 1mm">
                    <span style="font-size: 5mm; font-family: monospace;">Технет_<strong>НТИ</strong></span>
                </td>
            </tr>
        </table>
    </div>
    <div class="root-round-bottom text-white text-center" style="background: #019BDE; padding: 6mm;">
        <table width="100%" cellpadding="0" cellspacing="0" class="text-white" style="margin-bottom: 6mm">
            <tr>
                <td width="35%" class="text-right">
                    <img src="/img/event/rii16/rostelekom_white.png" width="12mm" alt="">
                </td>
                <td width="65%" class="text-left" style="padding-top: 9mm">
                    <strong style="font-size: 6mm; ">Ростелеком</strong>
                </td>
            </tr>
        </table>
        <p>Контакты организаторов</p>
        <p>+7 (495) 783 59 46</p>
        <p>+7 (964) 551 17 62</p>
        <p>conference@ts-group.msk.ru</p>
    </div>
</div>
<div class="root-cut" style="top: 193mm;">
    <div class="root-cut-line"></div>
</div>
<div class="root-col-4" style="top: 203mm;">
    <div class="text-center text-white root-round-top" style="padding: 3mm 0;background-color: #3E6A7E;">
        <img src="/img/ticket/pdf/base/logo.png" style="padding-right: 3mm; image-resolution: 110dpi;">
        eTicket
    </div>
    <div class="root-round-bottom" style="background: #EAEAEB; padding-bottom: 10mm">
        <img src="/img/event/rii16/map.png" width="100%" alt="">
    </div>
</div>
