<?php	
	$link = "http://2017.russianinternetforum.ru/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'Ke4SkEkDYRFZHYT5K6sDDZRGG'), 0, 16);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Важная информация для участников РИФ+КИБ!</title>
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
          <table class="content section-red" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative;background-color:#eb4247;">
            <tr>
              <td class="section-red" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;background-color:#eb4247;">
                <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="20" colspan="3" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <p align="center" style="line-height:22px;margin:0;padding:15px 0 0 0;color:#ffffff;font-size:15px;">До&nbsp;главного весеннего мероприятия IT-индустрии&nbsp;&mdash; РИФ+КИБ&nbsp;&mdash;<br>
                        ровно неделя!</p>
                      <p align="center" style="line-height:22px;margin:0;padding:15px 0 0 0;color:#ffffff;font-size:15px;">
                        Ваш статус в&nbsp;рамках проекта: <br>
                        <span class="caption" style="font-size:22px;font-weight:bold;line-height:32px;"><?=$user->Participants[0]->Role->Title?></span>
                      </p>
                      <p align="center" style="line-height:22px;margin:0;padding:15px 0 0 0;color:#ffffff;font-size:15px;">Хотим поделиться с&nbsp;Вами важной информацией, которую необходимо знать каждому участнику.</p>
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
                    <td height="15" colspan="3" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <p align="center" style="line-height:22px;margin:0;padding:15px 0 0 0;">Чтобы не&nbsp;&laquo;потеряться&raquo; в&nbsp;контенте и&nbsp;наиболее эффективно распланировать Ваше время 19&ndash;21&nbsp;апреля, а&nbsp;также чтобы максимально упростить Вашу регистрацию на&nbsp;площадке, воспользуйтесь представленными ниже советами.</p>
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
                    <td height="20" colspan="4" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                    <td width="80" valign="middle" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <img src="http://vizh.share.s3.amazonaws.com/ruvents/rifkib2017/icon-van.png" width="64">
                    </td>
                    <td valign="middle" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <p class="caption" style="line-height:22px;margin:0;padding:15px 0 0 0;font-size:22px;font-weight:bold;line-height:32px;padding: 0;">Как добраться</p>
                    </td>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                    <td colspan="2" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <p style="line-height:22px;margin:0;padding:15px 0 0 0;">До&nbsp;места проведения&nbsp;&mdash; пансионата &laquo;Лесные дали&raquo;&nbsp;&mdash; можно добраться 4&nbsp;видами:</p>
                      <ul>
                        <li style="margin-bottom:10px;">на&nbsp;личном автомобиле,</li>
                        <li style="margin-bottom:10px;">на&nbsp;бесплатных автобусах форума от&nbsp;метро Крылатское, <a href="https://2017.russianinternetforum.ru/about/way/bus/" target="_blank" class="black-a" style="color:#000000;">расписание</a>
                        </li>
                        <li style="margin-bottom:10px;">воспользоваться сервисом <a href="https://2017.russianinternetforum.ru/pplus/beepcar/" target="_blank" class="black-a" style="color:#000000;">BeepCar</a>
                        </li>
                        <li style="margin-bottom:10px;">воспользоваться сервисом каршеринга <a href="https://2017.russianinternetforum.ru/pplus/youdrive/" target="_blank" class="black-a" style="color:#000000;">YouDrive</a>
                        </li>
                      </ul>
                    </td>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td height="30" colspan="4" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
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
                    <td height="20" colspan="4" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                    <td width="80" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <img src="http://vizh.share.s3.amazonaws.com/ruvents/rifkib2017/icon-interactive.png" width="64">
                    </td>
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <p class="caption" style="line-height:22px;margin:0;padding:15px 0 0 0;font-size:22px;font-weight:bold;line-height:32px;padding-top: 0;">Интерактивная версия программы РИФ+КИБ</p>
                    </td>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                    <td colspan="2" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <p style="line-height:22px;margin:0;padding:15px 0 0 0;">Программа РИФ+КИБ получилась очень насыщенной: в&nbsp;течение трех дней в&nbsp;режиме нон-стоп с&nbsp;10:00 до&nbsp;20:00 будут работать 8&nbsp;параллельных залов, всего пройдет около 100&nbsp;секций, в&nbsp;которых будут задействованы сотни спикеров и&nbsp;тысячи участников.</p>
                      <p style="line-height:22px;margin:0;padding:15px 0 0 0;"><a href="http://2017.russianinternetforum.ru/program/" target="_blank" class="black-a" style="color:#000000;">Онлайн-версия программы</a> содержит самую подробную информацию о&nbsp;секциях, докладчиках, темах выступлений и&nbsp;т.&nbsp;д.</p>
                      <p style="line-height:22px;margin:0;padding:15px 0 0 0;">Рекомендуем добавить этот адрес в&nbsp;закладки Вашего мобильного браузера!</p>
                      <p style="line-height:22px;margin:0;padding:15px 0 0 0;">Также много интересного и&nbsp;полезного ждет участников в&nbsp;рамках <a href="http://2017.russianinternetforum.ru/pplus/" target="_blank" class="black-a" style="color:#000000;">Программы+</a> (неконференционные мерпоприятия от&nbsp;организаторов и&nbsp;партнеров).</p>
                    </td>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td height="30" colspan="4" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
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
              <td valign="top" colspan="3" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                <img src="http://vizh.share.s3.amazonaws.com/ruvents/rifkib2017/rifkib17(25)-01.jpg" width="600" class="head-img" style="width:100%;display:block;"/>
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
                    <td height="20" colspan="4" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                    <td width="80" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <img src="http://vizh.share.s3.amazonaws.com/ruvents/rifkib2017/icon-myprogram.png" width="64">
                    </td>
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <p class="caption" style="line-height:22px;margin:0;padding:15px 0 0 0;font-size:22px;font-weight:bold;line-height:32px;padding-top: 0;">Сервис &laquo;Моя программа&raquo;</p>
                    </td>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                    <td colspan="2" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <p style="line-height:22px;margin:0;padding:15px 0 0 0;">Настоятельно рекомендуем воспользоваться сервисом &laquo;Моя программа&raquo;, который позволяет Вам сформировать собственную программу посещения интересных Вам секций.</p>
                      <p style="line-height:22px;margin:0;padding:15px 0 0 0;">Для этого Вам нужно зайти в&nbsp;раздел <a href="http://2017.russianinternetforum.ru/program/" target="_blank" class="black-a" style="color:#000000;">Программа РИФ+КИБ 2017</a>&nbsp;в авторизованном виде </p>
                      <p style="line-height:22px;margin:0;padding:15px 0 0 0;">Далее Вы&nbsp;можете просто отмечать интересные Вам секции, кликнув на&nbsp;&laquo;звездочку&raquo; рядом с&nbsp;названием. </p>
                      <p style="line-height:22px;margin:0;padding:15px 0 0 0;">Все выбранные секции добавятся в&nbsp;раздел &laquo;Моя программа&raquo; в&nbsp;Вашем Личном кабинете или при клике на&nbsp;&laquo;звездочку&raquo; в&nbsp;левом верхнем углу страницы.</p>
                    </td>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td height="30" colspan="4" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
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
                    <td height="20" colspan="4" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <img src="http://vizh.share.s3.amazonaws.com/ruvents/rifkib2017/icon-van.png" width="64">
                    </td>
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <p class="caption" style="line-height:22px;margin:0;padding:15px 0 0 0;font-size:22px;font-weight:bold;line-height:32px;">Ваш Путевой Лист</p>
                    </td>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                    <td colspan="2" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <p style="line-height:22px;margin:0;padding:15px 0 0 0;">Если Вы&nbsp;планируете посетить Форум лично, настоятельно рекомендуем сохранить на&nbsp;мобильное устройство или распечатать и&nbsp;взять с&nbsp;собой в&nbsp;бумажном виде Ваш персональный Путевой Лист.</p>
                      <p style="line-height:22px;margin:0;padding:15px 0 0 0;">В&nbsp;нем содержится подробная информация, которая облегчит Вашу логистику и&nbsp;адаптацию на&nbsp;месте. <b>В&nbsp;Путевом Листе представлены:</b></p>
                      <ul>
                        <li style="margin-bottom:10px;">Все опции Вашего участия</li>
                        <li style="margin-bottom:10px;">Схема проезда, рекомендации по&nbsp;использованию всех типов транспорта, график движения РИФ&mdash;автобусов для бесплатной доставки участников</li>
                        <li style="margin-bottom:10px;">Схема расположения главных объектов на&nbsp;территории проведения Форума</li>
                        <li style="margin-bottom:10px;">Расписание работы всех объектов на&nbsp;территории проведения Форума</li>
                        <li style="margin-bottom:10px;">Памятка участника</li>
                      </ul>
                      <p align="center" style="line-height:22px;margin:0;padding:15px 0 0 0;">
                        <a href="<?=$user->Participants[0]->getTicketUrl()?>" target="" class="btn btn-red" style="color:#167BD2;font-size:18px;font-weight:bold;text-decoration:none;padding:10px 30px;display:inline-block;background-color:#eb4247;border-left:solid 1px #af2a21;border-bottom:solid 4px #af2a21;border-right:solid 4px #af2a21;color:#ffffff;border-radius:50px;">Скачать путевой лист</a>
                      </p>
                    </td>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td height="30" colspan="4" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
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
              <td valign="top" colspan="3" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                <img src="http://vizh.share.s3.amazonaws.com/ruvents/rifkib2017/rifkib17(25)-02.jpg" width="600" class="head-img" style="width:100%;display:block;"/>
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
                    <td height="20" colspan="4" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                    <td width="80" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <img src="http://vizh.share.s3.amazonaws.com/ruvents/rifkib2017/icon-question.png" width="64">
                    </td>
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <p class="caption" style="line-height:22px;margin:0;padding:15px 0 0 0;font-size:22px;font-weight:bold;line-height:32px;padding-top: 0;">Задай вопрос спикеру через Viber </p>
                    </td>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                    <td colspan="2" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <p style="line-height:22px;margin:0;padding:15px 0 0 0;">Паблик аккаунт <a href="http://viber.com/runet-id" target="_blank" class="black-a" style="color:#000000;">Viber</a>&nbsp;&mdash; это Ваш персональный гид по&nbsp;форуму. Аккаунт является не&nbsp;только удобным ресурсом для получения новостей форума, но&nbsp;и&nbsp;способом коммуникации со&nbsp;спикерами&nbsp;&mdash; вопрос спикеру можно задать, используя Viber-бота.</p>
                    </td>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td height="30" colspan="4" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
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
                <img src="https://showtime.s3.amazonaws.com/201704131119-viber.png" width="600" class="head-img" style="width:100%;display:block;"/>
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
                    <td height="20" colspan="4" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <img src="http://vizh.share.s3.amazonaws.com/ruvents/rifkib2017/icon-plus.png" width="64">
                    </td>
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <p class="caption" style="line-height:22px;margin:0;padding:15px 0 0 0;font-size:22px;font-weight:bold;line-height:32px;padding-top: 0;">Также советуем изучить</p>
                    </td>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                    <td colspan="2" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <ul>
                        <li style="margin-bottom:10px;"><a href="https://2017.russianinternetforum.ru/about/memo/" target="_blank" class="black-a" style="color:#000000;">Памятка участника</a></li>
                        <li style="margin-bottom:10px;"><a href="https://2017.russianinternetforum.ru/news/" target="_blank" class="black-a" style="color:#000000;">Новости о&nbsp;РИФ+КИБ</a></li>
                        <li style="margin-bottom:10px;"><a href="https://2017.russianinternetforum.ru/paperless/" target="_blank" class="black-a" style="color:#000000;">Интерактивные возможности персонального бейджа</a></li>
                      </ul>
                    </td>
                    <td width="30" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
                  </tr>
                  <tr>
                    <td height="30" colspan="4" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;"></td>
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
                        <a href="http://www.rif.ru/" target="_blank" class="black-a" style="color:#000000;">www.rif.ru</a>
                      </p>
                      <p align="center" style="line-height:22px;margin:0;padding:15px 0 0 0;"><b>Подписывайтесь на&nbsp;страницы РИФ+КИБ в&nbsp;социальных медиа:</b></p>
                      <p align="center" style="line-height:22px;margin:0;padding:15px 0 0 0;">
                        <a href="http://chats.viber.com/runet-id" target="_blank" class="no-a" style="text-decoration:none;color:#000000;font-weight:bold;display: inline-block; width: 50px;"><img src="http://vizh.share.s3.amazonaws.com/ruvents/viber-white.jpg" width="38" height="37" style="border:none;display:inline-block;"></a>
                        <a href="https://www.facebook.com/rifokib/" target="_blank" class="no-a" style="text-decoration:none;color:#000000;font-weight:bold;display: inline-block; width: 50px;"><img src="http://vizh.share.s3.amazonaws.com/ruvents/fb-white.jpg" width="38" height="37" style="border:none;display:inline-block;"></a>
                        <a href="https://twitter.com/RIF_KIB" target="_blank" class="no-a" style="text-decoration:none;color:#000000;font-weight:bold;display: inline-block; width: 50px;"><img src="http://vizh.share.s3.amazonaws.com/ruvents/tw-white.jpg" width="38" height="37" style="border:none;display:inline-block;"></a>
                        <a href="https://vk.com/rif_cib" target="_blank" class="no-a" style="text-decoration:none;color:#000000;font-weight:bold;display: inline-block; width: 50px;"><img src="http://vizh.share.s3.amazonaws.com/ruvents/vk-white.jpg" width="38" height="37" style="border:none;display:inline-block;"></a>
                      </p>
                      <p align="center" style="line-height:22px;margin:0;padding:15px 0 0 0;">
                        <a href="https://www.facebook.com/events/618146678368519/" target="_blank" class="black-a" style="color:#000000;">Добавить в&nbsp;календарь</a><br>
                        <a href="https://runet-id.com/event/rif17/" target="_blank" class="black-a" style="color:#000000;">Runet-ID</a>
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