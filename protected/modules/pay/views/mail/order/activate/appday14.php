<?php
/**
 * @var \user\models\User $payer
 * @var \pay\models\OrderItem[] $items
 * @var int $total
 */
?>

<table cellpadding="0" cellspacing="0" border="0" width="634" align="left">
    <tr>
        <td height="209">
            <a href="http://www.russianappday.ru/"><img src="http://runet-id.com/img/event/2014/appday14-mail-header634.jpg" /></a>
        </td>
    </tr>
    <tr>
        <td>
            <table cellpadding="10" cellspacing="10" border="0" width="100%">
                <tr>
                    <td>

                        <?if (!empty($payer->LastName)):?>
                            Здравствуйте, <?=$payer->getShortName();?>.
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
                            <a href="http://www.russianappday.ru/">www.russianappday.ru</a><br/>
                            #appday<br/><br/>

                            Call-center конференции по вопросам оплаты:<br/>
                            <a href="mailto:users@runet-id.com">users@runet-id.com</a><br/>
                            +7(495) 916 71 10<br/>
                        </p>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>