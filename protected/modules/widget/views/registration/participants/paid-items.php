<?php
/**
 * @var \widget\components\Controller $this
 * @var \pay\components\collection\Finder $finder
 */

$collections = array_merge($finder->getPaidOrderCollections(), $finder->getPaidFreeCollections());
$formatter = \Yii::app()->getDateFormatter();
?>
<?if(sizeof($finder->getPaidOrderCollections()) > 0 || sizeof($finder->getPaidFreeCollections()) > 0):?>
    <hr/>
    <table class="table paid-items">
        <thead>
        <tr>
            <th colspan="4"><h4><?=\Yii::t('app', 'Оплаченные товары')?></h4></th>
        </tr>
        </thead>
        <tbody>
        <?foreach($collections as $collection):?>
            <?foreach($collection as $item):?>
                <?php
                /** @var \pay\models\OrderItem $orderItem */
                $orderItem = $item->getOrderItem();
               ?>
                <tr>
                    <td><?=$orderItem->Owner->getFullName()?></td>
                    <td><?=$orderItem->Product->Title?></td>
                    <td class="text-center"><?=$formatter->format('d MMMM yyyy г., H:mm', $orderItem->PaidTime)?></td>
                    <td class="text-right">
                        <?=$item->getPriceDiscount() == 0 ? \Yii::t('app', 'Бесплатно') : $item->getPriceDiscount() . ' '.\Yii::t('app', 'руб').'.'?>
                    </td>
                </tr>
            <?endforeach?>
        <?endforeach?>
        </tbody>
    </table>
<?endif?>