<?php
/**
 * @var \pay\models\Order $order
 */
?>
<p style="font-family: Segoe UI, Tahoma,Arial,Helvetica, sans-serif; font-size: 14px;"><?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy', $order->CreationTime)?> вами был выставлен счет № <?=$order->Number?> для оплаты следующих услуг:</p>

<ul>
    <?foreach($order->ItemLinks as $link):?>
        <?$orderItem = $link->OrderItem?>
        <li style="font-family: Segoe UI, Tahoma,Arial,Helvetica, sans-serif; font-size: 14px;">"<?=$orderItem->Product->Title?>" на <?=$orderItem->Owner->getFullName()?></li>
    <?endforeach?>
</ul>

<p style="font-family: Segoe UI, Tahoma,Arial,Helvetica, sans-serif; font-size: 14px;">Напоминаем, что счет действителен для оплаты в течение 5 рабочих дней с момента выставления.</p>

<p style="font-family: Segoe UI, Tahoma,Arial,Helvetica, sans-serif; font-size: 14px;">
    <a href="<?=$order->getUrl()?>" mc:disable-tracking>Распечатать счет</a>
</p>

<p style="font-family: Segoe UI, Tahoma,Arial,Helvetica, sans-serif; font-size: 14px;">Если этот счет уже оплачен, пожалуйста, сообщите нам об этом.</p>