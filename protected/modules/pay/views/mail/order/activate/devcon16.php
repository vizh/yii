<?php
/**
 * @var \user\models\User $payer
 * @var \pay\models\OrderItem[] $items
 * @var \pay\models\Order $order
 * @var int $total
 */
?>

<p style="font-family: Segoe UI, Tahoma,Arial,Helvetica, sans-serif; font-size: 14px;">Рады сообщить, что в рамках участия в конференции DevCon 2016 вами успешно был оплачен счет <?if($order->getIsBankTransfer()):?>№ <?=$order->Number?><?endif?> на сумму <?=$total?> руб. за следующие услучи:</p>

<ul>
<?foreach($items as $orderItem):?>
    <li style="font-family: Segoe UI, Tahoma,Arial,Helvetica, sans-serif; font-size: 14px;">"<?=$orderItem->Product->Title?>" на <?=$orderItem->Owner->getFullName()?></li>
<?endforeach?>
</ul>

<p style="font-family: Segoe UI, Tahoma,Arial,Helvetica, sans-serif; font-size: 14px;">Для вашего комфортного размещения в отеле, пришлите нам, пожалуйста, ваши пожелания по адресу ms@devcon2016.ru до 13 мая 2016 года.</p>
<p style="font-family: Segoe UI, Tahoma,Arial,Helvetica, sans-serif; font-size: 14px;">Размещение предоставляется в 2х-местных номерах или в 3х-местных двухкомнатных номерах. Мы постараемся максимально соответствовать вашим пожеланиям при размещении, но оставляем за организаторами финальное решение по размещению участников.</p>
<p style="font-family: Segoe UI, Tahoma,Arial,Helvetica, sans-serif; font-size: 14px;">До встречи на конференции!</p>
