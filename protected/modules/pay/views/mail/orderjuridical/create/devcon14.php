<?php
/**
 * @var \pay\models\Order $order
 * @var \user\models\User $payer
 * @var \event\models\Event $event
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
                Здравствуйте,<br /><?=$payer->getFullName();?>.
              <?else:?>
                Уважаемый пользователь.
              <?endif;?>
            </font>
            <br />
            <br />

            <?if ($order->Type == \pay\models\OrderType::Juridical):?>
            <font face="Segoe UI, Tahoma, Helvetica, sans-serif" size="2" style="font-family: Segoe UI, Tahoma, Helvetica, sans-serif; font-size: 13px;">Сообщаем, что вы создали счет для юридических лиц № <?=$order->Id;?> на оплату участия в конференции DevCon 2014 на сумму <?=$total;?> руб.</font>
              <br />
              <br />
              <font face="Segoe UI, Tahoma, Helvetica, sans-serif" size="2" style="font-family: Segoe UI, Tahoma, Helvetica, sans-serif; font-size: 15px;"><a href="<?=$order->getUrl();?>">Распечатать счет</a></font>
              <br />
              <br />
              <font face="Segoe UI, Tahoma, Helvetica, sans-serif" size="2" style="font-family: Segoe UI, Tahoma, Helvetica, sans-serif; font-size: 13px;">Счет действителен в течении 5-и рабочих дней. Просим Вас произвести оплату в этот срок.
            </font>
            <?else:?>
              <font face="Segoe UI, Tahoma, Helvetica, sans-serif" size="2" style="font-family: Segoe UI, Tahoma, Helvetica, sans-serif; font-size: 13px;">Сообщаем, что вы создали счет для физических лиц № <?=$order->Id;?> на оплату участия в конференции DevCon 2014 на сумму <?=$total;?> руб.</font>
                <br />
                <br />
              <font face="Segoe UI, Tahoma, Helvetica, sans-serif" size="2" style="font-family: Segoe UI, Tahoma, Helvetica, sans-serif; font-size: 15px;"><a href="<?=$order->getUrl();?>">Распечатать квитанцию</a></font>
                <br />
                <br />
              <font face="Segoe UI, Tahoma, Helvetica, sans-serif" size="2" style="font-family: Segoe UI, Tahoma, Helvetica, sans-serif; font-size: 13px;">Квитанция действительна в течении 5-и рабочих дней. Просим Вас произвести оплату в этот срок.
              </font>
            <?endif;?>
            <br />
            <br />
            <font face="Segoe UI, Tahoma, Helvetica, sans-serif" size="2" style="font-family: Segoe UI, Tahoma, Helvetica, sans-serif; font-size: 13px;">Благодарим за интерес к мероприятиям Microsoft!</font>
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

