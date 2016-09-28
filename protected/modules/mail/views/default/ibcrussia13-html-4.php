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
                  <h1>Internet Business Conference,<br />IBC Russia 2013</h1>
                </td>
                <td width="40"></td>
                <td width="180">
                  <img src="http://runet-id.com/images/mail/ibcrussia13/ibc_logo_black_100x100.png" width="100" alt="">
                </td>
                <td width="50"></td>
              </tr>

              <tr>
                <td colspan="5" height="25"></td>
              </tr>

              <tr>
                <td></td>
                <td>
                  <p style="margin-bottom:  15px;">Вы зарегистрировались на сайте конференции <a href="http://www.ibcrussia.com/?utm_source=ibcvirtrass">IBC Russia 2013</a>, но пока не стали ее участником. Возможно, у вас есть вопросы о программе или условиях участия в конференции? Мы готовы обсудить их с вами:</p>
                  <ul style="margin-bottom:  15px;">
                    <li><a href="mailto:reg@ibcrussia.com">reg@ibcrussia.com</a></li>
                    <li>+7 (495) 258-28-10</li>
                  </ul>
                  <p style="margin-bottom:  15px;">Если хотите, мы можем сами позвонить вам в удобное для вас время. Для этого просто оставьте нам свой телефон.</p>
                  <p style="margin-bottom:  15px;">Напоминаем, что до начала главной отраслевой конференции об интернет-маркетинге и веб-разработке для бизнеса остались считанные недели. Мы будем рады видеть Вас в числе её участников 5 и 6 декабря в Digital October.</p>
                  <p style="margin-bottom:  15px;"><a href="http://ibcrussia.com/program/?utm_source=ibcvirtrass">Программа IBC Russia</a> практически сформирована и ежедневно обновляется. Среди докладчиков – практики и ведущие специалисты «Яндекса», Google, Mail.ru, «ВКонтакте», ADFOX, Promodo, iConText, Текарт, «Ашманов и партнеры» и других компаний.</p>
                  <p style="margin-bottom:  15px;">В <a href="http://ibcrussia.com/exhibition/?utm_source=ibcvirtrass">выставке</a> принимают участие крупнейшие российские компании: SpaceWeb, CDNvideo, «1С-Битрикс», NetCat, Mail.ru Group, Inside, BETWEEN, i-Media, AREALIDEA и другие.</p>
                  <p style="margin-bottom:  15px;">Кстати, совместно с журналом «<a href="http://www.praima.ru/?utm_source=ibcvirtrass">Практика интернет-маркетинга</a>» мы проводим специальную акцию. Оплатив участие в потоке «Интернет-реклама и digital-стратегии» или «Академия интернет-проектов», вы получите бесплатную подписку на 2014 год.</p>
                  <p style="margin-bottom:  15px;">Журнал издаётся с 2007 года и выходит ежеквартально. В каждом номере – статьи ведущих специалистов по интернет-маркетингу, интервью с экспертами, аналитика рынка, инфографика и многое другое.</p>
                  <p style="margin-bottom:  15px;">Акция действует с 19 по 25 ноября, количество подписок ограничено. За подробной информацией о предложении обращайтесь к менеджеру по адресу reg@ibcrussia.com.</p>
                </td>
                <td></td>
                <td valign="top">
                  <h3 style="margin-bottom: 10px;"><b>05/12 - 06/12</b></h3>
                  <p style="margin-bottom: 10px;">
                    <strong>Место проведения</strong>:<br>г. Москва, Digital October,<br/><a href="http://maps.yandex.ru/-/CVbkmHNI">Берсеневская наб., 6, стр. 3</a>
                  </p>
                  <p style="margin-bottom: 10px;"><a href="http://ibcrussia.com/?utm_source=ibcvirtrass" target="_blank">www.ibcrussia.com</a></p>
                </td>
                <td></td>
              </tr>

              <tr>
                <td colspan="5" height="25"></td>
              </tr>

              <tr>
                <td></td>
                <td style="background: #e2f4fc;">
                  <div style="padding: 30px 0 30px 40px;">
                    <h3><b>Участие в конференции Internet Business Conference, IBC Russia 2013</b></h3>
                  </div>
                </td>
                <td style="background: #e2f4fc;"></td>
                <td style="background: #e2f4fc; vertical-align: middle;">
                  <a href="http://ibcrussia.com/my/?RUNETID=<?=$user->RunetId?>&KEY=<?=substr(md5($user->RunetId.'xggMpIQINvHqR0QlZgZa'), 0, 16)?>" target="_blank" class="register-btn" style="display: inline-block; width: 139px; height: 41px; background: url(http://runet-id.com/images/mail/event-main-template/register-btn.png) transparent 0 0 no-repeat; color: #fff; font-size: 13px; line-height: 41px; text-align: center; text-decoration: none;">Регистрация</a>
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