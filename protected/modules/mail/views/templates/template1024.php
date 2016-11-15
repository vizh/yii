<?php
$regLink = "http://2016.sp-ic.ru/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'xggMpIQINvHqR0QlZgZa'), 0, 16) . '&redirect=http://2016.sp-ic.ru/vote/';
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
                    <h2 style='margin:0;padding:0;color:#111111;font-family:"Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;font-weight:200;line-height:1.2em;margin:10px 0;font-size:28px;color: #ffffff'><?=$user->getShortName();?>, здравствуйте!</h2>
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
                    <p style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px">Спасибо за&nbsp;Ваше участие в&nbsp;Санкт-Петербургской интернет конференции (СПИК 2016), проходившей <nobr style="margin:0;padding:0">30-31</nobr> мая 2016. </p>
                    <p style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px">Мы&nbsp;высоко ценим мнение каждого участника Конференции и&nbsp;будем признательны, если вы&nbsp;<b style="margin:0;padding:0">уделите 5&nbsp;минут своего времени</b>, чтобы принять участие в&nbsp;итоговом опросе участников.</p>
                    <p style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px">Результаты опроса обязательно будут учитываться при подготовке СПИК 2017.</p>
                    <table class="btn-primary" cellpadding="0" cellspacing="0" border="0" style="margin:0;padding:0;margin-bottom:10px;width:auto;width:100%;margin: 15px auto; width: auto;">
                      <tr style="margin:0;padding:0">
                        <td style='margin:0;padding:0;background-color:#F49900;font-family:"Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;font-size:14px;text-align:center;vertical-align:top'>
                          <a href="<?=$regLink?>" style="margin:0;padding:0;color:#F49900;background-color:#F49900;border:solid 1px #F49900;border-width:10px 20px;display:inline-block;color:#ffffff;cursor:pointer;font-weight:bold;line-height:2;text-decoration:none">ПРОЙТИ ОПРОС »</a>
                        </td>
                      </tr>
                    </table>
                    <hr style="margin:0;padding:0;border:0;border-top:1px solid #eaeaea;height:1px;margin:35px auto">
                    <p style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px">Прямо сейчас мы активно занимаемся обработкой итоговых материалов и постараемся выложить их в полном объеме в течение недели.</p>
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