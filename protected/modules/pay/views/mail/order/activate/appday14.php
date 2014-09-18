<?php
/**
 * @var \user\models\User $payer
 * @var \pay\models\OrderItem[] $items
 * @var int $total
 */
?>
<?if (!empty($payer->LastName)):?>
    Здравствуйте, <?=$payer->getFullName();?>.
<?else:?>
    Уважаемый пользователь.
<?endif;?>

<p>В рамках конференции Russian App Day Вами была успешно произведена оплата на сумму <?=$total;?> руб. следующих услуг:<br/>
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