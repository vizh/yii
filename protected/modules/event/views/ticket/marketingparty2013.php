<?php
/**
 * @var \event\models\Event $event
 * @var \event\models\Role $role
 * @var \user\models\User $user
 * @var \pay\models\OrderItem[] $orderItems
 */
$mask = ['1387' => 17, '1391' => 18, '1392' => 19];
$lunchDays = [];
foreach ($orderItems as $item)
{
  if (isset($mask[$item->ProductId]))
  {
    $lunchDays[] = $mask[$item->ProductId];
  }
}
sort($lunchDays, SORT_NUMERIC);
?>

<style type="text/css">
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
  /*body {line-height: 1;}*/
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
  }

  /* Styles */
  body {
    margin: 0;
    padding: 0;
    font-size: 13px;
    font-family: Helvetica, Arial, sans-serif;
  }

  a {color: #00a8ca;}
  a:hover {text-decoration: none;}

  h1 {font-size: 50px;}
  h2 {font-size: 35px;}
  h3 {
    font-size: 19px;
    line-height: 1.25;
  }
  h2, h3 {font-weight: normal;}

  p, li {line-height: 1.5;}

  img, td {vertical-align: top;}

  table {
    width: 740px;
    margin: 0 auto;
  }

  ul {
    margin-left: 20px;
  }

  .role {
    margin-top: 15px;
    margin-bottom: 10px;
    display: block;
    /*width: 140px;*/
    text-align: center;
    padding: 2px 0;
    background-color: #4f4f4f;
    color: #ffffff;
    text-transform: uppercase;
  }
  .extra_pay {
    margin-top: 5px;
    display: block;
    /*width: 140px;*/
    text-align: center;
    padding: 2px 0;
    background-color: #4481A4;
    color: #ffffff;
  }
  a.program-btn {
    background: transparent url("http://runet-id.com/images/mail/riw13/program_bg.png") no-repeat;
    color: #FFFFFF;
    display: block;
    font-size: 12px;
    height: 26px;
    line-height: 24px;
    margin-top: 12px;
    text-align: center;
    text-transform: uppercase;
    width: 192px;
  }
</style>

<body>
  <table style="width: 660px;  color: #4e4e4e; font-family: tahoma; font-size: 14px; background-color: #F6F6F6; background-repeat: no-repeat; background-position: center -70px; padding-left: 20px; padding-right: 20px; padding-bottom: 20px; border: 20px solid #000;" cellpadding="0" cellspacing="0">
    <tr>
      <td>
        <table style="width: 100%;" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center"><img src="http://runet-id.com/images/mail/marketingparty2013/marketing-header.jpg" /></td>
          </tr>
          <tr>
            <td style="padding-top: 20px; padding-left: 30px; padding-right: 30px; background-color: #ffffff">
              <table style="width: 100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td>
                    <span style="font-size: 35px; font-weight: bold;">Путевой лист &mdash;<br/>Вечеринка для маркетинг директоров</span>
                  </td>
                </tr>
                <tr>
                  <td style="padding-top: 10px;">
                    <hr size="1" color="#d2d2d2" />
                  </td>
                </tr>
                <tr>
                  <td>
                    <table style="width: 100%" cellpadding="0" cellspacing="0">
                      <tr>
                        <td valign="top" style="width: 270px; padding-right: 20px;">
                          <div style="color: #000; font-size: 30px; font-weight: bold; line-height: 35px;"><?=$user->getFullName();?></div>
                          <div style="font-size: 12px; margin-top: 5px;"><?=$user->getEmploymentPrimary();?></div>
                        </td>
                        <td valign="top" style="padding-right: 20px; width: 205px; font-size: 12px;">
                          <div class="role"><?=$role->Title;?></div>
                        </td>
                        <td valign="top" style="background: #f6f6f6; padding: 10px; text-align: center;" align="right">
                          <img src="<?=\ruvents\components\QrCode::getAbsoluteUrl($user,120);?>" />
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td align="right" style="padding-top: 5px;">RUNET&mdash;ID <a href="<?=$user->getUrl();?>" style="color: #339dd5;"><?=$user->RunetId;?></a></td>
                </tr>
                <tr>
                  <td style="padding-top: 30px;">
                    <table style="width: 100%;" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="65%" style="background-color: #ececec; padding: 5px;">
                          <strong>Время работы стойки регистрации</strong><br/>
                          <span style="font-size: 80%;">17 октября 09:00-17:00 / 18 октября 10:00-17:00 / 19 октября 10:00-17:00</span>
                        </td>
                        <td align="right">
                          <a href="http://runet-id.com/event/marketingparty2013/" target="_blank" class="program-btn">ПРОГРАММА</a>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td style="text-align: center; padding-top: 20px;">
                    <img src="http://runet-id.com/images/mail/riw13/warning.png" />
                  </td>
                </tr>
                <tr>
                  <td style="padding-top: 10px;">
                    <hr size="1" color="#d2d2d2" />
                  </td>
                </tr>
                <tr>
                  <td>
                    <span style="font-size: 35px; font-weight: bold;">Место проведения</span>
                  </td>
                </tr>
                <tr>
                  <td style="padding-top: 10px;">
                    <p>г. Москва, Кудринская площадь, д. 1, Simon Says</p>
                    <p>По всем вопросам: +7 (916) 709-69-71, index@rta-moscow.com</p>
                  </td>
                </tr>
                <tr>
                  <td style="padding-top: 10px; text-align: center;"><img src="http://runet-id.com/images/mail/marketingparty2013/map.jpg" border="0"/></td>
                </tr>
                <tr>
                  <td style="text-align: center; padding: 20px;">
                    <img src="http://runet-id.com/images/mail/spic13/ticket/runet-id_logo.gif" />
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
