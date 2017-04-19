<?php
/**
 * @var $import \pay\models\Import
 * @var $this \pay\components\Controller
 */

use application\components\helpers\ArrayHelper;
?>
<tr id="order-<?=$order->Id?>">

    <td><?=ArrayHelper::getValue($order, 'order.Number')?></td>
    <td><?=ArrayHelper::getValue($order, 'order.CreationTime')?></td>
    <td><?=ArrayHelper::getValue($order, 'order.OrderJuridical.INN')?></td>
    <td><?=ArrayHelper::getValue($order, 'order.OrderJuridical.Name')?></td>
    <td><?=ArrayHelper::getValue($order, 'order.price')?></td>
    <td>
        <?if(!$order->order->Paid) {
            echo CHtml::ajaxLink(
                '<i class="icon-ok icon-white"></i> Оплатить',
                array('/pay/admin/import/pay', 'orderId' => $order->Id),
                [
                    'method' => 'post',
                    'data' => [
                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                    ],
                    'error' => 'js:function(response){$("<iframe></iframe>").attr("src", response.responseText).dialog({modal:true});}',
                    'replace' => '#order-' . $order->Id
                ],
                [
                    'confirm' => 'Вы уверены, что хотите отметить данный счет оплаченным?',
                    'class' => 'btn btn-default'
                ]
            );
        } else {?>
            Оплачен
        <?php }?>
    </td>
</tr>