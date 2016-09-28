<?php
/**
 * @var User $user
 * @var Event $event
 * @var Participant|Participant[] $participant
 */

use user\models\User;
use event\models\Event;
use event\models\Participant;
use ruvents\components\QrCode;

$contacts = [];
if ($event->getContactSite() != null) {
    $contacts[] = 'Сайт: ' . $event->getContactSite()->getCleanUrl();
}
if (!empty($event->LinkPhones)) {
    $contacts[] = 'Тел.: ' . $event->LinkPhones[0]->Phone;
}
if (!empty($event->LinkEmails)) {
    $contacts[] = 'E-mail: ' . $event->LinkEmails[0]->Email->Email;
}

?>
<style type="text/css">
    p {
        padding: 0;
        margin:  0;
    }
    h3 {
        font-size: 5mm;
        font-weight: 100;
        padding: 0;
        margin: 0;
    }
</style>
<div style="position: absolute; width: 87mm; rotate: 90;font-family: 'Roboto', 'Helvetica Neue', Helvetica,Arial, sans-serif; font-size: 3mm; color: #556a7d;">
    <div style="padding: 2mm 0;background-color: #586877; text-align: center; color: #fff; border-radius: 7mm 7mm 0 0;">
        eTicket
    </div>
    <div style="padding: 5mm; height: 87mm; background: url('/img/event/nspk15/ticket/header.png'); background-image-resolution: 110dpi; background-repeat: no-repeat; background-position: center center;"></div>
    <table style="width: 100%; background-color: #007dc3; padding: 0 5mm; color: #fff; font-family: 'Roboto', 'Helvetica Neue', Helvetica,Arial, sans-serif;">
        <tbody>
            <tr>
                <td style="height: 30mm; vertical-align: middle;">
                    <table style="width: 100%;" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="font-size: 5mm; font-weight: 100; padding: 0; margin: 0;">
                                <?=$user->LastName?> <?=$user->getShortName()?>
                            </td>
                        </tr>
                        <?if($user->getEmploymentPrimary() !== null):?>
                            <tr>
                                <td style="font-size: 4mm; padding-top: 3mm;"><?=$user->getEmploymentPrimary()->Company->Name?></td>
                            </tr>
                        <?endif?>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="height: 23mm; vertical-align: middle; font-size: 5mm;">
                    <?if(is_array($participant)):?>
                        <?foreach($participant as $item):?>
                            <span style="text-transform: uppercase;"><?=$item->Part->Title?>:</span> <?=$item->Role->Title?><br/>
                        <?endforeach?>
                    <?else:?>
                        <span style="text-transform: uppercase;"><?=$participant->Role->Title?></span>
                    <?endif?>
                </td>
            </tr>
        </tbody>
    </table>
    <div style="padding: 5mm 5mm 3mm; text-align: right; background: #ebebeb; border-radius: 0 0 7mm 7mm;">
        <table style="font-size: 3mm; font-family: 'Roboto', 'Helvetica Neue', Helvetica,Arial, sans-serif; width: 100%;" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td style="text-align: left; width: 50%;"><?=\CHtml::image(QrCode::getAbsoluteUrl($user, 70))?></td>
                <td style="font-size: 7mm; font-weight: 400;"><?=$user->RunetId?></td>
            </tr>
            <tr>
                <td style="text-align: center; font-size: 3mm; color: #959595; padding-top: 5mm;" colspan="2">Для прохода на мероприятие предъявите билет в распечатанном или электронном виде</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div style="height: 91mm;"></div>
<div style="background: url('/img/ticket/pdf/base/cutting-line.png') center center; height: 1mm; background-image-resolution: 100dpi;">
    <img src="/img/ticket/pdf/base/cutting.png" style="position: absolute; margin-top: 0; margin-left: 5mm;"/>
</div>
<div style="height: 85mm; margin-top: 5mm; position: relative;">
    <img src="/img/event/nspk15/ticket/2page.png" style="image-resolution: 193dpi;"/>
    <div style="margin-top: -24mm; width: 100%; text-align: right; padding-right: 18.5mm;"><?=\CHtml::image(QrCode::getAbsoluteUrl($user, 60))?></div>
</div>
<div style="background: url('/img/ticket/pdf/base/cutting-line.png') center center; height: 1mm; background-image-resolution: 100dpi; margin: 5mm 0 4mm;">
    <img src="/img/ticket/pdf/base/cutting.png" style="position: absolute; margin-top: 0; margin-left: 5mm;"/>
</div>
<div style="height: 85mm; margin-top: 3mm;">
    <img src="/img/event/nspk15/ticket/3page.png" style="image-resolution: 193dpi;"/>
</div>
