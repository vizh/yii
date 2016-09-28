<!DOCTYPE HTML>
<html>
  <head>
    <title>Mailing event</title>
    <style>
      /* Reset */
      html, body, div, span, h1, h2, h3, h4, h5, h6, p, img, b, i, ol, ul, li, table, caption, tbody, tfoot, thead, tr, th, td {
        margin: 0;
        padding: 0;
        border: 0;
        outline: 0;
        font-size: 100%;
        vertical-align: baseline;
        background: transparent;
      }
      body {line-height: 1;}
      a {
        margin: 0;
        padding: 0;
        font-size: 100%;
        vertical-align: baseline;
        background: transparent;
      }
      table {
        border-collapse: collapse;
        border-spacing: 0;
      }

      /* Styles */
      body {
        padding: 50px 0;
        font-size: 13px;
        font-family: Helvetica, Arial, sans-serif;
      }

      a {color: #00a8ca;}
      a:hover {text-decoration: none;}

      h1 {font-size: 50px;}
      h2 {font-size: 35px;}
      h3 {
        font-size: 19px;
        line-height: 1.25;
      }
      h2, h3 {font-weight: normal;}

      p, li {line-height: 1.5;}

      img, td {vertical-align: top;}

      table {
        width: 740px;
        margin: 0 auto;
      }

      ul {
        margin-left: 20px;
      }
      ul li {
        margin: 10px 0;
      }

      .register-btn:hover {opacity: .9;}
      .register-btn:active {opacity: .8;}
    </style>
  </head>
  <body>


    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>&nbsp;</td>
        <td style="font-size: 25px; font-weight: bold; line-height: 25px; text-align: center; width: 1px; padding: 5px;" rowspan="2">RUNET</td>
        <td>&nbsp;</td>
        <td style="font-size: 25px; font-weight: bold; line-height: 25px; width: 1px; text-align: center; padding: 5px;" rowspan="2">ID</td>
        <td>&nbsp;</td>
        <td rowspan="2" style="font-size: 25px; font-weight: bold; line-height: 25px; width: 1px; text-align: center; padding: 5px;"><?=$user->RunetId?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td style="border-width: 3px 0 0 3px; border-color: #000; border-style: solid; width: 20px;">&nbsp;</td>
        <td style="border-top: 3px solid #000; width: 20px;">&nbsp;</td>
        <td style="border-top: 3px solid #000;">&nbsp;</td>
        <td style="border-top: 3px solid #000; border-right: 3px solid #000; width: 20px;">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="10" style="border-left: 3px solid #000; border-right: 3px solid #000; border-bottom: 3px solid #000;">

          <table border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 50px; border-top: 0;">
            <tbody>
              <tr>
                <td colspan="5" height="30"></td>
              </tr>

              <tr>
                <td></td>
                <td colspan="3">
                  <p>Здравствуйте, <?=$user->getShortName()?>!</p>
                </td>
                <td></td>
              </tr>

              <tr>
                <td colspan="5" height="25"></td>
              </tr>

              <!-- Columns width -->
              <tr>
                <td width="50"></td>
                <td width="420">
                  <h1 style="font-size: 35px;">RUSSIAN<br/>AFFILIATE DAYS 2013,<br/>RAD-2013</h1>
                </td>
                <td width="40"></td>
                <td width="180">
                  <img src="http://runet-id.com/images/mail/rad13/rad_100.png" width="100" alt="">
                </td>
                <td width="50"></td>
              </tr>

              <tr>
                <td colspan="5" height="25"></td>
              </tr>

              <tr>
                <td></td>
                <td>
                  <p style="margin-bottom: 15px;">Спешим Вам сообщить, к сожалению, в силу ряда организационных причин, мы вынуждены сдвинуть дату конференции Russian Affiliate Days на 20 ноября 2013 года. Место проведения остается тем же – Digital October.</p>
                  <p style="margin-bottom: 15px;">Пожалуйста, примите наши извинения за доставленные неудобства!</p>
                  <p style="margin-bottom: 15px;">Удобна ли Вам новая дата проведения конференции?</p>
                  <p style="margin-bottom: 15px;">Надеемся, что сдвиг даты, не повлияет на Вашу возможность посетить конференцию. Для Вас на мероприятии: обсуждение актуальных тем CPA-маркетинга, полезное общение за чашкой кофе, новые знания, а также полезные контакты!</p>
                  <p style="margin-bottom: 15px;">Если Вы в силу личных обстоятельств, не сможете присутствовать на мероприятии, то сообщите нам, пожалуйста, об этом, для урегулирования всех финансовых вопросов.</p>
                  <p style="margin-bottom: 15px;">Будем благодарны за обратную связь.</p>
                </td>
                <td></td>
                <td valign="top">
                  <h3 style="margin-bottom: 10px;"><b>20 ноября</b></h3>
                  <p style="margin-bottom: 15px;">
                    <strong>Место проведения</strong>:<br />г. Москва<br/>Digital October
                  </p>
                  <p style="margin-bottom: 15px;"><a href="http://www.affdays.ru/?utm_source=runet&utm_medium=2email&utm_campaign=info" target="_blank">www.affdays.ru</a></p>
                </td>
                <td></td>
              </tr>

            </tbody>
          </table>

        </td>
      </tr>
    </table>
    <p style="width: 740px; margin: 0 auto; color: #909090;">Вы получили это письмо, так как являетесь <a href="<?=$user->getUrl()?>" target="_blank" style="color: #909090;">пользователем runet-id.ru</a> и подписаны на новостную рассылку. Вы можете <a href="http://runet-id.com/user/setting/subscription/" target="_blank" style="color: #909090;">изменить настройки уведомлений</a>.</p>

  </body>
</html>