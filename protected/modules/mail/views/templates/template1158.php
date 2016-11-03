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
                <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/img-top-01.jpg" width="600" class="head-img" style="width:100%;display:block;"/>
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
                      <p>RIW уже через две недели!<br>
                        <b>Самое важное в&nbsp;его программе:</b></p>
                      <p>В&nbsp;этом году программный комитет Russian Interactive Week подготовил для участников контент с&nbsp;разной степенью профессиональной подготовки.</p>
                      <p>Все три дня мероприятия будут доступны <a href="http://riw.moscow/program" target="_blank" class="black-a" style="color:#000000;">10&nbsp;конференционных залов</a>, <a href="http://riw.moscow/forum/presentation_hall" target="_blank" class="black-a" style="color:#000000;">Presentation Hall</a>, Медиа / <nobr>Пресс-центр</nobr>, эксклюзивные открытые лекционные площадки&nbsp;&mdash; сегодня знакомим с&nbsp;некоторыми подробнее.</p>
                      <p class="li-pink" style="font-size:20px;font-weight:bold;color:#E3227F;text-decoration:none;">Для самых молодых участников RIW:</p>
                      <p style="padding-left: 30px"><a href="http://riw.moscow/special/buduguru" target="_blank" class="black-a" style="color:#000000;">BuduGuru Academy</a>&nbsp;&mdash; образовательный проект, созданный при поддержке крупнейших российских <nobr>IT-компаний</nobr>, для того, чтобы помочь молодым людям стать успешными профессионалами в&nbsp;самой перспективной отрасли на&nbsp;сегодняшний день&nbsp;&mdash; сфере Информационных технологий.</p>
                      <p class="li-pink" style="font-size:20px;font-weight:bold;color:#E3227F;text-decoration:none;"><nobr>Экспресс-погружение</nobr> в&nbsp;<nobr>IT-бизнес</nobr></p>
                      <p style="padding-left: 30px"><a href="http://riw.moscow/special/riw_for_beginners" target="_blank" class="black-a" style="color:#000000;">&laquo;RIW 4 BEGINNERS / ВВЕДЕНИЕ в&nbsp;DIGITAL&raquo;</a>&nbsp;&mdash; <nobr>Блок-конференция</nobr> для новичков&nbsp;&mdash; три дня <nobr>интернет-ликбеза</nobr> для <nobr>офлайн-специалистов</nobr> и&nbsp;новичков в&nbsp;диджитал.</p>
                      <p style="padding-left: 30px"><a href="http://riw.moscow/special/next" target="_blank" class="black-a" style="color:#000000;">Поколение NEXT</a>&nbsp;&mdash; Первая <nobr>практико-ориентированная</nobr> площадка страны, объединяющая детей, педагогов, а&nbsp;также <nobr>интернет-индустрию</nobr> и&nbsp;власть для совместной работы.</p>
                      <p class="li-pink" style="font-size:20px;font-weight:bold;color:#E3227F;text-decoration:none;">Для <nobr>IT-профессионалов</nobr></p>
                      <p style="padding-left: 30px"><a href="http://riw.moscow/special/userexperience" target="_blank" class="black-a" style="color:#000000;">User eXperience 2016</a>&nbsp;&mdash; Специальная двухдневная <nobr>блок-конференция</nobr> об&nbsp;инновациях в&nbsp;юзабилити.</p>
                      <p style="padding-left: 30px"><a href="http://riw.moscow/program/20161102-520-a3dae" target="_blank" class="black-a" style="color:#000000;">Performance Marketing</a>&nbsp;&mdash; обсуждение главных трендов Performance Marketing и&nbsp;взгляд на&nbsp;направление до&nbsp;2020 года.</p>
                      <p style="padding-left: 30px"><a href="http://riw.moscow/special/next" target="_blank" class="black-a" style="color:#000000;">Поколение NEXT</a>&nbsp;&mdash; Первая <nobr>практико-ориентированная</nobr> площадка страны, объединяющая детей, педагогов, а&nbsp;также <nobr>интернет-индустрию</nobr> и&nbsp;власть для совместной работы.</p>
                      <p style="padding-left: 30px"><a href="http://riw.moscow/special/iot" target="_blank" class="black-a" style="color:#000000;">&laquo;Интернет вещей / Умный город 2016&raquo;</a>&nbsp;&mdash; в&nbsp;рамках выставок <nobr>HI-TECH</nobr> BUILDING, Integrated Systems Russia и&nbsp;RIW состоится важный отраслевой ФОРУМ &laquo;ИНТЕРНЕТ ВЕЩЕЙ В&nbsp;УМНОМ ГОРОДЕ&raquo;, организованный компанией МИДЭКСПО вместе с&nbsp;Ассоциацией электронных коммуникаций РАЭК.</p>
                      <p style="padding-left: 30px">И&nbsp;еще более 20 <nobr>блок-конференций</nobr> в&nbsp;<a href="http://riw.moscow/program" target="_blank" class="black-a" style="color:#000000;">10 параллельных залах</a>.</p>
                      <p class="li-pink" style="font-size:20px;font-weight:bold;color:#E3227F;text-decoration:none;">Взгляд в&nbsp;будущее</p>
                      <p style="padding-left: 30px"><a href="http://riw.moscow/forum/presentation_hall" target="_blank" class="black-a" style="color:#000000;">Presentation Hall</a>&nbsp;&mdash; главный зал и&nbsp;площадка форума RIW 2016, где все 3 дня будут идти выступления <nobr>ТОП-спикеров</nobr>, которые будут представлять разные отрасли, но&nbsp;говорить про роль технологий и&nbsp;будущем этих отраслей. Простым языком о&nbsp;том, что нас ждет в&nbsp;медицине, спорте, найме, телекоме и&nbsp;госуправлении через 5&ndash;10 лет.</p>
                      <p style="padding-top: 10px">Различные уровни программы имеют различную политику доступа участников (открыто для всех или только для проф.участников, бесплатно или платно <nobr>и т. д.</nobr>).</p>
                      <p>Чтобы принять участие в&nbsp;выставке (бесплатно) или в&nbsp;Проф.программе&nbsp;&mdash; необходима РЕГИСТРАЦИЯ УЧАСТИЯ.</p>
                      <p style="padding-bottom: 10px">Для подтверждения регистрации на&nbsp;RIW 2016&nbsp;&mdash; нажмите на&nbsp;кнопку ниже:</p>
                        								
                      <p align="center">
                        <a href="<?=$link?>" target="_blank" class="btn-pink" style="background-color:#E3227F;color:#FFFFFF;font-size:16px;padding:10px 20px;text-decoration:none;display:inline-block;">РЕГИСТРАЦИЯ</a>
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
          <table class="content section-white" align="center" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;position:relative;background-color:#ffffff;">
            <tr class="wrapper" style="padding:20px 33px;">
              <td valign="top" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/%D0%A0%D0%B0%D1%81%D1%81%D1%8B%D0%BB%D0%BA%D0%B0/riw2016-20161018.png" width="600" class="head-img" style="width:100%;display:block;"/>
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
              <td class="wrapper section-white" style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;padding:20px 33px;background-color:#ffffff;padding-bottom: 0; padding-top: 5px;">
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
                      <p class="h3" align="center" style="font-size:1.45em;font-weight:bold;display:block;">Хотите иметь возможность участия без ограничений?</p>
                      <p align="center">
                        <a href="<?=$link?>" target="_blank" class="btn-pink" style="background-color:#E3227F;color:#FFFFFF;font-size:16px;padding:10px 20px;text-decoration:none;display:inline-block;">РЕГИСТРАЦИЯ ПРОФ.УЧАСТИЯ&nbsp;&mdash; В&nbsp;ОДИН КЛИК</a>
                      </p>
                      <p style="padding-top: 10px">Чтобы быть в&nbsp;курсе новостей и&nbsp;спецпредложений партнеров RIW и&nbsp;принять решение об&nbsp;участии в&nbsp;том или ином статусе&nbsp;&mdash; рекомендуем <a href="http://riw.moscow/info/partners/list" target="_blank" class="black-a" style="color:#000000;">подписаться на&nbsp;новости Клуба</a>.</p>
                      <p>Раздел постоянно пополняется новыми предложениями и&nbsp;спецакциями!<br/>
Следите за&nbsp;новостями!</p>
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