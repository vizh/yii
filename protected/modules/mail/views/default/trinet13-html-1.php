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

          <table border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 30px; border-top: 0;">
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
                  <h1 style="font-size: 35px;">День интернет-рекламы</h1>
                </td>
                <td width="40"></td>
                <td width="180">
                  <img src="http://runet-id.com/files/event/advday2013/150.png" width="150" alt="">
                </td>
                <td width="50"></td>
              </tr>

              <tr>
                <td colspan="5" height="25"></td>
              </tr>

              <tr>
                <td></td>
                <td>
                  <p style="margin-bottom: 15px;"><b>VI бесплатная конференция «<a href="http://www.advdays.ru/autumn2013/?utm_source=runet-id&utm_medium=mail&utm_campaign=AdvDays2013">День интернет-рекламы</a>» пройдет 22 ноября 2013 года в Санкт-Петербурге в отеле «Park Inn».</b></p>
                  <p style="margin-bottom: 15px;">Ведущие специалисты интернет-маркетинга расскажут о том, как на практике можно решить сложные задачи рекламы в виртуальном пространстве. Эксперты поделятся опытом разработки успешных проектов. Объяснят, с какими трудностями можно столкнуться в самом начале пути и какие сложности поджидают даже настоящих профессионалов.</p>
                  <p style="margin-bottom: 15px;">Реально работающие методики, новые технологии, свежие тренды — конференция будет интересна и новичкам, и практикующим участникам рынка интернет-рекламы. Вы поймете:</p>
                  <ul>
                    <li>Как грамотно применять стратегическое мышление в планировании рекламных кампаний?</li>
                    <li>Как увеличить продажи, не увеличивая затрат на рекламу?</li>
                    <li>Как не избежать типовых ошибок в привлечении трафика из поисковых систем?</li>
                    <li>Как настроить персонализацию сайта под ожидания посетителей средствами веб-аналитики в автоматизированном режиме?</li>
                    <li>Как увидеть быстрый результат от вложенных сил и средств?</li>
                  </ul>
                  <p style="margin-bottom: 15px;">Опыт, основанный на ошибках и успехах множества профессионалов, вы получите совершенно <b>бесплатно</b>. Для участия в конференции нужна <b>только <a href="<?=$user->getFastauthUrl('http://runet-id.com/event/advday2013/')?>">регистрация</a></b>.</p>
                  <p style="margin-bottom: 15px;">А если вы заинтересованы в получении максимума пользы от услышанных на конференции докладов и дополнительных бонусах, выбирайте формат <a href="http://www.advdays.ru/autumn2013/?utm_source=runet-id&utm_medium=mail&utm_campaign=AdvDays2013">бизнес-участия</a>.</p>
                  <p style="margin-bottom: 15px;">В рамках конференции «День интернет-рекламы» объявлен <b>конкурс на лучший сайт</b>! Успейте отправить <a href="http://www.advdays.ru/autumn2013/contest/?utm_source=runet-id&utm_medium=mail&utm_campaign=AdvDays2013">заявку на участие</a>. Все присланные сайты будут рассмотрены экспертами <a href="http://www.advdays.ru/autumn2013/about/partners/">компаний организаторов</a>.</p>
                </td>
                <td></td>
                <td valign="top">
                  <h3 style="margin-bottom: 10px;"><b>22 ноября</b></h3>
                  <p style="margin-bottom: 15px;">
                    <strong>Место проведения</strong>:<br />г. Санкт-Петербург<br/>отель «Park Inn»
                  </p>
                  <p style="margin-bottom: 15px;"><a href="http://www.advdays.ru/autumn2013/?utm_source=runet-id&utm_medium=mail&utm_campaign=AdvDays2013" target="_blank">www.advdays.ru/autumn2013/</a></p>
                </td>
                <td></td>
              </tr>

              <tr>
                <td></td>
                <td style="background: #e2f4fc;">
                  <div style="padding: 20px 0 20px 20px;">
                    <h4>Конференция «День интернет-рекламы»</h4>
                  </div>
                </td>
                <td style="background: #e2f4fc;"></td>
                <td style="background: #e2f4fc; vertical-align: middle;">
                  <a href="<?=$user->getFastauthUrl('http://runet-id.com/event/advday2013/')?>" target="_blank" class="register-btn" style="display: inline-block; width: 139px; height: 41px; background: url(http://runet-id.com/images/mail/event-main-template/register-btn.png) transparent 0 0 no-repeat; color: #fff; font-size: 13px; line-height: 41px; text-align: center; text-decoration: none;">Регистрация</a>
                </td>
                <td></td>
              </tr>

              <tr>
                <td colspan="5" height="25"></td>
              </tr>

              <tr>
                <td></td>
                <td>
                  <p style="margin-bottom: 15px;">
                    <i>Организатор: сервис контекстной рекламы eLama.ru</i><br/>
                    <i>Официальный регистратор: RU-CENTER</i><br/>
                    <i>Видео-партнер: VMG Media Group</i><br/>
                    <i>Печатный партнер: Astra Media Group</i><br/>
                    <i>Партнерами конференции выступают компании SubscribePRO, @Павлова, WEBINAR.RU, JagaJam, СКБ Контур, LeadHit и  TRINET</i>
                  </p>
                </td>
                <td></td>
                <td></td>
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