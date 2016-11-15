<?php
$regLink = "http://2016.sp-ic.ru/my/?RUNETID=" . $user->RunetId . "&KEY=" . substr(md5($user->RunetId.'xggMpIQINvHqR0QlZgZa'), 0, 16);

$translite = new \ext\translator\Translite();
$reporter = $translite->translit($user->LastName);

$userCode = mb_convert_case('SPIC16_' . $reporter, MB_CASE_UPPER);
$discount = \pay\models\Coupon::model()->byCode($userCode)->byEventId(2386)->find();
if (empty($discount)) {
    $discount = new \pay\models\Coupon();
    $discount->EventId  = 2386;
    $discount->Code = $userCode;
    $discount->Multiple = true;
    $discount->MultipleCount = 50;
    $discount->EndTime  = null;
    $discount->Discount = 30;
//     $discount->Discount = (float) 30 / 100;
    $discount->save();
    
    $product = \pay\models\Product::model()->findByPk(4031);
		$discount->addProductLinks([$product]);
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Спешим поделиться с вами оперативной информацией для подготовки ваших презентаций на 
СПИК 2016!</title>
    <style type="text/css">
      /* Media query */
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
                    <p class="lead" style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px;font-size:17px;color: #ffffff">Спешим поделиться с вами оперативной информацией для подготовки ваших презентаций на СПИК 2016!</p>
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
            <a href="http://2016.sp-ic.ru" style="margin:0;padding:0;color:#F49900;line-height: 0 !important;"><img src="https://showtime.s3.amazonaws.com/201605242331-spic16-header.png" style="margin:0;padding:0;height: auto; width: 100%;" alt=""></a>
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
                    <p style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px">К&nbsp;счастью удалось обновить оборудование в&nbsp;залах до&nbsp;более качественного, в&nbsp;связи с&nbsp;чем вынуждены внести изменения в&nbsp;формат презентации. <strong style="margin:0;padding:0">Соотношение сторон экранов будет 16×9</strong>, а&nbsp;не&nbsp;4×3 (которое сообщали ранее).</p>
                    <p style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px">Приносим свои извинения за&nbsp;то, что информируем об&nbsp;этом перед конференцией, надеемся на&nbsp;ваше понимание!</p>
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
                  <td style="margin:0;padding:0;vertical-align:top">
                    <table style="margin:0;padding:0;width:100%">
                      <tr style="margin:0;padding:0">
                        <td dir="ltr" class="full" style="margin:0;padding:0;vertical-align:top;vertical-align: top;" width="50%">
                          <table class="btn-secondary" cellpadding="0" cellspacing="0" border="0" style="margin:0;padding:0;margin-bottom:10px;width:auto;width:100%;margin: 15px auto; width: auto;">
                            <tr style="margin:0;padding:0">
                              <td style='margin:0;padding:0;background-color:#F49900;font-family:"Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;font-size:14px;text-align:center;vertical-align:top'>
                                <a href="http://2016.sp-ic.ru/about/speakers/" style="margin:0;padding:0;color:#F49900;border:solid 3px #FFFFFF;padding:10px 20px;display:inline-block;color:#FFFFFF;cursor:pointer;font-weight:bold;line-height:2;text-decoration:none">ПАМЯТКА ДОКЛАДЧИКА</a>
                              </td>
                            </tr>
                          </table>
                        </td>
                        <td dir="ltr" class="full" style="margin:0;padding:0;vertical-align:top;vertical-align: top;" width="50%">
                          <table class="btn-secondary" cellpadding="0" cellspacing="0" border="0" style="margin:0;padding:0;margin-bottom:10px;width:auto;width:100%;margin: 15px auto; width: auto;">
                            <tr style="margin:0;padding:0">
                              <td style='margin:0;padding:0;background-color:#F49900;font-family:"Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;font-size:14px;text-align:center;vertical-align:top'>
                                <a href="http://2016.sp-ic.ru/about/moderator/" style="margin:0;padding:0;color:#F49900;border:solid 3px #FFFFFF;padding:10px 20px;display:inline-block;color:#FFFFFF;cursor:pointer;font-weight:bold;line-height:2;text-decoration:none">ПАМЯТКА ВЕДУЩЕГО</a>
                              </td>
                            </tr>
                          </table>
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
                    <p style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px">Также напоминаем:</p>
                    <ul style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px">
                      <li style="margin:0;padding:0;margin-left:25px;list-style-position:outside">
                        <p style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px">Промо-код <span style="margin:0;padding:0;display: inline-block; background-color: #FEF294; padding: 2px 4px; font-weight: bold;"><?=$userCode?></span> предоставляет скидку в&nbsp;30% на&nbsp;участие в&nbsp;конференции, его можно публиковать в&nbsp;открытом доступе и&nbsp;рассылать коллегам и&nbsp;клиентам.</p>
                      </li>
                    </ul>
                    <ul style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px">
                      <li style="margin:0;padding:0;margin-left:25px;list-style-position:outside">
                        <p style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px"><a href="http://eventicious.com/spic/ru" style="margin:0;padding:0;color:#F49900">Мобильное приложение</a> СПИК 2016 доступно для скачивания, используйте этот инструмент для более эффективного участия в&nbsp;мероприятии.</p>
                      </li>
                    </ul>
                    <p style="margin:0;padding:0;font-size:14px;font-weight:normal;margin-bottom:10px">В&nbsp;случае возникновения любых дополнительных вопросов по&nbsp;программе&nbsp;— обращайтесь в&nbsp;Программный комитет: <a href="mailto:prog@sp-ic.ru" style="margin:0;padding:0;color:#F49900">prog@sp-ic.ru</a>.</p>
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