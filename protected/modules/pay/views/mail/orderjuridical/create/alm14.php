<?php
/**
 * @var \pay\models\Order $order
 * @var \user\models\User $payer
 * @var \event\models\Event $event
 * @var int $total
 */
?>
<?if (!empty($payer->LastName)):?>
Здравствуйте, <?=$payer->getFullName();?>.
<?else:?>
Уважаемый пользователь.
<?endif;?>

<?if (!$order->Receipt):?>
Вами был выставлен счет №<?=$order->Id;?> на оплату участия в конференции ALM Summit на сумму <?=$total;?> руб вкл.НДС.

Распечатать счет Вы можете, воспользовавшись ссылкой:
<?=$order->getUrl();?>


Счет действителен в течении 5-и рабочих дней. Просим Вас произвести оплату в этот срок.
<?else:?>
Вам была выписана квитанция №<?=$order->Id;?> на оплату участия в конференции ALM Summit на сумму <?=$total;?> руб.

Распечатать квитанцию Вы можете, воспользовавшись ссылкой:
<?=$order->getUrl();?>


Квитанция действительна в течении 5-и рабочих дней. Просим Вас произвести оплату в этот срок.
<?endif;?>

---
С уважением,
Организаторы конференции ALM Summit
www.alm-summit.ru
#almsummit

Call-center конференции по вопросам оплаты:
event@runet-id.com
+7(495) 916 71 10
