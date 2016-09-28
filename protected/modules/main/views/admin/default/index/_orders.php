<?php
/**
 * @var Order[] $orders
 */
use pay\models\Order;
use pay\models\OrderType;
use application\components\web\ArrayDataProvider;
?>
<div class="block-heading">
    <a href="#yw6">Финансовые операции (20 последних)</a>
</div>
<div class="block-body">
    <?$this->widget('\application\widgets\grid\GridView', [
        'dataProvider'=> new ArrayDataProvider($orders),
        'columns' => [
            [
                'header' => 'Мероприятие',
                'value' => function (Order $order) {
                    return $order->Event->Title;
                }
            ],
            [
                'name' => 'Number',
                'header' => 'Номер счета'
            ],
            [
                'header' => 'Сумма',
                'value' => function (Order $order) {
                    return \Yii::app()->getNumberFormatter()->formatCurrency($order->Total, 'RUB');
                }
            ],
            [
                'header' => 'Дата оплаты',
                'value' => function (Order $order) {
                    return \Yii::app()->getDateFormatter()->format('dd MMM yyyy HH:mm', $order->PaidTime);
                }
            ],
            [
                'header' => '',
                'type' => 'html',
                'value' => function (Order $order) {
                    return \CHtml::tag('span', ['class' => 'label'], OrderType::getTitle($order->Type));
                }
            ]

        ],
    ])?>
</div>