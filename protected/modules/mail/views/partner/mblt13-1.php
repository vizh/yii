<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>
  <table style="width: 660px;  color: #4e4e4e; font-family: tahoma; font-size: 14px; background-color: #ECECEC; background-position: center -70px; padding-left: 20px; padding-right: 20px;" cellpadding="0" cellspacing="0">
    <tr>
      <td>
        <table style="width: 100%;" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" style="padding-top: 10px; padding-bottom: 30px;"><img src="http://runet-id.com/images/mail/mblt13/ticket/logo.jpg" style="float: left;"/></td>
          </tr>
          <tr>
            <td style="padding-top: 20px; padding-left: 30px; padding-right: 30px; background-color: #ffffff">
              <table style="width: 100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td>
                    <span style="color: #CE484F; font-size: 35px; font-weight: bold;">Электронный билет &mdash;<br/> Международная<br/> Мобильная Конференция</span>
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
                          <span style="margin-top: 15px; display: block; width: 120px; text-align: center; padding-top: 5px; padding-bottom: 5px; background-color: #D14852; color: #ffffff; text-transform: uppercase;"><?=$role->Title?></span>
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
                          <strong>Время работы регистрации</strong><br/>
                          <span style="font-size: 80%;">15 мая с 09:30-18:00</span>
                        </td>
                        <td width="50%" align="right">
                          <a href="http://mblt.ru/ru/timetable" style="display: block; background-image: url('http://runet-id.com/images/mail/mblt13/ticket/program-link_bg.gif'); background-repeat: no-repeat; color: #ffffff; text-transform: uppercase; padding: 6px 0; width: 237px; text-align: center;">программа конференции</a>
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
                    <span style="color: #CE484F; font-size: 35px; font-weight: bold;">Место проведения</span>
                  </td>
                </tr>
                <tr>
                  <td style="padding-top: 10px;">
                    <strong>Digital October</strong><br/>
                    119072, Москва, Берсеневская набережная, 6, стр. 3, тел.: +7 (495) 988 33 56
                  </td>
                </tr>
                <tr>
                  <td style="padding-top: 10px;"><img src="http://runet-id.com/images/mail/mblt13/ticket/map.jpg" border="0"/></td>
                </tr>
                <tr>
                  <td style="padding-top: 20px; padding-bottom: 40px;">
                    <h4 style="padding-bottom: 10px; margin: 0;">От метро «Кропоткинская»:</h4>
                    Выйдя из метро к храму Христа Спасителя, обогните храм и идите к реке. Вам нужно перейти Москву-реку по пешеходному Патриаршему мосту и спуститься по ближайшей лестнице на Берсеневскую набережную. По набережной идите в сторону стрелки острова, к памятнику Петру I и комплексу зданий «Красного октября». По левую руку вы увидете поворот в Берсеневский переулок.<br/>
                    Сразу после переулка сверните на лево в арку с металлическими воротами.<br/>
                    Вы окажитесь во дворике; подьезд с чёрно-белым логотипом DO будет напротив вас.<br/>
                    Мы находимся на третьем этаже. Весь путь занимает около 10 минут.
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