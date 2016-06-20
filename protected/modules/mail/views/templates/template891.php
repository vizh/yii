<?php	
	$regLink = "http://2016.russianinternetforum.ru/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'aihrQ0AcKmaJ'), 0, 16);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Возможность повлиять на программу форума!</title>
        <style type="text/css">
            body {
                margin: 0;
                padding: 0;
                min-width: 100%!important;
            }
            .content {
                width: 100%;
                max-width: 600px;
                padding-top: 20px;
                padding-bottom: 20px;
            } 
            
            .h1, 
            .h2, 
            .h3 {
              color: #111111;
              font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
              font-weight: 200;
              line-height: 1.2em;
              margin: 10px 0;
            }

            .h1 {
              font-size: 36px;
            }
            .h2 {
              font-size: 28px;
              padding-top: 20px;
              padding-bottom: 10px;
            }
            .h3 {
              font-size: 22px;
              font-weight: bold;
              text-transform: uppercase;
              padding-top: 10px;
              padding-bottom: 10px;
            }
            .h4 {
              font-size: 18px;
              margin: 20px 0 5px;
              padding: 0;
            }

            .p {
              font-size: 14px;
              font-weight: normal;
              padding-bottom: 10px;
            }

            .padding-20 {
                padding-left: 20px;
                padding-right: 20px;
            }

            .button {
                padding: 10px;
            }

            .btn-secondary {
              margin-bottom: 10px;
              width: auto;
            }

            .btn-secondary td {
              background-color: transparent; 
              font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; 
              font-size: 14px; 
              text-align: center;
              vertical-align: top; 
            }

            .btn-secondary td a {
              background-color: transparent;
              border: 2px solid #FE9901;
              display: block;
              color: #FE9901;
              cursor: pointer;
              font-weight: bold;
              line-height: 2;
              padding: 8px 15px;
              text-decoration: none;
            }
            a {
              color: #000000;
              font-weight: bold;
            }

            .no-a {
              text-decoration: none;
              font-weight: normal;
              color: #000000;
            }

            table tr td {
                font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
                font-size: 14px;
                line-height: 1.5em;
            }                        
            @media only screen and (min-device-width: 601px) {
                .content {width: 600px !important;}
            }
            @media only screen and (max-width: 599px) {
                .alert {
                  width: 30px!important
                }
            }
        </style>
    </head>
    <body yahoo bgcolor="#D2D9DC" style="margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;min-width:100%!important;" >
          <!--[if (gte mso 9)|(IE)]>
                    <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                    <td style="font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;font-size:14px;line-height:1.5em;" >
                    <![endif]-->
        <table width="100%" bgcolor="#D2D9DC" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td style="font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;font-size:14px;line-height:1.5em;" >
              
                    <table class="content" width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="padding-top:0!important;width:100%;max-width:600px;padding-bottom:20px;" >                                   
                        <tr>
                            <td style="font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;font-size:14px;line-height:1.5em;" >
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#D2D9DC" style="padding-bottom:20px;" >
                                    <tr>
                                        <td align="center" class="h2 padding-20" style="color:#111111;font-family:'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif;font-weight:200;line-height:1.2em;margin-top:10px;margin-bottom:10px;margin-right:0;margin-left:0;font-size:28px;padding-top:20px;padding-bottom:10px;padding-left:20px;padding-right:20px;" >Здравствуйте, <?=$user->getShortName();?>!</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;font-size:14px;line-height:1.5em;" >
                                <a href="http://rif.ru" style="line-height:0 !important;color:#000000;font-weight:bold;" >
                                  <img src="https://showtime.s3.amazonaws.com/201603180918-RIF16_642x-01.png"  alt="" style="height:auto;width:100%;" >
                                </a>
                            </td>
                        </tr>
                        
                        <tr>
                            <td style="font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;font-size:14px;line-height:1.5em;" >
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="padding-top:20px;" >
                                    <tr>
                                        <td align="left" class="padding-20 p" style="font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;line-height:1.5em;font-size:14px;font-weight:normal;text-align:center;padding-bottom:10px;padding-left:20px;padding-right:20px;" >До главного мероприятия Рунета осталась всего 1 неделя!</td>
                                    </tr>
                                    <tr>
                                        <td align="left" class="padding-20 p" style="font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;line-height:1.5em;font-size:14px;font-weight:normal;padding-bottom:10px;padding-left:20px;padding-right:20px;" >
                                          <a href="http://2016.russianinternetforum.ru" style="color:#000000;font-weight:bold;" >20-й РИФ+КИБ 2016</a> включает Форум, Выставку, Программу+ и пройдет <a href="#" class="no-a" style="text-decoration:none;font-weight:normal;color:#000000;" >13–15 апреля</a> 2016 года в&nbsp;подмосковном пансионате “Лесные дали”</td>
                                    </tr>
                                    <tr>
                                        <td align="center" style="font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;font-size:14px;line-height:1.5em;" >
                                            <table class="btn-secondary" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:10px;width:auto;" >
                                              <tr>
                                                <td class="button" height="45" style="padding-bottom:0;line-height:1.5em;padding-top:10px;padding-right:10px;padding-left:10px;background-color:transparent;font-family:'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif;font-size:14px;text-align:center;vertical-align:top;" >
                                                  <a href="<?=$regLink?>" style="background-color:transparent;border-width:2px;border-style:solid;border-color:#FE9901;display:block;color:#FE9901;cursor:pointer;font-weight:bold;line-height:2;padding-top:8px;padding-bottom:8px;padding-right:15px;padding-left:15px;text-decoration:none;" >Быстрая онлайн-регистрация</a>
                                                </td>
                                              </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    
                </td>
            </tr>
            <tr>
                <td style="font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;font-size:14px;line-height:1.5em;" >
                    
                    <table class="content" width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#FFECC4" style="width:100%;max-width:600px;padding-top:20px;padding-bottom:20px;" >
                                    <tr>
                                        <td align="left" class="padding-20 p" style="font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;line-height:1.5em;font-size:14px;font-weight:normal;padding-bottom:10px;padding-left:20px;padding-right:20px;" >Каждый РИФ+КИБ&nbsp;&mdash; это море контента, бизнес-контактов, отдыха и&nbsp;развлечений.</td>
                                    </tr>
                                    <tr>
                                        <td align="left" class="padding-20 p" style="font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;line-height:1.5em;font-size:14px;font-weight:normal;padding-bottom:10px;padding-left:20px;padding-right:20px;" >А&nbsp;к&nbsp;юбилейному РИФу&nbsp;&mdash; это относится вдвойне:</td>
                                    </tr>
                                    <tr>
                                        <td align="left" class="padding-20 p" style="font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;line-height:1.5em;font-size:14px;font-weight:normal;padding-bottom:10px;padding-left:20px;padding-right:20px;" >Интерактивная <a href="http://2016.russianinternetforum.ru/program/" style="color:#000000;font-weight:bold;" >Программа</a> поможет определиться с&nbsp;выбором актуальных для Вас секций (в&nbsp;этом году мероприятия Форума проходят ежедневно в&nbsp;8&nbsp;параллельных залах с&nbsp;<a href="#" class="no-a" style="text-decoration:none;font-weight:normal;color:#000000;" >10:00</a> до&nbsp;<a href="#" class="no-a" style="text-decoration:none;font-weight:normal;color:#000000;" >20:00</a> все три дня).</td>
                                    </tr>
                                    <tr>
                                        <td align="left" class="padding-20 p" style="font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;line-height:1.5em;font-size:14px;font-weight:normal;padding-bottom:10px;padding-left:20px;padding-right:20px;" >Список участников <a href="http://2016.russianinternetforum.ru/expo/" style="color:#000000;font-weight:bold;" >Выставки</a> поможет запланировать нужные Вам встречи (свыше 1&nbsp;000 кв.м, более 50&nbsp;стендов российских и&nbsp;зарубежных компаний: Яндекс, Yota, Mail.ru Group, Avito, 1С-Битрикс, ФРИИ, RU&mdash;CENTER, Hewlett Packard, Softkey и&nbsp;др.).</td>
                                    </tr>
                                    <tr>
                                        <td align="left" class="padding-20 p" style="font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;line-height:1.5em;font-size:14px;font-weight:normal;padding-bottom:10px;padding-left:20px;padding-right:20px;" >Приятно удивит <a href="http://2016.russianinternetforum.ru/pplus/" style="color:#000000;font-weight:bold;" >Программа+</a> (мероприятия от&nbsp;организаторов и&nbsp;партнеров: соревнования дронов, лаунж-зона &laquo;Лаборатории Касперского&raquo;, игровая зона League of&nbsp;Legends от&nbsp;Riot Games, вечеринка компании Avito, День Рождения &laquo;РИФ+КИБ&raquo; в&nbsp;Баре &laquo;Пумба&raquo; и&nbsp;многое другое)!</td>
                                    </tr>
                     </table>
                    
                </td>
            </tr>
            <tr>
                <td style="font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;font-size:14px;line-height:1.5em;" >
                   

                  <table class="content" width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="width:100%;max-width:600px;padding-top:20px;padding-bottom:20px;" >    <tr>
                          <td style="font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;font-size:14px;line-height:1.5em;" >
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="padding-top:20px;" >
                                  <tr>
                                      <td align="left" class="padding-20 p" style="font-weight:bold;text-align:center;font-size:15px;font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;line-height:1.5em;padding-bottom:10px;padding-left:20px;padding-right:20px;" >
                                        Итак, если Вы хотите следить за новостями РИФа в онлайн-режиме или принять в нем личное участие, спешите пройти <a href="<?=$regLink?>" style="display:block;color:#000000;font-weight:bold;" >онлайн-регистрацию</a>.
                                      </td>
                                  </tr>
                              </table>
                          </td>
                      </tr>
                      <tr>
                          <td style="font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;font-size:14px;line-height:1.5em;" >
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="padding-top:20px;" >
                                  <tr>
                                      <td align="left" class="padding-20 p" style="font-weight:bold;text-align:center;font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;line-height:1.5em;font-size:14px;padding-bottom:10px;padding-left:20px;padding-right:20px;" ><h3>ВНИМАНИЮ ТЕХ, КТО ПЛАНИРУЕТ ЛИЧНО ПОСЕТИТЬ ФОРУМ:</h3>      
                                      </td>
                                  </tr>
                              </table>
                          </td>
                      </tr>
                      <tr>
                          <td align="center" class="p padding-20" style="font-size:11px;font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;line-height:1.5em;font-weight:normal;padding-bottom:10px;padding-left:20px;padding-right:20px;" >
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                  <tr>
                                      <td style="font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;font-size:14px;line-height:1.5em;" >
                                          <img class="alert" src="https://showtime.s3.amazonaws.com/201602241624-exclamation-sign-in-oval-speech-bubble.png" alt="" width="70" style="display:block;padding-top:0;padding-bottom:0;padding-right:15px;padding-left:0;" />
                                      </td>
                                      <td style="font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;font-size:14px;line-height:1.5em;" >
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                              <tr>
                                                  <td style="padding-bottom:20px;font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;font-size:14px;line-height:1.5em;" >
                                                      Для регистрации в&nbsp;качестве &laquo;Участника РИФ+КИБ 2016&raquo; необходимо пройти онлайн-регистрацию и&nbsp;оплатить регистрационный взнос участника.
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <td style="font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;font-size:14px;line-height:1.5em;" >
                                                    Обращаем Ваше внимание, что&nbsp;<a href="#" style="text-decoration:none;color:#000000;font-weight:bold;" >8&nbsp;апреля (пятница)&nbsp;&mdash; последний день оплаты регистрационного взноса по&nbsp;безналичному расчету</a>, после чего будут доступны только электронные платежи или оплата участия на месте.
                                                  </td>
                                              </tr>

                                          </table>
                                      </td>
                                  </tr>

                              </table>
                          </td>
                      </tr>
                      <tr>
                          <td class="p padding-20" align="center" style="font-weight:bold;padding-top:30px;font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;line-height:1.5em;font-size:14px;padding-bottom:10px;padding-left:20px;padding-right:20px;" >
                              Следите за нашими новостями в:
                          </td>
                      </tr>
                      <tr>
                        <td style="font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;font-size:14px;line-height:1.5em;" >
                          <table align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="padding-bottom:10px;" >
                            <tr>
                              <td width="30px" style="font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;font-size:14px;line-height:1.5em;" ><a href="https://vk.com/rif_cib" style="color:#000000;font-weight:bold;" ><img src="http://vizh.share.s3.amazonaws.com/ruvents/vk.jpg" alt=""  width="23" height="23" style="display:block;" ></a></td>
                              <td width="30px" style="font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;font-size:14px;line-height:1.5em;" ><a href="https://www.facebook.com/rifokib" style="color:#000000;font-weight:bold;" ><img src="http://vizh.share.s3.amazonaws.com/ruvents/fb.jpg" alt=""  width="23" height="23" style="display:block;" ></a></td>
                              <td width="30px" style="font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;font-size:14px;line-height:1.5em;" ><a href="https://telegram.me/rif_kib" style="color:#000000;font-weight:bold;" ><img src="http://vizh.share.s3.amazonaws.com/ruvents/tel.jpg" alt=""  width="23" height="23" style="display:block;" ></a></td>
                              <td width="30px" style="font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;font-size:14px;line-height:1.5em;" ><a href="https://www.instagram.com/rif_cib/" style="color:#000000;font-weight:bold;" ><img src="http://vizh.share.s3.amazonaws.com/ruvents/inst.jpg" alt=""  width="23" height="23" style="display:block;" ></a></td>
                            </tr>
                          </table>
                        </td>
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
               
    </body>
</html>