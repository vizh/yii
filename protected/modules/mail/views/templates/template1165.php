<?php	
	$link = "http://riw.moscow/auth/fast?runet_id=" . $user->RunetId . "&key=" . substr(md5($user->RunetId.'awjdn2iuh4i3hudaiubdiwuabd'), 0, 16) . "&redirect=/my";
?>

<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title></title>
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
                      .wrapper {
                          padding: 20px!important
                      }
                  }
    </style>
  </head>
  <body yahoo bgcolor="#F1F1F1" style="margin:0;padding:0;min-width:100% !important;">
    <table width="100%" bgcolor="#F1F1F1" border="0" cellpadding="0" cellspacing="0" style="padding-bottom: 20px">
      <tr>
        <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
          <!--[if (gte mso 9)|(IE)]>
            <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
          <![endif]-->
          <table class="content" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative;">
            <tr>
              <td class="wrapper" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding:20px 33px;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" class="h2" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;color:#111111;font-family:&quot;Helvetica Neue&quot;, Helvetica, Arial, &quot;Lucida Grande&quot;, sans-serif;font-weight:200;line-height:1.2em;margin:10px 0;font-size:28px;"><?=$user->getShortName();?>, здравствуйте!</td>
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
          <table class="content" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative;">
            <tr>
              <td class="wrapper section-white" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding:20px 33px;background-color:#ffffff;">
                <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
                  <!--[if (gte mso 9)|(IE)]>
                    <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td height="30px">
                        </td>
                      </tr>
                    </table>
                  <![endif]-->
                  <tr class="table-list">
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;text-align: center; vertical-align: top; font-size: 0;">
                      <div class="ou" style="width: 267px; display: inline-block; vertical-align: top; margin-left: 0;margin-right: 0; mso-width-alt: 260px !important">
                        <table width="267" align="left" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
                          <tr>
                            <td width="51" valign="middle" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px">
                              <img class="person-photo" src="https://runet-id.com/<?=$user->getPhoto()->get50px();?>" width="51" height="51">
                            </td>
                            <td class="person-name" width="203" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;text-align:center"><a href="<?=$user->getProfileUrl();?>"><?=$user->getName();?></a></td>
                            <td width="16" valign="middle" align="left" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px">
                              <a href="<?=$link?>">
                                <img class="person-photo" src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/img-lk.jpg" width="16" height="16" style="padding-top: 4px">
                              </a>
                            </td>
                          </tr>
                        </table>
                      </div>
                      <div class="ou" style="width: 242px; display: inline-block; vertical-align: top; margin-left: 25px;margin-right: 0; mso-width-alt: 235px !important">
                        <table width="242" align="center" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
                          <tr>
                            <td width="219" height="51" valign="middle" align="center" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                              <a href="<?=$link?>" target="_blank" class=" btn-registration" style="display:inline-block;">
                                <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/%D0%A0%D0%B0%D1%81%D1%81%D1%8B%D0%BB%D0%BA%D0%B0/img-btn-reg-pink.jpg" height="37" style="padding: 7px 0"/>
		                                                                </a>
                            </td>
                          </tr>
                        </table>
                      </div>
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
          <!--[if (gte mso 9)|(IE)]>
            <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
          <![endif]-->
          <table class="content section-white" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative;background-color:#ffffff;">
            <tr class="wrapper" style="padding:20px 33px;">
              <td valign="top" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/%D0%A0%D0%B0%D1%81%D1%81%D1%8B%D0%BB%D0%BA%D0%B0/riw20161020-top-img.jpg" width="600" class="head-img" style="width:100%;display:block;"/>
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
              <td class="wrapper section-white" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding:20px 33px;background-color:#ffffff;padding-bottom: 0;">
                <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
                  <!--[if (gte mso 9)|(IE)]>
                    <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td height="1" style="padding:0; margin: 0">
                        </td>
                      </tr>
                    </table>
                  <![endif]-->
                  <tr>
                    <td align="center" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <p align="center">Еще не&nbsp;зарегистрировались на&nbsp;RIW сами или не&nbsp;зарегистрировали Ваших коллег (для посещения выставки INTERNET 2016 и&nbsp;/или Проф.программы)?</p>
                      <p align="center"><a href="<?=$link?>" target="_blank" class="btn-pink" style="background-color:#E3227F;color:#FFFFFF;font-size:16px;padding:10px 20px;text-decoration:none;display:inline-block;">РЕГИСТРАЦИЯ В&nbsp;ОДИН КЛИК</a></p>
                    </td>
                  </tr>
                  <tr>
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <p align="center"><b>До&nbsp;RIW остается 11 дней, и&nbsp;мы&nbsp;продолжаем рассказывать о&nbsp;его акцентах.<br/>
Сегодня&nbsp;&mdash; еще 5 важных акцентов программы RIW 2016:</b></p>
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
          <!--[if (gte mso 9)|(IE)]>
            <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
          <![endif]-->
          <table class="content section-white" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative;background-color:#ffffff;padding-top: 20px;">
            <tr class="wrapper" style="padding:20px 33px;">
              <td valign="top" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/%D0%A0%D0%B0%D1%81%D1%81%D1%8B%D0%BB%D0%BA%D0%B0/20161021-upstart.jpg" width="600" class="head-img" style="width:100%;display:block;"/>
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
              <td class="wrapper section-white" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding:20px 33px;background-color:#ffffff;padding-bottom: 0;">
                <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
                  <!--[if (gte mso 9)|(IE)]>
                    <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td height="1" style="padding:0; margin: 0">
                        </td>
                      </tr>
                    </table>
                  <![endif]-->
                  <tr>
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <h2><a class="pink" href="http://riw.moscow/special/upstart" target="_blank" style="font-weight:bold;display:block;text-decoration:none;color:#E3227F !important;">UpStart = UpStart CONF + UpStart COMPETITION + Аллея Инноваций</a></h2>
                      <p style="padding-left: 30px">UpStart&nbsp;&mdash; уникальный проект, зонтичный бренд и&nbsp;постоянный &laquo;гость&raquo; на&nbsp;крупнейших отраслевых мероприятиях (таких как РИФ+КИБ, RIW и&nbsp;др.).</p>
                      <p style="padding-left: 30px"><b>UpStart CONF</b>&nbsp;&mdash; это конференция, посвященная молодому предпринимательству в&nbsp;сфере ИТ, стартапам, инвестициям и&nbsp;<nobr>интернет-индустрии</nobr> в&nbsp;российской инновационной экономике.</p>
                      <p style="padding-left: 30px">В&nbsp;рамках RIW 2016 традиционно проводится конкурс стартапов&nbsp;&mdash; <b>UpStart COMPETITiON</b>.</p>
                      <p style="padding-left: 30px">В&nbsp;этом году 15 финалистов конкурса смогут участвовать в&nbsp;самом масштабном мероприятии <nobr>интернет-индустрии</nobr> со&nbsp;стендом, который будет предоставлен оргкомитетом мероприятия и&nbsp;конкурса бесплатно. Любой молодой проект из&nbsp;категории <nobr>ИТ-стартапов</nobr>, может подать заявку на&nbsp;участие в&nbsp;конкурсе и&nbsp;претендовать на&nbsp;бесплатный стенд в&nbsp;течение 1 дня в&nbsp;рамках Выставки &laquo;Аллея инноваций на&nbsp;RIW 2016&raquo;.</p>
                      <p class="pink" style="font-weight:bold;display:block;text-decoration:none;color:#E3227F !important;padding-left: 30px;">Посещение UpStart CONF и&nbsp;Аллеи инноваций&nbsp;&mdash; доступно для всех типов зарегистрированных участников (БЕСПЛАТНО).</p>
                      <p style="padding-left: 30px"><b>ВНИМАНИЕ!</b><br/>
														Конкурс Upstart COMPETITION подходит к&nbsp;концу. Если Вы&nbsp;представляете молодой проект или команду&nbsp;&mdash; регистрируйте его на&nbsp;<a href="http://riw.moscow/special/upstart" target="_blank" class="black-a" style="color:#000000;">конкурс</a>.</p>
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
          <!--[if (gte mso 9)|(IE)]>
            <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
          <![endif]-->
          <table class="content section-white" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative;background-color:#ffffff;padding-top: 20px;">
            <tr class="wrapper" style="padding:20px 33px;">
              <td valign="top" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/%D0%A0%D0%B0%D1%81%D1%81%D1%8B%D0%BB%D0%BA%D0%B0/20161021-buduguru.jpg" width="600" class="head-img" style="width:100%;display:block;"/>
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
              <td class="wrapper section-white" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding:20px 33px;background-color:#ffffff;padding-bottom: 0;">
                <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
                  <!--[if (gte mso 9)|(IE)]>
                    <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td height="1" style="padding:0; margin: 0">
                        </td>
                      </tr>
                    </table>
                  <![endif]-->
                  <tr>
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <h2><a href="http://riw.moscow/special/buduguru" target="_blank" class="pink" style="font-weight:bold;display:block;text-decoration:none;color:#E3227F !important;">BuduGuru Academy</a></h2>
                      <p style="padding-left: 30px">BuduGuru Academy (от&nbsp;РОЦИТ)&nbsp;&mdash; специальная молодежная <nobr>блок-конференция</nobr> на&nbsp;RIW для старшеклассников и&nbsp;студентов по&nbsp;развитию карьеры в&nbsp;области информационных технологий.</p>
                      <p style="padding-left: 30px">Образовательная программа строится вокруг ключевых навыков и&nbsp;знаний, необходимых будущему специалисту в&nbsp;области IT. Ведущие специалисты отрасли расскажут о&nbsp;настоящем и&nbsp;будущем рынка кадров, актуальных навыках современного специалиста, а&nbsp;также новых возможностях профессионального образования.</p>
                      <p class="pink" style="font-weight:bold;display:block;text-decoration:none;color:#E3227F !important;padding-left: 30px;">Посещение BuduGuru Academy&nbsp;&mdash; доступно для всех типов зарегистрированных участников (БЕСПЛАТНО).</p>
                      <p style="padding-left: 30px"><a href="http://riw.moscow/special/buduguru" target="_blank" class="black-a" style="color:#000000;">Подробнее...</a></p>
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
          <!--[if (gte mso 9)|(IE)]>
            <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
          <![endif]-->
          <table class="content section-white" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative;background-color:#ffffff;padding-top: 20px;">
            <tr class="wrapper" style="padding:20px 33px;">
              <td valign="top" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/%D0%A0%D0%B0%D1%81%D1%81%D1%8B%D0%BB%D0%BA%D0%B0/20161021-next.jpg" width="600" class="head-img" style="width:100%;display:block;"/>
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
              <td class="wrapper section-white" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding:20px 33px;background-color:#ffffff;padding-bottom: 0;">
                <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
                  <!--[if (gte mso 9)|(IE)]>
                    <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td height="1" style="padding:0; margin: 0">
                        </td>
                      </tr>
                    </table>
                  <![endif]-->
                  <tr>
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <h2><a href="http://riw.moscow/special/next" class="pink" target="_blank" style="font-weight:bold;display:block;text-decoration:none;color:#E3227F !important;">Поколение NEXT</a></h2>
                      <p style="padding-left: 30px">Первая <nobr>практико-ориентированная</nobr> площадка страны, объединяющая детей, педагогов, а&nbsp;также <nobr>интернет-индустрию</nobr> и&nbsp;власть для совместной работы.</p>
                      <p style="padding-left: 30px">Посещение конференции &laquo;Поколение NEXT&raquo;&nbsp;&mdash; доступно для всех типов зарегистрированных участников (БЕСПЛАТНО).</p>
                      <p style="padding-left: 30px"><a href="http://riw.moscow/special/next" class="black-a" style="color:#000000;">Подробнее...</a></p>
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
          <!--[if (gte mso 9)|(IE)]>
            <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
          <![endif]-->
          <table class="content section-white" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative;background-color:#ffffff;padding-top: 20px;">
            <tr class="wrapper" style="padding:20px 33px;">
              <td valign="top" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/%D0%A0%D0%B0%D1%81%D1%81%D1%8B%D0%BB%D0%BA%D0%B0/20161021-iot.jpg" width="600" class="head-img" style="width:100%;display:block;"/>
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
              <td class="wrapper section-white" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding:20px 33px;background-color:#ffffff;padding-bottom: 0;">
                <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
                  <!--[if (gte mso 9)|(IE)]>
                    <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td height="1" style="padding:0; margin: 0">
                        </td>
                      </tr>
                    </table>
                  <![endif]-->
                  <tr>
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <h2><a href="http://riw.moscow/special/iot" target="_blank" class="pink" style="font-weight:bold;display:block;text-decoration:none;color:#E3227F !important;">Интернет вещей в Умном городе 2016</a></h2>
                      <p style="padding-left: 30px">2 ноября в&nbsp;конференционном зале Wood Hall на&nbsp;территории Экспоцентра пройдет самостоятельный ФОРУМ &laquo;ИНТЕРНЕТ ВЕЩЕЙ В&nbsp;УМНОМ ГОРОДЕ&nbsp;&mdash; 2016&raquo;.</p>
                      <p style="padding-left: 30px">К&nbsp;участию приглашены: представители Министерства строительства и&nbsp;<acronym title="Жилищно-коммунальное хозяйство" lang="ru">ЖКХ</acronym> РФ; Департамента информационных технологий г.&nbsp;Москвы; Фонда &laquo;Сколково&raquo;; Фонда Развития Интернет Инициатив (ФРИИ); П<nobr>АО &laquo;Ростелеком&raquo;</nobr>; АПК &laquo;Безопасный город&raquo;, ГУ&nbsp;МЧС РФ&nbsp;по&nbsp;г.&nbsp;Москве; ГКУ ЦОДД Правительства Москвы; Комитета государственных услуг Москвы; ГБУ &laquo;Инфогород&raquo;; Иннополиса; IBM; GOOGLE; Ассоциации &laquo;Тайзен.ру&raquo; и&nbsp;многие другие.</p>
                      <p style="padding-left: 30px">Технологии, о&nbsp;которых поговорят на&nbsp;Форуме, можно увидеть в&nbsp;действии в&nbsp;инсталляции &laquo;Умный город&raquo; на&nbsp;выставках <nobr>HI-TECH</nobr> BUILDING и&nbsp;Integrated Systems Russia.</p>
                      <p style="font-weight:bold;display:block;text-decoration:none;color:#E3227F !important;padding-left: 30px;" class="pink">Участие в&nbsp;Форуме &laquo;Интернет вещей в&nbsp;Умном Городе 2016&raquo;&nbsp;&mdash; доступно только для участников, зарегистрированных на&nbsp;это мероприятие и&nbsp;оплативших регистрационный взнос.</p>
                      <p style="padding-left: 30px"><a href="https://runet-id.com/event/iot16/" class="black-a" style="color:#000000;">Подробности и&nbsp;регистрация</a></p>
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
          <!--[if (gte mso 9)|(IE)]>
            <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
          <![endif]-->
          <table class="content section-white" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative;background-color:#ffffff;padding-top: 20px;">
            <tr class="wrapper" style="padding:20px 33px;">
              <td valign="top" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/%D0%A0%D0%B0%D1%81%D1%81%D1%8B%D0%BB%D0%BA%D0%B0/20161021-user-exp.jpg" width="600" class="head-img" style="width:100%;display:block;"/>
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
              <td class="wrapper section-white" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding:20px 33px;background-color:#ffffff;padding-bottom: 0;">
                <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
                  <!--[if (gte mso 9)|(IE)]>
                    <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td height="1" style="padding:0; margin: 0">
                        </td>
                      </tr>
                    </table>
                  <![endif]-->
                  <tr>
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <h2><a href="http://riw.moscow/special/userexperience" class="pink" target="_blank" style="font-weight:bold;display:block;text-decoration:none;color:#E3227F !important;">User eXperience 2016</a></h2>
                      <p style="padding-left: 30px">User eXperience 2016&nbsp;&mdash; десятая международная профессиональная конференция, посвященная вопросам юзабилити и&nbsp;User Experience.</p>
                      <p style="padding-left: 30px">В&nbsp;этом году девиз конференции&nbsp;&mdash; &laquo;<nobr>UX-кадры</nobr> решают все!&raquo;. Самые опытные &laquo;кадры&raquo; расскажут о&nbsp;интерфейсах, дизайне и&nbsp;проектировании взаимодействия.<br/>
														Секции User eXperience 2016 пройдут в&nbsp;рамках RIW 2016&nbsp;&mdash; 2 и&nbsp;3 ноября в&nbsp;зале Stone Hall.</p>
                      <p style="font-weight:bold;display:block;text-decoration:none;color:#E3227F !important;padding-left: 30px;" class="pink">Участие Конференции User eXperience 2016&nbsp;&mdash; доступно для Проф.участников RIW 2016. дополнительная регистрация не&nbsp;требуется.</p>
                      <p style="padding-left: 30px"><a href="http://riw.moscow/special/userexperience" class="black-a" style="color:#000000;">Подробнее о&nbsp;User eXperience</a></p>
                      <hr class="yellow" style="background-color:#FFED40;border:none;border-top:solid 1px #FFED40;margin:30px 0;">
                      <h2><a href="http://riw.moscow/program" target="_blank" class="pink" style="font-weight:bold;display:block;text-decoration:none;color:#E3227F !important;">Вся программа RIW 2016</a></h2>
                      <p style="padding-left: 30px"><a href="http://riw.moscow/program" target="_blank" class="black-a" style="color:#000000;">Проф.программа форума RIW 2016</a>&nbsp;&mdash; 9 конференционных залов, около 700 спикеров за&nbsp;3 дня, доступ только для участников со&nbsp;статусом &laquo;Проф.участник RIW 2016&raquo;.</p>
                      <p style="padding-left: 30px"><a href="http://riw.moscow/forum/presentation_hall" target="_blank" class="black-a" style="color:#000000;">Впервые на&nbsp;RIW: трехдневный уникальный формат INTERNET. FUTURE. RED DOT</a>&nbsp;&mdash; серия авторских лекций, визионерских выступлений и&nbsp;интервью с&nbsp;харизматичными спикерами&nbsp;&mdash; про БУДУЩЕЕ интернета, коммуникаций, смежных отраслей</p>
                      <hr class="yellow" style="background-color:#FFED40;border:none;border-top:solid 1px #FFED40;margin:30px 0;">
                      <h2>ВНИМАНИЕ!</h2>
                      <p>Принять участие в&nbsp;Проф.программе могут только участники со&nbsp;статусом &laquo;Проф.участник&raquo;.</p>
                      <p>Оплата Проф.участия от&nbsp;юридических лиц <b>по&nbsp;безналичному расчёту</b>&nbsp;&mdash; принимается до&nbsp;<b>28 октября (пятница)</b>, в&nbsp;дальнейшем сохранится возможность оплаты всеми&nbsp;другими способами (банковские карты, электронные деньги).</p>
                      <p>Стоимость участия: 8&nbsp;000&nbsp;рублей, включая все налоги&nbsp;&mdash; за&nbsp;безлимитное посещение всех 10 залов Форума и&nbsp;4 <nobr>Бизнес-зоны</nobr> в&nbsp;течение всех дней. Принимаются все виды платежей, включая пластиковые карты, электронные деньги, безналичные платежи.</p>
                      <p>Оплатить участие в&nbsp;Форуме (включая возможность оплаты участия Ваших коллег) Вы&nbsp;можете в&nbsp;Вашем <a href="<?=$link?>" class="pink-a" target="_blank" style="color:#E3227F;">Личном кабинете</a>.</p>
                      <hr class="yellow" style="background-color:#FFED40;border:none;border-top:solid 1px #FFED40;margin:30px 0;">
                      <p>Еще не&nbsp;зарегистрировались на&nbsp;RIW сами или не&nbsp;зарегистрировали Ваших коллег (для посещения выставки INTERNET 2016 и&nbsp;/или Проф.программы)?</p>
                      <p align="center"><a href="<?=$link?>" target="_blank" class="btn-pink" style="background-color:#E3227F;color:#FFFFFF;font-size:16px;padding:10px 20px;text-decoration:none;display:inline-block;">РЕГИСТРАЦИЯ В&nbsp;ОДИН КЛИК</a></p>
                      <p style="padding-top: 15px;color: #787878" align="right">
                        <i>С уважением,<br/>
															Оргкомитет RIW 2016<br/>
															<a href="mailto:users@russianinternetweek.ru" target="_blank" style="color: #787878">users@russianinternetweek.ru</a> </i>
                      </p>
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
        </td>
      </tr>
    </table>
  </body>
</html>