<?php
/**
 * @var \application\components\controllers\PublicMainController $this
 * @var stdClass $item
 */
?>
<div class="event-orders"><h4><?=$item->Event->Title ?></h4>
    <table class="table">
        <thead>
            <tr>
                <th colspan="3"><?=\Yii::t('app', 'Заказы');?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($item->Products as $product):?>
                <tr>
                    <td><?=$product->Title;?></td>
                    <td><?=$product->Count;?></td>
                    <td>
                        <?=$product->Total;?> <?=\Yii::t('app', 'руб.');?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"><?=\CHtml::link(\Yii::t('app', 'Перейти к оплате'), [], ['class' => 'btn btn-success btn-small']);?></td>
            </tr>
        </tfoot>
    </table>

    <?php if (!empty($item->Orders)):?>
        <table class="table">
            <thead>
                <tr>
                    <th colspan="3"><?=\Yii::t('app', 'Счета');?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($item->Orders as $order):?>
                    <tr>
                        <td><?=\CHtml::link((\Yii::t('app', 'Счет') . ' №' . $order->Number), $order->getUrl(), ['target' => '_blank']);?></td>
                        <td>
                            <?=$order->getPrice();?> <?=\Yii::t('app', 'руб.');?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif;?>

</div>