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

      ul,ol {
        margin-left: 20px;
      }
      li {
        margin: 5px 0;
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
                  <h1>Неделя Российского Интернета</h1>
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
                  <p style="margin-bottom: 15px;">Уже совсем скоро, 17 октября 2013 года, в&nbsp;Экспоцентре на&nbsp;Красной Пресне начнет свою работу Неделя Российского Интернета (RIW 2013)&nbsp;&mdash; самое ожидаемое и&nbsp;масштабное событие <nobr>интернет-отрасли</nobr>.</p>
                  <p style="margin-bottom: 15px;"><b>RIW&nbsp;&mdash; это ежегодная выставка</b> (более 15 тыс. посетителей за&nbsp;3 дня работы и&nbsp;более 100 экспонентов&nbsp;&mdash; лидеров Рунета) и&nbsp;<b>мощная конференционная программа</b> (более 3 тыс. участников, 12 <nobr>блок-конференций</nobr> по&nbsp;всем актуальным темам развития интернета, более 400 докладчиков).</p>
                  <p style="margin-bottom: 15px;">Что должен знать каждый участник:</p>
                  <h3 style="margin-bottom: 15px;">ПРОГРАММА RIW 2013</h3>
                  <p style="margin-bottom: 15px;">Определены главные направления и&nbsp;названия <nobr>блок-конференций</nobr> <a href="http://2013.russianinternetweek.ru/program/" target="_blank">Профессиональной программы</a>:</p>
                  <table style="width: 420px; margin-bottom: 15px;">
                    <tr>
                      <td width="50%">
                        <ul style="margin-bottom: 10px;">
                          <li>Интернет-реклама</li>
                          <li>Веб-разаработка и интернет-технологии</li>
                          <li>Интернет-маркетинг</li>
                          <li>SEO</li>
                          <li>Social Media</li>
                          <li>Электронная коммерция</li>
                        </ul>
                      </td>
                      <td width="50%">
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
                  <p style="margin-bottom: 15px;">Участие в&nbsp;профессиональной программе&nbsp;&mdash; это обмен мнениями и&nbsp;опытом, бесценные профессиональные навыки, ответы на&nbsp;вопросы и&nbsp;возможные пути решения проблем&nbsp;&mdash; в&nbsp;режиме живого общения.</p>
                  <p style="margin-bottom: 15px;"><b>Более 400 квалифицированных экспертов</b> Рунета поделятся своими знаниями по&nbsp;самым актуальным темам развития <nobr>интернет-бизнеса</nobr> и&nbsp;<nobr>интернет-технологий</nobr>.</p>
                  <h3 style="margin-bottom: 15px;">ВЫСТАВКА ИНТЕРНЕТ 2013</h3>
                  <p style="margin-bottom: 15px;">Изучить достижения лидеров Рунета, посмотреть и&nbsp;потрогать руками их&nbsp;виртуальные товары, пообщаться с&nbsp;их&nbsp;представителями, а&nbsp;также немного расслабиться&nbsp;&mdash; можно будет на&nbsp;выставке, где свои стенды представят: Mail.ru Group, HeadHunter Group, Лаборатория Касперского, <nobr>RU-CENTER</nobr>, <nobr>1С-Битрикс</nobr>, OZON.ru, PayOnline и&nbsp;многие другие.</p>
                  <p style="margin-bottom: 15px;">Всех посетителей &laquo;Интернет 2013&raquo; ждут консультации специалистов на&nbsp;многочисленных информационных стендах, <nobr>промо-продукция</nobr> и&nbsp;развлекательные мероприятия от&nbsp;партнеров с&nbsp;приятными бонусами.</p>
                  <p style="margin-bottom: 15px;"><strong>Участие в&nbsp;выставке
                    бесплатно</strong> для всех зарегистрированных участников RIW 2013.</p>
                  <h3 style="margin-bottom: 15px;"><nobr>БИЗНЕС-ЗОНА</nobr> RIW 2013</h3>
                  <p style="margin-bottom: 15px;"><nobr>Бизнес-зона</nobr> RIW 2013&nbsp;&mdash; удобное место для переговоров и&nbsp;делового общения. Здесь каждый сможет не&nbsp;только выпить кофе, но&nbsp;и&nbsp;провести время с&nbsp;максимальной пользой: на&nbsp;площадке организован доступ в&nbsp;интернет, работает кафе, есть все возможности для отдыха и&nbsp;многое другое.</p>
                  <h3 style="margin-bottom: 15px;">ПРОГРАММА+ НА&nbsp;RIW 2013</h3>
                  <p style="margin-bottom: 15px;">В&nbsp;Программу+ традиционно входят различные мероприятия, дополняющие выставку и&nbsp;конференцию RIW:</p>
                  <ul style="margin-bottom: 15px;">
                    <li><strong>UpStart Conf </strong>&mdash;&nbsp;ежегодная конференция, посвященная стартапам, инвестициям и&nbsp;роли <nobr>интернет-индустрии</nobr> в&nbsp;российской инновационной экономике.</li>
                    <li><b>Аллея инноваций</b> &mdash;&nbsp;<nobr>выставка-презентация</nobr> финалистов одноименного конкурса, это ежегодный проект, посвященный поиску и&nbsp;поддержке лучших <nobr>стартап-команд</nobr>, работающих в&nbsp;сфере высоких технологий.</li>
                    <li><strong>Шоу от&nbsp;партнеров</strong>, церемонии награждение победителей конкурсов <strong>&laquo;Золотой Сайт&raquo;</strong>, <strong><nobr>&laquo;IT-журналистика&raquo;</nobr></strong> и&nbsp;много другое.</li>
                  </ul>
                  <h3 style="margin-bottom: 15px;">ЗАЛ ПРЕЗЕНТАЦИЙ</h3>
                  <p style="margin-bottom: 15px;">Новинка этого года&nbsp;&mdash; специальная площадка, на&nbsp;которой будут представлены продукты и&nbsp;сервисы от&nbsp;игроков <nobr>интернет-индустрии</nobr>. Часть мероприятий пройдет в&nbsp;закрытом формате.</p>
                  <h3 style="margin-bottom: 15px;">УСЛОВИЯ УЧАСТИЯ В&nbsp;RIW 2013</h3>
                  <ul style="margin-bottom: 15px;">
                    <li><strong>Посещение выставки</strong>&nbsp;&mdash; бесплатное для всех зарегистрированных участников. </li>
                    <li><strong>Для участия в&nbsp;Конференционной программе</strong>&nbsp;&mdash; требуется оплата регистрационного взноса (при оплате до&nbsp;1 октября: 6000&nbsp;рублей включая налоги).</li>
                  </ul>
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
                  <div style="padding: 20px 0 20px 30px;">
                    <h3>Участие в Неделе Российского Интернета (Russian Internet Week, RIW 2013) с 17 по 19 октября</h3>
                  </div>
                </td>
                <td style="background: #e2f4fc;"></td>
                <td style="background: #e2f4fc; vertical-align: middle;">
                  <a href="<?='http://2013.russianinternetweek.ru/my/' . $user->RunetId . '/' . substr(md5($user->RunetId . 'xggMpIQINvHqR0QlZgZa'), 0, 16) . '/' ?>" target="_blank" class="register-btn" style="display: inline-block; width: 139px; height: 41px; background: url(http://runet-id.com/images/mail/event-main-template/register-btn.png) transparent 0 0 no-repeat; color: #fff; font-size: 13px; line-height: 41px; text-align: center; text-decoration: none;">Регистрация</a>
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