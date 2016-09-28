<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>
  <table style="width: 660px;  color: #4e4e4e; font-family: tahoma; font-size: 14px; background-color: #0082C0; background-image: url('http://runet-id.com/images/mail/spic13/ticket/bg.jpg'); background-repeat: no-repeat; background-position: center -70px; padding-left: 20px; padding-right: 20px;" cellpadding="0" cellspacing="0">
    <tr>
      <td>
        <table style="width: 100%;" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center"><img src="http://runet-id.com/images/mail/spic13/ticket/logo.jpg" style="float: left;"/></td>
          </tr>
          <tr>
            <td style="padding-top: 20px; padding-left: 30px; padding-right: 30px; background-color: #ffffff">
              <table style="width: 100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td>
                    <span style="color: #0085ca; font-size: 35px; font-weight: bold;">Электронное приглашение &mdash;<br/> Санкт-Петербургская<br/> Интернет Конференция</span>
                    <br/><br/><span style="color: red;">Обязательно к предъявлению на регистрации</span>
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
                          <span style="margin-top: 15px; display: block; width: 120px; text-align: center; padding-top: 5px; padding-bottom: 5px; background-color: #0085c9; color: #ffffff; text-transform: uppercase;"><?=$role->Title?></span>
                        </td>
                        <td valign="top" style="background: #f6f6f6; padding: 10px; text-align: center;" align="right">
                          <img src="<?=\ruvents\components\QrCode::getAbsoluteUrl($user)?>" />
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td align="right" style="padding-top: 5px;">RUNET&mdash;ID <a href="<?=$user->getUrl()?>" style="color: #339dd5;"><?=$user->RunetId?></a></td>
                </tr>
                <tr>
                  <td style="padding-top: 20px;">
                    <h4 style="padding-bottom: 10px; margin: 0;">Памятка участника:</h4>
                    <ul style="margin: 0; padding-left: 25px;">
                      <li>Распечатать путевой лист</li>
                      <li>Зарегистрироваться на конференции (второй этаж)</li>
                      <li>Оплатить дополнительные услуги (участие в конференции, питание)</li>
                      <li>Посетить выставку СПИК</li>
                      <li>Посетить конференцию СПИК</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td style="padding-top: 30px;">
                    <table style="width: 100%;" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="50%" style="background-color: #ececec; padding: 5px;">
                          <strong>Время работы регистрации</strong><br/>
                          <span style="font-size: 80%;">20-21 мая с 09:00-18:00</span>
                        </td>
                        <td width="50%" align="right">
                          <a href="http://2013.sp-ic.ru/program/" style="display: block; background-image: url('http://runet-id.com/images/mail/spic13/ticket/program-link_bg.gif'); background-repeat: no-repeat; color: #ffffff; text-transform: uppercase; padding: 6px 0; width: 237px; text-align: center;">программа конференции</a>
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
                    <span style="color: #0085ca; font-size: 35px; font-weight: bold;">Место проведения</span>
                  </td>
                </tr>
                <tr>
                  <td style="padding-top: 10px;">
                    <strong>Конференц-центр гостиницы «Прибалтийская Park Inn»</strong><br/>
                    199226, Россия, г. Санкт-Петербург, ул. Кораблестроителей, д.14, гостиница «Прибалтийская Park Inn».<br/> Тел.: +7 (495) 950-5651
                  </td>
                </tr>
                <tr>
                  <td style="padding-top: 10px;"><img src="http://runet-id.com/images/mail/spic13/ticket/map.jpg" border="0"/></td>
                </tr>
                <tr>
                  <td style="padding-top: 20px; padding-bottom: 40px;">
                    <h4 style="padding-bottom: 10px; margin: 0;">Проезд на площадку:</h4>
                    <strong>На общественном транспорте</strong> &mdash; проезд до станции метро «Приморская», далее: либо на маршрутное такси №162, №248 (отправляется с улицы «Наличная», до остановки «Аквапарк гостиницы Прибалтийская») либо автобус №42 (до остановки «гостиница Прибалтийская»)
                    <br/><br/>
                    <strong>На личном автотранспорте</strong>:<br/>
                    Парковка у гостиницы «Прибалтийская Park Inn» (парковка платная: 120 руб./сутки)
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