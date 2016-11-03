<?php	
	$link = "http://riw.moscow/auth/fast?runet_id=" . $user->RunetId . "&key=" . substr(md5($user->RunetId.'awjdn2iuh4i3hudaiubdiwuabd'), 0, 16) . "&redirect=/my";
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
    <style>
      .coloured-line td a:hover{text-decoration:underline}
    </style>
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
  <body yahoo bgcolor="#F1F1F1" style="margin:0;padding:0;min-width:100% !important">
    <table width="100%" bgcolor="#F1F1F1" border="0" cellpadding="0" cellspacing="0" style="padding-bottom: 20px">
      <tr>
        <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px">
          <!--[if (gte mso 9)|(IE)]>
            <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
          <![endif]-->
          <table class="content" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative">
            <tr>
              <td class="wrapper" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding:20px 33px">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" class="h2" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;color:#111111;font-family:&quot;Helvetica Neue&quot;, Helvetica, Arial, &quot;Lucida Grande&quot;, sans-serif;font-weight:200;line-height:1.2em;margin:10px 0;font-size:28px"><?=$user->getShortName();?>, здравствуйте!</td>
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
          <table class="content" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative">
            <tr>
              <td class="wrapper section-white" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding:20px 33px;background-color:#ffffff">
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
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;text-align: center; vertical-align: top; font-size: 0">
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
                            <td width="219" height="51" valign="middle" align="center" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px">
                              <a href="<?=$link?>" target="_blank" class=" btn-registration" style="display:inline-block">
                                <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/%D0%A0%D0%B0%D1%81%D1%81%D1%8B%D0%BB%D0%BA%D0%B0/img-btn-reg-pink.jpg" height="37" style="padding: 7px 0">
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
          <table class="content section-white" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative;background-color:#ffffff">
            <tr class="wrapper" style="padding:20px 33px">
              <td valign="top" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px">
                <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/img-top-01.jpg" width="600" class="head-img" style="width:100%;display:block">
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
          <table class="content section-white" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative;background-color:#ffffff">
            <tr>
              <td class="wrapper section-white" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding:20px 33px;background-color:#ffffff;padding-bottom: 0">
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
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding-bottom: 0">
                      <p>До&nbsp;крупнейшего мероприятия Рунета&nbsp;&mdash; Russian Interactive Week&nbsp;&mdash; остается всего один месяц. В&nbsp;период с&nbsp;<b style="color: black!important;text-decoration: none!important">1 по&nbsp;3 ноября</b> в&nbsp;московском <b style="color: black!important;text-decoration: none!important">Экспоцентре</b> на&nbsp;площадке RIW 2016 соберутся десятки тысяч посетителей выставки, тысячи <nobr>IT-специалистов</nobr> и&nbsp;профессионалов из&nbsp;смежных отраслей, руководителей <nobr>интернет-бизнеса</nobr>, представители государственных органов, СМИ, сотни докладчиков и&nbsp;отраслевых экспертов.</p>
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
          <table class="content section-white" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative;background-color:#ffffff">
            <tr>
              <td class="wrapper section-white" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding:20px 33px;background-color:#ffffff;padding-bottom: 0!important">
                <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="pink-border" style="border:solid 2px #e3227f;padding:10px 30px">
                  <!--[if (gte mso 9)|(IE)]>
                    <table width="534" align="center" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td height="30px">
                        </td>
                      </tr>
                    </table>
                  <![endif]-->
                  <tr class="table-list">
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;text-align: center; vertical-align: top; font-size: 0">
                      <div class="ou" style="width: 235px; display: inline-block; vertical-align: top; margin-left: 0;margin-right: 0; mso-width-alt: 230px !important">
                        <table width="235" align="left" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
                          <tr>
                            <td width="219" align="center" valign="middle" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding-bottom: 10px">
                              <p align="center">RIW&nbsp;&mdash; это большая <b>выставка про интернет, медиа, технологии, телеком и&nbsp;софт</b>&nbsp;&mdash; интересная для рядовых пользователей и&nbsp;специалистов.</p>
                            </td>
                          </tr>
                        </table>
                      </div>
                      <div class="ou" style="width: 235px; display: inline-block; vertical-align: top; margin-right: 0; mso-width-alt: 230px !important">
                        <table width="235" align="left" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
                          <tr>
                            <td width="219" align="center" valign="middle" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding-bottom: 10px">
                              <p align="center">RIW&nbsp;&mdash; это трехдневная <b><nobr>10-потоковая</nobr> профессиональная конференция</b>.</p>
                            </td>
                          </tr>
                        </table>
                      </div>
                    </td>
                  </tr>
                  <tr class="table-list">
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;text-align: center; vertical-align: top; font-size: 0">
                      <div class="ou" style="width: 235px; display: inline-block; vertical-align: top; margin-left: 0;margin-right: 0; mso-width-alt: 230px !important">
                        <table width="235" align="left" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
                          <tr>
                            <td width="219" align="center" valign="middle" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding-bottom: 10px">
                              <p align="center">RIW&nbsp;&mdash; это <b>конкурсы, награды, премии и&nbsp;вечерние развлекательные мероприятия</b>.</p>
                            </td>
                          </tr>
                        </table>
                      </div>
                      <div class="ou" style="width: 235px; display: inline-block; vertical-align: top; margin-right: 0; mso-width-alt: 230px !important">
                        <table width="235" align="left" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
                          <tr>
                            <td width="219" align="center" valign="middle" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding-bottom: 10px">
                              <p align="center">RIW&nbsp;&mdash; это <b>крупнейшее<br>
                                  осеннее мероприятие</b><br>
                                отрасли высоких<br>
                                технологий.</p>
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
          <table class="content" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative">
            <tr>
              <td class="wrapper section-white" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding:20px 33px;background-color:#ffffff;padding: 10px 33px 20px">
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
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding-bottom: 0">
                      <h2 align="center">Как получить максимум пользы от&nbsp;участия в&nbsp;RIW? И&nbsp;как не&nbsp;утонуть в&nbsp;море контента и&nbsp;специальных мероприятий?</h2>
                      <p>Вот самые яркие опции RIW 2016, <b>доступные для всех участников без <nobr>какой-либо</nobr> оплаты</b> (требуется только регистрация на&nbsp;сайте):</p>
                      <ul style="margin:0;padding:0 0 0 20px;list-style-type:disc">
                        <li style="padding-bottom:15px">
                          <b><a href="http://riw.moscow/expo/scheme/" class="black-a" target="_blank" style="color:#000000">Выставка INTERNET 2016</a></b><br>
                          Сотни партнеров и&nbsp;экспонентов: Яндекс, Софткей, YouTube, Samsung, Mail. Ru, РБК, OZON, Битрикс, <nobr>Ru-Center</nobr>, 1С, Максима Телеком, МТТ, ИРИ, РОЦИТ, Лаборатория Касперского, Pay. Онлайн, Триколор и&nbsp;многие другие.</li>
                        <li style="padding-bottom:15px">
                          <b><a href="http://riw.moscow/expo/softool/" class="black-a" target="_blank" style="color:#000000">Выставка Softool</a></b><br>
                          Выставка с <nobr>27-летним</nobr> стажем и&nbsp;большой историей.</li>
                        <li style="padding-bottom:15px">RIW проходит бок о бок с&nbsp;выставками <b><nobr>HI-TECH</nobr> Building (Умные здания) и&nbsp;Integrated Systems Russia и</b>&nbsp;предлагает посетителям ежедневные технологические туры по&nbsp;этим выставкам и&nbsp;по&nbsp;специальной экспозиции <b><a href="http://riw.moscow/news/3" class="black-a" target="_blank" style="color:#000000">&laquo;Интернет вещей&raquo;</a></b>.</li>
                        <li style="padding-bottom:15px">
                          <b><a href="http://riw.moscow/special/upstart/" class="black-a" target="_blank" style="color:#000000">UpStart Conf</a></b><br>
                          Конференция о стартапах и для стартапов.</li>
                        <li style="padding-bottom:15px">
                          <b><a href="http://riw.moscow/special/upstart/" class="black-a" target="_blank" style="color:#000000">UpStart Competiotion / Аллея инноваций</a></b><br>
                          Конкурс и&nbsp;выставка молодых проектов иvкоманд.</li>
                        <li style="padding-bottom:15px">
                          <b>Детская аллея инноваций и&nbsp;Школьный <nobr>пресс-центр</nobr></b><br>
                          Специальная зона для юных посетителей выставки, их&nbsp;родителей и&nbsp;учителей. Детская Аллея Инноваций&nbsp;&mdash; это мир IT&nbsp;глазами детей и&nbsp;подростков, учащихся школ.</li>
                        <li style="padding-bottom:15px">
                          <b>BuduGuru Academy</b><br>
                          Молодежная секция о&nbsp;развитии карьеры и&nbsp;образовании в IT.</li>
                        <li style="padding-bottom:15px">
                          <b>Зона Премии Рунета</b><br>
                          На&nbsp;RIW вы&nbsp;сможете в&nbsp;разы увеличить вес своего &laquo;народного голоса&raquo;. Это&nbsp;позволит значительно повлиять на&nbsp;результат Народного голосования Премии Рунета. Также не&nbsp;пропустите презентацию лидеров Народного голосования, общение, <nobr>мини-лекции</nobr> и&nbsp;<nobr>мастер-классы</nobr> от&nbsp;популярных видеоблогеров.</li>
                      </ul>
                      <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td align="center" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding: 8px 0 25px;">
                            <a href="<?=$link?>" target="_blank" class=" btn-registration" style="display:inline-block">
                              <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/img-btn-reg-salad.jpg" height="37">
                            </a>
                          </td>
                        </tr>
                      </table>
                      <h2 align="center">Хотите расширить возможности?</h2>
                      <p>Специально для Вас мы&nbsp;создали и&nbsp;будем наполнять актуальным контентом <b>ГИД участника</b>, чтобы Вы&nbsp;могли наилучшим образом спланировать Ваш собственный формат участия в&nbsp;главном осеннем мероприятии отрасли высоких технологий.</p>
                      <p>Кстати, стать <b>профессиональным участником RIW 2016</b> (получить доступ ко&nbsp;всем залам Форума, к&nbsp;лаундж- и&nbsp;<nobr>бизнес-зонам</nobr>, к&nbsp;уникальному контенту)&nbsp;&mdash; можно всегда, но&nbsp;только при оплате в&nbsp;сентябре&nbsp;&mdash; это особенно выгодно!</p>
                      <p>До&nbsp;30 сентября 2016 года действует специальная цена на&nbsp;регистрацию в&nbsp;статусе &laquo;Проф.участник&raquo;: 
														<b>7000&nbsp;рублей, включая налоги (с&nbsp;1 октября стоимость вырастет до&nbsp;8000 р)</b>.</p>
                      <p>В&nbsp;своем Личном кабинете Вы&nbsp;можете управлять собственным статусом, а&nbsp;также зарегистрировать Ваших коллег.</p>
                      <p align="center" style="padding: 20px 0 0px">
                        <a class="pink-border" style="border:solid 2px #e3227f;padding:10px 30px;display: inline-block; text-decoration: none; color: #000000; font-weight: bold" href="<?=$link?>" target="_blank">РЕГИСТРАЦИЯ ПРОФ.УЧАСТИЯ – В&nbsp;ОДИН КЛИК</a>
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
          <!--[if (gte mso 9)|(IE)]>
            <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
          <![endif]-->
          <table class="content section-white" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative;background-color:#ffffff">
            <tr>
              <td class="wrapper section-white" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding:20px 33px;background-color:#ffffff;padding: 5px 33px 20px;">
                <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0" style="border-top: solid 1px #111111; padding-top: 20px">
                  <tr>
                    <td align="center" valign="top" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px">
                      <!--[if (gte mso 9)|(IE)]>
                        <table width="300px" align="left" cellpadding="0" cellspacing="0" border="0">
                          <tr>
                            <td>
                      <![endif]-->
                      <table align="left" width="50%" border="0" cellspacing="0" cellpadding="0">
                        <!--[if (gte mso 9)|(IE)]>
                          <table width="260" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                              <td height="1px">
                              </td>
                            </tr>
                          </table>
                        <![endif]-->
                        <tr>
                          <td align="left" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding-right: 10px">
                            <p>
                              <b>RIW 2016</b> пройдет<br>
                              <b><nobr>1&mdash;3 ноября</nobr></b> в&nbsp;московском Экспоцентре<br>
                              на&nbsp;Красной Пресне:<br>
                              <a href="http://riw.moscow" target="_blank" class="black-a" style="color:#000000">www.riw.moscow</a>
                            </p>
                          </td>
                        </tr>
                      </table>
                      <!--[if (gte mso 9)|(IE)]>
                      </td>
                      <td width="300px" align="left" cellpadding="0" cellspacing="0" border="0">
                      <![endif]-->
                      <table align="left" width="50%" border="0" cellspacing="0" cellpadding="0">
                        <!--[if (gte mso 9)|(IE)]>
                          <table width="260" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                              <td height="1px">
                              </td>
                            </tr>
                          </table>
                        <![endif]-->
                        <tr>
                          <td align="left" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px">
                            <p style="padding-bottom: 20px">
                              <b>Премия Рунета 2016</b><br>
                              пройдет <b>22 ноября</b><br>
                              на&nbsp;площадке &laquo;Известия Холл&raquo;:<br>
                              <a href="http://premiaruneta.ru" target="_blank" class="black-a" style="color:#000000">www. PremiaRuneta.ru</a>
                            </p>
                            <p>
                              <b>Номинирование организаций и&nbsp;проектов</b> на&nbsp;соискание Премии Рунета 2016 (продлится до&nbsp;конца сентября)&nbsp;&mdash; по&nbsp;адресу: <a class="small-a black-a" href="http://reg.premiaruneta.ru" target="_blank" style="color:#000000;font-size:13px !important">http://reg.premiaruneta.ru</a></p>
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
                  <!--[if (gte mso 9)|(IE)]>
                    <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td height="1px">
                        </td>
                      </tr>
                    </table>
                  <![endif]-->
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
          <table class="content section-white" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative;background-color:#ffffff">
            <tr>
              <td class="wrapper section-white" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding:20px 33px;background-color:#ffffff;padding-top: 5px; padding-bottom: 30px">
                <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                  <!--[if (gte mso 9)|(IE)]>
                    <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td height="1px">
                        </td>
                      </tr>
                    </table>
                  <![endif]-->
                  <tr class="table-list">
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;text-align: center; vertical-align: top; font-size: 0">
                      <div class="ou" style="width: 170px; display: inline-block; vertical-align: top; margin-left: 0;margin-right: 0; mso-width-alt: 170px !important; text-align: center">
                        <table width="170" align="center" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="padding-bottom: 10px">
                          <tr>
                            <td width="170" valign="middle" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px">
                              <a href="<?=$link?>" target="_blank">
                                <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/img-riw16jpg" width="78">
                              </a>
                            </td>
                          </tr>
                        </table>
                      </div>
                      <div class="ou" style="width: 170px; display: inline-block; vertical-align: top; margin-left: 0;margin-right: 0; mso-width-alt: 170px !important; text-align: center">
                        <table width="170" align="center" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="padding-bottom: 10px">
                          <tr>
                            <td width="170" valign="middle" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px">
                              <a href="https://www.facebook.com/russianinteractiveweek" target="_blank" class="btn-footer-ss" style="display:inline-block;text-decoration:none;margin:0;margin:0 2px">
                                <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/img-icon-fb.jpg" style="vertical-align:middle">
                              </a>
                              <a href="https://twitter.com/ru_riw" target="_blank" class="btn-footer-ss" style="display:inline-block;text-decoration:none;margin:0;margin:0 2px">
                                <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/img-icon-tweet.jpg" style="vertical-align:middle">
                              </a>
                              <a href="https://vk.com/club27733454" target="_blank" class="btn-footer-ss" style="display:inline-block;text-decoration:none;margin:0;margin:0 2px">
                                <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/img-icon-vk.jpg" style="vertical-align:middle">
                              </a>
                              <a href="https://instagram.com/ru_riw/" target="_blank" class="btn-footer-ss" style="display:inline-block;text-decoration:none;margin:0;margin:0 2px">
                                <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/img-icon-instagram.jpg" style="vertical-align:middle">
                              </a>
                              <a href="https://telegram.me/riwmoscow" target="_blank" class="btn-footer-ss" style="display:inline-block;text-decoration:none;margin:0;margin:0 2px">
                                <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/img-icon-telegram.jpg" style="vertical-align:middle">
                              </a>
                              <a href="https://runet-id.com/event/riw16/" target="_blank" class="btn-footer-ss" style="display:inline-block;text-decoration:none;margin:0;margin:0 2px">
                                <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/img-icon-id.jpg" style="vertical-align:middle">
                              </a>
                            </td>
                          </tr>
                        </table>
                      </div>
                      <div class="ou" style="width: 170px; display: inline-block; vertical-align: top; margin-left: 0;margin-right: 0;  mso-width-alt: 170px !important; text-align: center">
                        <table width="170" align="center" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="padding-bottom: 10px">
                          <tr>
                            <td width="170" valign="middle" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px">
                              <a href="http://www.riw.moscow" target="_blank" style="color: #000000; text-decoration: none">
                                www.riw.moscow
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
        </td>
      </tr>
    </table>
  </body>
</html>