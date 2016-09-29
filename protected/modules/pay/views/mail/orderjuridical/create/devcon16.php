<?php
/**
 * @var \pay\models\Order $order
 * @var \user\models\User $payer
 * @var \event\models\Event $event
 * @var string $total
 */
?>
<p style="font-family: Segoe UI, Tahoma,Arial,Helvetica, sans-serif; font-size: 14px;">Сообщаем, что вы создали счет для юридических лиц № <?=$order->Number?> на оплату участия в конференции DevCon 2016 на сумму <?=$total?>руб.</p>
<p style="font-family: Segoe UI, Tahoma,Arial,Helvetica, sans-serif; font-size: 14px;">
    <a href="<?=$order->getUrl()?>" mc:disable-tracking>Распечатать счет</a>
</p>
<p style="font-family: Segoe UI, Tahoma,Arial,Helvetica, sans-serif; font-size: 14px;">Счет действителен в течение 5 рабочих дней, просим вас произвести оплату в этот срок.</p>

