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

<p>Вам был выставлен счет №<?=$order->Number?> на оплату International Conference on Big Data and its Applications (ICBDA) на сумму <?=$total?> руб согласно оферте на сайте <a href="http://icbda2015.org/oferta.html" target="_blank">http://icbda2015.org/oferta.html</a></p>

<p>Распечатать счет:<br/>
<a href="<?=$order->getUrl()?>"><?=$order->getUrl()?></a></p>

<p>Счет действителен в течение 5 рабочих дней.</p>
<?else:?>
<p>Вам была выписана квитанция №<?=$order->Id?> на оплату <?=$event->Title?> на сумму <?=$total?> руб.</p>

<p>Распечатать квитанцию:<br/>
<a href="<?=$order->getUrl()?>"><?=$order->getUrl()?></a></p>

<p>Квитанция действительна в течение 5 рабочих дней.</p>
<?endif?>

<p>
---<br/>
Финансовая служба -RUNET—ID-<br/>
<a href="mailto:fin@runet-id.com">fin@runet-id.com</a> / Чтобы получить Акты или запросить другую финансовую информацию, свяжитесь с нами по адресу <?=\CHtml::mailto('team@rusbase.vc')?>
</p>