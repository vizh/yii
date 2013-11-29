<?php
/**
 * @var \event\models\Event $event
 * @var \user\models\User $user
 * @var \pay\models\OrderItem[] $orderItems
 * @var \event\models\Participant[] $participants
 * или
 * @var \event\models\Participant $role
 */
?>
<style>
  /* Reset */
  html, body, div, span, h1, h2, h3, h4, h5, h6, p, img, b, i, ol, ul, li, table, caption, tbody, tfoot, thead, tr, th, td {
    margin: 0;
    padding: 0;
    border: 0;
    outline: 0;
    font-size: 100%;
    vertical-align: baseline;
    background: transparent;
  }
  body {line-height: 1;}
  a {
    margin: 0;
    padding: 0;
    font-size: 100%;
    vertical-align: baseline;
    background: transparent;
  }
  table {
    border-collapse: collapse;
    border-spacing: 0;
    margin: 0;
  }

  /* Styles */
  body {
    font-size: 13px;
    font-family: Helvetica, Arial, sans-serif;
  }

  a {color: #00a8ca;}
  a:hover {text-decoration: none;}

  h1, h2, h3, h4, h5 {
    font-weight: normal;
  }
  h1 {font-size: 4em;}
  h2 {font-size: 3em;}
  h3 {font-size: 2em;}
  h4 {font-size: 1.5em;}

  p, li {line-height: 1.5;}
  p {margin: 10px 0;}

  img, td {vertical-align: top;}

  ul,ol {margin-left: 20px;}
  li {margin: 5px 0;}
</style>

<?$detect = Yii::app()->mobileDetect;?>

<body <?if ($detect->isMobile() === false && $detect->isTablet() === false):?>onload="window.print();<?endif;?>">
  <table align="center" style="margin: 0 auto;">
    <tr>
      <td style="background: #ffffff;">
        <table width="750" height="1060" align="center" cellpadding="0" cellspacing="0" style="position: relative; width: 750px; height: 1060px; border-collapse:collapse; background: url('http://runet-id.com/img/event/beesuper13/beesuper-bg.jpg') no-repeat; font-family: Verdana;">
          <tr style="height: 355px;">
            <td align="left" valign="top">
              <a style="font-family: Verdana; display: block; font-size: 11px; font-style: italic; line-height: 33px; margin-right: 10px; min-height: 43px; padding-right: 60px; text-align: right; text-decoration: none; background: transparent url('http://runet-id.com/img/event/beesuper13/print.png') no-repeat right !important; color: #000000 !important;" href="#" onclick="window.print();">Распечатать</a>
              <div style="margin-top: 120px; margin-left: 45px; padding: 0 10px; width: 385px;">
                <h1 style="font-family: Verdana; font-size: 22px; margin: 0; font-weight: normal; line-height: 28px;">Дорогой коллега,<br/>приглашаем тебя на новогодний<br/>слет супергероев &laquo;Билайн&raquo;!</h1>
                <div style="font-family: Verdana; font-size: 11px; line-height: 19px; margin-top: 12px;">На празднике мы, как всегда, сможем продемонстрировать<br/>свои неограниченные возможности. Вместе вспомним<br/>наши подвиги и достижения уходящего года и зарядимся<br/>суперсилой для исполнения своей миссии в 2014 году!</div>
              </div>
            </td>
          </tr>
          <tr>
            <td align="left" valign="top" style="height: 297px;"><div style="font-family: Verdana; font-size: 16px; line-height: 23px; margin-left: 45px; margin-top: 95px; width: 205px; font-style: italic;">Приходи с позитивным настроем в костюме супергероя:)</div></td>
          </tr>
          <tr>
            <td align="left" valign="top">
              <table width="100%" style="width: 100%;">
                <tr>
                  <td>
                    <div style="font-family: Verdana; font-size: 11px; margin-left: 30px; line-height: 15px; margin-top: 20px; width: 130px;">Новогодний слет<br/>состоится 19 декабря<br/>с 18:00 до 23:00<br/>по адресу:<br/>г.Москва, Болотная<br/>набережная, 3/4<br/>клуб Gipsy</div>
                    <div style="font-family: Verdana; font-size: 11px; margin-left: 30px; line-height: 15px; margin-top: 6px; width: 130px;">GPS координаты:<br/>55.739782 N<br/>37.610134 E</div>
                  </td>
                  <td style="font-family: Verdana; text-align: center; width: 100px; vertical-align: top;">
                    <div><img src="<?=\ruvents\components\QrCode::getAbsoluteUrl($user,100);?>" /><br/><?=$user->RunetId;?></div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td align="left" valign="top">
              <div style="font-size: 11px; margin-left: 30px; margin-top: 25px; width: 205px;">
                <div style="font-family: Verdana; line-height: 15px;">Вход на слет супергероев<br/>будет осуществлен по<br/>индивидуальному QR-коду.</div>
                <div style="font-family: Verdana; line-height: 15px; color: #ffffff; margin-top: 10px;">Просьба при себе иметь<br/>распечатанное или электронное<br/>приглашение и служебный<br/>пропуск. Все QR-коды<br/>персонифицированы, передача<br/>другим сотрудникам невозможна.</div>
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

</body>