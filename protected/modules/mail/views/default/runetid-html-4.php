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

      /*h1 {font-size: 50px;}*/
      h1 {font-size: 30px;}
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
                  <h1>Авторский тренинг-коучинг «Интернет-маркетинг от «А до Я»</h1>
                </td>
                <td width="40"></td>
                <td width="180">
                  <img src="http://getlogo.org/img/trinet/200/150x/" width="150" alt="">
                </td>
                <td width="50"></td>
              </tr>

              <tr>
                <td colspan="5" height="25"></td>
              </tr>

              <tr>
                <td></td>
                <td>
                  <p style="margin-bottom: 10px;">Это полный и всеохватывающий курс по изучению эффективного интернет-маркетинга!</p>
                  <p style="margin-bottom: 10px;">Ведущий: Алексей Довжиков, известный эксперт в интернет-сообществе в сфере IT-менеджмента и интернет-маркетинга. Под руководством Алексея разрабатывались и продвигались проекты для таких компаний как: МТС, BIC, JVC, Балтимор, ФК Зенит и многие другие.</p>
                  <p style="margin-bottom: 10px;">Основной упор тренинга сделан на повышение эффективности работы с интернет-проектом как с точки зрения временных и финансовых затрат на разработку и продвижение, так и с точки зрения получения максимальной отдачи от вложений в интернет-проект.</p>
                  <p style="margin-bottom: 10px;">Заполните форму заявки прямо сейчас, чтобы получить дополнительные полезные материалы по продвижению компании совершенно бесплатно!</p>
                </td>
                <td></td>
                <td valign="top">
                  <h3 style="margin-bottom: 10px;"><b>6-8 ноября 2013</b></h3>
                  <p style="margin-bottom: 10px;">
                    <strong>Место проведения</strong>:<br>г. Санкт-Петербург,<br />Большая Конюшенная улица, д. 29,<br />Бизнес Центр Эра Хаус
                  </p>
                  <p style="margin-bottom: 10px;"><a href="http://dovzhikov.trinet.ru/" target="_blank">www.dovzhikov.trinet.ru</a></p>
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
                    <h4>Авторский тренинг-коучинг «Интернет-маркетинг от «А до Я»</h4>
                  </div>
                </td>
                <td style="background: #e2f4fc;"></td>
                <td style="background: #e2f4fc; vertical-align: middle;">
                  <a href="<?=$user->getFastauthUrl('http://runet-id.com/event/kursdovzhikov13/')?>" target="_blank" class="register-btn" style="display: inline-block; width: 139px; height: 41px; background: url(http://runet-id.com/images/mail/event-main-template/register-btn.png) transparent 0 0 no-repeat; color: #fff; font-size: 13px; line-height: 41px; text-align: center; text-decoration: none;">Регистрация</a>
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
                  <h1>Мастер-класс «Один на всех. Разработка мульти-платформенного адаптивного сайта»</h1>
                </td>
                <td width="40"></td>
                <td width="180">
                  <img src="http://getlogo.org/img/trinet/200/150x/" width="150" alt="">
                </td>
                <td width="50"></td>
              </tr>

              <tr>
                <td colspan="5" height="25"></td>
              </tr>

              <tr>
                <td></td>
                <td>
                  <p style="margin-bottom: 10px;">Ведущий: Денис Мишунов, Front-end разработчик, живет и работает в Норвегии. Употребляет CSS на
                  завтрак, обед и ужин, приправляя HTML и Javascript. Денис в профессиональной веб-разработке уже более 10-ти лет. Выступал на международных конференциях и проводил мастер-классы в США, Швейцарии, Италии, Венгрии.</p>
                  <p style="margin-bottom: 10px;">Что вы получите в результате мастер-класса:</p>
                  <ul>
                    <li>Изучите основы адаптивного дизайна, его конструктивные блоки</li>
                    <li>Получите массу практических советов по адаптивному дизайну и front-end разработке</li>
                    <li>Узнаете плюсы и минусы адаптивного дизайна по сравнению с родными приложениями для конкретных платформ</li>
                    <li>Освоите инструменты и вспомогательные технологии, необходимые для разработки адаптивного сайта</li>
                    <li>Получите ответы на любые интересующие вас вопросы</li>
                    <li>Получите навыки создания мульти-платформенного адаптивного сайта</li>
                  </ul>
                </td>
                <td></td>
                <td valign="top">
                  <h3 style="margin-bottom: 10px;"><b>14-15 ноября</b></h3>
                  <p style="margin-bottom: 10px;">
                    <strong>Место проведения</strong>:<br>г. Санкт-Петербург,<br />Невский пр. 78,<br />Центр Обучения "Академия Роста"
                  </p>
                  <p style="margin-bottom: 10px;"><a href="http://trinet.ru/edu/seminar/524" target="_blank">www.trinet.ru</a></p>
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
                    <h4>Мастер-класс «Один на всех. Разработка мульти-платформенного адаптивного сайта»</h4>
                  </div>
                </td>
                <td style="background: #e2f4fc;"></td>
                <td style="background: #e2f4fc; vertical-align: middle;">
                  <a href="http://trinet.ru/edu/seminar/524/#price" target="_blank" class="register-btn" style="display: inline-block; width: 139px; height: 41px; background: url(http://runet-id.com/images/mail/event-main-template/register-btn.png) transparent 0 0 no-repeat; color: #fff; font-size: 13px; line-height: 41px; text-align: center; text-decoration: none;">Регистрация</a>
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
                  <h1>Семинар «Эффективная реклама + продающий сайт»</h1>
                </td>
                <td width="40"></td>
                <td width="180">
                  <img src="http://getlogo.org/img/trinet/200/150x/" width="150" alt="">
                </td>
                <td width="50"></td>
              </tr>

              <tr>
                <td colspan="5" height="25"></td>
              </tr>

              <tr>
                <td></td>
                <td>
                  <p style="margin-bottom: 10px;">Ваш сайт приносит гораздо меньше заказов, чем вам хотелось бы? Вы вкладываете в продвижение и раскрутку сайта большие деньги, но эффекта нет? Специалисты по интернет-рекламе оперируют непонятными терминами, обещают золотые горы и пытаются "вытянуть" из вас еще больше денег? Иногда вам кажется, что заказы, получаемые с сайта, обходятся вам слишком дорого?</p>
                  <p style="margin-bottom: 10px;">Тогда вам обязательно нужно посетить самый популярный семинар по интернет-рекламе и продающему сайту от практика с 14 летним стажем!</p>
                  <p style="margin-bottom: 10px;">Ведущий: Сергей Спивак. Под руководством Сергея спланированы и проведены сотни рекламных кампаний в Интернете, создано более 70 сайтов для крупных и средних компаний. Вы получите полное представление о интернет-рекламе. Узнаете, что делать и как оценивать эффективность именно в вашем бизнесе.</p>
                </td>
                <td></td>
                <td valign="top">
                  <h3 style="margin-bottom: 10px;"><b>20 ноября</b></h3>
                  <p style="margin-bottom: 10px;">
                    <strong>Место проведения</strong>:<br>г. Санкт-Петербург,<br />ул. Большая Конюшенная 29,<br />Бизнес Центр Эра Хаус, 5 этаж
                  </p>
                  <p style="margin-bottom: 10px;"><a href="http://spb.spivak.ru/" target="_blank">www.spb.spivak.ru</a></p>
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
                    <h4>Семинар «Эффективная реклама + продающий сайт»</h4>
                  </div>
                </td>
                <td style="background: #e2f4fc;"></td>
                <td style="background: #e2f4fc; vertical-align: middle;">
                  <a href="<?=$user->getFastauthUrl('http://runet-id.com/event/obgon2013/')?>" target="_blank" class="register-btn" style="display: inline-block; width: 139px; height: 41px; background: url(http://runet-id.com/images/mail/event-main-template/register-btn.png) transparent 0 0 no-repeat; color: #fff; font-size: 13px; line-height: 41px; text-align: center; text-decoration: none;">Регистрация</a>
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