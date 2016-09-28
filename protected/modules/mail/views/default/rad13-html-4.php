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

      ul, ol {
        margin-left: 20px;
      }
      li {
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
                <td style="background: #e2f4fc;">
                  <div style="padding: 20px 0 20px 30px;">
                    <h3><b>Участие в Russian Affiliate Days 2013 (RAD-2013) 20 ноября</b></h3>
                  </div>
                </td>
                <td style="background: #e2f4fc;"></td>
                <td style="background: #e2f4fc; vertical-align: middle;">
                  <a href="<?=$user->getFastauthUrl('http://runet-id.com/event/rad13/?utm_source=raek&utm_medium=12email&utm_campaign=info')?>" target="_blank" class="register-btn" style="display: inline-block; width: 139px; height: 41px; background: url(http://runet-id.com/images/mail/event-main-template/register-btn.png) transparent 0 0 no-repeat; color: #fff; font-size: 13px; line-height: 41px; text-align: center; text-decoration: none;">Регистрация</a>
                </td>
                <td></td>
              </tr>


              <tr>
                <td colspan="5" height="25"></td>
              </tr>

              <tr>
                <td></td>
                <td>
                  <p style="margin-bottom: 15px;">Приглашаем Вас посетить конференцию <a href="http://www.affdays.ru/?utm_source=raek&utm_medium=12email&utm_campaign=info">Russian Affiliate Days 2013</a> – 2-ю конференцию, посвященную маркетингу с оплатой за результат.</p>
                  <p style="margin-bottom: 15px;">Конференция будет проходить <b>20 ноября</b>.</p>
                  <p style="margin-bottom: 15px;">В этом году конференция будет однодневной и проходить в 2 потока: <b>для рекламодателей и партнеров</b>.</p>
                  <p style="margin-bottom: 15px;">Стоимость участия в конференции составляет 7 500 рублей (включает пакет участника и 2 кофе-брейка). Также есть расширенные пакеты участия, которые включают обед и фуршет на конференции.</p>
                  <p style="margin-bottom: 15px;">На конференции RAD 2013 ведущие практики поделятся опытом, как заработать на партнерских программах, расскажут об арбитраже  в социальных сетях,  о заработках на мобильных приложениях и e-mail рассылках, поведают секреты создания продающих посадочных страниц и создания привлекательных офферов  и еще много всего завлекательного и полезного из мира партнерского маркетинга! В дополнение к профессиональной программе -  неформальная обстановка для приятного общения и нетворкинга!</p>
                  <p style="margin-bottom: 15px;"><b>3 причины посетить RAD 2013:</b></p>
                  <ol style="margin-bottom: 15px;">
                    <li><b>Практика:</b> в программе собраны практические доклады от экспертов CPA-рынка и крупных игроков отрасли</li>
                    <li><b>Личное общение:</b> возможность пообщаться и задать вопросы представителям ведущих партнерских сетей, а также экспертам сегмента</li>
                    <li><b>Новые деловые контакты:</b> на одной площадке соберутся представители ведущих  партнерских сетей, рекламодатели и партнеры. На территории конференции будут созданы все условия для плодотворного общения</li>
                  </ol>
                </td>
                <td></td>
                <td valign="top">
                  <h3 style="margin-bottom: 10px;"><b>20 ноября</b></h3>
                  <p style="margin-bottom: 15px;">
                    <strong>Место проведения</strong>:<br />г. Москва<br/>Проспект Мира д.14, стр.2<br/>Бизнес-центр "Дом приемов"
                  </p>
                  <p style="margin-bottom: 15px;"><a href="http://www.affdays.ru/?utm_source=runet&utm_medium=2email&utm_campaign=info" target="_blank">www.affdays.ru</a></p>
                </td>
                <td></td>
              </tr>

              <tr>
                <td></td>
                <td style="background: #e2f4fc;">
                  <div style="padding: 20px 0 20px 30px;">
                    <h3><b>Участие в Russian Affiliate Days 2013 (RAD-2013) 20 ноября</b></h3>
                  </div>
                </td>
                <td style="background: #e2f4fc;"></td>
                <td style="background: #e2f4fc; vertical-align: middle;">
                  <a href="<?=$user->getFastauthUrl('http://runet-id.com/event/rad13/?utm_source=raek&utm_medium=12email&utm_campaign=info')?>" target="_blank" class="register-btn" style="display: inline-block; width: 139px; height: 41px; background: url(http://runet-id.com/images/mail/event-main-template/register-btn.png) transparent 0 0 no-repeat; color: #fff; font-size: 13px; line-height: 41px; text-align: center; text-decoration: none;">Регистрация</a>
                </td>
                <td></td>
              </tr>
              <tr>
                <td colspan="5" height="20"></td>
              </tr>


              <tr>
                <td></td>
                <td>
                  <h3 style="margin-bottom: 15px;"><a href="http://affdays.ru/program/?utm_source=raek&utm_medium=12email&utm_campaign=info">ПРОГРАММА:</a></h3>
                  <p style="margin-bottom: 15px;"><b>Тренды развития CPA в России: кто из рекламодателей придет в 2014 году от экспертов – <a href="http://affdays.ru/speakers/7/?utm_source=raek&utm_medium=12email&utm_campaign=info">Дениса Кучумова</a> и <a href="http://affdays.ru/speakers/20/?utm_source=raek&utm_medium=12email&utm_campaign=info">Екатерины Шинкевич</a>.</b></p>
                  <p style="margin-bottom: 15px;"><b>Для рекламодателей</b></p>
                  <ul style="margin-bottom: 15px;">
                    <li>Уникальный формат: мастер-шоу по созданию партнерской программы! Тимофей Шиколенков, директор по маркетингу и развитию бизнеса компании Аудиомания, и Михаил Гаркунов, директор по продажам компании Аудиомания, в реальном времени для случайного участника конференции создадут партнерскую программу готовую к запуску после окончания секции</li>
                    <li>Максим Плосконосов, директор по маркетингу компании LP Generator, поведает о секретах препарирования входных страниц (landing pages)</li>
                    <li>Мария Меньшова, старший клиент-менеджер EmailMatrix, расскажет о монетизации холодных лидов, поделится опытом, как «зацепить» клиентов с первого письма, как выстроить с ними долгосрочную коммуникацию</li>
                    <li>Алексей Довжиков, основатель сервиса контекстной рекламы eLama, поделится опытом, как привлечь больше покупателей/лидов, используя контекстную рекламу, расскажет о рынке контекстной рекламы в России</li>
                    <li>Андрей Шатров, директор по продажам WapStart, расскажет о методах борьбы за нового клиента в мобильном пространстве</li>
                  </ul>
                  <p style="margin-bottom: 15px;"><b>Для партнеров</b></p>
                  <ul style="margin-bottom: 15px;">
                    <li>Евгений Савельев, генеральный директора Get Activa, расскажет о первых шагах заработка на партнерских программах: подбор работающих источников трафика, выбор целевой аудитории, нестандартные методы мотивации</li>
                    <li>Алексей Терехов, PR-директор  партнерской сети Admitad, расскажет о новых методах заработка на товарных CPA-офферах.</li>
                    <li>О том, как следуя западным трендам, начать зарабатывать в промышленных масштабах поведает Сергей Греков, директор по разработке Партнерской сети Миксмаркет (ex-Zanox), в докладе о создании и запуске партнерского веб-агентства</li>
                    <li>Андрей Синицын, директор по продажам Партнерской сети Миксмаркет, поделится вредными советами по накрутке трафика, или зачем следят честные партнерские сети</li>
                    <li>Роман Кохановский, директор по продажам сервиса Таргет@mail.ru, поделится секретами арбитража трафика в социальных сетях, расскажет, какие лиды хорошо конвертируются в социальных сетях</li>
                    <li>Вадим Роговский, генеральный директор рекламной платформы Clickky, расскажет о монетизации игровых приложений, как не утонуть в океане возможностей.</li>
                  </ul>
                  <p style="margin-bottom: 15px;"><b>Что еще</b></p>
                  <ul style="margin-bottom: 15px;">
                    <li><b>БЛИЦ-КОНТАКТ</b> – бесплатное мероприятие в рамках конференции для быстрого обмена контактами между партнерами и рекламодателями</li>
                    <li><b>Дистанционное участие</b> – всего за 1 500 рублей можно будет удаленно наблюдать видеотрансляцию партнерской секции</li>
                    <li><b>Круглый стол</b> – живая дискуссия о развитии CPA в России. Темы круглого стола будут определены в реальном времени на конференции. В круглом столе будут принимать участие признанные эксперты CPA-рынка: <b>Герман Осташевский, Денис Кучумов, Андрей Синицын, Никита Гуровский, Тимофей Шиколенков, Анна Ветринская, Марта Тер-Саркисян, Павел Васин, Александр Бахманн</b></li>
                  </ul>

                  <p style="margin-bottom: 15px;"><b>Все еще думаете?</b></p>
                  <p style="margin-bottom: 15px;">Ознакомьтесь бесплатно с <a href="http://2012.affdays.ru/program/?utm_source=raek&utm_medium=12email&utm_campaign=info">докладами с предыдущей конференции</a></p>


                  <p style="margin-bottom: 15px;"><b>Организаторы:</b> Партнерская сеть Миксмаркет, ADLABS</p>
                  <p style="margin-bottom: 15px;"><b>Соорганизаторы:</b> РАЭК, CPAExchange</p>
                  </p>
                </td>
                <td></td>
                <td></td>
                <td></td>
              </tr>

              <tr>
                <td colspan="5" height="25"></td>
              </tr>

              <tr>
                <td></td>
                <td style="background: #e2f4fc;">
                  <div style="padding: 20px 0 20px 30px;">
                    <h3><b>Участие в Russian Affiliate Days 2013 (RAD-2013) 20 ноября</b></h3>
                  </div>
                </td>
                <td style="background: #e2f4fc;"></td>
                <td style="background: #e2f4fc; vertical-align: middle;">
                  <a href="<?=$user->getFastauthUrl('http://runet-id.com/event/rad13/?utm_source=raek&utm_medium=12email&utm_campaign=info')?>" target="_blank" class="register-btn" style="display: inline-block; width: 139px; height: 41px; background: url(http://runet-id.com/images/mail/event-main-template/register-btn.png) transparent 0 0 no-repeat; color: #fff; font-size: 13px; line-height: 41px; text-align: center; text-decoration: none;">Регистрация</a>
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