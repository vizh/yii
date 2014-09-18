<?php
/**
 * @var \pay\models\Order $order
 * @var \user\models\User $payer
 * @var \event\models\Event $event
 * @var int $total
 */
?>
<?if (!empty($payer->LastName)):?>
    <p>Здравствуйте, <?=$payer->getFullName();?>.</p>
<?else:?>
    <p>Уважаемый пользователь.</p>
<?endif;?>

<?if ($order->Type == \pay\models\OrderType::Juridical):?>
    <p>Вами был выставлен счет №<?=$order->Id;?> на оплату участия в конференции Russian App Day на сумму <?=$total;?> руб вкл.НДС.</p>

    <p>Распечатать счет Вы можете, воспользовавшись ссылкой:<br/>
        <a href="<?=$order->getUrl();?>"><?=$order->getUrl();?></a></p>


    <p>Счет действителен в течении 5-и рабочих дней. Просим Вас произвести оплату в этот срок.</p>
<?else:?>
    <p>Вам была выписана квитанция №<?=$order->Id;?> на оплату участия в конференции Russian App Day на сумму <?=$total;?> руб.</p>

    <p>Распечатать квитанцию Вы можете, воспользовавшись ссылкой:<br/>
        <a href="<?=$order->getUrl();?>"><?=$order->getUrl();?></a></p>


    <p>Квитанция действительна в течении 5-и рабочих дней. Просим Вас произвести оплату в этот срок.</p>
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