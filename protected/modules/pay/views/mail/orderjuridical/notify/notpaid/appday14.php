<?php
/**
 * @var \pay\models\Order $order
 */
?>
<p>
    <?if (!empty($order->Payer->LastName)):?>
        Здравствуйте, <?=$order->Payer->getShortName();?>.
    <?else:?>
        Уважаемый пользователь.
    <?endif;?>
</p>


<p><?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy', $order->CreationTime);?> вами был выставлен счет №<?=$order->Id;?> для оплаты следующих услуг:<br/>
    <?foreach($order->ItemLinks as $link):?>
        &ndash; "<?=$link->OrderItem->Product->Title;?>" на <?=$link->OrderItem->Owner->getFullName();?><br/>
    <?endforeach;?>
</p>

<p>Напоминаем, что счет действителен к оплате в течение 5 (пяти) рабочих дней с момента выставления.</p>

<p>Ссылка на счет для оплаты:<br/>
    <a href="<?=$order->getUrl();?>"><?=$order->getUrl();?></a>
</p>

<p>Если этот счет уже оплачен - письмо можно проигнорировать.</p>

<p>---<br/>
    С уважением,<br/>
    Организаторы конференции Russian App Day<br/>
    <a href="http://events.techdays.ru/AppDay/2014-11/">http://events.techdays.ru/AppDay/2014-11/</a><br/>
    #appday<br/><br/>

    Call-center конференции по вопросам оплаты:<br/>
    <a href="mailto:users@runet-id.com">users@runet-id.com</a><br/>
    +7(495) 916 71 10<br/>
</p>