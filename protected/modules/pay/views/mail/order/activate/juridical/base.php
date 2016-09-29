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

<?if(!$payer->Temporary):?>
  <p>Ваш профиль:<br/><a href="<?=$payer->getUrl()?>"><?=$payer->getUrl()?></a></p>
<?endif?>

<p>---<br/>
<em>Сервис регистраций RUNET-ID<br/>
<a href="mailto:users@runet-id.com">users@runet-id.com</a></em></p>