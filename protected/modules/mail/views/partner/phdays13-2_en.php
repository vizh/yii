<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>
  <table style="width: 660px;  color: #4e4e4e; font-family: tahoma; font-size: 14px; background-color: #EDEDED; background-position: center -70px; padding-left: 20px; padding-right: 20px;" cellpadding="0" cellspacing="0">
    <tr>
      <td>
        <table style="width: 100%;" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" style="padding-top: 10px; padding-bottom: 10px;"><img src="http://runet-id.com/images/mail/phdays13/ticket/logo_en.jpg" style="float: left;"/></td>
          </tr>
          <tr>
            <td style="padding-top: 20px; padding-left: 30px; padding-right: 30px; background-color: #ffffff">
              <table style="width: 100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td>
                    <span style="color: #E11D21; font-size: 35px; font-weight: bold;">Electronic Ticket &mdash;<br/> Positive Hack Days</span>
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
                          <span style="color: #000000; font-size: 30px; font-weight: bold;"><?=$user->getFullName()?></span>
                        </td>
                        <td valign="top" style="padding-right: 20px;">
                          <span style="margin-top: 15px; display: block; width: 120px; text-align: center; padding-top: 5px; padding-bottom: 5px; background-color: #D52120; color: #ffffff; text-transform: uppercase;"><?=\Yii::t('app', $role->Title)?></span>
                        </td>
                        <td valign="top" style="background: #f6f6f6; padding: 10px; text-align: center; width: 100px;" align="right">
                          <img src="<?=\ruvents\components\QrCode::getAbsoluteUrl($user)?>"/>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td align="right" style="padding-top: 5px;">RUNET&mdash;ID <a href="<?=$user->getUrl()?>" style="color: #D14852;"><?=$user->RunetId?></a></td>
                </tr>
                <tr>
                  <td style="padding-top: 30px;">
                    <table style="width: 100%;" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="50%" style="background-color: #ececec; padding: 5px;">
                          <strong>Registration time</strong><br/>
                          <span style="font-size: 80%;">From 8.30 a.m. to 5 p.m. on May 23-24</span>
                        </td>
                        <td width="50%" align="right">
                          <a href="http://www.phdays.ru/program/" style="display: block; background-image: url('http://runet-id.com/images/mail/phdays13/ticket/program-link_bg.gif'); background-repeat: no-repeat; color: #ffffff; text-transform: uppercase; padding: 6px 0; width: 237px; text-align: center;">CONFERENCE PROGRAM</a>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td style="padding-top: 10px;">
                    <hr size="1" color="#d2d2d2" />
                  </td>
                </tr>
                <tr>
                  <td>
                    <span style="color: #D22117; font-size: 35px; font-weight: bold;">Sponsors and exhibitors</span>
                  </td>
                </tr>
                <tr>
                  <td>
                    <table style="width: 100%; padding-top: 30px;" cellpadding="0" cellspacing="0">
                      <tr>
                        <td style="width: 25%; text-align: center;"><img src="http://runet-id.com/images/mail/phdays13/ticket/partners/kaspersky.jpg" border="0"/></td>
                        <td style="width: 25%; text-align: center;"><img src="http://runet-id.com/images/mail/phdays13/ticket/partners/EMC2.jpg" border="0"/></td>
                        <td style="width: 25%; text-align: center;"><img src="http://runet-id.com/images/mail/phdays13/ticket/partners/asteros.jpg" border="0"/></td>
                        <td style="width: 25%; text-align: center;"><img src="http://runet-id.com/images/mail/phdays13/ticket/partners/cisco.jpg" border="0"/></td>
                      </tr>
                    </table>
                    <table style="width: 100%; margin-top: 30px;" cellpadding="0" cellspacing="0">
                      <tr>
                        <td style="width: 25%; text-align: center;"><img src="http://runet-id.com/images/mail/phdays13/ticket/partners/icl.jpg" border="0"/></td>
                        <td style="width: 25%; text-align: center;"><img src="http://runet-id.com/images/mail/phdays13/ticket/partners/set-1.jpg" border="0"/></td>
                        <td style="width: 25%; text-align: center;"><img src="http://runet-id.com/images/mail/phdays13/ticket/partners/pepsi.jpg" border="0"/></td>
                        <td style="width: 25%; text-align: center;"><img src="http://runet-id.com/images/mail/phdays13/ticket/partners/stonesoft.jpg" border="0"/></td>
                      </tr>
                    </table>
                    <table style="width: 100%; margin-top: 30px;" cellpadding="0" cellspacing="0">
                      <tr>
                        <td style="width: 25%; text-align: center;"><img src="http://runet-id.com/images/mail/phdays13/ticket/partners/elvis.jpg" border="0"/></td>
                        <td style="width: 25%; text-align: center;"></td>
                        <td style="width: 25%; text-align: center;"></td>
                        <td style="width: 25%; text-align: center;"></td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td style="padding-top: 10px;">
                    <hr size="1" color="#d2d2d2" />
                  </td>
                </tr>
                <tr>
                  <td>
                    <span style="color: #D22117; font-size: 35px; font-weight: bold;">Media partners</span>
                  </td>
                </tr>
                <tr>
                  <td>
                    <table style="width: 100%; margin-top: 30px;" cellpadding="0" cellspacing="0">
                      <tr>
                        <td style="width: 33%; text-align: center;"><img src="http://runet-id.com/images/mail/phdays13/ticket/partners/cnews.jpg" border="0"/></td>
                        <td style="width: 33%; text-align: center;"><img src="http://runet-id.com/images/mail/phdays13/ticket/partners/xaker.jpg" border="0"/></td>
                        <td style="width: 33%; text-align: center;"><img src="http://runet-id.com/images/mail/phdays13/ticket/partners/anti.jpg" border="0"/></td>
                        <td></td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td style="padding-top: 10px;">
                    <hr size="1" color="#d2d2d2" />
                  </td>
                </tr>
                <tr>
                  <td>
                    <span style="color: #D22117; font-size: 35px; font-weight: bold;">Venue</span>
                  </td>
                </tr>
                <tr>
                  <td style="padding-top: 10px;">
                    <strong>WTC Congress Center, entrance 4</strong><br/>
                    Krasnopresnenskaya Naberezhnaya 12, Moscow, 123610, Russia, tel.: +7 (499) 253 11 40
                  </td>
                </tr>
                <tr>
                  <td style="padding-top: 10px;"><img src="http://runet-id.com/images/mail/phdays13/ticket/map.jpg" border="0"/></td>
                </tr>
                <tr>
                  <td style="padding-top: 20px; padding-bottom: 40px;">
                    <h5>Location:</h5>
                    <h4 style="padding-bottom: 10px; margin: 0;">Metro station Ulitsa 1905 Goda:</h4>
                    Exit to Krasnaya Presnya. Go down the road Ulitsa 1905 Goda from the same name metro station (15-20 minutes of walk to WTC) to Krasnopresnenskaya Naberezhnaya about 1 km. Cross the road using underpass at the intersection with Mantulinskaya Street, turn to the right and go along Mantulinskaya Street approximately 70 meters up to the checkpoint.<br/>
                    Minibus No.423 or bus No.12 to WTC.<br/><br/>
                    <h4 style="padding-bottom: 10px; margin: 0;">Metro station Vystavochnaya:</h4>
                    Exit to Krasnogvardeisky Proezd. Walk 15-20 minutes to WTC.
                  </td>
                </tr>
                <tr>
                  <td style="background-image: url('http://runet-id.com/images/mail/spic13/ticket/runet-id_logo.gif'); height: 14px; background-repeat: no-repeat; padding-bottom: 80px;"></td>
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