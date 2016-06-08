<?php
/* @var $order \pay\models\Order */
?>
<tr id="order-<?=$order->Id; ?>">
    <td data-title="Номер счета/заказа">
        <p class="lead" style="margin-bottom: 5px;"><?=$order->Number;?></p>
        <p class="muted"><?=$order->Id;?></p>
    </td>
    <td data-title="Краткие данные">
        <?if ($order->Type == \pay\models\OrderType::Juridical):?>
            <strong><?=$order->OrderJuridical->Name;?></strong><br>
            ИНН/КПП:&nbsp;<?=$order->OrderJuridical->INN;?> / <?=$order->OrderJuridical->KPP;?>
        <?elseif ($order->Type == \pay\models\OrderType::Receipt):?>
            <p class="text-warning"><strong>Квитанция</strong></p>
        <?else:?>
            <p class="text-warning"><strong>Через платежную систему</strong></p>
        <?endif;?>
    </td>
    <td data-title="Выставил">
        <?php echo $order->Payer->RunetId;?>, <strong><?php echo $order->Payer->getFullName();?></strong>
        <p>
            <em><?=$order->Payer->Email;?></em>
        </p>
        <?foreach ($order->Payer->LinkPhones as $link):?>
            <?if ($link->Phone == null) { continue; }?>
            <p><em><?=urldecode($link->Phone);?></em></p>
        <?endforeach;?>
    </td>
    <td data-title="Дата"><?=Yii::app()->locale->getDateFormatter()->format('d MMMM y', strtotime($order->CreationTime));?><br>
        <?if ($order->Paid):?>
            <span class="label label-success">ОПЛАЧЕН</span>
        <?else:?>
            <span class="label label-important">НЕ ОПЛАЧЕН</span>
        <?endif;?>
    </td>
    <td data-title="Сумма"><?=$order->getPrice();?> руб.</td>
    <td data-title="Управление">
        <?= \CHtml::beginForm(array('/pay/admin/order/view', 'orderId' => $order->Id)); ?>
        <div class="btn-group">
            <a class="btn btn-info" href="<?=\Yii::app()->createUrl('/pay/admin/order/view', array('orderId' => $order->Id));?>"><i class="icon-list icon-white"></i></a>

            <?if (!$order->Paid && $order->getIsBankTransfer()):?>
                <?= CHtml::ajaxLink(
                    '<i class="icon-ok icon-white"></i>',
                    array('/pay/admin/order/pay', 'orderId' => $order->Id),
                    [
                        'method' => 'post',
                        'data' => [
                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                        ],
                        'error' => 'js:function(response){$("<iframe></iframe>").attr("src", response.responseText).dialog({modal:true});}',
                        'replace' => '#order-'.$order->Id
                    ],
                    [
                        'confirm' => 'Вы уверены, что хотите отметить данный счет оплаченным?',
                        'class' => 'btn btn-success'
                    ]);
                ?>
            <?else:?>
                <button class="btn btn-success disabled" type="submit" disabled name="SetPaid"><i class="icon-ok icon-white"></i></button>
            <?endif;?>

            <?if ($order->Type == \pay\models\OrderType::Juridical):?>
                <a class="btn" target="_blank" href="<?=$order->getUrl(true);?>"><i class="icon-print"></i></a>
            <?else:?>
                <a class="btn disabled" target="_blank"><i class="icon-print"></i></a>
            <?endif;?>
        </div>
        <?= \CHtml::endForm(); ?>
    </td>
</tr>