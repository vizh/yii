<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>
  <table style="width: 660px;  color: #4e4e4e; font-family: tahoma; font-size: 14px; background-color: #F6F6F6; background-repeat: no-repeat; background-position: center -70px; padding-left: 20px; padding-right: 20px; padding-bottom: 20px;" cellpadding="0" cellspacing="0">
    <tr>
      <td>
        <table style="width: 100%;" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center"><img src="http://runet-id.com/images/mail/next13/header.png" style="float: left;"/></td>
          </tr>
          <tr>
            <td style="padding-top: 20px; padding-left: 30px; padding-right: 30px; background-color: #ffffff">
              <table style="width: 100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td>
                    <span style="color: #942A83; font-size: 35px; font-weight: bold;">Путевой лист &mdash;<br/>конференция Поколение NEXT</span>
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
                          <span style="color: #000000; font-size: 30px; font-weight: bold;"><?=$user->getFullName()?></span><br/><span style="font-size: 12px;"><?=$user->getEmploymentPrimary()?></span>
                        </td>
                        <td valign="top" style="padding-right: 20px;">
                          <span style="margin-top: 15px; display: block; width: 120px; text-align: center; padding-top: 5px; padding-bottom: 5px; background-color: #942A83; color: #ffffff; text-transform: uppercase;"><?=$role?></span>
                        </td>
                        <td valign="top" style="background: #f6f6f6; padding: 10px; text-align: center;" align="right">
                          <img src="<?=\ruvents\components\QrCode::getAbsoluteUrl($user)?>" />
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td align="right" style="padding-top: 5px;">RUNET&mdash;ID <a href="<?=$user->getUrl()?>" style="color: #942A83;"><?=$user->RunetId?></a></td>
                </tr>
                <tr>
                  <td style="padding-top: 30px;">
                    <table style="width: 100%;" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="50%" style="background-color: #ececec; padding: 5px;">
                          <strong>Время работы регистрации</strong><br/>
                          <span style="font-size: 80%;">26 сентября с 09:00-17:00</span>
                        </td>
                        <td width="50%" align="right">
                          <a href="http://runet-id.com/event/next2013/" style="display: block; background-image: url('http://runet-id.com/images/mail/next13/program-link_bg.png'); background-repeat: no-repeat; color: #ffffff; text-transform: uppercase; padding: 6px 0; width: 237px; min-height: 19px; text-align: center;">ПРОГРАММА КОНФЕРЕНЦИИ</a>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td style="text-align: center; padding-top: 20px;">
                    <img src="http://runet-id.com/images/mail/next13/warning.png">
                  </td>
                </tr>
                <tr>
                  <td style="padding-top: 10px;">
                    <hr size="1" color="#d2d2d2" />
                  </td>
                </tr>
                <tr>
                  <td>
                    <span style="color: #942A83; font-size: 35px; font-weight: bold;">Место проведения</span>
                  </td>
                </tr>
                <tr>
                  <td style="padding-top: 10px;">
                    <b>Международный мультимедийный пресс-центр (ММПЦ) РИА Новости</b><br/>
                    119021, Москва, м.Парк Культуры, Зубовский бульвар, 4<br/> Тел.: +7 (495) 645-6472
                  </td>
                </tr>
                <tr>
                  <td style="padding-top: 10px;"><img src="http://runet-id.com/images/mail/next13/map.jpg" border="0"/></td>
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
</html>