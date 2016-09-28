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
    $contacts[] = 'Сайт: www.regions.rif.ru/events/voronezh' . ', www.rifvrn.ru';
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
    <div style="padding: 5mm; border-left: 0.5mm solid #ededed; border-right: 0.5mm solid #ededed; height: 77mm;">
        <h3><span style="text-transform: uppercase;">ЭЛЕКТРОННЫЙ БИЛЕТ</span><br/><span style="font-weight: bold;"><?=$event->Title?></span></h3>
        <h3 style="padding: 12mm 0; font-weight: bold; text-transform: uppercase;"><?$this->widget('\event\widgets\Date', ['event' => $event])?></h3>
        <?if($event->getContactAddress() != null):?>
            <p><?=$event->getContactAddress()->Place?><br/><?=$event->getContactAddress()->getShort()?></p>
        <?endif?>
    </div>
    <table style="width: 100%; background-color: #586877; padding: 5mm; color: #fff; font-family: 'Roboto', 'Helvetica Neue', Helvetica,Arial, sans-serif;">
        <tbody>
            <tr>
                <td style="height: 33mm; vertical-align: top;">
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
            <tr>
                <td style="height: 20mm; vertical-align: bottom; font-size: 3mm;">
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
    <div style="padding: 10mm 5mm; text-align: right; background: #ededed; border-radius: 0 0 7mm 7mm;">
        <table style="font-size: 3mm; font-family: 'Roboto', 'Helvetica Neue', Helvetica,Arial, sans-serif; width: 100%;" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td style="font-size: 13mm;"><?=$user->RunetId?></td>
                <td style="text-align: right;"><?=\CHtml::image(QrCode::getAbsoluteUrl($user, 70))?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div style="height: 92mm;"></div>
<div style="background: url('/img/ticket/pdf/base/cutting-line.png') center center; height: 1mm; background-image-resolution: 100dpi;">
    <img src="/img/ticket/pdf/base/cutting.png" style="position: absolute; margin-top: 0; margin-left: 5mm;"/>
</div>
<p style="font-size: 4mm; font-family: 'Roboto', 'Helvetica Neue', Helvetica,Arial, sans-serif; color: #556a7d; text-transform: uppercase; text-align: center; padding-top: 4mm;">
    Для прохода на мероприятие обязательно предъявите билет
</p>
<table style="width: 100%;" cellpadding="0" cellspacing="0">
    <tbody>
        <tr>
            <td style="text-align: center; vertical-align: middle; height: 60mm;">
                <img src="<?=$event->getTicketImage()->get864px()?>" style="image-resolution: 130dpi;">
            </td>
        </tr>
    </tbody>
</table>
<div style="margin: 0 5mm; padding: 5mm 0; background-color: #ededed; font-family: 'Roboto', 'Helvetica Neue', Helvetica,Arial, sans-serif; font-size: 3mm; color: #556a7d;">
    <h3 style="font-size: 5mm; font-weight: 100; text-transform: uppercase; text-align: center; margin: 0; padding: 0 0 4mm;">Контакты</h3>
    <p style="text-align: center;"><?=implode(' | ', $contacts)?></p>
</div>
<div style="background: url('/img/ticket/pdf/base/cutting-line.png') center center; height: 1mm; background-image-resolution: 100dpi; margin: 5mm 0;"></div>
<div style="text-align: center; margin: 0 5mm; overflow: hidden;">
    <img src="http://maps.googleapis.com/maps/api/staticmap?zoom=14&size=900x260&scale=2&maptype=roadmap&markers=color:blue%7C<?=$event->getContactAddress()->getLatitude()?>,<?=$event->getContactAddress()->getLongitude()?>&sensor=false&language=ru" />
</div>