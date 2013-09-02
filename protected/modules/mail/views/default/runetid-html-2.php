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
        <td rowspan="2" style="font-size: 25px; font-weight: bold; line-height: 25px; width: 1px; text-align: center; padding: 5px;"><?=$user->RunetId;?></td>
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
                  <p>Здравствуйте, <?=$user->getShortName();?>!</p>
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
                  <img src="http://runet-id.com/files/event/pravodownload2013/150.png" width="150" alt="">
                </td>
                <td width="50"></td>
              </tr>

              <tr>
                <td colspan="5" height="25"></td>
              </tr>

              <tr>
                <td></td>
                <td>
                  <h3 style="margin-bottom: 10px;">Научно-практическая конференция &laquo;Защита интеллектуальной собственности в Интернете: юридические, технологические, процедурные, организационные аспекты&raquo;</h3>
                  <p style="margin-bottom: 10px;">Специалисты обсудят такие темы, как «Альтернативные концепции и модели регулирования», «Опыт исполнения антипиратского закона», «Анализ международного опыта, кейсы», а также «Обязательства России в области защиты интеллектуальной собственности в связи с вступлением во Всемирную торговую и Организацию экономического сотрудничества и развития».</p>
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
                  <a href="<?=$user->getFastauthUrl('http://runet-id.com/event/pravodownload2013/');?>" target="_blank" class="register-btn" style="display: inline-block; width: 139px; height: 41px; background: url(http://runet-id.com/images/mail/event-main-template/register-btn.png) transparent 0 0 no-repeat; color: #fff; font-size: 13px; line-height: 41px; text-align: center; text-decoration: none;">Регистрация</a>
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
                  <img src="http://runet-id.com/files/event/next2013/150.png" width="150" alt="">
                </td>
                <td width="50"></td>
              </tr>

              <tr>
                <td colspan="5" height="25"></td>
              </tr>

              <tr>
                <td></td>
                <td>
                  <h3 style="margin-bottom: 10px;">Конференция посвящена обсуждению наиболее актуальных проблем взаимодействия детей с онлайн-средой, изучению и исследованию несовершеннолетних в Сети, созданию современных детских интернет-ресурсов и сервисов и их монетизации</h3>
                  <p style="margin-bottom: 10px;">Конференция пройдёт для создателей и сотрудников детских интернет-проектов, работников системы образования и профильных ведомств, аналитиков и журналистов, рекламистов и маркетологов.</p>
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
                  <a href="<?=$user->getFastauthUrl('http://runet-id.com/event/next2013/');?>" target="_blank" class="register-btn" style="display: inline-block; width: 139px; height: 41px; background: url(http://runet-id.com/images/mail/event-main-template/register-btn.png) transparent 0 0 no-repeat; color: #fff; font-size: 13px; line-height: 41px; text-align: center; text-decoration: none;">Регистрация</a>
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
                  <h1>Неделя Российского Интернета 2013, RIW-2013</h1>
                </td>
                <td width="40"></td>
                <td width="180">
                  <img src="http://runet-id.com/files/event/riw13/150.png" width="150" alt="">
                </td>
                <td width="50"></td>
              </tr>

              <tr>
                <td colspan="5" height="25"></td>
              </tr>

              <tr>
                <td></td>
                <td>
                  <h3 style="margin-bottom: 10px;">VI Неделя Российского Интернета (Russian Internet Week, RIW-2013) – это многопотоковая трехдневная конференция, состоящая из Общей и Профессиональной программы, Выставки, а также внепрограммных активностей, презентаций и промо-акций</h3>
                  <p style="margin-bottom: 10px;">В программе конференции представлены практически все основные направления деятельности в Рунете: реклама, социальные медиа, веб-разработки, управление проектами, кадры, информационная безопасность, правовое регулирование и т.д. В мероприятии принимают участие эксперты и признанные специалисты Рунета, сотрудники российских и зарубежных IT-компаний, государственные деятели, представители профильных министерств и ведомств, журналисты и рядовые интернет-пользователи.</p>
                </td>
                <td></td>
                <td valign="top">
                  <h3 style="margin-bottom: 10px;"><b>17-19 октября</b></h3>
                  <p style="margin-bottom: 10px;">
                    <strong>Место проведения</strong>:<br>г. Москва,<br />Краснопресненская наб., д. 14,<br />"Экспоцентр"
                  </p>
                  <p style="margin-bottom: 10px;"><a href="<?='http://2013.russianinternetweek.ru/my/' . $user->RunetId . '/' . substr(md5($user->RunetId . 'xggMpIQINvHqR0QlZgZa'), 0, 16) . '/' ;?>" target="_blank">www.russianinternetweek.ru</a></p>
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
                    <h4>Участие в конференции Russian Internet Week, RIW-2013 с 17 по 19 октября</h4>
                  </div>
                </td>
                <td style="background: #e2f4fc;"></td>
                <td style="background: #e2f4fc; vertical-align: middle;">
                  <a href="<?='http://2013.russianinternetweek.ru/my/' . $user->RunetId . '/' . substr(md5($user->RunetId . 'xggMpIQINvHqR0QlZgZa'), 0, 16) . '/' ;?>" target="_blank" class="register-btn" style="display: inline-block; width: 139px; height: 41px; background: url(http://runet-id.com/images/mail/event-main-template/register-btn.png) transparent 0 0 no-repeat; color: #fff; font-size: 13px; line-height: 41px; text-align: center; text-decoration: none;">Регистрация</a>
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
    <p style="width: 740px; margin: 0 auto; color: #909090;">Вы получили это письмо, так как являетесь <a href="<?=$user->getUrl();?>" target="_blank" style="color: #909090;">пользователем runet-id.ru</a> и подписаны на новостную рассылку. Вы можете <a href="http://runet-id.com/user/setting/subscription/" target="_blank" style="color: #909090;">изменить настройки уведомлений</a>.</p>

  </body>
</html>