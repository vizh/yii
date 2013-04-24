<p>Здравствуйте, <?=$payer->getFullName();?>.</p>

<p>В рамках <?=$event->Title;?> Вами была успешно произведена оплата на сумму <?=$total;?> руб. следующих услуг:<br/>
<?foreach($items as $orderItem):?>
  &ndash; "<?=$orderItem->Product->Title;?>" на <?=$orderItem->Owner->getFullName();?><br/>
<?endforeach;?>
</p>

<p>Ваш профиль:<br/>
<a href="<?=$payer->getUrl();?>"><?=$payer->getUrl();?></a></p>
<p>---<br/>
<em>Сервис регистраций RUNET-ID<br/>
<a href="mailto:users@runet-id.com">users@runet-id.com</a></em></p>