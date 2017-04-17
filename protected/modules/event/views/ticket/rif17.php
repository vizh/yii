<?php
/**
 * @var User $user
 * @var Event $event
 * @var Participant|Participant[] $participant
 */

use event\models\Event;
use event\models\Participant;
use ruvents\components\QrCode;
use pay\models\OrderItem;
use pay\components\admin\Rif;

$participant = Participant::model()->with('Role')->byEventId($event->Id)->byUserId($user->Id)->find();
if ($participant->Role->Id === \event\models\Role::VIRTUAL_ROLE_ID) {
    die('Вашего статуса недостаточно для участия');
}
$role = $participant->Role;
$criteria = new \CDbCriteria();
$criteria->with = ['Product'];
$criteria->addCondition('"Product"."ManagerName" = :ManagerName');
$criteria->params['ManagerName'] = 'RoomProductManager';
$roomOrderItem = OrderItem::model()->byEventId(/*$event->Id*/
    $event->Id)->byPaid(true)->byAnyOwnerId($user->Id)->find($criteria);

$roomProductManager = $roomOrderItem !== null ? $roomOrderItem->Product->getManager() : null;

$criteria = new \CDbCriteria();
$criteria->with = ['Product'];
$criteria->addCondition('"Product"."ManagerName" = :ManagerName');
$criteria->params['ManagerName'] = 'FoodProductManager';

$foodOrderItems = OrderItem::model()->with('Product')->byEventId(/*$event->Id*/
    3016)->byPaid(true)->byAnyOwnerId($user->Id)->findAll($criteria);

$productIds = [
    '18' => [
        'ужин' => '7246',
    ],
    '19' => [
        'завтрак' => '7247',
        'обед' => '7248',
        'ужин' => '7249',
    ],
    '20' => [
        'завтрак' => '7250',
        'обед' => '7251',
        'ужин' => '7252',
    ],
    '21' => [
        'завтрак' => '7253',
        'обед' => '7254',
        'ужин' => '7255',
    ],
];

$userFoodProductIds = [];
if (!empty($foodOrderItems)) {
    foreach ($foodOrderItems as $foodOrderItem) {
        $userFoodProductIds[] = $foodOrderItem->Product->Id;
    }
}


/*$foodProductManager = $foodOrderItem !== null ? $foodOrderItem->Product->getManager() : null;*/

//$partyOrderItem = OrderItem::model()

if ($roomOrderItem) {
    $dateIn = new \DateTime($roomOrderItem->getItemAttribute('DateIn'));
    $dateOut = new \DateTime($roomOrderItem->getItemAttribute('DateOut'));
}

$coupons = \pay\models\CouponActivation::model()
    ->with('Coupon')
    ->byUserId($user->Id)
    ->byEventId(/*$event->Id*/
        $event->Id)
    ->findAll();

$discount = false;
foreach ($coupons as $coupon) {
    if (!$coupon->Coupon->Deleted && $coupon->Coupon->Discount == 100 && $coupon->Coupon->ManagerName === 'Percent') {
        $discount = true;
    }
}
$sum = 0;
if (!$discount) {
    $orders = \pay\models\Order::model()->byPayerId($user->Id)->byEventId(/*$event->Id*/
        $event->Id)->byPaid(true)->findAll();

    foreach ($orders as $order) {
        if ($order) {
            $sum += $order->Total;
        }
    }
}

if (!$sum && $role->Id !== \event\models\Role::VIRTUAL_ROLE_ID) {
    $discount = true;
}

$parkingReporterRoleIdList = [3, 6];
$parking = null;
if ($roomProductManager !== null || in_array($role->Id, $parkingReporterRoleIdList)) {
    $command = Rif::getDb()->createCommand();
    $command->select('*')->from('ext_booked_parking')->where('ownerRunetId = :RunetId');
    $parking = $command->queryRow(true, ['RunetId' => $user->RunetId]);
}
$parkingReporter = !empty($parking) && in_array($role->Id,
        $parkingReporterRoleIdList) && ($roomProductManager == null || $roomProductManager->Hotel != Rif::HOTEL_P);
?>
<style type="text/css">
    * {
        position: relative;
    }

    @font-face {
        font-family: 'SFRegular'; /* Имя шрифта */
        src: url(/img/event/rif17/ticket/fonts/SFUIDisplay-Regular.ttf); /* Путь к файлу со шрифтом */
    }

    html, p, div, table, table tr td {
        font-family: 'Helvetica';
    }

    article, aside, details, figcaption, figure, footer, header, main, nav, section, summary {
        display: block
    }

    .page {
        width: 21cm;
        height: 29.7cm;
        position: relative;
    }

    .uppercase {
        text-transform: uppercase;
    }

    .page-header {
        /*
                background: url("/img/ticket/rif17/logo.png") no-repeat;
        */
        width: 100%;
        height: 72px;
        position: relative;
        margin-bottom: 16mm;
    }

    .a-bottom {
        position: absolute;
        bottom: 0;
        display: block;
    }

    .red {
        color: #ef304a;
    }

    .row {
        margin-left: -4mm;
        margin-right: -4mm;
    }

    .row:after, .clearfix:after {
        content: " ";
        visibility: hidden;
        display: block;
        height: 0;
        clear: both
    }

    .col-1, .col-sm-1, .col-md-1, .col-lg-1, .col-2, .col-sm-2, .col-md-2, .col-lg-2, .col-3, .col-sm-3, .col-md-3, .col-lg-3, .col-4, .col-sm-4, .col-md-4, .col-lg-4, .col-5, .col-sm-5, .col-md-5, .col-lg-5, .col-6, .col-sm-6, .col-md-6, .col-lg-6, .col-7, .col-sm-7, .col-md-7, .col-lg-7, .col-8, .col-sm-8, .col-md-8, .col-lg-8, .col-9, .col-sm-9, .col-md-9, .col-lg-9, .col-10, .col-sm-10, .col-md-10, .col-lg-10, .col-11, .col-sm-11, .col-md-11, .col-lg-11, .col-12, .col-sm-12, .col-md-12, .col-lg-12 {
        position: relative;
        min-height: 0.2mm;
    }

    .col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12 {
        float: left
    }

    .col-12 {
        width: 100%
    }

    .col-11 {
        width: 91.66666667%
    }

    .col-10 {
        width: 83.33333333%
    }

    .col-9 {
        width: 75%
    }

    .col-8 {
        width: 66.66666667%
    }

    .col-7 {
        width: 58.33333333%
    }

    .col-6 {
        width: 50%
    }

    .col-5 {
        width: 41.66666667%
    }

    .col-4 {
        width: 33.33333333%
    }

    .col-3 {
        width: 25%
    }

    .col-2 {
        width: 16.66666667%
    }

    .col-1 {
        width: 8.33333333%
    }

    .col-offset-12 {
        margin-left: 100%
    }

    .col-offset-11 {
        margin-left: 91.66666667%
    }

    .col-offset-10 {
        margin-left: 83.33333333%
    }

    .col-offset-9 {
        margin-left: 75%
    }

    .col-offset-8 {
        margin-left: 66.66666667%
    }

    .col-offset-7 {
        margin-left: 58.33333333%
    }

    .col-offset-6 {
        margin-left: 50%
    }

    .col-offset-5 {
        margin-left: 41.66666667%
    }

    .col-offset-4 {
        margin-left: 33.33333333%
    }

    .col-offset-3 {
        margin-left: 25%
    }

    .col-offset-2 {
        margin-left: 16.66666667%
    }

    .col-offset-1 {
        margin-left: 8.33333333%
    }

    .col-offset-0 {
        margin-left: 0
    }

    .img-responsive {
        display: block;
        max-width: 100%;
        height: auto
    }

    .main-area {
        width: 155mm;
        margin-left: 25mm;

        padding: 0;
    }

    .main-area > div {
        margin: 0;
    }

    .qrcode figcaption {
        font-size: 2.7mm;
    }

    .status {
        color: #40ad49;
        font-weight: 600;
    }

    .text-center {
        text-align: center;
    }

    .user-name {
        font-size: 6.5mm;
        font-weight: 500;
    }

    .user-company {
        font-size: 4.3mm;
        font-weight: 100;
    }

    img {
        vertical-align: middle
    }

    .user-info {
        padding-left: 5mm;
        width: 85mm;
    }

    .hr {
        width: 100%;
        height: .25mm;
        background: #918f90;
    }

    .order-items {
        margin-bottom: 4.3mm;
    }

    .page-footer image {
        position: relative;
        margin-bottom: 0;
        margin-right: 0;
    }

    table {
        border: none;
    }

    thead {
        text-align: center;
    }

    .bg-grey {
        background: #e9e9e9;
    }

    .bg-grey td {
        padding: 5px 10px;
    }

    td {
        font-size: 2.6mm;
        padding: 5px 0 10px 10px;
    }

    .img-div {
        overflow: hidden;
        background-image: url(<?= $user->getPhoto()->get238px() ?>);
        background-position: top, center;
        background-repeat: no-repeat;
    }

    @page {
        margin-footer: 0mm;
        size: auto
    }

</style>

<htmlpagefooter name="main-footer">
    <div class="page-footer">
        <img style="margin-top: 50mm" src="/img/event/rif17/ticket/footer.png">
    </div>
</htmlpagefooter>
<htmlpagefooter name="footer">
</htmlpagefooter>
<html>
<div class="page">
    <div class="page-header" style="">
        <img src="/img/ticket/rif17/logo.png"/>
        <div class="a-bottom"
             style="font-size: 4.1mm;margin-top:-22mm;margin-bottom:10mm;margin-left: 100px;padding-top: 20mm">
            19 -
            21 апреля <? if ($roomProductManager->Hotel) : ?><span
                class="red">/</span> Пансионат &laquo;<?= $roomProductManager->Hotel ?>&raquo;, <?= $roomProductManager->Housing ?>, номер <?= $roomProductManager->Number ?>
            <? endif ?>
        </div>
    </div>
    <div class="clearfix main-area">
        <div class="user" style="margin-bottom: 25px;margin-top: 6mm">
            <div class="clearfix">
                <div class="col-3" style="margin-left:0;margin-top:-10mm;padding: 0!important">
                    <figure class="qrcode text-center" style="margin-top:-11mm;margin-left:-10px;padding-left: 0;: ">
                        <div class="" style="height: 160px">
                            <img style="width: 140px;height:140px;border:1px solid black"
                                 src="<?= QrCode::getAbsoluteUrl($user, 140) ?>"/>
                        </div>
                        <figcaption style="font-size: 3.6mm;margin-top: -10px"><b>RUNET-ID</b> / <?= $user->RunetId ?>
                        </figcaption>
                    </figure>
                </div>
                <div class="col-9 user-info" style="padding-top:0;position:relative">
                    <div style="height:120px">

                        <div class="user-name uppercase"
                             style="margin-top:-12mm;margin-bottom: 1mm"><?= $user->LastName ?></div>
                        <div class="user-name uppercase"><?= $user->FirstName . ' ' . $user->FatherName ?></div>
                        <p class="user-company"><?= $user->getEmploymentPrimary()->Company->Name ?></p>
                    </div>
                    <div class="status" style="text-transform:uppercase;font-size: 3.6mm;margin-top: -3.1mm"><b>
                            <?= $role->Title ?>
                        </b></div>
                </div>
            </div>
        </div>

        <div class="hr"></div>

        <div class="col-12 clearfix order-items" style="margin: 25px 0">
            <div class="col-4" style="vertical-align: middle;padding-top: 20px">
                <? if ($discount) : ?>
                    <div style="font-size: 5mm; text-transform: uppercase;">участие</div>
                    <span style="font-size: 5mm; text-transform: uppercase;">по приглашению</span>
                <? else : ?>
                    <div style="font-size: 6mm; text-transform: uppercase;">Оплачено:</div>
                    <span>=<?= $sum ?> P</span>
                <? endif ?>

            </div>
            <div class="col-2 text-center">
                <img src="/img/event/rif17/ticket/ticket.png">
                участие
            </div>
            <div class="col-2 text-center">
                <? if ($roomProductManager !== null) : ?>
                    <img src="/img/event/rif17/ticket/living.png">
                    проживание
                <? endif; ?>
            </div>
            <div class="col-2 text-center">
                <? if (!empty($userFoodProductIds)) : ?>
                    <img src="/img/event/rif17/ticket/food.png">
                    питание
                <? endif; ?>
            </div>
            <div class="col-2 text-center">
                <!-- party -->
            </div>
        </div>

        <div class="hr"></div>

        <? if ($roomOrderItem) : ?>

            <?
            $dateIn = new \DateTime($roomOrderItem->getItemAttribute('DateIn'));
            $dateOut = new \DateTime($roomOrderItem->getItemAttribute('DateOut'));
            ?>
            <div class="col-12 clearfix order-items" style="margin: 25px 0">

                <div style="margin-top:5mm;font-size: 3.8mm;">Вы проживате: <b>Пансионат
                        &laquo;<?= $roomProductManager->Hotel ?>&raquo;,
                        <?= $roomProductManager->Housing ?>, номер <?= $roomProductManager->Number ?></b>
                </div>
                <div style="font-size: 3.8mm;margin-top: 17px;margin-bottom: 20px">
                    <div style="width:200px;float: left;"><span style="display:inline-block;margin-right: 20px">Дата заезда:</span>
                        <span class="status" style="margin-left: 20px;display: inline-block">
                            <b><?= $dateIn->format('d.m.Y') ?></b>
                        </span>
                        <? if ($dateIn->format('d') == '18'): ?>
                            <div style="font-size: 2.1mm;margin-top:0;margin-left: 95px" class="date status"><b>НЕ РАНЕЕ
                                    17:00</b></div><? endif ?> </div>
                    <div style="float:left;margin-left:4mm">Дата выезда: <span
                            style="color: #d2232a;"><b>       <?= $dateOut->format('d.m.Y') ?></b></span>
                        <div style="font-size: 2.1mm;margin-top:0;margin-left: 100px;color: #d2232a;" class="date"><b>НЕ
                                ПОЗДНЕЕ 12:00</b></div>
                    </div>
                </div>
            </div>
        <? endif ?>
        <div class="hr"></div>

        <? if($roomProductManager->Hotel === 'ЛЕСНЫЕ ДАЛИ' || !$roomProductManager->Hotel) :?>
            <table class="food" style="width: 100%;margin-top: 24px;font-size: 2.6mm">
                <thead>
                <tr style="">
                    <th style="padding-bottom: 17px;padding-left:10px;font-weight: 300;font-size: 7.5mm;text-align: left">
                        18/04<span style="margin-left:5px;font-size: 2.6mm">  Вторник</span></th>
                    <th style="padding-bottom: 17px;padding-left:10px;font-weight: 300;font-size: 7.5mm;text-align: left">
                        19/04<span style="margin-left:5px;font-size: 2.6mm">  Среда</span></th>
                    <th style="padding-bottom: 17px;padding-left:10px;font-weight: 300;font-size: 7.5mm;text-align: left">
                        20/04<span style="margin-left:5px;font-size: 2.6mm">  Четверг</span></th>
                    <th style="padding-bottom: 17px;padding-left:10px;font-weight: 300;font-size: 7.5mm;text-align: left">
                        21/04<span style="margin-left:5px;font-size: 2.6mm">  Пятница</span></th>
                </tr>
                </thead>
                <tbody>
                <tr class="bg-grey">
                    <?php if (!empty($foodOrderItems)) : ?>
                        <? foreach ($productIds as $day => $meals) : ?>
                            <? $payedMeals = 'не оплачено';
                            $i = 0;
                            foreach ($meals as $mealName => $mealId) {
                                if (in_array($mealId, $userFoodProductIds)) {
                                    if (!$i) {
                                        $payedMeals = $mealName;
                                    } else {
                                        $payedMeals .= ', ' . $mealName;
                                    }
                                    $i++;
                                }
                            } ?>
                            <td style="font-size: 2.6mm">Питание (<?= $payedMeals ?>)</td>
                        <? endforeach; ?>
                    <? else : ?>
                        <td style="font-size: 2.6mm">Питание (не оплачено)</td>
                        <td style="font-size: 2.6mm">Питание (не оплачено)</td>
                        <td style="font-size: 2.6mm">Питание (не оплачено)</td>
                        <td style="font-size: 2.6mm">Питание (не оплачено)</td>
                    <? endif ?>
                </tr>
                <tr>
                    <td style="vertical-align: top">
                        Ужин / 20:30 - 22:00<br><br>
                    </td>
                    <td style="vertical-align: top">
                        Завтрак / 8:30 - 10:00<br>
                        Обед / 14:30 - 15:30<br>
                        Ужин / 20:00 - 21:30<br><br>
                    </td>
                    <td style="vertical-align: top">
                        Завтрак / 8:30 - 10:00<br>
                        Обед / 14:30 - 16:00<br>
                        Ужин / 20:00 - 21:30<br><br>
                    </td>
                    <td style="vertical-align: top">
                        Завтрак / 8:30 - 10:00<br>
                        Обед / 14:30 - 16:00<br>
                        Ужин / 19:00 - 20:30<br><br>
                </tr>
                </tbody>
            </table>
        <? else :?>
            <table class="food" style="width: 100%;margin-top: 24px;font-size: 2.6mm">
                <thead>
                <tr style="">
                    <th style="padding-bottom: 17px;padding-left:10px;font-weight: 300;font-size: 7.5mm;text-align: left">
                        19/04<span style="margin-left:5px;font-size: 2.6mm">  Среда</span></th>
                    <th style="padding-bottom: 17px;padding-left:10px;font-weight: 300;font-size: 7.5mm;text-align: left">
                        20/04<span style="margin-left:5px;font-size: 2.6mm">  Четверг</span></th>
                    <th style="padding-bottom: 17px;padding-left:10px;font-weight: 300;font-size: 7.5mm;text-align: left">
                        21/04<span style="margin-left:5px;font-size: 2.6mm">  Пятница</span></th>
                </tr>
                </thead>
                <tbody>
                <tr class="bg-grey">
                    <?php if (!empty($foodOrderItems)) : ?>
                        <?
                        unset($productIds['18']);
                        foreach ($productIds as $day => $meals) : ?>
                            <? $payedMeals = 'не оплачено';
                            $i = 0;
                            foreach ($meals as $mealName => $mealId) {
                                if (in_array($mealId, $userFoodProductIds)) {
                                    if (!$i) {
                                        $payedMeals = $mealName;
                                    } else {
                                        $payedMeals .= ', ' . $mealName;
                                    }
                                    $i++;
                                }
                            } ?>
                            <td style="font-size: 2.6mm">Питание (<?= $payedMeals ?>)</td>
                        <? endforeach; ?>
                    <? else : ?>
                        <td style="font-size: 2.6mm">Питание (не оплачено)</td>
                        <td style="font-size: 2.6mm">Питание (не оплачено)</td>
                        <td style="font-size: 2.6mm">Питание (не оплачено)</td>
                    <? endif ?>
                </tr>
                <tr>
                    <td style="vertical-align: top">Завтрак / 8:30 - 10:00<br>
                        Обед / 13:30 - 15:00<br>
                        Ужин / 18:30 - 20:00<br><br>
                    </td>
                    <td style="vertical-align: top">Завтрак / 8:30 - 10:00<br>
                        Обед / 13:30 - 15:00<br>
                        Ужин / 18:30 - 20:00<br><br>
                    </td>
                    <td style="vertical-align: top">Завтрак / 8:30 - 10:00<br>
                        Обед / 13:30 - 15:00<br>
                        Ужин / 18:30 - 20:00<br><br>
                </tr>
                </tbody>
            </table>
        <? endif?>


        <div class="col-12">
        </div>

    </div>
</div>
<sethtmlpagefooter name="main-footer" value="on" show-this-page="1"/>
<div style="page-break-after: always"></div>

<div class="text-center">
    <div class="page-header" style="text-align: left">
        <img src="/img/ticket/rif17/logo.png"/>
        <div class="a-bottom"
             style="font-size: 4.1mm;margin-top:-22mm;margin-bottom:10mm;margin-left: 100px;padding-top: 20mm">
            19 -
            21 апреля <? if ($roomProductManager->Hotel) : ?><span
                class="red">/</span> Пансионат &laquo;<?= $roomProductManager->Hotel ?>&raquo;, <?= $roomProductManager->Housing ?>, номер <?= $roomProductManager->Number ?>

            <? endif ?>

        </div>
    </div>

    <img style="margin-top: -20mm" src="/img/event/rif17/ticket/second.png"/>
</div>
<sethtmlpagefooter name="main-footer" value="on" show-this-page="1"/>

<div style="page-break-after: always"></div>
<div class="text-center">
    <div class="page-header" style="text-align: left">
        <img src="/img/ticket/rif17/logo.png"/>
        <div class="a-bottom"
             style="font-size: 4.1mm;margin-top:-22mm;margin-bottom:10mm;margin-left: 100px;padding-top: 20mm">
            19 -
            21 апреля <? if ($roomProductManager->Hotel) : ?><span
                class="red">/</span> Пансионат &laquo;<?= $roomProductManager->Hotel ?>&raquo;, <?= $roomProductManager->Housing ?>, номер <?= $roomProductManager->Number ?>

            <? endif ?>

        </div>
    </div>
    <img style="margin-top: -20mm" src="/img/event/rif17/ticket/third.png"/>
</div>
<sethtmlpagefooter name="main-footer" value="on" show-this-page="1"/>
<div style="page-break-after: always"></div>
<pagebreak/>
<div class="text-center">
    <img src="/img/event/rif17/ticket/krylo.png" class="img-responsive"/>
</div>

<?

$dates = [];
if ($roomOrderItem) {
    $datetime = new \DateTime($roomOrderItem->getItemAttribute('DateIn'));
    while ($datetime->format('Y-m-d') <= $roomOrderItem->getItemAttribute('DateOut')) {
        $dates[] = $datetime->format('d');
        $datetime->modify('+1 day');
    }
}

?>
<? if (!empty($parking) && $roomProductManager !== null): ?><?php
    $showText2 = false;

    switch ($roomProductManager->Hotel) {
        case Rif::HOTEL_LD:
            $y = 930;
            $name = 'dali';
            $showText2 = true;
            $map = 'map_ld.png';
            break;

        case RIF::HOTEL_P:
            $y = 1380;
            $name = 'polyany';
            $showText2 = false;
            $map = 'map_p.png';
            break;
    }

    $image = \Yii::app()->image->load(\Yii::getPathOfAlias('webroot.img.event.rif17.ticket.' . $name) . '.png');
    $text1 = mb_strtoupper($parking['carNumber']);

    $path = '/img/event/rif17/ticket/car_rendered/' . $user->RunetId . '.jpg';
    $image->text($text1, 130, 0, $y);
    $image->save(\Yii::getPathOfAlias('webroot') . $path);

    if ($showText2) {
        $text2 = implode(',', $dates);

        $image = \Yii::app()->image->load(\Yii::getPathOfAlias('webroot') . $path);
        $image->text($text2, 80, 500, 1380);
        $image->save(\Yii::getPathOfAlias('webroot') . $path);
    }
    ?>

<? endif ?>
<?/*
$eventSections = \event\models\section\Section::model()->with('LinkUsers')
    ->byEventId($event->Id)
    ->findAll('"LinkUsers"."UserId" = :userId', [':userId' => $user->Id]);

$dates = [];

if (!empty($eventSections)) {
    foreach ($eventSections as $eventSection) {
        $datetime = new \DateTime($eventSection->StartTime);
        $dates[] = $datetime->format('d');
        $datetime->modify('+1 day');
    }

}
*/?>
<? if (!$parkingReporter): ?>
    <pagebreak/>
    <div class="text-center">
        <img src="/img/event/rif17/ticket/map_ld.png"/>
    </div>
    <pagebreak/>
    <div class="text-center">
        <img src="/img/event/rif17/ticket/scheme-ld.png" class="img-responsive"/>
    </div>
    <pagebreak/>
    <div class="text-center">
        <img src="/img/event/rif17/ticket/scheme.png" class="img-responsive"/>
    </div>
<? endif ?>
<? if (!empty($parking)): ?>
    <? if (!$parkingReporter): ?>

        <pagebreak orientation="L"/>
        <div class="text-center"
             style="position:fixed;rotate:90; width: 285mm; height: 225mm;text-align: center; margin-top:-25mm">
            <img style="width: 100%; height:100%" src="<?= $path ?>"/>
        </div>
        <sethtmlpagefooter name="footer" value="on" show-this-page="1"/>

    <? else: ?>
        <?php

        $eventSections = \event\models\section\Section::model()->with('LinkUsers')
            ->byEventId($event->Id)
            ->findAll('"LinkUsers"."UserId" = :userId', [':userId' => $user->Id]);

        $reportDates = [];

        if (!empty($eventSections)) {
            foreach ($eventSections as $eventSection) {
                $datetime = new \DateTime($eventSection->StartTime);
                $reportDates[] = $datetime->format('d');
                $datetime->modify('+1 day');
            }

        }

        $totalDates = $dates + $reportDates;

        $image = \Yii::app()->image->load(\Yii::getPathOfAlias('webroot.img.event.rif17.ticket.reporter') . '.png');
        $text1 = mb_strtoupper($parking['carNumber']);
        $path = '/img/event/rif17/ticket/car_rendered/' . $user->RunetId . '-r.jpg';
        $image->text($text1, 160, 0, 860);
        $image->save(\Yii::getPathOfAlias('webroot') . $path);
        $image = \Yii::app()->image->load(\Yii::getPathOfAlias('webroot') . $path);

        if (!empty($totalDates)) {
            $image->text(implode(',', $totalDates), 100, 500, 1360);
            $image->save(\Yii::getPathOfAlias('webroot') . $path);
        } else {
            $image->text('19, 20, 21', 100, 500, 1360);
            $image->save(\Yii::getPathOfAlias('webroot') . $path);
        }
        ?>
        <pagebreak/>
        <div class="text-center">
            <img src="/img/event/rif17/ticket/map_reporter.png"/>
        </div>
        <pagebreak/>
        <div class="text-center">
            <img src="/img/event/rif17/ticket/scheme-ld.png" class="img-responsive"/>
        </div>
        <pagebreak/>
        <div class="text-center">
            <img src="/img/event/rif17/ticket/scheme.png" class="img-responsive"/>
        </div>
        <pagebreak orientation="L"/>

        <div class="text-center"
             style="position:fixed;rotate:90; width: 285mm; height: 225mm;text-align: center; margin-top:-25mm">
            <img src="<?= $path ?>"/>
        </div>
        <sethtmlpagefooter name="footer" value="on" show-this-page="1"/>
    <? endif ?>
<? endif ?>


</html>
