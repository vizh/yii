<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <style>
    ul {
      margin-top: 0;
      padding-left: 10px;
    }
    li {
      padding: 5px 0;
    }
  </style>
</head>
<body>
	<table style="margin: 0 auto;">
		<tr>
			<td style="background: #ffffff;">
				<table width="600" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse; border: 5px solid #7B3384;">
					<tr>
						<td align="center" valign="top">
   						<img src="http://runet-id.com/images/mail/alm14/header-bg.gif" border=0 align="middle" width="620">
					  </td>
					</tr>

					<tr>
						<td style="padding: 35px; padding-top: 10px;">
					    <table width="550" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" border="0">
	    					<tr>
                  <td>
                    <h3>Здравствуйте, <?=$user->getShortName()?>!</h3>
                    <p>Благодарим Вас за интерес к конференции <a href="http://www.alm-summit.ru/">ALM Summit</a> и напоминаем, что заказанный Вами счет на оплату участия не был оплачен в течение 5 рабочих дней.</p>
                    <p>Просим Вас оплатить заказанный счет до 22 января, чтобы гарантировать участие в конференции.</p>

                    <p><a href="<?=$user->getFastauthUrl('http://pay.runet-id.com/register/alm14/')?>" style="display: block; text-decoration: none; background: #7B3384; color: #FFFFFF; font-family: Arial,Verdana,sans-serif; font-size: 20px; margin: 0 auto; padding: 12px; text-align: center; width: 300px;">Оплатить участие</a></p>

                    <p>Если у Вас возникли сложности с оплатой счета, пожалуйста, напишите нам об этом на <a href="mailto:event@runet-id.com">event@runet-id.com</a> или сообщите по телефону <b>+7(495) 950-56-51</b>.</p>
                    <p>Ознакомиться с <a href="http://events.techdays.ru/ALM-Summit/2014-02/schedule">программой</a> ALM Summit Вы можете на официальном сайте конференции <a href="http://www.alm-summit.ru/">www.alm-summit.ru</a></p>
                    <p>До встречи на <a href="http://www.alm-summit.ru/">ALM Summit</a>!</p>

                    <p>---<br>
                      <em>С уважением,<br>
                        Организаторы конференции ALM Summit<br>--<br>
                        <a href="mailto:event@runet-id.com">event@runet-id.com</a></em><br>
                        +7(495) 950-56-51<br>
                        <a href="http://www.alm-summit.ru/">www.alm-summit.ru</a><br>
                        #ALMSummit
                    </p>
                  </td>
						    </tr>
						  </table>
					  </td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

</body>
</html>