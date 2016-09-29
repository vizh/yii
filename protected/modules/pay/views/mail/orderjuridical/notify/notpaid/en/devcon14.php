<?php
/**
 * @var \pay\models\Order $order
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
              <?if(!empty($order->Payer->LastName)):?>
                Dear <?=$order->Payer->getFullName()?>.
              <?else:?>
                Dear user.
              <?endif?>
            </font>
            <br />
            <br />

            <font face="Segoe UI, Tahoma, Helvetica, sans-serif" size="2" style="font-family: Segoe UI, Tahoma, Helvetica, sans-serif; font-size: 13px;">On <?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy', $order->CreationTime)?> you issued invoice No. <?=$order->Id?> to pay for the following services:<br/>
              <?foreach($order->ItemLinks as $link):?>
                &ndash; "<?=$link->OrderItem->Product->Title?>": <?=$link->OrderItem->Owner->getFullName()?><br/>
              <?endforeach?>

              <br />
              <br />

              The invoice is valid for 5 business days. Please provide payment within the stipulated term.
            </font>

            <br />
            <br />

            <font face="Segoe UI, Tahoma, Helvetica, sans-serif" size="2" style="font-family: Segoe UI, Tahoma, Helvetica, sans-serif; font-size: 15px;">
              <a href="<?=$order->getUrl()?>">Print invoice</a>
              </font>

            <br />
            <br />


            <font face="Segoe UI, Tahoma, Helvetica, sans-serif" size="2" style="font-family: Segoe UI, Tahoma, Helvetica, sans-serif; font-size: 13px;">If you have already paid this invoice, please ignore this message.</font>






            <br />
            <br />
            <font face="Segoe UI, Tahoma, Helvetica, sans-serif" size="2" style="font-family: Segoe UI, Tahoma, Helvetica, sans-serif; font-size: 13px;">Best regards,<br />DevCon 2014 conference organizing committee</font><br />
            <font face="Segoe UI, Tahoma, Helvetica, sans-serif" size="2" style="font-family: Segoe UI, Tahoma, Helvetica, sans-serif; font-size: 13px;">______________________________________</font><br /><br />
            <font face="Segoe UI, Tahoma, Helvetica, sans-serif" size="2" style="font-family: Segoe UI, Tahoma, Helvetica, sans-serif; font-size: 13px;">DevCon payment support center:</font><br /><br />
            <font face="Segoe UI, Tahoma, Helvetica, sans-serif" size="2" style="font-family: Segoe UI, Tahoma, Helvetica, sans-serif; font-size: 13px;">Email: <a href="mailto:devcon@runet-id.com" style="color: #5ba1e2;">devcon@runet-id.com</a></font><br /><br />
            <font face="Segoe UI, Tahoma, Helvetica, sans-serif" size="2" style="font-family: Segoe UI, Tahoma, Helvetica, sans-serif; font-size: 13px;">Call-center: +7 (495) 916-71-10</font><br />
            <font face="Segoe UI, Tahoma, Helvetica, sans-serif" size="2" style="font-family: Segoe UI, Tahoma, Helvetica, sans-serif; font-size: 13px;">Working hours: Mon–Fri 9:00 a.m. &ndash; 6:00 p.m.</font><br /><br />
            <font face="Segoe UI, Tahoma, Helvetica, sans-serif" size="2" style="font-family: Segoe UI, Tahoma, Helvetica, sans-serif; font-size: 13px;"><a href="http://www.msdevcon.ru/" style="color: #5ba1e2;">Website of the conference</a></font>
            <br />
            <br />

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