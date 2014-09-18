<?php
/**
 * @var \pay\models\Order $order
 * @var \user\models\User $payer
 * @var \event\models\Event $event
 * @var int $total
 */
?>
<p>Здравствуйте, <?=$payer->getFullName();?>.</p>

<?if ($order->Type == \pay\models\OrderType::Juridical):?>
<p>Вами был выставлен счет №<?=$order->Number;?> на оплату <?=$event->Title;?> на сумму <?=$total;?> руб.</p>

<p>Распечатать счет:<br/>
<a href="<?=$order->getUrl();?>"><?=$order->getUrl();?></a></p>

<p>Счет действителен в течении 5-и рабочих дней.</p>
<?else:?>
<p>Вам была выписана квитанция №<?=$order->Id;?> на оплату <?=$event->Title;?> на сумму <?=$total;?> руб.</p>

<p>Распечатать квитанцию:<br/>
<a href="<?=$order->getUrl();?>"><?=$order->getUrl();?></a></p>

<p>Квитанция действительна в течении 5-и рабочих дней.</p>
<?endif;?>

<p>
---<br/>
Финансовая служба -RUNET—ID-<br/>
<a href="mailto:fin@runet-id.com">fin@runet-id.com</a>
</p>