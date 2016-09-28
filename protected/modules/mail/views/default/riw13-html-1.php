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
                  <h1>Неделя Российского Интернета, RIW-2013 </h1>
                </td>
                <td width="40"></td>
                <td width="180">
                  <img src="http://runet-id.com/images/mail/riw13/riw13_150.png" width="150" alt="">
                </td>
                <td width="50"></td>
              </tr>

              <tr>
                <td colspan="5" height="25"></td>
              </tr>

              <tr>
                <td></td>
                <td>
                  <h3>RIW – это главное осеннее мероприятие интернет-индустрии, объединяющее выставку, конференцию и ряд профессиональных конкурсов и наград.</h3>
                  <h3 style="margin-bottom: 20px;"><a href="http://riw13.com">www.riw13.com</a></h3>
                  <h3 style="margin: 10px 0;">ВЫСТАВКА</h3>
                  <p>Все три дня на RIW будет работать выставка “Интернет-2013”, которая будет актуальна и полезна для представителей бизнеса, интернет-специалистов и продвинутых пользователей интернета.</p>
                  <p>Участие в Выставке - бесплатное для всех зарегистрированных участников RIW 2013.</p>
                  <h3 style="margin: 10px 0;">КОНФЕРЕНЦИЯ</h3>
                  <p style="margin-bottom:  5px;">В ходе профессиональной конференции RIW 2013 будут подробно обсуждаться все ключевые  темы развития бизнеса и технологий.</p>
                  <p style="margin-bottom:  5px;">В 2013 году запланировано более десяти блок-конференций, среди которых:</p>
                  <table style="width: 420px;">
                    <tr>
                      <td>
                        <ul style="margin-bottom: 10px;">
                          <li>Интернет-реклама</li>
                          <li>Веб-разаработка и интернет-технологии</li>
                          <li>Интернет-маркетинг</li>
                          <li>SEO</li>
                          <li>Social Media</li>
                          <li>Электронная коммерция</li>
                        </ul>
                      </td>
                      <td>
                        <ul style="margin-bottom: 10px;">
                          <li>Кадры</li>
                          <li>Мобильные технологии</li>
                          <li>Информационная безопасность</li>
                          <li>Инвестиии и стартапы</li>
                          <li>Веб-аналитика</li>
                          <li>Законодательство и гос.инициативы</li>
                        </ul>
                      </td>
                    </tr>
                  </table>
                  <h3 style="margin: 10px 0;">УСЛОВИЯ УЧАСТИЯ</h3>
                  <p>Для участия в конференционной программе необходимо оплатить регистрационный взнос «Профессионального участника» (при оплате <b>до 31 июля – 5 000 рублей</b>, с 1 августа – 6 000 рублей, с 1 сентября – 7 000 рублей).</p>
                  <p>Посещение выставки – бесплатное для всех зарегистрированных участников.</p>
                </td>
                <td></td>
                <td valign="top">
                  <h3 style="margin-bottom: 10px;"><b>17-19 октября</b></h3>
                  <p style="margin-bottom: 10px;">
                    <strong>Место проведения</strong>:<br>г. Москва<br/>Экспоцентр на Красной Пресне (павильон №3)
                  </p>
                  <p style="margin-bottom: 10px;"><a href="http://riw13.com" target="_blank">www.riw13.com</a></p>
                </td>
                <td></td>
              </tr>

              <tr>
                <td colspan="5" height="25"></td>
              </tr>

              <tr>
                <td></td>
                <td style="background: #e2f4fc;">
                  <div style="padding: 40px 0 40px 50px;">
                    <h3><b>Участие в Неделе Российского Интернета (Russian Internet Week, RIW 2013) с 17 по 19 октября</b></h3>
                  </div>
                </td>
                <td style="background: #e2f4fc;"></td>
                <td style="background: #e2f4fc; vertical-align: middle;">
                  <a href="<?=$user->getFastauthUrl('http://runet-id.com/event/riw13/')?>" target="_blank" class="register-btn" style="display: inline-block; width: 139px; height: 41px; background: url(http://runet-id.com/images/mail/event-main-template/register-btn.png) transparent 0 0 no-repeat; color: #fff; font-size: 13px; line-height: 41px; text-align: center; text-decoration: none;">Регистрация</a>
                </td>
                <td></td>
              </tr>
              <tr>
                <td colspan="5" height="50"></td>
              </tr>
            </tbody>
          </table>

        </td>
      </tr>
    </table>
    <p style="width: 740px; margin: 0 auto; color: #909090;">Вы получили это письмо, так как являетесь <a href="<?=$user->getUrl()?>" target="_blank" style="color: #909090;">пользователем runet-id.ru</a> и подписаны на новостную рассылку. Вы можете <a href="http://runet-id.com/user/setting/subscription/" target="_blank" style="color: #909090;">изменить настройки уведомлений</a>.</p>

  </body>
</html>