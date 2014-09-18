<?php
/**
 * @var \user\models\User $payer
 * @var \pay\models\OrderItem[] $items
 * @var \pay\models\Order $order
 * @var int $total
 */
?>
<?if (!empty($payer->LastName)):?>
    Здравствуйте, <?=$payer->getFullName();?>.
<?else:?>
    Уважаемый пользователь.
<?endif;?>

<p>Финансовая служба подтверждает получение оплаты по <?=$order->Type == \pay\models\OrderType::Receipt  ? 'квитанции' :'счету';?> №<?=$order->Id;?> на оплату участия в конференции Russian App Day на сумму <?=$total;?> руб. за следующие услуги:<br/>
    <?foreach($items as $orderItem):?>
        &ndash; "<?=$orderItem->Product->Title;?>" на <?=$orderItem->Owner->getFullName();?><br/>
    <?endforeach;?>
</p>

<?if (!$payer->Temporary):?>
    <p>Ваш профиль:<br/><a href="<?=$payer->getUrl();?>"><?=$payer->getUrl();?></a></p>
<?endif;?>


<p>---<br/>
    С уважением,<br/>
    Организаторы конференции Russian App Day<br/>
    <a href="http://events.techdays.ru/AppDay/2014-11/">http://events.techdays.ru/AppDay/2014-11/</a><br/>
    #appday<br/><br/>

    Call-center конференции по вопросам оплаты:<br/>
    <a href="mailto:users@runet-id.com">users@runet-id.com</a><br/>
    +7(495) 916 71 10<br/>
</p>