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
    <div style="padding: 3mm 0;background-color: #262626; text-align: center; color: #fff; border-radius: 7mm 7mm 0 0;">
        <img src="/img/ticket/pdf/base/logo.png" style="padding-right: 3mm; image-resolution: 110dpi;"/> eTicket
    </div>
    <div style="padding: 2mm 0mm 0 1mm; height: 72mm; background-color: #000000; border-top: solid 0.5mm #fff;">
        <img src="/img/event/phdays15/ticket/bg1.png" style="image-resolution: 124dpi;"/>
    </div>
    <table style="width: 100%; background-color: #df0024; color: #fff; font-family: 'Roboto', 'Helvetica Neue', Helvetica,Arial, sans-serif; border-top: solid 0.5mm #fff; padding: 5mm 5mm 0 5mm;">
        <tbody>
            <tr>
                <td style="height: 28mm; vertical-align: top;">
                    <table style="width: 100%;" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="font-size: 5mm; font-weight: 100; padding: 0; margin: 0;">
                                <?=$user->LastName?><br/><?=$user->getShortName()?>
                            </td>
                        </tr>
                        <?if($user->getEmploymentPrimary() !== null):?>
                            <tr>
                                <td style="font-size: 4mm; padding-top: 5mm;"><?=$user->getEmploymentPrimary()->Company->Name?></td>
                            </tr>
                        <?endif?>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 100%; background-color: #454545; color: #fff; font-family: 'Roboto', 'Helvetica Neue', Helvetica,Arial, sans-serif; border-top: solid 0.5mm #fff; padding: 5mm;">
        <tbody>
        <tr>
            <td style="height: 20mm; font-size: 3mm;">
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
    <div style="padding: 10mm 5mm 0; text-align: right; background: #fff; border-radius: 0 0 7mm 7mm;">
        <table style="font-size: 3mm; font-family: 'Roboto', 'Helvetica Neue', Helvetica,Arial, sans-serif; width: 100%;" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td style="color: #636363; font-weight: bold; font-size: 13mm;"><?=$user->RunetId?></td>
                <td style="text-align: right;"><?=\CHtml::image(QrCode::getAbsoluteUrl($user, 70))?></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center; color: #df0024; padding-top: 3mm; font-size: 3.5mm;">
                    To pass to the event You must present a ticket
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div style="height: 92mm;"></div>
<div style="background: url('/img/ticket/pdf/base/cutting-line.png') center center; height: 1mm; background-image-resolution: 100dpi;">
    <img src="/img/ticket/pdf/base/cutting.png" style="position: absolute; margin-top: 0; margin-left: 5mm;"/>
</div>
<table style="width: 100%;" cellpadding="0" cellspacing="0" style="padding-top: 3.5mm;">
    <tbody>
        <tr>
            <td style="text-align: left; vertical-align: middle;">
                <img src="/img/event/phdays15/ticket/bg2.png" style="image-resolution: 130dpi;"/>
            </td>
        </tr>
    </tbody>
</table>
<div style="background: url('/img/ticket/pdf/base/cutting-line.png') center center; height: 1mm; background-image-resolution: 100dpi; margin: 3.5mm 0 3mm;"></div>
<div style="text-align: left; overflow: hidden;">
    <img src="/img/event/phdays15/ticket/bg3.png" style="image-resolution: 130dpi;"/>
</div>