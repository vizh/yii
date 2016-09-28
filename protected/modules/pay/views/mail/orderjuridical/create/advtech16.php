<?php
/**
 * @var \pay\models\Order $order
 * @var \user\models\User $payer
 * @var \event\models\Event $event
 * @var int $total
 */
?>
<p>Здравствуйте, <?=$payer->getFullName()?>.</p>

<?if($order->Type == \pay\models\OrderType::Juridical):?>
<p>Вами был выставлен счет №<?=$order->Number?> на оплату <?=$event->Title?> на сумму <?=$total?> руб.</p>

<p>Распечатать счет:<br/>
<a href="<?=$order->getUrl()?>"><?=$order->getUrl()?></a></p>
<?else:?>
<p>Вам была выписана квитанция №<?=$order->Id?> на оплату <?=$event->Title?> на сумму <?=$total?> руб.</p>

<p>Распечатать квитанцию:<br/>
<a href="<?=$order->getUrl()?>"><?=$order->getUrl()?></a></p>
<?endif?>

<p>Как только мы получим оплату, на указанные электронные адреса будут отправлены билеты на мероприятие ADTech Russia<p>
<p>По всем финансовым вопросам можно связаться по контактам, указанным ниже</p><br/>
<p>---<br/>
Команда ADTech Russia
<br/>
<a href="mailto:team@rusbase.com">team@rusbase.com</a>
<br/>
+7 (495) 268-05-86
</p>