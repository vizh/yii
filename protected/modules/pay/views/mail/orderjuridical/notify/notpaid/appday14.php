<?php
/**
 * @var \pay\models\Order $order
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