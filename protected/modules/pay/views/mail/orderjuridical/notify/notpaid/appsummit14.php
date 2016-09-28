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


<p><?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy', $order->CreationTime)?> вами был выставлен счет №<?=$order->Id?> для оплаты следующих услуг:<br/>
  <?foreach($order->ItemLinks as $link):?>
    &ndash; "<?=$link->OrderItem->Product->Title?>" на <?=$link->OrderItem->Owner->getFullName()?><br/>
  <?endforeach?>
</p>

<p>Напоминаем, что счет действителен к оплате в течение 5 (пяти) рабочих дней с момента выставления.</p>

<p>Ссылка на счет для оплаты:<br/>
  <a href="<?=$order->getUrl()?>"><?=$order->getUrl()?></a>
</p>

<p>Если этот счет уже оплачен - письмо можно проигнорировать.</p>

<p>---<br/>
  С уважением,<br/>
  Организаторы конференции AppSummit<br/>
  <a href="http://appsummit.ru">appsummit.ru</a><br/>
  #appsummit<br/><br/>

  Call-center конференции по вопросам оплаты:<br/>
  <a href="mailto:event@runet-id.com">event@runet-id.com</a><br/>
  +7(495) 950 56 51<br/>
</p>