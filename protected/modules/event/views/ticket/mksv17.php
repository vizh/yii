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
use application\components\web\helpers\Html;

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
    <table style="width: 100%; padding: 5mm; border-left: 0.5mm solid #ededed; border-right: 0.5mm solid #ededed; height: 77mm; font-family: 'Roboto', 'Helvetica Neue', Helvetica,Arial, sans-serif;" cellpadding="0" cellspacing="0">
        <tr>
            <td style="vertical-align: top; height: 40mm; color: #556a7d;">
                <h3 style="text-transform: uppercase; padding-bottom: 20px;">ЭЛЕКТРОННЫЙ БИЛЕТ</h3>
                <?=Html::limitedTag('h3', $event->Title, 19, 291, 115, ['style' => 'font-weight: bold;'])?>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: middle; height: 17mm; color: #556a7d;">
                <h3 style="padding: 12mm 0; font-weight: bold; text-transform: uppercase;"><?$this->widget('\event\widgets\Date', ['event' => $event])?></h3>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: bottom; height: 20mm; color: #556a7d;">
                <?if($event->getContactAddress() != null):?>
                    <?=Html::limitedTag('span', $event->getContactAddress()->Place . '<br/>' . $event->getContactAddress()->getShort(), 11, 291, 75)?>
                <?endif?>
            </td>
        </tr>
    </table>
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
                                <?=Html::limitedTag('td', $user->getEmploymentPrimary()->Company->Name, 15, 291, 60, ['style' => 'padding-top: 5mm'])?>
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
</div> <p style="position: absolute; rotate: 90; width: 107mm; top: 100mm; right: 0mm; font-size: 4mm; font-family: 'Roboto', 'Helvetica Neue', Helvetica,Arial, sans-serif; color: #556a7d; text-transform: uppercase; text-align: center; padding-top: 4mm;">
    Для прохода на мероприятие обязательно предъявите билет
</p>
<div class="rotate" style="position: absolute; rotate: 90; width: 107mm; top: 100mm; right: 50mm;">

    <table style="width: 100%;" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td style="text-align: center; vertical-align: middle; height: 60mm;">
                    <?if($event->getTicketImage()->exists()):?>
                        <img src="<?=$event->getTicketImage()->original()?>" style="image-resolution: 130dpi;">
                    <?else:?>
                        <img src="<?=$event->getLogo()->get150px()?>">
                    <?endif?>

                </td>
            </tr>
        </tbody>
    </table>
</div>
<div style="  width: 200mm; position: absolute; top: 200mm; z-index:100; background: url('/img/ticket/pdf/base/cutting-line.png') left center; height: 1mm; background-image-resolution: 100dpi; margin: 5mm 0;"></div>
<div style="position: absolute; top: 210mm; text-align: center; margin: 0 5mm; overflow: hidden;">
    <img src="http://maps.googleapis.com/maps/api/staticmap?zoom=12&size=900x260&scale=2&maptype=roadmap&markers=color:blue%7C<?=$event->getContactAddress()->getLatitude()?>,<?=$event->getContactAddress()->getLongitude()?>&sensor=false&language=ru" />
</div>