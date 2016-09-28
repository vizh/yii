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
                  <h1>User Experience Russia 2013</h1>
                </td>
                <td width="40"></td>
                <td width="180">
                  <img src="http://runet-id.com/files/event/userexp2013/150.png" width="150" alt="">
                </td>
                <td width="50"></td>
              </tr>

              <tr>
                <td colspan="5" height="25"></td>
              </tr>

              <tr>
                <td></td>
                <td>
                  <p style="margin-bottom: 10px;">User eXperience 2013 — седьмая международная профессиональная конференция, посвященная вопросам юзабилити и User Experience.</p>
                  <p style="margin-bottom: 10px;">В этом году в центре внимания будут две наиболее актуальные тенденции 2013 года: мобилизация, как следствие повсеместного проникновения мобильных устройств в нашу жизнь, и социализация, как добровольное опутывание нас виртуальными связями.</p>
                  <p style="margin-bottom: 10px;">В программе мероприятия доклады и мастер-классы от ведущих специалистов в области юзабилити и User Experience.</p>
                </td>
                <td></td>
                <td valign="top">
                  <h3 style="margin-bottom: 10px;"><b>7-8 ноября 2013</b></h3>
                  <p style="margin-bottom: 10px;">
                    <strong>Место проведения</strong>:<br>г. Москва,<br />Ленинградский пр-т, д.39, стр. 79,<br />медиа-центр Mail.ru Group
                  </p>
                  <p style="margin-bottom: 10px;"><a href="http://2013.userexperience.ru/" target="_blank">www.2013.userexperience.ru</a></p>
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
                    <h4>Участие в конференции User Experience Russia 2013</h4>
                  </div>
                </td>
                <td style="background: #e2f4fc;"></td>
                <td style="background: #e2f4fc; vertical-align: middle;">
                  <a href="<?=$user->getFastauthUrl('http://runet-id.com/event/userexp2013/')?>" target="_blank" class="register-btn" style="display: inline-block; width: 139px; height: 41px; background: url(http://runet-id.com/images/mail/event-main-template/register-btn.png) transparent 0 0 no-repeat; color: #fff; font-size: 13px; line-height: 41px; text-align: center; text-decoration: none;">Регистрация</a>
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
                  <h1>Russian Affiliate Days 2013</h1>
                </td>
                <td width="40"></td>
                <td width="180">
                  <img src="http://runet-id.com/files/event/rad13/150.png" width="150" alt="">
                </td>
                <td width="50"></td>
              </tr>

              <tr>
                <td colspan="5" height="25"></td>
              </tr>

              <tr>
                <td></td>
                <td>
                  <p style="margin-bottom: 10px;">Приглашаем Вас посетить конференцию <a href="http://www.affdays.ru/?utm_source=raek&utm_medium=29email&utm_campaign=info">Russian Affiliate Days 2013</a> – 2-ю конференцию, посвященную маркетингу с оплатой за результат.</p>
                  <p style="margin-bottom: 10px;">3 причины посетить RAD 2013:</p>
                  <ul>
                    <li>Практика: в программе будут представлены практические доклады от экспертов CPA-рынка и крупных игроков отрасли</li>
                    <li>Личное общение: возможность пообщаться и задать вопросы представителям ведущих партнерских сетей, а также экспертам CPA-рынка</li>
                    <li>Новые деловые контакты: на одной площадке соберутся представители ведущих CPA-сетей, рекламодатели и партнеры, на территории конференции будут созданы все условия для плодотворного общения</li>
                  </ul>
                  <p style="margin-bottom: 10px">Стоимость участия в конференции составляет 7 500 рублей (включает пакет участника и 2 кофе-брейка).</p>
                  <p style="margin-bottom: 10px">Для подписчиков РАЭК предоставляется специальная скидка 25% на любой пакет участника.</p>
                  <p style="margin-bottom: 10px">Скидка действует до 5 ноября включительно. Чтобы воспользоваться скидкой используйте при регистрации промо-код: <b>rad13_29raec25</b></p>
                </td>
                <td></td>
                <td valign="top">
                  <h3 style="margin-bottom: 10px;"><b>20 ноября</b></h3>
                  <p style="margin-bottom: 10px;">
                    <strong>Место проведения</strong>:<br>г. Москва,<br />проспект Мира, 14, стр. 2,<br />Дом приемов (Гостиница «Садовое кольцо»)
                  </p>
                  <p style="margin-bottom: 10px;"><a href="http://www.affdays.ru/?utm_source=raek&utm_medium=29email&utm_campaign=info" target="_blank">www.affdays.ru</a></p>
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
                    <h4>Участие в конференции Russian Affiliate Days 2013</h4>
                  </div>
                </td>
                <td style="background: #e2f4fc;"></td>
                <td style="background: #e2f4fc; vertical-align: middle;">
                  <a href="<?=$user->getFastauthUrl('http://runet-id.com/event/rad13/')?>" target="_blank" class="register-btn" style="display: inline-block; width: 139px; height: 41px; background: url(http://runet-id.com/images/mail/event-main-template/register-btn.png) transparent 0 0 no-repeat; color: #fff; font-size: 13px; line-height: 41px; text-align: center; text-decoration: none;">Регистрация</a>
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
                  <h1>Digital Marketing Conference 2013</h1>
                </td>
                <td width="40"></td>
                <td width="180">
                  <img src="http://runet-id.com/files/event/dmc2013/150.png" width="150" alt="">
                </td>
                <td width="50"></td>
              </tr>

              <tr>
                <td colspan="5" height="25"></td>
              </tr>

              <tr>
                <td></td>
                <td>
                  <p style="margin-bottom: 10px;">Конференция для профессионалов маркетинговых коммуникаций. Вдохновение и опыт от мировых digital-звезд.</p>
                  <p style="margin-bottom: 10px;">Уникальность DMC в высочайшем уровне спикеров и формате мероприятия — теория + практика. Два дня звезды рекламного рынка будут делиться с гостями DMC своими знаниями и опытом.</p>
                  <p style="margin-bottom: 10px;">Первый день конференции отведен докладам и открытым дискуссиям, второй — реальным практикам и мастер-классам.</p>
                  <ul>
                    <li>Чего хотят пользователи?</li>
                    <li>Что отличает профессионала, и как не устать от работы в рекламе после 10 лет в индустрии?</li>
                    <li>Как меняются подходы к разработке Social Media стратегии по мере развития рынка?</li>
                    <li>Зачем встраивать twitter в пианино?</li>
                    <li>Как рождаются эффективные и неожиданные идеи?</li>
                    <li>Как превратить UGC в шедевр: life in a day и другие удачные digital-эксперименты.</li>
                  </ul>
                  <p style="margin-bottom: 10px;">Ответы на эти и другие вопросы узнают гости Digital Marketing Conference в этом году.</p>
                </td>
                <td></td>
                <td valign="top">
                  <h3 style="margin-bottom: 10px;"><b>22-23 ноября</b></h3>
                  <p style="margin-bottom: 10px;">
                    <strong>Место проведения</strong>:<br>г. Москва,<br />Зубовский бульвар, д. 4,<br />РИА Новости
                  </p>
                  <p style="margin-bottom: 10px;"><a href="http://digitalconference.ru/" target="_blank">www.digitalconference.ru</a></p>
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
                    <h4>Участие в конференции Digital Marketing Conference 2013</h4>
                  </div>
                </td>
                <td style="background: #e2f4fc;"></td>
                <td style="background: #e2f4fc; vertical-align: middle;">
                  <a href="http://digitalconference.ru/ticket" target="_blank" class="register-btn" style="display: inline-block; width: 139px; height: 41px; background: url(http://runet-id.com/images/mail/event-main-template/register-btn.png) transparent 0 0 no-repeat; color: #fff; font-size: 13px; line-height: 41px; text-align: center; text-decoration: none;">Регистрация</a>
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