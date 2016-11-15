<?php
$regLink = "http://2016.sp-ic.ru/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'xggMpIQINvHqR0QlZgZa'), 0, 16);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Напоминаем вам, что Санкт-Петербургская интернет-конференция состоится 30-31 мая (понедельник, вторник).</title>
    <style type="text/css">
      @media only screen and (max-width: 480px)  {
      	.content .img-right {
      		float: none;
      		height: auto;
      		margin: 15px 0;
      		width: 100%;
      	}
        .full {
          display: block !important;
          width: 100%  !important;
        }
        .full-hidden {
          display: none !important;
          height: 0 !important;
          width: 0% !important;
          visibility: hidden !important;
        }
      }
    </style>
  </head>
  <body bgcolor="#F49900" style='margin:0;padding:0;-webkit-font-smoothing:antialiased;height:100%;-webkit-text-size-adjust:none;font-family:"Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;font-size:14px;line-height:1.5em;width:100% !important'>
    <div id="wrapper" style="background-color:#F49900;height:100%;margin:0;padding:0;width:100%">
      <!-- unboxed -->
      <table class="unboxed-wrap" bgcolor="#F49900" style="margin:0;padding:0;padding:25px 0;width:100%;clear:both !important;margin-top: 25px">
        <tr style="margin:0;padding:0">
          <td style="margin:0;padding:0;vertical-align:top"></td>
          <td class="container" style="margin:0;padding:0;vertical-align:top;clear:both !important;display:block !important;margin:0 auto !important;max-width:600px !important">
            <!-- content -->
            <div class="content" style="margin:0;padding:0;display:block;margin:0 auto;max-width:600px">
              <table style="margin:0;padding:0;width:100%">
                <tr style="margin:0;padding:0">
                  <td align="center" style="margin:0;padding:0;vertical-align:top">
                    <h2 style='margin:0;padding:0;color:#111111;font-family:"Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;font-weight:200;line-height:1.2em;margin:10px 0;font-size:28px;color: #ffffff'>Здравствуйте, <?= $user->getShortName(); ?>!</h2>
                    <p class="lead" style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px;font-size:17px;color: #ffffff">Важная информация для участников СПИК 2016 (30-31 мая).</p>
                  </td>
                </tr>
              </table>
            </div>
            <!-- /content -->
          </td>
          <td style="margin:0;padding:0;vertical-align:top"></td>
        </tr>
      </table>
      <!-- /unboxed -->
      <!-- body -->
      <table class="body-wrap" bgcolor="#F49900" style="padding:0;border-collapse:collapse;margin:0;padding:20px;width:100%">
        <tr class="clear-padding" style="margin:0;padding:0">
          <td style="margin:0;padding:0;vertical-align:top;line-height:0 !important;padding:0 !important"></td>
          <td class="container-image" style="margin:0;padding:0;vertical-align:top;clear:both !important;display:block !important;margin:0 auto !important;max-width:642px !important;line-height:0 !important;padding:0 !important">
            <a href="http://2016.sp-ic.ru" style="margin:0;padding:0;color:#F49900;line-height: 0 !important;"><img src="https://showtime.s3.amazonaws.com/201605272029-spic16-header.png" style="margin:0;padding:0;height: auto; width: 100%;" alt=""></a>
          </td>
          <td style="margin:0;padding:0;vertical-align:top;line-height:0 !important;padding:0 !important"></td>
        </tr>
        <tr style="margin:0;padding:0">
          <td style="margin:0;padding:0;vertical-align:top"></td>
          <td class="container" bgcolor="#FFFFFF" style="margin:0;padding:0;vertical-align:top;padding:20px;clear:both !important;display:block !important;margin:0 auto !important;max-width:600px !important">
            <!-- content -->
            <div class="content" style="margin:0;padding:0;display:block;margin:0 auto;max-width:600px">
              <table style="margin:0;padding:0;width:100%">
                <tr style="margin:0;padding:0">
                  <td style="margin:0;padding:0;vertical-align:top">
                    <p style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px">Напоминаем вам, что Санкт-Петербургская интернет-конференция состоится <b style="margin:0;padding:0">30-31 мая</b> (понедельник, вторник) по адресу <b style="margin:0;padding:0">г. Санкт-Петербург, ул. Кораблестроителей, д. 14</b> (гостиница «Прибалтийская Park Inn»).</p>
                    <p style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px"> Для максимально быстрой регистрации на&nbsp;мероприятии распечатайте, пожалуйста, ваш электронный билет.</p>
                    <table class="btn-primary" cellpadding="0" cellspacing="0" border="0" style="margin:0;padding:0;margin-bottom:10px;width:auto;width:100%;margin: 15px auto; width: auto;">
                      <tr style="margin:0;padding:0">
                        <td style='margin:0;padding:0;background-color:#F49900;font-family:"Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;font-size:14px;text-align:center;vertical-align:top'>
                          <a href="<?=$user->Participants[0]->getTicketUrl();?>" style="margin:0;padding:0;color:#F49900;background-color:#F49900;border:solid 1px #F49900;border-width:10px 20px;display:inline-block;color:#ffffff;cursor:pointer;font-weight:bold;line-height:2;text-decoration:none">ЭЛЕКТРОННЫЙ БИЛЕТ</a>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </div>
            <!-- /content -->
          </td>
          <td style="margin:0;padding:0;vertical-align:top"></td>
        </tr>
      </table>
      <!-- /body -->
      <br style="margin:0;padding:0">
      <!-- body -->
      <table class="body-wrap" bgcolor="#F49900" style="padding:0;border-collapse:collapse;margin:0;padding:20px;width:100%">
        <tr style="margin:0;padding:0">
          <td style="margin:0;padding:0;vertical-align:top"></td>
          <td class="container" bgcolor="#FFFFFF" style="margin:0;padding:0;vertical-align:top;padding:20px;clear:both !important;display:block !important;margin:0 auto !important;max-width:600px !important">
            <!-- content -->
            <div class="content" style="margin:0;padding:0;display:block;margin:0 auto;max-width:600px">
              <table style="margin:0;padding:0;width:100%">
                <tr style="margin:0;padding:0">
                  <td style="margin:0;padding:0;vertical-align:top">
                    <h3 style='margin:0;padding:0;color:#111111;font-family:"Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;font-weight:200;line-height:1.2em;margin:10px 0;color:#F49900;font-size:22px;font-weight:bold;text-transform:uppercase'>Краткая памятка участника:</h3>
                    <ul style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px">
                      <li style="margin:0;padding:0;margin-left:25px;list-style-position:outside">
                        <p style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px">Даты проведения конференции <strong style="margin:0;padding:0"><nobr style="margin:0;padding:0">30-31</nobr> мая 2016&nbsp;г</strong>., понедельник-вторник. СПИК 2016 пройдет по&nbsp;адресу: <strong style="margin:0;padding:0">ул. Кораблестроителей, </strong><strong style="margin:0;padding:0">д.&nbsp;14</strong>, гостиница «Прибалтийская Park Inn». У&nbsp;отеля имеется платная парковка: 150 руб./сутки. Ближайшая станция метро «Приморская».</p>
                      </li>
                    </ul>
                    <ul style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px">
                      <li style="margin:0;padding:0;margin-left:25px;list-style-position:outside">
                        <p style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px"><strong style="margin:0;padding:0">Начало регистрации в&nbsp;9:00.</strong> Регистрация будет работать весь день до&nbsp;17:00, вы&nbsp;можете подойти в&nbsp;любое удобное вам время. Для прохода на&nbsp;конференцию покажите сотрудникам на&nbsp;стойке регистрации распечатанный электронный билет (или его электронную версию на&nbsp;экране телефона). Там&nbsp;же вы&nbsp;получите бейдж участника и&nbsp;раздаточные материалы. Чтобы потратить на&nbsp;регистрацию как можно меньше времени, рекомендуем приезжать заранее.</p>
                      </li>
                    </ul>
                    <ul style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px">
                      <li style="margin:0;padding:0;margin-left:25px;list-style-position:outside">
                        <p style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px"><a href="http://2016.sp-ic.ru/program/" style="margin:0;padding:0;color:#F49900"><strong style="margin:0;padding:0">Подробная программа</strong></a> доступна на&nbsp;сайте. Начало деловой программы в&nbsp;первый день&nbsp;— в&nbsp;10:00, во&nbsp;второй&nbsp;— в&nbsp;11:00. Выступления будут идти параллельно в&nbsp;5&nbsp;потоках. Рекомендуем вам заранее ознакомиться с&nbsp;программой, чтобы спланировать посещение конференции максимально эффективно. </p>
                      </li>
                    </ul>
                    <ul style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px">
                      <li style="margin:0;padding:0;margin-left:25px;list-style-position:outside">
                        <p style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px">Во&nbsp;время мероприятия будет проводиться <strong style="margin:0;padding:0">2&nbsp;кофе-брейка</strong>. Питание во&nbsp;время обеденного перерыва не&nbsp;включено в&nbsp;программу мероприятия. Пообедать вы&nbsp;сможете в&nbsp;любом заведении отеля.</p>
                      </li>
                    </ul>
                    <ul style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px">
                      <li style="margin:0;padding:0;margin-left:25px;list-style-position:outside">
                        <p style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px">Если вы&nbsp;уже приобрели билет на&nbsp;<a href="http://2016.sp-ic.ru/about/afterparty/" style="margin:0;padding:0;color:#F49900"><strong style="margin:0;padding:0">вечернее мероприятие</strong></a> первого дня СПИК, получите при регистрации на&nbsp;конференцию свое приглашение: вход будет осуществляться по&nbsp;ним. Хотите принять участие, но&nbsp;еще не&nbsp;успели оплатить? Торопитесь, билет можно успеть купить в&nbsp;<a href="<?=$regLink?>" style="margin:0;padding:0;color:#F49900"><strong style="margin:0;padding:0">личном кабинете</strong></a>! Начало в&nbsp;20.00, ресторан CheerDuck (5&nbsp;минут от&nbsp;места проведения конференции).</p>
                      </li>
                    </ul>
                    <ul style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px">
                      <li style="margin:0;padding:0;margin-left:25px;list-style-position:outside">
                        <p style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px"><strong style="margin:0;padding:0">Не&nbsp;забудьте взять с&nbsp;собой визитки!</strong> Они помогут вам найти новые деловые контакты и&nbsp;принять участие в&nbsp;розыгрыше призов на&nbsp;выставке.</p>
                      </li>
                    </ul>
                    <ul style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px">
                      <li style="margin:0;padding:0;margin-left:25px;list-style-position:outside">
                        <p style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px"><a href="http://eventicious.com/spic/ru" style="margin:0;padding:0;color:#F49900"><strong style="margin:0;padding:0">Установите приложение СПИК</strong></a> для смартфонов и&nbsp;планшетов, чтобы быть в&nbsp;курсе всех событий и&nbsp;назначать встречи коллегам! Кстати, здесь&nbsp;же вы&nbsp;можете составить «свою» программу из&nbsp;выбранных для посещения секций.</p>
                      </li>
                    </ul>
                    <ul style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px">
                      <li style="margin:0;padding:0;margin-left:25px;list-style-position:outside">
                        <p style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px">Презентации всех 5&nbsp;потоков и&nbsp;видеозаписи докладов из&nbsp;1&nbsp;зала будут выложены на&nbsp;сайт конференции после ее&nbsp;окончания. В&nbsp;течение 2-4х дней вы&nbsp;получите об&nbsp;этом уведомление на&nbsp;почту.</p>
                      </li>
                    </ul>
                  </td>
                </tr>
              </table>
            </div>
            <!-- /content -->
          </td>
          <td style="margin:0;padding:0;vertical-align:top"></td>
        </tr>
      </table>
      <!-- /body -->
      <!-- body -->
      <table class="body-wrap" bgcolor="#F49900" style="padding:0;border-collapse:collapse;margin:0;padding:20px;width:100%">
        <tr style="margin:0;padding:0">
          <td style="margin:0;padding:0;vertical-align:top"></td>
          <td class="container" bgcolor="#F49900" style="margin:0;padding:0;vertical-align:top;padding:20px;clear:both !important;display:block !important;margin:0 auto !important;max-width:600px !important">
            <!-- content -->
            <div class="content" style="margin:0;padding:0;display:block;margin:0 auto;max-width:600px">
              <table style="margin:0;padding:0;width:100%">
                <tr style="margin:0;padding:0">
                  <td style="margin:0;padding:0;vertical-align:top;color: #ffffff;">
                    <p class="center" style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px;text-align:center;font-size: 11px; line-height: 1.1; color: #FFFFFF;">С уважением,<br style="margin:0;padding:0">
                      Оргкомитет СПИК 2016<br style="margin:0;padding:0">
                      <a href="http://2016.sp-ic.ru" style="margin:0;padding:0;color:#F49900;color: #ffffff">www.sp-ic.ru</a></p>
                  </td>
                </tr>
              </table>
            </div>
            <!-- /content -->
          </td>
          <td style="margin:0;padding:0;vertical-align:top"></td>
        </tr>
      </table>
      <!-- /body -->
      <br style="margin:0;padding:0">
    </div>
  </body>
</html>