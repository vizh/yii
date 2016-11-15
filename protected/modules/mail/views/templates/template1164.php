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
                      <p><b>Вы&nbsp;&mdash; зарегистрированный участник <a href="http://riw.moscow" target="_blank" class="black-a" style="color:#000000;">RIW&nbsp;2016</a> и&nbsp;<a href="http://riw.moscow" target="_blank" class="black-a" style="color:#000000;">Выставки INTERNET&nbsp;2016</a></b></p>
                    </td>
                  </tr>
                  <tr>
                    <td style="font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:14px;">
                      <p>Важные ссылки, которые помогут Вам подготовиться к&nbsp;участию в&nbsp;RIW (<nobr>1&mdash;3 ноября</nobr>):</p>
                      <p style="padding-left: 30px"><a href="http://riw.moscow/expo/scheme" target="_blank" class="pink-a" style="color:#E3227F;">Выставка INTERNET 2016</a>, доступ к&nbsp;которой имеют все зарегистрированные участники.</p>
                      <p style="padding-left: 30px"><a href="http://riw.moscow/forum/presentation_hall" target="_blank" class="pink-a" style="color:#E3227F;">Впервые на&nbsp;RIW: трехдневный уникальный формат INTERNET. FUTURE. RED DOT</a>&nbsp;&mdash; серия авторских лекций, визионерских выступлений и&nbsp;интервью с&nbsp;харизматичными спикерами&nbsp;&mdash; про БУДУЩЕЕ интернета, коммуникаций, смежных отраслей.</p>
                      <p style="padding-left: 30px"><a href="http://riw.moscow/program" target="_blank" class="pink-a" style="color:#E3227F;">Проф.программа форума RIW 2016</a>&nbsp;&mdash; 9 конференционных залов, около 700 спикеров за&nbsp;3 дня, доступ только для участников со&nbsp;статусом &laquo;Проф.участник RIW 2016&raquo;.</p>
                      <p style="padding-left: 30px"><a href="<?=$link?>" target="_blank" class="pink-a" style="color:#E3227F;">Ваш Личный Кабинет</a> (управление статусом, возможность приобретения &laquo;Проф.участия&raquo;&nbsp;&mdash; в&nbsp;том числе и&nbsp;для Ваших коллег).</p>
                      <p>Конференционная часть (Проф.программа) Russian Interactive Week стала настолько масштабной, что мы&nbsp;решили представить ее&nbsp;в&nbsp;новом формате, таргетировать на&nbsp;группы участников с&nbsp;разной степенью профессиональной подготовки, с&nbsp;разбивкой по&nbsp;10 залам, > 20 <nobr>блок-конференциям</nobr> и&nbsp;темам, а&nbsp;также по&nbsp;24 Экосистемам Рунета.</p>
                      <h3 align="center" style="font-size: 20px">Некоторые акценты программы RIW 2016 – помогут Вам выбрать самое полезное и принять решение о посещении нужных секций</h3>
                      <h3><a class="pink-a" href="http://riw.moscow/program/20161102-520-a3dae#section-3459" target="_blank" style="color:#E3227F;">Уникальная программа Performance Marketing </a></h3>
                      <p style="padding-left: 30px">Мы&nbsp;собрали лучшие доклады со&nbsp;всей отрасли, теперь всю важную и&nbsp;актуальную информацию можно узнать на&nbsp;RIW&nbsp;&mdash; просто посетив соответствующие <nobr>блок-конференции</nobr>.</p>
                      <p style="padding-left: 30px">Многие, говоря о&nbsp;Performance Marketing, привыкли подразумевать <b>контекстную рекламу</b>, на&nbsp;самом деле тема намного шире и&nbsp;включает в&nbsp;себя различные каналы продвижения, позволяет их&nbsp;успешно сочетать для достижения задач и&nbsp;KPI бренда.</p>
                      <p style="padding-left: 30px">В&nbsp;рамках <nobr>блок-конференции</nobr> по&nbsp;Performance Marketing вы&nbsp;узнаете о&nbsp;том, как можно организовать <b><nobr>SEO-продвижение</nobr> без ссылок</b>, что изменилось <b>в&nbsp;поисковых системах</b> в&nbsp;последние годы, как увеличить <b>конверсию</b> в&nbsp;два раза и&nbsp;тайну непорочной <b>оптимизации</b>.</p>
                      <p style="padding-left: 30px">Современный <nobr>digital-менеджер</nobr> сможет лучше разбираться в&nbsp;инструментах <nobr>performance-маркетинга</nobr>, его настройках и&nbsp;метриках после посещения секций RIW.</p>
                      <p style="padding-left: 30px;padding-bottom: 20px"><a href="http://riw.moscow/program/20161102-520-a3dae#section-3459" target="_blank" class="black-a" style="color:#000000;">Подробнее...</a></p>
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
                <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/%D0%A0%D0%B0%D1%81%D1%81%D1%8B%D0%BB%D0%BA%D0%B0/riw2016-20161020-img-3.png" width="600" class="head-img" style="width:100%;display:block;"/>
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
                      <h3><a class="pink-a" href="http://riw.moscow/program/20161102-522-f2e32" target="_blank" style="color:#E3227F;">Технологии для бизнеса</a></h3>
                      <p style="padding-left: 30px">Все, что вы&nbsp;хотели узнать о&nbsp;применении нейронных сетей: распознавание образов, обучение, прогнозирование. Нейронные сети для развлечения, обучения и, конечно, для бизнеса. Кейсы, прогнозы, планы.</p>
                      <p style="padding-left: 30px">Агрегаторы товаров и&nbsp;услуг&nbsp;&mdash; как заставить модель приносить прибыль? Остались&nbsp;ли еще неохваченные ниши? Во&nbsp;что обойдется создание и&nbsp;разработка товарного маркетплейса и&nbsp;высокотехнологичного агрегатора услуг?</p>
                      <p style="padding-left: 30px"><a href="http://riw.moscow/program/20161102-522-f2e32" target="_blank" class="black-a" style="color:#000000;">Подробнее...</a></p>
                      <hr class="yellow" style="background-color:#FFED40;border:none;border-top:solid 1px #FFED40;margin:30px 0;">
                      <h3><a class="pink-a" href="http://riw.moscow/program/20161101-522-a980b#" target="_blank" style="color:#E3227F;">Блок <nobr>e-Commerce</nobr></a></h3>
                      <p style="padding-left: 30px">Тема <b>Электронной Коммерции</b> будет представлена на&nbsp;RIW в&nbsp;разных форматах&nbsp;&mdash; и&nbsp;в&nbsp;программе, и&nbsp;на&nbsp;выставке.</p>
                      <p style="padding-left: 30px">Этой теме посвящены несколько <nobr>блок-конференций</nobr>, где будут затрагиваться вопросы <b>мобильной коммерции</b>, использования <b>SMM в&nbsp;электронных продажах</b>, управления <nobr>бизнес-процессами</nobr>, а&nbsp;также популяризации <nobr>e-commerce</nobr> в&nbsp;сфере малого бизнеса и&nbsp;развитии <b>трансграничных продаж</b> в&nbsp;деятельности <nobr>интернет-магазинов</nobr>.</p>
                      <p style="padding-left: 30px">В&nbsp;дополнении к&nbsp;этому с&nbsp;участием сильнейших игроков рынка состоится профессиональный диалог о&nbsp;том, как работает сегодня сфера <b><nobr>e-Travel</nobr></b>, затрагивающая многие смежные сегменты.</p>
                      <hr class="yellow" style="background-color:#FFED40;border:none;border-top:solid 1px #FFED40;margin:30px 0;">
                      <h3><a class="pink-a" href="http://riw.moscow/special/riw_for_beginners" target="_blank" style="color:#E3227F;">RIW 4 BEGINNERS. Введение в Digital</a></h3>
                      <p style="padding-left: 30px">На&nbsp;<nobr>RIW-2016</nobr> впервые появится целое направление и&nbsp;<nobr>блок-конференция</nobr> для тех, кто не&nbsp;является пока профессионалом в&nbsp;области Digital, а&nbsp;также для <nobr>офлайн-специалистов</nobr>.</p>
                      <p style="padding-left: 30px">Университет <nobr>интернет-профессий</nobr> <b>&laquo;Нетология&raquo;</b> совместно с&nbsp;RIW представляет новую <nobr>блок-конференцию</nobr>: три дня <nobr>интернет-ликбеза</nobr> для <nobr>офлайн-специалистов</nobr> и&nbsp;новичков в&nbsp;диджитал.</p>
                      <p style="padding-left: 30px;padding-bottom: 10px"><a href="http://riw.moscow/special/riw_for_beginners" target="_blank" class="black-a" style="color:#000000;">Подробнее...</a></p>
                      <img src="http://vizh.share.s3.amazonaws.com/ruvents/riw2016/%D0%A0%D0%B0%D1%81%D1%81%D1%8B%D0%BB%D0%BA%D0%B0/riw20161020-img-2.jpg" width="600" class="head-img" style="width:100%;display:block;"/>
														<hr class="yellow" style="background-color:#FFED40;border:none;border-top:solid 1px #FFED40;margin:30px 0;">
                      <h3><a class="pink-a" href="http://riw.moscow/program/20161103-548-d8e5a#section-3479" target="_blank" style="color:#E3227F;">Digital-кластер</a></h3>
                      <p style="padding-left: 30px">Более 10 секций, объединенных в&nbsp;несколько <nobr>блок-конференций</nobr>, организованных под эгидой <nobr>Digital-Кластера</nobr> РАЭК.Все самые горячие <nobr>digital-тренды</nobr> на&nbsp;одной конференции. Лучшие проекты крупнейших игроков, конкретные цифры, подводные камни, находки и&nbsp;лайфхаки.</p>
                      <p style="padding-left: 30px"><a href="http://riw.moscow/program/20161103-548-d8e5a#section-3479" target="_blank" class="black-a" style="color:#000000;">Подробнее...</a></p>
                      <hr class="yellow" style="background-color:#FFED40;border:none;border-top:solid 1px #FFED40;margin:30px 0;">
                      <h3><a class="pink-a" href="http://riw.moscow/program/20161103-525-3070f#section-3927" target="_blank" style="color:#E3227F;">Mobile</a></h3>
                      <p style="padding-left: 30px">Мобайл как главный драйвер <nobr>интернет-рынка</nobr> смог внести огромные коррективы в&nbsp;распределении рекламных бюджетов на&nbsp;различных площадках. Поведение пользователей в&nbsp;мобайле кардинально отличается от&nbsp;поведения в&nbsp;десктопе.</p>
                      <p style="padding-left: 30px">Социальные сети, будучи самыми популярными ресурсами на&nbsp;мобильных устройствах, сосредоточили в&nbsp;себе значительную долю медиапотребления пользователя. Они являются главным фундаментом таргетированной рекламы, и&nbsp;от&nbsp;их&nbsp;развития будет зависеть будущее <nobr>интернет-рынка</nobr>.</p>
                      <p style="padding-left: 30px;padding-bottom: 10px">Сегодня мобильная реклама&nbsp;&mdash; это прерогатива не&nbsp;только топовых брендов и&nbsp;мобильных приложений. Малый / средний бизнес также активно пользуется этим каналом продвижения, применяя адаптивные лендинги и&nbsp;технологию геолокационной рекламы.</p>
                      <p align="center"><a href="http://riw.moscow/program/" target="_blank" class="btn-pink" style="background-color:#E3227F;color:#FFFFFF;font-size:16px;padding:10px 20px;text-decoration:none;display:inline-block;">ПОДРОБНАЯ ПРОГРАММА</a></p>
                      <hr class="yellow" style="background-color:#FFED40;border:none;border-top:solid 1px #FFED40;margin:30px 0;">
                      <h3>ВНИМАНИЕ!</h3>
                      <p>Принять участие в&nbsp;Проф.программе могут только участники со&nbsp;статусом &laquo;Проф.участник&raquo;.</p>
                      <p>Оплата Проф.участия от&nbsp;юридических лиц <b>по&nbsp;безналичному расчёту</b>&nbsp;&mdash; принимается до&nbsp;<b>28 октября (пятница)</b>, в&nbsp;дальнейшем сохранится возможность оплаты всеми&nbsp;другими способами (банковские карты, электронные деньги).</p>
                      <p>Стоимость участия: 8&nbsp;000&nbsp;рублей, включая все налоги&nbsp;&mdash; за&nbsp;безлимитное посещение всех 10 залов Форума и&nbsp;4 <nobr>Бизнес-зоны</nobr> в&nbsp;течение всех дней. Принимаются все виды платежей, включая пластиковые карты, электронные деньги, безналичные платежи.</p>
                      <p>Оплатить участие в&nbsp;Форуме (включая возможность оплаты участия Ваших коллег) Вы&nbsp;можете в&nbsp;Вашем <a href="" target="_blank" class="black-a" style="color:#000000;">Личном кабинете</a>.</p>
                      <p align="center" style="padding: 10px 0"><a href="<?=$link?>" target="_blank" class="btn-pink" style="background-color:#E3227F;color:#FFFFFF;font-size:16px;padding:10px 20px;text-decoration:none;display:inline-block;">ОПЛАТИТЬ УЧАСТИЕ</a></p>
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