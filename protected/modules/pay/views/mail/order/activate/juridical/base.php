<p>Здравствуйте, <?=$payer->getFullName();?>.</p>

<p>Финансовая служба подтверждает получение оплаты по счету №<?=$order->Id;?> на сумму <?=$total;?> руб. за следующие услуги:<br/>
<?foreach($items as $orderItem):?>
  &ndash; "<?=$orderItem->Product->Title;?>" на <?=$orderItem->Owner->getFullName();?><br/>
<?endforeach;?>
</p>

<p>Ваш профиль:<br/>
<a href="<?=$payer->getUrl();?>"><?=$payer->getUrl();?></a></p>

<p>---<br/>
<em>Сервис регистраций RUNET-ID<br/>
<a href="mailto:users@runet-id.com">users@runet-id.com</a></em></p>