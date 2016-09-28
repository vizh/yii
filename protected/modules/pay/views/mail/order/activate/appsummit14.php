<?php
/**
 * @var \user\models\User $payer
 * @var \pay\models\OrderItem[] $items
 * @var int $total
 */
?>
<?if(!empty($payer->LastName)):?>
  Здравствуйте, <?=$payer->getFullName()?>.
<?else:?>
  Уважаемый пользователь.
<?endif?>

<p>В рамках конференции AppSummit Вами была успешно произведена оплата на сумму <?=$total?> руб. следующих услуг:<br/>
  <?foreach($items as $orderItem):?>
    &ndash; "<?=$orderItem->Product->Title?>" на <?=$orderItem->Owner->getFullName()?><br/>
  <?endforeach?>
</p>

<?if(!$payer->Temporary):?>
  <p>Ваш профиль:<br/><a href="<?=$payer->getUrl()?>"><?=$payer->getUrl()?></a></p>
<?endif?>

<p>---<br>
  <em>С уважением,<br>
    Организаторы конференции AppSummit<br>
    <a href="http://appsummit.ru">appsummit.ru</a><br>
    #almsummit<br><br>

    Call-center конференции по вопросам оплаты:<br>
    <a href="mailto:event@runet-id.com">event@runet-id.com</a><br>
    +7(495) 950 56 51</em></p>