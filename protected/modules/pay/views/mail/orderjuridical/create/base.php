<?php
/**
 * @var \pay\models\Order $order
 * @var \user\models\User $payer
 * @var \event\models\Event $event
 * @var int $total
 */
?>
Здравствуйте, <?=$payer->getFullName();?>.

<?if ($order->Type == \pay\models\OrderType::Juridical):?>
Вами был выставлен счет №<?=$order->Number;?> на оплату <?=$event->Title;?> на сумму <?=$total;?> руб.

Распечатать счет:
<?=$order->getUrl();?>

Счет действителен в течении 5-и рабочих дней.
<?else:?>
Вам была выписана квитанция №<?=$order->Id;?> на оплату <?=$event->Title;?> на сумму <?=$total;?> руб.

Распечатать квитанцию:
<?=$order->getUrl();?>

Квитанция действительна в течении 5-и рабочих дней.
<?endif;?>

---
Финансовая служба -RUNET—ID-
fin@runet-id.com