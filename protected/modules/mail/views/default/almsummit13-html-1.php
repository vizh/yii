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
                    <p>Мы благодарим вас за регистрацию на мероприятие <a href="http://runet-id.com/event/alm14/">ALM Summit</a>, которое пройдёт 6 февраля 2014 в Digital October, Москва.</p>
                    <p>ALM Summit – это шанс получить новые знания о том, как улучшить процессы по разработке программного обеспечения, познакомиться с новыми инструментами, облегчающими создание ПО и сопровождение процессов, а значит, и принятие решений по выбору инструментария.</p>
                    <p>Напоминаем вам, чтобы стать участником саммита по специальной цене, необходимо <a href="<?=$user->getFastauthUrl('http://pay.runet-id.com/register/alm14/')?>">оплатить</a> ваше участие до 31 декабря 2013 г.</p>
                    <p>Подробности о конференции ALM Summit вы можете узнать на <a href="http://www.alm-summit.ru/">официальном сайте мероприятия</a></p>

                    <a href="<?=$user->getFastauthUrl('http://pay.runet-id.com/register/alm14/')?>" style="display: block; text-decoration: none; background: #7B3384; color: #FFFFFF; font-family: Arial,Verdana,sans-serif; font-size: 20px; margin: 0 auto; padding: 12px; text-align: center; width: 300px;">Оплатить участие</a>

                    <p>---<br>
                      <em>С уважением,<br>
                        Организаторы конференции ALM Summit<br>
                        <a href="http://www.alm-summit.ru/">www.alm-summit.ru</a>
                        <br><br>

                        Call-center конференции по вопросам оплаты:<br>
                        <a href="mailto:event@runet-id.com">event@runet-id.com</a></em>
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