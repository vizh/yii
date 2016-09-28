<?php
/**
 * @var \application\components\controllers\PublicMainController $this
 * @var \user\controllers\events\EventPayItem $item
 * @var bool $showCabinetBtn
 */
if (!isset($showCabinetBtn)) $showCabinetBtn = false;
?>
<div class="event-pay-item">
    <h4><?=$item->getEvent()->Title?></h4>
    <table class="table">
        <thead>
        <tr>
            <th colspan="3"><?=\Yii::t('app', 'Заказы')?></th>
        </tr>
        </thead>
        <tbody>
        <?foreach($item->getProducts() as $product):?>
            <tr>
                <td class="event-pay-item_title"><?=$product->Title?></td>
                <td><?=$product->Count?></td>
                <td class="event-pay-item_price">
                    <?=$product->Total?> <?=\Yii::t('app', 'руб.')?>
                </td>
            </tr>
        <?endforeach?>
        </tbody>
        <?if($showCabinetBtn):?>
        <tfoot>
        <tr>
            <td colspan="3" class="text-right">
                <?=\CHtml::link(\Yii::t('app', 'Перейти к оплате'), ['/pay/cabinet/index', 'eventIdName' => $item->getEvent()->IdName], ['class' => 'btn btn-success btn-small'])?>
            </td>
        </tr>
        </tfoot>
        <?endif?>
    </table>

    <?php
    $orders = $item->getOrders();
    if (!empty($orders)):?>
        <table class="table">
            <thead>
            <tr>
                <th colspan="3"><?=\Yii::t('app', 'Счета')?></th>
            </tr>
            </thead>
            <tbody>
            <?foreach($orders as $order):?>
                <tr>
                    <td class="event-pay-item_title"><?=\CHtml::link((\Yii::t('app', 'Счет') . ' №' . $order->Number), $order->getUrl(), ['target' => '_blank'])?></td>
                    <td class="event-pay-item_price">
                        <?=$order->getPrice()?> <?=\Yii::t('app', 'руб.')?>
                    </td>
                </tr>
            <?endforeach?>
            </tbody>
        </table>
    <?endif?>

</div>