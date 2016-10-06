<?php
/**
 * @var \pay\models\Order $order
 * @var \user\models\User $payer
 * @var \pay\models\OrderItem[] $items
 * @var int $total
 */
?>
<p>Здравствуйте, <?=$payer->getFullName()?>.</p>

<p>Финансовая служба подтверждает получение оплаты по счету №<?=$order->Number?> на сумму <?=$total?> руб. за следующие услуги:<br/>
    <?foreach($items as $orderItem):?>
        &ndash; "<?=$orderItem->Product->Title?>" на <?=$orderItem->Owner->getFullName()?><br/>
    <?endforeach?>
</p>

<p>
    С уважением,<br>
    Оргкомитет форума «Открытые инновации 2016»
</p>