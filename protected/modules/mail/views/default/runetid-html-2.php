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
        margin: 0 2px;
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
                  <h1>Право на Download</h1>
                </td>
                <td width="40"></td>
                <td width="180">
                  <img src="http://runet-id.com/images/mail/runet-1/pdownload150.png" width="150" alt="">
                </td>
                <td width="50"></td>
              </tr>

              <tr>
                <td colspan="5" height="25"></td>
              </tr>

              <tr>
                <td></td>
                <td>
                  <p style="margin-bottom: 10px;">Научно-практическая конференция "Защита интеллектуальной собственности в Интернете: юридические, технологические, процедурные, организационные аспекты". Главная тема конференции – первые месяцы после вступления «антипиратского» закона в действие.</p>
                </td>
                <td></td>
                <td valign="top">
                  <h3 style="margin-bottom: 10px;"><b>17 сентября</b></h3>
                  <p style="margin-bottom: 10px;">
                    <strong>Место проведения</strong>:<br>г. Москва,<br />Зубовский бульвар, д. 4,<br />РИА Новости
                  </p>
                  <p style="margin-bottom: 10px;"><a href="http://runet-id.com/event/pravodownload2013/" target="_blank">www.runet-id.com</a></p>
                </td>
                <td></td>
              </tr>

              <tr>
                <td colspan="5" height="25"></td>
              </tr>

              <tr>
                <td></td>
                <td style="background: #e2f4fc;">
                  <div style="padding: 20px 0 20px 20px;">
                    <h4>Участие в конференции Право на Download 17 сентября</h4>
                  </div>
                </td>
                <td style="background: #e2f4fc;"></td>
                <td style="background: #e2f4fc; vertical-align: middle;">
                  <a href="<?=$user->getFastauthUrl('http://runet-id.com/event/pravodownload2013/')?>" target="_blank" class="register-btn" style="display: inline-block; width: 139px; height: 41px; background: url(http://runet-id.com/images/mail/event-main-template/register-btn.png) transparent 0 0 no-repeat; color: #fff; font-size: 13px; line-height: 41px; text-align: center; text-decoration: none;">Регистрация</a>
                </td>
                <td></td>
              </tr>

              <tr>
                <td colspan="5" height="40" style="border-bottom: 1px solid #dddddd;"></td>
              </tr>



              <!-- New Event -->

              <tr>
                <td colspan="5" height="30"></td>
              </tr>

              <!-- Columns width -->
              <tr>
                <td width="50"></td>
                <td width="420">
                  <h1>ПОКОЛЕНИЕ NEXT >>></h1>
                </td>
                <td width="40"></td>
                <td width="180">
                  <img src="http://runet-id.com/images/mail/runet-1/next150.png" width="150" alt="">
                </td>
                <td width="50"></td>
              </tr>

              <tr>
                <td colspan="5" height="25"></td>
              </tr>

              <tr>
                <td></td>
                <td>
                  <p style="margin-bottom: 10px;">Конференция посвящена обсуждению наиболее актуальных проблем взаимодействия детей с интернет-пространством. Создание современных детских интернет-ресурсов.</p>
                </td>
                <td></td>
                <td valign="top">
                  <h3 style="margin-bottom: 10px;"><b>26 сентября</b></h3>
                  <p style="margin-bottom: 10px;">
                    <strong>Место проведения</strong>:<br>г. Москва,<br />Зубовский бульвар, д. 4,<br />РИА Новости
                  </p>
                  <p style="margin-bottom: 10px;"><a href="http://runet-id.com/event/next2013/" target="_blank">www.runet-id.com</a></p>
                </td>
                <td></td>
              </tr>

              <tr>
                <td colspan="5" height="25"></td>
              </tr>

              <tr>
                <td></td>
                <td style="background: #e2f4fc;">
                  <div style="padding: 20px 0 20px 20px;">
                    <h4>Участие в конференции ПОКОЛЕНИЕ NEXT >>> 26 сентября</h4>
                  </div>
                </td>
                <td style="background: #e2f4fc;"></td>
                <td style="background: #e2f4fc; vertical-align: middle;">
                  <a href="<?=$user->getFastauthUrl('http://runet-id.com/event/next2013/')?>" target="_blank" class="register-btn" style="display: inline-block; width: 139px; height: 41px; background: url(http://runet-id.com/images/mail/event-main-template/register-btn.png) transparent 0 0 no-repeat; color: #fff; font-size: 13px; line-height: 41px; text-align: center; text-decoration: none;">Регистрация</a>
                </td>
                <td></td>
              </tr>

              <tr>
                <td colspan="5" height="40" style="border-bottom: 1px solid #dddddd;"></td>
              </tr>


              <!-- New Event -->

              <tr>
                <td colspan="5" height="30"></td>
              </tr>

              <!-- Columns width -->
              <tr>
                <td width="50"></td>
                <td width="420">
                  <h1>Неделя Российского Интернета 2013, RIW 2013</h1>
                </td>
                <td width="40"></td>
                <td width="180">
                  <img src="http://runet-id.com/images/mail/runet-1/riw150.png" width="150" alt="">
                </td>
                <td width="50"></td>
              </tr>

              <tr>
                <td colspan="5" height="25"></td>
              </tr>

              <tr>
                <td></td>
                <td>
                  <p style="margin-bottom: 10px;">Главное ежегодное интернет-событие отрасли. Многопотоковая трехдневная конференция, более 50 секций  и более 300 докладчиков, выставка «Интернет-2013» от компаний-лидеров Рунета и Программа+.</p>
                </td>
                <td></td>
                <td valign="top">
                  <h3 style="margin-bottom: 10px;"><b>17-19 октября</b></h3>
                  <p style="margin-bottom: 10px;">
                    <strong>Место проведения</strong>:<br>г. Москва,<br />Краснопресненская наб.,<br />д. 14, "Экспоцентр"
                  </p>
                  <p style="margin-bottom: 10px;"><a href="http://2013.russianinternetweek.ru/" target="_blank">www.russianinternetweek.ru</a></p>
                </td>
                <td></td>
              </tr>

              <tr>
                <td colspan="5" height="25"></td>
              </tr>

              <tr>
                <td></td>
                <td style="background: #e2f4fc;">
                  <div style="padding: 20px 0 20px 20px;">
                    <h4>Участие в конференции Russian Internet Week, RIW 2013 с 17 по 19 октября</h4>
                  </div>
                </td>
                <td style="background: #e2f4fc;"></td>
                <td style="background: #e2f4fc; vertical-align: middle;">
                  <a href="<?='http://2013.russianinternetweek.ru/my/' . $user->RunetId . '/' . substr(md5($user->RunetId . 'xggMpIQINvHqR0QlZgZa'), 0, 16) . '/' ?>" target="_blank" class="register-btn" style="display: inline-block; width: 139px; height: 41px; background: url(http://runet-id.com/images/mail/event-main-template/register-btn.png) transparent 0 0 no-repeat; color: #fff; font-size: 13px; line-height: 41px; text-align: center; text-decoration: none;">Регистрация</a>
                </td>
                <td></td>
              </tr>

              <tr>
                <td colspan="5" height="40" style="border-bottom: 1px solid #dddddd;"></td>
              </tr>



              <!-- New Event -->

              <tr>
                <td colspan="5" height="30"></td>
              </tr>

              <!-- Columns width -->
              <tr>
                <td width="50"></td>
                <td width="420">
                  <h1>Премия<br />«Облака 2013»</h1>
                </td>
                <td width="40"></td>
                <td width="180">
                  <img src="http://runet-id.com/images/mail/runet-1/cloud150.png" width="150" alt="">
                </td>
                <td width="50"></td>
              </tr>

              <tr>
                <td colspan="5" height="25"></td>
              </tr>

              <tr>
                <td></td>
                <td>
                  <p style="margin-bottom: 10px;">Ежегодная премия в области SAAS решений, демонстрация отечественных наработок и достижений в сфере «облачных технологий». Конкурс для талантливых и амбициозных  IT-команд российского интернет-рынка.</p>
                </td>
                <td></td>
                <td valign="top">
                  <h3 style="margin-bottom: 10px;"><b>18 октября</b></h3>
                  <p style="margin-bottom: 10px;">
                    <strong>Место проведения</strong>:<br>г. Москва
                  </p>
                  <p style="margin-bottom: 10px;"><a href="http://2013.cloudaward.ru" target="_blank">www.2013.cloudaward.ru</a></p>
                </td>
                <td></td>
              </tr>

              <tr>
                <td colspan="5" height="25"></td>
              </tr>

              <tr>
                <td></td>
                <td style="background: #e2f4fc;">
                  <div style="padding: 20px 0 20px 20px;">
                    <h4>Участие в премии «Облака 2013» 18 октября</h4>
                  </div>
                </td>
                <td style="background: #e2f4fc;"></td>
                <td style="background: #e2f4fc; vertical-align: middle;">
                  <a href="http://2013.cloudaward.ru/#nominate" target="_blank" class="register-btn" style="display: inline-block; width: 139px; height: 41px; background: url(http://runet-id.com/images/mail/event-main-template/register-btn.png) transparent 0 0 no-repeat; color: #fff; font-size: 13px; line-height: 41px; text-align: center; text-decoration: none;">Номинировать</a>
                </td>
                <td></td>
              </tr>

              <tr>
                <td colspan="5" height="40" style="border-bottom: 1px solid #dddddd;"></td>
              </tr>


              <!-- New Event -->


              <tr>
                <td colspan="5" height="30"></td>
              </tr>

              <!-- Columns width -->
              <tr>
                <td width="50"></td>
                <td width="420">
                  <h1>IBC Russia 2013</h1>
                </td>
                <td width="40"></td>
                <td width="180">
                  <img src="http://runet-id.com/images/mail/runet-1/ibc150.png" width="150" alt="">
                </td>
                <td width="50"></td>
              </tr>

              <tr>
                <td colspan="5" height="25"></td>
              </tr>

              <tr>
                <td></td>
                <td>
                  <p style="margin-bottom: 10px;">Крупнейшая отраслевая конференция для бизнеса об интернет-маркетинге и веб-разработке. Расширенный диалог между различными игроками рынка  интернет-рекламы, направленный на получение максимальной практической информации для успешного старта в интернет-маркетинге.</p>
                </td>
                <td></td>
                <td valign="top">
                  <h3 style="margin-bottom: 10px;"><b>5-6 декабря</b></h3>
                  <p style="margin-bottom: 10px;">
                    <strong>Место проведения</strong>:<br>г. Москва<br />Краснопресненская наб.,<br />д. 12
                  </p>
                  <p style="margin-bottom: 10px;"><a href="http://ibcrussia.com/" target="_blank">www.ibcrussia.com</a></p>
                </td>
                <td></td>
              </tr>

              <tr>
                <td colspan="5" height="25"></td>
              </tr>

              <tr>
                <td></td>
                <td style="background: #e2f4fc;">
                  <div style="padding: 20px 0 20px 20px;">
                    <h4>Участие в конференции IBC Russia 2013 5-6 декабря</h4>
                  </div>
                </td>
                <td style="background: #e2f4fc;"></td>
                <td style="background: #e2f4fc; vertical-align: middle;">
                  <a href="<?='http://ibcrussia.com/my/' . $user->RunetId . '/' . substr(md5($user->RunetId . 'xggMpIQINvHqR0QlZgZa'), 0, 16) . '/' ?>" target="_blank" class="register-btn" style="display: inline-block; width: 139px; height: 41px; background: url(http://runet-id.com/images/mail/event-main-template/register-btn.png) transparent 0 0 no-repeat; color: #fff; font-size: 13px; line-height: 41px; text-align: center; text-decoration: none;">Регистрация</a>
                </td>
                <td></td>
              </tr>

              <tr>
                <td colspan="5" height="40" style="border-bottom: 1px solid #dddddd;"></td>
              </tr>





            </tbody>
          </table>

        </td>
      </tr>
    </table>
    <p style="width: 740px; margin: 0 5px; color: #909090;">Вы получили это письмо, так как являетесь <a href="<?=$user->getUrl()?>" target="_blank" style="color: #909090;">пользователем runet-id.ru</a> и подписаны на новостную рассылку. Вы можете <a href="http://runet-id.com/user/setting/subscription/" target="_blank" style="color: #909090;">изменить настройки уведомлений</a>.</p>

  </body>
</html>