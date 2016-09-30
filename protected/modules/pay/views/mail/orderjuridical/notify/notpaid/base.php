<?php
/**
 * @var \pay\models\Order $order
 */
?>
<p>
<?if(!empty($order->Payer->LastName)):?>
Здравствуйте, <?=$order->Payer->getShortName()?>.
<?else:?>
Уважаемый пользователь.
<?endif?>
</p>

<p><?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy', $order->CreationTime)?> вами был выставлен счет №<?=$order->Number?> для оплаты следующих услуг:<br/>
<?foreach($order->ItemLinks as $link):?>
  &ndash; "<?=$link->OrderItem->Product->Title?>" на <?=$link->OrderItem->Owner->getFullName()?><br/>
<?endforeach?>
</p>

<p>Напоминаем, что счет действителен к оплате в течение 5 (пяти) рабочих дней с момента выставления.</p>

<p>Ссылка на счет для оплаты:<br/>
<?=$order->getUrl()?>
</p>

<p>Если этот счет уже оплачен - письмо можно проигнорировать.</p>

<p>---<br/>
Сервис регистраций RUNET-ID<br/>
<a href="http://runet-id.com">www.runet-id.com</a></p>