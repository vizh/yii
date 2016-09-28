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
    <div style="padding: 3mm 0;background-color: #586877; text-align: center; color: #fff; border-radius: 7mm 7mm 0 0;">
        <img src="/img/ticket/pdf/base/logo.png" style="padding-right: 3mm; image-resolution: 110dpi;"/> eTicket
    </div>
    <div style="padding: 5mm; border-left: 0.5mm solid #ededed; border-right: 0.5mm solid #ededed; height: 87mm; background: url('/img/event/iiot15/header.png'); background-image-resolution: 110dpi; background-repeat: no-repeat; background-position: center center;">

    </div>
    <table style="width: 100%; background-color: #eb7f13; padding: 0 5mm; color: #fff; font-family: 'Roboto', 'Helvetica Neue', Helvetica,Arial, sans-serif;">
        <tbody>
            <tr>
                <td style="height: 33mm; vertical-align: middle;">
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
        </tbody>
    </table>
    <table style="width: 100%; background-color: #06a7e4; padding: 5mm; color: #fff; font-family: 'Roboto', 'Helvetica Neue', Helvetica,Arial, sans-serif;">
        <tbody>
        <tr>
            <td style="height: 10mm; vertical-align: middle; font-size: 5mm;">
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
                <td style="font-size: 7mm; font-weight: 400;">RUNET&ndash;ID<br/><?=$user->RunetId?></td>
            </tr>
            <tr>
                <td style="text-align: center; font-size: 3mm; color: #959595; padding-top: 5mm;" colspan="2">Для прохода на мероприятие предъявите билет в распечатанном или электронном виде</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div style="height: 92mm;"></div>
<div style="background: url('/img/ticket/pdf/base/cutting-line.png') center center; height: 1mm; background-image-resolution: 100dpi;">
    <img src="/img/ticket/pdf/base/cutting.png" style="position: absolute; margin-top: 0; margin-left: 5mm;"/>
</div>
<div style="background: url('/img/event/iiot15/2page.png'); background-image-resolution: 195dpi; height: 90mm; margin-top: 5mm;">

</div>
<div style="background: url('/img/ticket/pdf/base/cutting-line.png') center center; height: 1mm; background-image-resolution: 100dpi; margin: 5mm 0;">
    <img src="/img/ticket/pdf/base/cutting.png" style="position: absolute; margin-top: 0; margin-left: 5mm;"/>
</div>

<div style="background: url('/img/event/iiot15/3page.png'); background-image-resolution: 195dpi; height: 83mm; margin-top: 5mm;">
