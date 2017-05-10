<?php	
	$link = "http://2017.russianinternetforum.ru/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'Ke4SkEkDYRFZHYT5K6sDDZRGG'), 0, 16);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Неделя до РИФа. Последние 3 дня голосования за Программу 2.0</title>
    <!--[if (gte mso 9)|(IE)]>
      <style>
        td {
        	                font-family: Helvetica, Arial, sans-serif;
        	            }
      </style>
    <![endif]-->
    <style type="text/css">
      @media only screen and (min-device-width: 601px) {
                      .content {
      	                width: 600px !important
      	            }
                  }
                  @media screen and (max-width: 600px) {
                      .content {
      	                width: 100%!important
      	            }
                  }
    </style>
  </head>
  <body yahoo bgcolor="#f1f1f1" style="margin:0;padding:0;min-width:100% !important;">
    <table width="100%" bgcolor="#f1f1f1" border="0" cellpadding="0" cellspacing="0" style="padding-bottom: 20px">
      <tr>
        <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
          <!--[if (gte mso 9)|(IE)]>
            <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
          <![endif]-->
          <table class="content" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative;">
            <tr>
              <td class="wrapper" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="30" colspan="3" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td align="center" class="h2" colspan="3" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;color:#111111;font-family:&quot;Helvetica Neue&quot;, Helvetica, Arial, &quot;Lucida Grande&quot;, sans-serif;font-weight:200;line-height:1.2em;margin:10px 0;font-size:28px;">Здравствуйте, <?=$user->getShortName()?>!</td>
                  </tr>
                  <tr>
                    <td height="20 colspan=" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <!--[if (gte mso 9)|(IE)]>
          </td>
        </tr>
      </table>
          <![endif]-->
          <!--[if (gte mso 9)|(IE)]>
            <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
          <![endif]-->
          <table class="content section-white" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative;background-color:#ffffff;">
            <tr>
              <td valign="top" colspan="3" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                <img src="http://vizh.share.s3.amazonaws.com/ruvents/rifkib2017/rifkib17(19)-01.jpg" width="600" class="head-img" style="width:100%;display:block;"/>
                                        </td>
            </tr>
          </table>
          <!--[if (gte mso 9)|(IE)]>
          </td>
        </tr>
      </table>
          <![endif]-->
        </td>
      </tr>
    </table>
    <table width="100%" bgcolor="#f1f1f1" border="0" cellpadding="0" cellspacing="0" style="padding-bottom: 20px">
      <tr>
        <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
          <!--[if (gte mso 9)|(IE)]>
            <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
          <![endif]-->
          <table class="content section-white" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative;background-color:#ffffff;">
            <tr>
              <td class="section-white" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;background-color:#ffffff;">
                <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="20" colspan="3" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <img src="https://showtime.s3.amazonaws.com/201704100925-email_calendar.png" style="float: right; height: auto; width: 60px;">
                      <p style="line-height:22px;margin:0;padding:15px 0 0 0;">С&nbsp;радостью и&nbsp;волнением сообщаем:<br>
                        <b>стартует финальная рабочая неделя перед РИФом.</b></p>
                      <p style="line-height:22px;margin:0;padding:15px 0 0 0;">Ваш статус: <b><?=$user->Participants[0]->Role->Title?></b>, а значит мы ждем Вас <nobr>19–21</nobr> апреля в&nbsp;пансионате «Лесные дали» на РИФ+КИБ 2017.</p>
                      <p style="line-height:22px;margin:0;padding:15px 0 0 0;">Если Вы или Ваши коллеги планируете принять личное участие в РИФе, необходимо удостовериться, что статус всех «Участник РИФ+КИБ 2017» (проверить статус можно в <a href="<?=$link?>" style="color:#167BD2;">личном кабинете</a> на сайте РИФа).</p>
                    </td>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td height="30" colspan="3" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <!--[if (gte mso 9)|(IE)]>
          </td>
        </tr>
      </table>
          <![endif]-->
        </td>
      </tr>
    </table>
    <table width="100%" bgcolor="#f1f1f1" border="0" cellpadding="0" cellspacing="0" style="padding-bottom: 20px">
      <tr>
        <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
          <!--[if (gte mso 9)|(IE)]>
            <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
          <![endif]-->
          <table class="content" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative;">
            <tr>
              <td class="wrapper" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="30" colspan="3" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td align="center" class="h2" colspan="3" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;color:#111111;font-family:&quot;Helvetica Neue&quot;, Helvetica, Arial, &quot;Lucida Grande&quot;, sans-serif;font-weight:200;line-height:1.2em;margin:10px 0;font-size:28px;">Специально для Вас<br/>мы выделили важные акценты:</td>
                  </tr>
                  <tr>
                    <td height="20 colspan=" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <!--[if (gte mso 9)|(IE)]>
          </td>
        </tr>
      </table>
          <![endif]-->
        </td>
      </tr>
    </table>
    <table width="100%" bgcolor="#f1f1f1" border="0" cellpadding="0" cellspacing="0" style="padding-bottom: 20px">
      <tr>
        <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
          <!--[if (gte mso 9)|(IE)]>
            <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
          <![endif]-->
          <table class="content section-white" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative;background-color:#ffffff;">
            <tr>
              <td class="section-white" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;background-color:#ffffff;">
                <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <h3 style="margin:25px 0 10px;">Голосуйте за&nbsp;секции Программы&nbsp;2.0</h3>
                      <p style="line-height:22px;margin:0;padding:15px 0 0 0;">Последний шанс проголосовать за&nbsp;Программу&nbsp;2.0. <a href="https://2017.russianinternetforum.ru/p2/" style="color:#167BD2;">Отдать свой голос</a> за&nbsp;лучшие секции можно до&nbsp;четверга 13&nbsp;апреля 2017.</p>
                      <p style="line-height:22px;margin:0;padding:15px 0 0 0;">Каждый участник Форума может оказать влияние на&nbsp;формирование Программы Форума: только 10&nbsp;секций-лидеров из&nbsp;числа почти 100&nbsp;претендентов, заявившихся на&nbsp;конкурс в&nbsp;Программе&nbsp;2.0, по&nbsp;итогам голосования будут включены в&nbsp;Основную программу.</p>
                    </td>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td height="20" colspan="3" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <!--[if (gte mso 9)|(IE)]>
          </td>
        </tr>
      </table>
          <![endif]-->
        </td>
      </tr>
    </table>
    <table width="100%" bgcolor="#f1f1f1" border="0" cellpadding="0" cellspacing="0" style="padding-bottom: 20px">
      <tr>
        <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
          <!--[if (gte mso 9)|(IE)]>
            <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
          <![endif]-->
          <table class="content section-white" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative;background-color:#ffffff;">
            <tr>
              <td class="section-white" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;background-color:#ffffff;">
                <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <h3 style="margin:25px 0 10px;">Назначайте встречи</h3>
                      <p style="line-height:22px;margin:0;padding:15px 0 0 0;">Одна из&nbsp;сильных сторон РИФ+КИБ&nbsp;— это нетворкиг. </p>
                      <p style="line-height:22px;margin:0;padding:15px 0 0 0;">Только тут собирается рекордное количество специалистов отрасли, друзей, партнеров, которые собираются вместе не&nbsp;чаще чем раз в&nbsp;полгода. </p>
                      <p style="line-height:22px;margin:0;padding:15px 0 0 0;">Поэтому важно ознакомиться <a href="https://2017.russianinternetforum.ru/participants/" style="color:#167BD2;">со&nbsp;списком участников</a> и&nbsp;назначить встречу. </p>
                      <p style="line-height:22px;margin:0;padding:15px 0 0 0;">Точками сбора и&nbsp;переговоров могут стать любые удобные зоны на&nbsp;площадке (кафе, стенд на&nbsp;выставке, одна из&nbsp;зон отдыха, пресс-центр или коворкинг-зона.</p>
                      <p style="line-height:22px;margin:0;padding:15px 0 0 0;"><a href="https://2017.russianinternetforum.ru/local/templates/rif17/assets/img/scheme_lesnie_dali.jpg" style="border:none;display:inline-block;height: auto; width: 100%;"></a></p>
                    </td>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td height="20" colspan="3" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <!--[if (gte mso 9)|(IE)]>
          </td>
        </tr>
      </table>
          <![endif]-->
        </td>
      </tr>
    </table>
    <table width="100%" bgcolor="#f1f1f1" border="0" cellpadding="0" cellspacing="0" style="padding-bottom: 20px">
      <tr>
        <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
          <!--[if (gte mso 9)|(IE)]>
            <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
          <![endif]-->
          <table class="content section-white" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative;background-color:#ffffff;">
            <tr>
              <td class="section-white" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;background-color:#ffffff;">
                <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <h3 style="margin:25px 0 10px;">Выбирайте попутчиков</h3>
                      <p style="line-height:22px;margin:0;padding:15px 0 0 0;">Каждый год интернет взрывается от&nbsp;вопросов, как добраться и&nbsp;у&nbsp;кого есть свободные места в&nbsp;машине. </p>
                      <p style="line-height:22px;margin:0;padding:15px 0 0 0;">Подвезите коллег и&nbsp;познакомьтесь с&nbsp;интересными людьми! Всем, кто приехал на&nbsp;BeepCar&nbsp;— рюкзак в&nbsp;ПОДАРОК! Приходите за&nbsp;ним в&nbsp;шатер <a href="https://2017.russianinternetforum.ru/pplus/beepcar/" style="color:#167BD2;">BeepCar</a>.</p>
                      <p style="line-height:22px;margin:0;padding:15px 0 0 0;">А&nbsp;еще возможно воспользоваться каршерингом <a href="https://2017.russianinternetforum.ru/pplus/youdrive/" style="color:#167BD2;">YouDrive</a>&nbsp;— технологичный сервис поминутной аренды автомобиля. </p>
                      <p style="line-height:22px;margin:0;padding:15px 0 0 0;">Специально для тех, кто приедет на&nbsp;РИФ на&nbsp;автомобиле YouDrive будет организована парковка на&nbsp;территории пансионатов «Лесные Дали» и&nbsp;«Поляны».</p>
                      <p style="line-height:22px;margin:0;padding:15px 0 0 0;">Вы&nbsp;— участник РИФ+КИБ? Вы&nbsp;— счастливчик! Первая поездка для участников Форуме&nbsp;— со&nbsp;скидкой 50&nbsp;% по&nbsp;промо-коду: <em>YOURIF</em></p>
                    </td>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td height="20" colspan="3" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <!--[if (gte mso 9)|(IE)]>
          </td>
        </tr>
      </table>
          <![endif]-->
        </td>
      </tr>
    </table>
    <table width="100%" bgcolor="#f1f1f1" border="0" cellpadding="0" cellspacing="0" style="padding-bottom: 20px">
      <tr>
        <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
          <!--[if (gte mso 9)|(IE)]>
            <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
          <![endif]-->
          <table class="content section-white" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative;background-color:#ffffff;">
            <tr>
              <td class="section-white" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;background-color:#ffffff;">
                <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <h3 style="margin:25px 0 10px;">Программа. Выставка. Программа+</h3>
                      <p style="line-height:22px;margin:0;padding:15px 0 0 0;">Настоятельно рекомендуем изучить <a href="https://2017.russianinternetforum.ru/program/" style="color:#167BD2;">программу</a> Форума и&nbsp;схему <a href="https://2017.russianinternetforum.ru/expo/" style="color:#167BD2;">выставки</a>. И&nbsp;определить заранее интересные темы и&nbsp;экспонентов.</p>
                      <p style="line-height:22px;margin:0;padding:15px 0 0 0;">Важно знать, что в&nbsp;этом году РИФ+КИБ подготовил для Вас много внкпрограммных выставочных и&nbsp;уличных активностей и&nbsp;<a href="https://2017.russianinternetforum.ru/pplus/" style="color:#167BD2;">вечерние мероприятия</a>&nbsp;— все три дня! Поэтому не&nbsp;стоит покидать площадку после окончания деловой программы.</p>
                    </td>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td height="20" colspan="3" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <!--[if (gte mso 9)|(IE)]>
          </td>
        </tr>
      </table>
          <![endif]-->
        </td>
      </tr>
    </table>
    <table width="100%" bgcolor="#f1f1f1" border="0" cellpadding="0" cellspacing="0" style="padding-bottom: 20px">
      <tr>
        <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
          <!--[if (gte mso 9)|(IE)]>
            <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
          <![endif]-->
          <table class="content section-white" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative;background-color:#ffffff;">
            <tr>
              <td class="section-white" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;background-color:#ffffff;">
                <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <h3 style="margin:25px 0 10px;">Управляйте опциями участия в&nbsp;личном кабинете:</h3>
                      <ul>
                        <li>Статус участия (Ваш и&nbsp;Ваших коллег)</li>
                        <li>Проживание&nbsp;и питание на&nbsp;территории пансионата в&nbsp;дни РИФа</li>
                        <li>Дополнительные сервисы и&nbsp;опции от&nbsp;организаторов и&nbsp;партнеров РИФа</li>
                      </ul>
                    </td>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <p align="center" style="line-height:22px;margin:0;padding:15px 0 0 0;">
                        <a href="<?=$link?>" class="btn btn-red" style="color:#167BD2;font-size:18px;font-weight:bold;text-decoration:none;padding:10px 30px;display:inline-block;background-color:#eb4247;border-left:solid 1px #af2a21;border-bottom:solid 4px #af2a21;border-right:solid 4px #af2a21;color:#ffffff;border-radius:50px;">Личный кабинет</a>
                      </p>
                    </td>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td height="30" colspan="3" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <!--[if (gte mso 9)|(IE)]>
          </td>
        </tr>
      </table>
          <![endif]-->
        </td>
      </tr>
    </table>
    <table width="100%" bgcolor="#f1f1f1" border="0" cellpadding="0" cellspacing="0" style="padding-bottom: 20px">
      <tr>
        <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
          <!--[if (gte mso 9)|(IE)]>
            <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
          <![endif]-->
          <table class="content section-white" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative;background-color:#ffffff;">
            <tr>
              <td class="section-white" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;background-color:#ffffff;">
                <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="10" colspan="3" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <p align="center" style="line-height:22px;margin:0;padding:15px 0 0 0;">
                        <b>Следите за&nbsp;анонсами и&nbsp;новостями на&nbsp;официальном сайте:</b><br>
                        <a href="http://www.rif.ru/" target="_blank" class="black-a" style="color:#167BD2;color:#000000;">www.rif.ru</a>
                      </p>
                      <p align="center" style="line-height:22px;margin:0;padding:15px 0 0 0;"><b>Подписывайтесь на&nbsp;страницы РИФ+КИБ в&nbsp;социальных медиа:</b></p>
                      <p align="center" style="line-height:22px;margin:0;padding:15px 0 0 0;">
                        <a href="http://chats.viber.com/runet-id" target="_blank" class="no-a" style="color:#167BD2;text-decoration:none;color:#000000;font-weight:bold;display: inline-block; width: 50px;"><img src="http://vizh.share.s3.amazonaws.com/ruvents/viber-white.jpg" width="38" height="37" style="border:none;display:inline-block;"></a>
                        <a href="https://www.facebook.com/rifokib/" target="_blank" class="no-a" style="color:#167BD2;text-decoration:none;color:#000000;font-weight:bold;display: inline-block; width: 50px;"><img src="http://vizh.share.s3.amazonaws.com/ruvents/fb-white.jpg" width="38" height="37" style="border:none;display:inline-block;"></a>
                        <a href="https://twitter.com/RIF_KIB" target="_blank" class="no-a" style="color:#167BD2;text-decoration:none;color:#000000;font-weight:bold;display: inline-block; width: 50px;"><img src="http://vizh.share.s3.amazonaws.com/ruvents/tw-white.jpg" width="38" height="37" style="border:none;display:inline-block;"></a>
                        <a href="https://vk.com/rif_cib" target="_blank" class="no-a" style="color:#167BD2;text-decoration:none;color:#000000;font-weight:bold;display: inline-block; width: 50px;"><img src="http://vizh.share.s3.amazonaws.com/ruvents/vk-white.jpg" width="38" height="37" style="border:none;display:inline-block;"></a>
                      </p>
                      <p align="center" style="line-height:22px;margin:0;padding:15px 0 0 0;">
                        <a href="https://www.facebook.com/events/618146678368519/" target="_blank" class="black-a" style="color:#167BD2;color:#000000;">Добавить в&nbsp;календарь</a><br>
                        <a href="https://runet-id.com/event/rif17/" target="_blank" class="black-a" style="color:#167BD2;color:#000000;">Runet-ID</a>
                      </p>
                    </td>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td height="30" colspan="3" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <!--[if (gte mso 9)|(IE)]>
          </td>
        </tr>
      </table>
          <![endif]-->
        </td>
      </tr>
    </table>
  </body>
</html>