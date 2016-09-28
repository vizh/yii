<?php
/**
 * @var string $owner
 * @var \pay\models\RoomPartnerOrder[] $orders
 * @var \pay\models\RoomPartnerBooking[] $bookings
 * @var \pay\models\FoodPartnerOrder[] $foodOrders
 */

use application\components\utility\Texts;

$this->setPageTitle('Бронирования партнера');
?>
<div class="btn-toolbar">
    <?=\CHtml::link('← Назад', ['partners'], ['class' => 'btn'])?>
    <?=\CHtml::link('Выставить счет на питание', ['orderfood', 'owner' => $owner], ['class' => 'btn btn-success pull-right'])?></a>
</div>
<div class="well">
    <h2>Партнер: <?=$owner?></h2>
    <?if(!empty($foodOrders)):?>
        <h3><?=\Yii::t('app', 'Счета на питание')?></h3>
        <table class="table">
            <thead>
            <tr>
                <th><?=\Yii::t('app', 'Сумма')?></th>
                <th><?=\Yii::t('app', 'Статус')?></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?foreach($foodOrders as $order):?>
                <tr>
                    <td><?=$order->getTotalPrice()?> <?=\Yii::t('app', 'руб')?>.</td>
                    <td>
                        <?if($order->Paid):?>
                            <span class="text-success"><?=\Yii::t('app', 'Оплачен')?></span>
                        <?else:?>
                            <span class="muted"><?=\Yii::t('app', 'Не оплачен')?></span>
                        <?endif?>
                    </td>
                    <td style="text-align: right;">
                        <div class="btn-group">
                            <?=\CHtml::link(\Yii::t('app', !$order->Paid ? 'Редактировать' : 'Просмотреть'), ['orderfood', 'owner' => $owner, 'id' => $order->Id], ['class' => 'btn'])?>
                            <?=\CHtml::link(\Yii::t('app', 'Счет для печати'), ['orderfood', 'owner' => $owner, 'id' => $order->Id, 'print' => 1], ['class' => 'btn', 'target' => '_blank'])?>
                            <?if(!$order->Paid):?>
                                <?=\CHtml::link(\Yii::t('app', 'Отметить оплаченным'), ['partner', 'owner' => $owner, 'actionFoodOrder' => 'activate', 'id' => $order->Id], ['class' => 'btn'])?>
                                <?=\CHtml::link(\Yii::t('app', 'Удалить'), ['partner', 'owner' => $owner, 'actionFoodOrder' => 'delete', 'id' => $order->Id], ['class' => 'btn btn-danger'])?>
                            <?endif?>
                        </div>
                    </td>
                </tr>
            <?endforeach?>
            </tbody>
        </table>
    <?endif?>

    <?if(!empty($orders)):?>
        <h3><?=\Yii::t('app', 'Счета')?></h3>
        <table class="table">
            <thead>
            <tr>
                <th><?=\Yii::t('app', 'Кол-во номеров')?></th>
                <th><?=\Yii::t('app', 'Сумма')?></th>
                <th><?=\Yii::t('app', 'Статус')?></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?foreach($orders as $order):?>
                <tr>
                    <td><?=\Yii::t('app', '{n} номер|{n} номера|{n} номеров|{n} номеров', sizeof($order->Bookings))?></td>
                    <td><?=$order->getTotalPrice()?> <?=\Yii::t('app', 'руб')?>.</td>
                    <td>
                        <?if($order->Paid):?>
                            <span class="text-success"><?=\Yii::t('app', 'Оплачен')?></span>
                        <?else:?>
                            <span class="muted"><?=\Yii::t('app', 'Не оплачен')?></span>
                        <?endif?>
                    </td>
                    <td style="text-align: right;">
                        <div class="btn-group">
                            <?=\CHtml::link(\Yii::t('app', !$order->Paid ? 'Редактировать' : 'Просмотреть'), ['order', 'owner' => $owner, 'id' => $order->Id], ['class' => 'btn'])?>
                            <?=\CHtml::link(\Yii::t('app', 'Счет для печати'), ['order', 'owner' => $owner, 'id' => $order->Id, 'print' => 1], ['class' => 'btn', 'target' => '_blank'])?>
                            <?if(!$order->Paid):?>
                                <?=\CHtml::link(\Yii::t('app', 'Отметить оплаченным'), ['partner', 'owner' => $owner, 'actionRoomOrder' => 'activate', 'id' => $order->Id], ['class' => 'btn'])?>
                                <?=\CHtml::link(\Yii::t('app', 'Удалить'), ['partner', 'owner' => $owner, 'actionRoomOrder' => 'delete', 'id' => $order->Id], ['class' => 'btn btn-danger'])?>
                            <?endif?>
                        </div>
                    </td>
                </tr>
            <?endforeach?>
            </tbody>
        </table>
    <?endif?>

    <?if(!empty($bookings)):?>
        <h3><?=\Yii::t('app', 'Номера без счета')?></h3>
        <form method="GET" class="bookings" action="<?=$this->createUrl('/pay/admin/booking/order')?>">
            <?=\CHtml::hiddenField('owner', $owner)?>
            <table class="table">
                <thead>
                <tr>
                    <th colspan="2"><?=\Yii::t('app', 'Заказ')?></th>
                    <th>Дата заезда</th>
                    <th>Дата выезда</th>
                    <th>Доп. мест</th>
                    <th>Итого за номер</th>
                    <th></th>
                </tr>
                </thead>
                <?foreach($bookings as $booking):?>
                    <?
                    /** @var \pay\components\managers\RoomProductManager $manager */
                    $manager = $booking->Product->getManager();
                    $price = $booking->getStayDay() * (Texts::getOnlyNumbers($manager->Price) + $booking->AdditionalCount * $manager->AdditionalPrice);
                   ?>
                    <tr>
                        <td style="width: 1px;"><label class="checkbox"><?=\CHtml::checkBox('bookingIdList[]', false, ['value' => $booking->Id])?></label></td>
                        <td><a href="<?=Yii::app()->createUrl('/pay/admin/booking/edit', ['productId' => $booking->Product->Id])?>"><?=$manager->Hotel?>, <?=$manager->Housing?>, №<?=$manager->Number?></a></td>
                        <td><?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy', $booking->DateIn)?></td>
                        <td><?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy', $booking->DateOut)?></td>
                        <td><span class="label label-info"><?=$booking->AdditionalCount?></span></td>
                        <td><span class="label"><?=$price?> <?=\Yii::t('app', 'руб')?></span></td>
                        <td class="text-center"><a href="<?=$this->createUrl('/pay/admin/booking/partnerbookinginfo', ['bookingId' => $booking->Id,'backUrl'=>\Yii::app()->getRequest()->getUrl()])?>" class="btn btn-info btn-mini"><i class="icon-wrench icon-white"></i></a></td>
                    </tr>
                <?endforeach?>
            </table>
            <?=\CHtml::submitButton(\Yii::t('app', 'Выставить счет'), ['class' => 'btn btn-success hide'])?>
        </form>
    <?endif?>
</div>