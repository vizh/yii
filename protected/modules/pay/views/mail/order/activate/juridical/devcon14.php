<?php
/**
 * @var \user\models\User $payer
 * @var \pay\models\OrderItem[] $items
 * @var \pay\models\Order $order
 * @var int $total
 */
?>
<table cellpadding="0" cellspacing="0" border="0" width="700" align="left" style="border: 1px solid #efefef; font-family:Segoe UI,Tahoma,Arial,Helvetica,Sans-Serif; font-size:13px;">
  <tr>
    <td height="140">
      <a href="http://www.msdevcon.ru/"><img src="http://runet-id.com/img/event/devcon14/email-header.gif" /></a>
    </td>
  </tr>
  <tr>
    <td>
      <table cellpadding="10" cellspacing="10" border="0" width="100%">
        <tr>
          <td style="font-size: 13px;">
            <font face="Segoe UI, Tahoma, Helvetica, sans-serif" size="4" style="font-family: Segoe UI, Tahoma, Helvetica, sans-serif; font-size: 18px;">
              <?if (!empty($payer->LastName)):?>
                Здравствуйте, <?=$payer->getFullName();?>.
              <?else:?>
                Уважаемый пользователь.
              <?endif;?>
            </font>
            <br />
            <br />

            <font face="Segoe UI, Tahoma, Helvetica, sans-serif" size="2" style="font-family: Segoe UI, Tahoma, Helvetica, sans-serif; font-size: 13px;">Финансовая служба подтверждает получение оплаты по <?=$order->Type == \pay\models\OrderType::Receipt ? 'квитанции' :'счету';?> № <?=$order->Id;?> на оплату участия в конференции DevCon 2014 на сумму <?=$total;?> руб. за следующие услуги:<br/>
              <?foreach($items as $orderItem):?>
                &ndash; "<?=$orderItem->Product->Title;?>" на <?=$orderItem->Owner->getFullName();?><br/>
              <?endforeach;?>
            </font>

            <br />
            <br />
            <font face="Segoe UI, Tahoma, Helvetica, sans-serif" size="2" style="font-family: Segoe UI, Tahoma, Helvetica, sans-serif; font-size: 13px;">С уважением,<br />организаторы конференции DevCon 2014</font><br />
            <font face="Segoe UI, Tahoma, Helvetica, sans-serif" size="2" style="font-family: Segoe UI, Tahoma, Helvetica, sans-serif; font-size: 13px;">______________________________________</font><br /><br />
            <font face="Segoe UI, Tahoma, Helvetica, sans-serif" size="2" style="font-family: Segoe UI, Tahoma, Helvetica, sans-serif; font-size: 13px;">Информационный центр поддержки конференции DevCon по вопросам оплаты:</font><br /><br />
            <font face="Segoe UI, Tahoma, Helvetica, sans-serif" size="2" style="font-family: Segoe UI, Tahoma, Helvetica, sans-serif; font-size: 13px;">Email: <a href="mailto:devcon@runet-id.com" style="color: #5ba1e2;">devcon@runet-id.com</a></font><br /><br />
            <font face="Segoe UI, Tahoma, Helvetica, sans-serif" size="2" style="font-family: Segoe UI, Tahoma, Helvetica, sans-serif; font-size: 13px;">Call-center: +7 (495) 916-71-10</font><br />
            <font face="Segoe UI, Tahoma, Helvetica, sans-serif" size="2" style="font-family: Segoe UI, Tahoma, Helvetica, sans-serif; font-size: 13px;">Режим работы: будни 09:00 &ndash; 18:00</font><br /><br />
            <font face="Segoe UI, Tahoma, Helvetica, sans-serif" size="2" style="font-family: Segoe UI, Tahoma, Helvetica, sans-serif; font-size: 13px;"><a href="http://www.msdevcon.ru/" style="color: #5ba1e2;">Сайт конференции</a></font><br /><br />
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td height="80">
      <img src="http://runet-id.com/img/event/devcon14/email-footer.gif" />
    </td>
  </tr>
</table>