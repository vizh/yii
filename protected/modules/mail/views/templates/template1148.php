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
                                <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/%D0%A0%D0%B0%D1%81%D1%81%D1%8B%D0%BB%D0%BA%D0%B0/img-btn-reg-salad.jpg" height="37" style="padding: 7px 0"/>
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
                <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/%D0%A0%D0%B0%D1%81%D1%81%D1%8B%D0%BB%D0%BA%D0%B0/img-top-02.jpg" width="600" class="head-img" style="width:100%;display:block;"/>
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
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding-bottom: 15px;">
                      <p class="h3" style="font-size:1.45em;font-weight:bold;display:block;">Итак, до&nbsp;старта крупнейшего мероприятия Рунета&nbsp;&mdash; <a href="http://riw.moscow" target="_blank" class="black-a" style="color:#000000;">Russian Interactive Week / RIW 2016</a>&nbsp;&mdash; осталось 3 недели.</p>
                      <p style="padding: 0 0 20px 0">Регистрация участия&nbsp;&mdash; идёт полным ходом:</p>
                      <p align="center"><a href="<?=$link?>" target="_blank" class="bg-green" style="background-color:#A1CA4C;color:white;font-weight:bold;text-transform:uppercase;text-decoration:none;padding:10px 20px;">ХОЧУ ПРИНЯТЬ УЧАСТИЕ</a></p>
                      <p style="padding-top: 30px">Без лишних слов публикуем только <b>ЦИФРЫ</b> и&nbsp;<b>ФАКТЫ</b>:</p>
                      <ul style="margin: 0; padding: 0 0 10px 30px">
                        <li style="padding-bottom:15px;line-height:22px;">Уже сейчас число зарегистрированных участников превысило <b class="green" style="color:#A1CA4C;font-size:20px;">10&nbsp;000</b> человек!</li>
                        <li style="padding-bottom:15px;line-height:22px;">Всего в&nbsp;ходе мероприятия будет распечатано более <b class="green" style="color:#A1CA4C;font-size:20px;">20&nbsp;000</b> бейджей</li>
                        <li style="padding-bottom:15px;line-height:22px;">По&nbsp;оценке Оргкомитета посмотреть на&nbsp;главные достижения технологичных компаний (выставка INTERNET 2016 и&nbsp;Softool 2016) и&nbsp;послушать самые актуальные доклады (Форум) сразу <b class="green" style="color:#A1CA4C;font-size:20px;">5</b> отраслей&nbsp;&mdash; ИНТЕРНЕТ / ТЕЛЕКОМ / IT&nbsp;/ СОФТ/ МЕДИА&nbsp;&mdash; смогут более <b class="green" style="color:#A1CA4C;font-size:20px;">25&nbsp;000</b> человек</li>
                        <li style="padding-bottom:15px;line-height:22px;">Посетить конференционную часть смогут более <b class="green" style="color:#A1CA4C;font-size:20px;">4500</b> профессиональных участников</li>
                        <li style="padding-bottom:15px;line-height:22px;">Посетители и&nbsp;участники RIW 2016&nbsp;&mdash; это: <b>рядовые пользователи Рунета</b> (выставка), <b>профессиональное сообщество</b> (выставка и&nbsp;форум), <b>&laquo;смежные&raquo; с&nbsp;интернетом отрасли</b> (телеком, <nobr>медиа-холдинги</nobr>, софтверщики, интернет вещей <nobr>и т. д.</nobr>), <b>государство</b>, <b>студенты</b> профильных ВУЗов, <b>школьники</b> и&nbsp;<b>преподаватели</b> (зона BuduGuru Academy), <b>СМИ</b> и&nbsp;<b>блогеры</b>…</li>
                      </ul>
                      <p style="margin: 0; padding-bottom: 20px"><a href="http://riw.moscow/program" target="_blank" class="black" style="font-size:18px;font-weight:bold;color:#000000;">Программа Форума</a> представлена уникальным контентом: за&nbsp;<b class="green" style="color:#A1CA4C;font-size:20px;">3</b> дня в&nbsp;<b class="green" style="color:#A1CA4C;font-size:20px;">10</b> параллельно <nobr>работающих <a href="http://riw.moscow/program" class="black-a" target="_blank" style="color:#000000;">конференц-залах</a></nobr> выступят более <b class="green" style="color:#A1CA4C;font-size:20px;">700</b> спикеров. За&nbsp;формирование программы отвечают более <b class="green" style="color:#A1CA4C;font-size:20px;">60</b> человек <a href="http://riw.moscow/forum/committee" class="black-a" target="_blank" style="color:#000000;">программного комитета</a>.</p>
                      <p style="margin: 0; padding-bottom: 20px"><a href="http://riw.moscow/about" target="_blank" class="black" style="font-size:18px;font-weight:bold;color:#000000;">Выставка INTERNET 2016</a> (<nobr>интернет-компании</nobr>, <nobr>медиа-холдинги</nobr>, пользовательские и&nbsp;бизнесовые продукты и&nbsp;решения) и&nbsp;Softool 2016 (софт, <nobr>ИТ-решения</nobr> для бизнеса, программные продукты и&nbsp;разработки)&nbsp;&mdash; <b class="green" style="color:#A1CA4C;font-size:20px;">120</b> компаний Рунета&nbsp;&mdash; экспоненты, партнеры и&nbsp;спонсоры специализированных <nobr>бизнес-зон</nobr>.</p>
                      <p style="margin: 0; padding-bottom: 20px">Более <b class="green" style="color:#A1CA4C;font-size:20px;">70</b> профильных и&nbsp;федеральных СМИ оказывают информационную поддержку мероприятию.</p>
                      <p style="margin: 0; padding-bottom: 20px"><b class="black" style="font-size:18px;font-weight:bold;color:#000000;">Специальные события</b> и&nbsp;<nobr>ШОУ-ПРОГРАММА</nobr>&nbsp;&mdash; будут доступны все <b class="green" style="color:#A1CA4C;font-size:20px;">ТРИ</b> дня мероприятия.</p>
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
          <table class="content section-white bg-green" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative;background-color:#ffffff;background-color:#A1CA4C;color:white;font-weight:bold;text-transform:uppercase;text-decoration:none;padding:10px 20px;">
            <!--[if (gte mso 9)|(IE)]>
              <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td height="1" style="padding:0; margin: 0">
                  </td>
                </tr>
              </table>
            <![endif]-->
            <tr>
              <td class="wrapper section-white bg-green" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding:20px 33px;background-color:#ffffff;background-color:#A1CA4C;color:white;font-weight:bold;text-transform:uppercase;text-decoration:none;padding:10px 20px;padding-bottom: 0;">
                <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding-bottom: 15px;">
                      <p style="padding: 15px 0 15px 0"><a href="<?=$link?>" target="_blank" class="black" style="font-size:18px;font-weight:bold;color:#000000;">РЕГИСТРАЦИЯ</a> в&nbsp;один клик доступна прямо сейчас:</p>
                      <ul>
                        <li style="padding-bottom:15px;line-height:22px;">регистрация <b class="black" style="font-size:18px;font-weight:bold;color:#000000;"><nobr>онлайн-участия</nobr></b> (бесплатно)</li>
                        <li style="padding-bottom:15px;line-height:22px;">регистрация для <b class="black" style="font-size:18px;font-weight:bold;color:#000000;">посещения выставки</b> (бесплатно)</li>
                        <li style="padding-bottom:15px;line-height:22px;">регистрация участия в&nbsp;форуме<br>
                          (платная опция &laquo;<b class="black" style="font-size:18px;font-weight:bold;color:#000000;">Проф.участия</b>&raquo;)</li>
                      </ul>
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
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding-bottom: 15px;">
                      <p class="black" style="font-size:18px;font-weight:bold;color:#000000;">НАПОМИНАНИЕ!</p>
                      <p>Доступ на&nbsp;Выставку имеют все зарегистрированные участники RIW. Но&nbsp;только участники со&nbsp;статусом &laquo;Проф.участник&raquo; могут посещать залы Проф.программы Форума.</p>
                      <p>Проверить Ваш статус, оплатить участие (Ваше и&nbsp;Ваших коллег)&nbsp;&mdash; можно в&nbsp;Личном кабинете</p>
                      <p align="center" style="padding: 10px 0 15px 0"><a href="<?=$link?>" target="_blank" class="bg-green" style="background-color:#A1CA4C;color:white;font-weight:bold;text-transform:uppercase;text-decoration:none;padding:10px 20px;">ЛИЧНЫЙ КАБИНЕТ</a></p>
                      <p>Следите за&nbsp;новостями&nbsp;&mdash; подписывайтесь на&nbsp;новости партнёров и&nbsp;экспонентов в&nbsp;<a href="http://riw.moscow/info/partners/list" target="_blank" class="black-a" style="color:#000000;">Партнерском Клубе RIW 2016</a>!</p>
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
            <tr>
              <td class="wrapper section-white" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding:20px 33px;background-color:#ffffff;padding-top: 5px; padding-bottom: 30px;">
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
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;text-align: center; vertical-align: top; font-size: 0;">
                      <div class="ou" style="width: 170px; display: inline-block; vertical-align: top; margin-left: 0;margin-right: 0; mso-width-alt: 170px !important; text-align: center">
                        <table width="170" align="center" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="padding-bottom: 10px">
                          <tr>
                            <td width="170" valign="middle" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                              <a href="<?=$link?>" target="_blank">
                                <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/%D0%A0%D0%B0%D1%81%D1%81%D1%8B%D0%BB%D0%BA%D0%B0/icon-gray-riw16.jpg" width="78"/>
																		</a>
                            </td>
                          </tr>
                        </table>
                      </div>
                      <div class="ou" style="width: 173px; display: inline-block; vertical-align: top; margin-left: 0;margin-right: 0; mso-width-alt: 170px !important; text-align: center">
                        <table width="173" align="center" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="padding-bottom: 10px">
                          <tr>
                            <td width="173" valign="middle" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                              <a href="https://www.facebook.com/russianinteractiveweek" target="_blank" class="btn-footer-ss" style="display:inline-block;text-decoration:none;margin:0;margin:0 2px;">
                                <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/%D0%A0%D0%B0%D1%81%D1%81%D1%8B%D0%BB%D0%BA%D0%B0/icon-gray-fb.jpg" style="vertical-align:middle;"/>
			                                                            </a>
                              <a href="https://twitter.com/ru_riw" target="_blank" class="btn-footer-ss" style="display:inline-block;text-decoration:none;margin:0;margin:0 2px;">
                                <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/%D0%A0%D0%B0%D1%81%D1%81%D1%8B%D0%BB%D0%BA%D0%B0/icon-gray-tweet.jpg?new" style="vertical-align:middle;"/>
			                                                            </a>
                              <a href="https://vk.com/club27733454" target="_blank" class="btn-footer-ss" style="display:inline-block;text-decoration:none;margin:0;margin:0 2px;">
                                <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/%D0%A0%D0%B0%D1%81%D1%81%D1%8B%D0%BB%D0%BA%D0%B0/icon-gray-vk.jpg" style="vertical-align:middle;"/>
			                                                            </a>
                              <a href="https://instagram.com/ru_riw/" target="_blank" class="btn-footer-ss" style="display:inline-block;text-decoration:none;margin:0;margin:0 2px;">
                                <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/%D0%A0%D0%B0%D1%81%D1%81%D1%8B%D0%BB%D0%BA%D0%B0/icon-gray-instagram.jpg" style="vertical-align:middle;"/>
			                                                            </a>
                              <a href="https://telegram.me/riwmoscow" target="_blank" class="btn-footer-ss" style="display:inline-block;text-decoration:none;margin:0;margin:0 2px;">
                                <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/%D0%A0%D0%B0%D1%81%D1%81%D1%8B%D0%BB%D0%BA%D0%B0/icon-gray-telegram.jpg" style="vertical-align:middle;"/>
			                                                            </a>
                              <a href="https://runet-id.com/event/riw16/" target="_blank" class="btn-footer-ss" style="display:inline-block;text-decoration:none;margin:0;margin:0 2px;">
                                <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/%D0%A0%D0%B0%D1%81%D1%81%D1%8B%D0%BB%D0%BA%D0%B0/icon-gray-id.jpg" style="vertical-align:middle;"/>
			                                                            </a>
                            </td>
                          </tr>
                        </table>
                      </div>
                      <div class="ou" style="width: 170px; display: inline-block; vertical-align: top; margin-left: 0;margin-right: 0;  mso-width-alt: 170px !important; text-align: center">
                        <table width="170" align="center" border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="padding-bottom: 10px">
                          <tr>
                            <td width="170" valign="middle" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
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