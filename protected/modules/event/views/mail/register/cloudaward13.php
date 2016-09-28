<?
/*
 * @var user\models\User $user
 * @var event\models\Participant $participant
 */
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <style>
    ul {
      padding-left: 10px;
    }
    li {
      padding: 5px 0;
    }
  </style>
</head>
<body>
	<table>
		<tr>
			<td style="background: #ffffff;">
				<table width="600" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse; border: 5px solid #234671;">
					<tr>
						<td align="center" valign="top">
   						<img src="http://runet-id.com/images/mail/cloudaward13/oblaka.png" border=0 align="middle">
					  </td>
					</tr>

					<tr>
						<td style="padding: 15px">
					    <table width="570" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" border="0">
	    					<tr>
                  <td>
                    <h2 style="text-align: center;">Пригласительный билет</h2>

                    <p>Вы зарегистрировались на ежегодную Премиию SaaS-решений Облака 2013.</p>

                  </td>
                </tr>

                <tr>
                  <td style="line-height:15px;">
                    <table>
                      <tr>
                        <td style="background: #54AB98; text-align: center; width: 250px; padding: 10px 0;">
                          <span style="font-family:Arial, Helvetica, sans-serif; font-size:18px;"><a style="color:#ffffff; text-decoration: none;" href="<?=$participant->getTicketUrl()?>">Пригласительный билет</a></span>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>

                <tr>
                  <td>
                    <p>Ждем Вас 18 октября в 18-30 в конференц-центре гостиницы Novotel Moscow City.</p>
                    <p>По адресу: Пресненская набережная д.2 , г. Москва</p>
                  </td>
						    </tr>
                <tr>
                  <td>
                    <p>Подробно о премии: <a href="http://2013.cloudaward.ru/">2013.cloudaward.ru</a></p>
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