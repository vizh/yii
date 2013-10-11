<?php
/**
 * @var \event\models\Event $event
 * @var \event\models\Role $role
 * @var \user\models\User $user
 * @var \pay\models\OrderItem[] $orderItems
 */
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
    display: block;
    width: 120px;
    text-align: center;
    padding-top: 5px;
    padding-bottom: 5px;
    background-color: #4f4f4f;
    color: #ffffff;
    text-transform: uppercase;
  }
  .extra_pay {
    margin-top: 5px;
    display: block;
    width: 120px;
    text-align: center;
    padding-top: 5px;
    padding-bottom: 5px;
    background-color: #4f4f4f;
    color: #ffffff;
  }
</style>

<body>
  <table style="width: 660px;  color: #4e4e4e; font-family: tahoma; font-size: 14px; background-color: #F6F6F6; background-repeat: no-repeat; background-position: center -70px; padding-left: 20px; padding-right: 20px; padding-bottom: 20px; border: 20px solid #F6F6F6;" cellpadding="0" cellspacing="0">
    <tr>
      <td>
        <table style="width: 100%;" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center"><img src="http://runet-id.com/images/mail/riw13/riw13-header1.png" /></td>
          </tr>
          <tr>
            <td style="padding-top: 20px; padding-left: 30px; padding-right: 30px; background-color: #ffffff">
              <table style="width: 100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td>
                    <span style="font-size: 35px; font-weight: bold;">Путевой лист &mdash;<br/>Russian Internet Week 2013</span>
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
                          <div style="font-size: 30px; font-weight: bold; line-height: 35px;"><?=$user->getFullName();?></div>
                          <div style="font-size: 12px; margin-top: 5px;"><?=$user->getEmploymentPrimary();?></div>
                        </td>
                        <td valign="top" style="padding-right: 20px;">
                          <div class="role"><?=$role->Title;?></div>

                          <?if (count($orderItems) > 0):?>
                            <div class="extra_pay"><p>БИЗНЕС-ЛАНЧ*</p></div>
                            <?foreach($orderItems as $item):?>
                              <?if ($day = array_search($item->ProductId, array(17 => 1387,18 => 1391,19 => 1392))):?>
                                <div class="extra_pay" style="float: left; margin-right: 5px; width: auto; padding: 5px;"><?=$day?></div>
                              <?endif;?>
                            <?endforeach;?>
                            <div style="clear: both;"></div>
                            <small>*при утрате карточка на бизнес-ланч не востанавливается</small>
                          <?endif;?>
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
                        <td width="50%" style="background-color: #ececec; padding: 5px;">
                          <strong>Время работы регистрации</strong><br/>
                          <span style="font-size: 80%;">
                            17 октября 09:00-17:00<br/>
                            18 октября 10:00-17:00<br/>
                            19 октября 10:00-17:00
                          </span>
                        </td>
                        <td width="50%" align="right">
                          <a href="http://2013.russianinternetweek.ru/program/" target="_blank" style="display: block; background-image: url('http://runet-id.com/images/mail/download13/program-link_bg.png'); background-repeat: no-repeat; color: #ffffff; text-transform: uppercase; padding: 6px 0; width: 237px; height: 19px; text-align: center;">ПРОГРАММА КОНФЕРЕНЦИИ</a>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td style="text-align: center; padding-top: 20px;">
                    <div style="background: #EA1E1E; color: #FFFFFF; font-weight: bold; padding: 5px 10px;">Для регистрации необходимо предъявить данный путевой лист, либо документ, удостоверяющий личность</div>
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
                    <p><b>Центральный выставочный комплекс «Экспоцентр».</b></p>
                    <p>Москва, м. Выставочная, Краснопресненская наб., 14</p>
                    <p>Телефон оргкомитета:<br/>+7 (985) 876-82-41<br/>+7 (985) 876-89-56</p>
                  </td>
                </tr>
                <tr>
                  <td style="padding-top: 10px; text-align: center;"><img style="border: 1px solid;" src="http://runet-id.com/images/mail/riw13/riw13-map.jpg" border="0"/></td>
                </tr>
                <tr>
                  <td style="text-align: center; padding: 30px;">
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
