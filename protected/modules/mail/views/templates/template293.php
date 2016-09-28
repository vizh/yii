<p>
<?if(!empty($user->LastName)):?>
Здравствуйте, <?=$user->getShortName()?>.
<?else:?>
Уважаемый пользователь.
<?endif?>
</p>

<?$order = \pay\models\Order::model()->byEventId(1503)->byPayerId($user->Id)->byPaid(false)->byDeleted(false)->byJuridical(true)->find()?>
<p><?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy', $order->CreationTime)?> вами был выставлен счет №<?=$order->Number?> для оплаты следующих услуг:<br/>
<?foreach($order->ItemLinks as $link):?>
  - "<?=$link->OrderItem->Product->Title?>" на <?=$link->OrderItem->Owner->getFullName()?><br/>
<?endforeach?>
</p>

<p>Напоминаем, что счет действителен к оплате до конца января.</p>

<p>Ссылка на счет для оплаты:<br/>
<?=$order->getUrl()?>
</p>

<p>Если этот счет уже оплачен - письмо можно проигнорировать.</p>

<p>---<br/>
Сервис регистраций RUNET-ID<br/>
<a href="http://runet-id.com">www.runet-id.com</a></p>