<?$user->setLocale('en');?>
<body>
<table style="color: #000; font-size: 14px; padding-bottom: 20px;" cellpadding="0" cellspacing="0">
  <tr>
    <td>
      <img src="/img/event/phdays2014/ticket/header.png" />
    </td>
  </tr>
  <tr>
    <td style="background: url('/img/event/phdays2014/ticket/body-bg.png') repeat;">
      <table style="width: 100%; padding: 0 20px; " cellpadding="0" cellspacing="0">
        <tr>
          <td style="background: #fff; padding: 20px; width: 530px;">
            <table style="width: 100%" cellpadding="0" cellspacing="0">
              <tr>
                <td>
                  <table style="width: 100%">
                    <tr>
                      <td>
                        <h2 style="font-size: 30px; font-weight: bold; margin: 0 0 10px; padding: 0;">E-TICKET</h2>
                        <p style="font-weight: bold; font-size: 18px; margin: 0; padding: 0;"><?=$user->getFullName();?></p>
                        <?if ($user->getEmploymentPrimary() !== null):?>
                          <p style="padding: 0; margin: 5px 0 0;"><?=$user->getEmploymentPrimary();?></p>
                        <?endif;?>
                      </td>
                      <td style="text-align: right;">
                        <img src="/img/event/phdays2014/ticket/dates.png" />
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td style="height: 20px;"></td>
              </tr>

              <tr>
                <td>
                  <table style="width: 100%">
                    <tr>
                      <td><img src="/img/event/phdays2014/ticket/danger.png" /></td>
                      <td style="width: 1px; text-align: center;">
                        <img src="<?=\ruvents\components\QrCode::getAbsoluteUrl($user, 100)?>"/>
                        <p style="padding: 0; margin: -15px 0 0;">RUNET&mdash;ID <a href="<?=$user->getUrl();?>" style="color: #339dd5;"><?=$user->RunetId;?></a></p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td>
                  <h2 style="font-size: 30px; font-weight: bold; margin: 20px 0 10px; padding: 0;">VENUE</h2>
                  <p style="font-weight: bold; font-size: 18px; margin: 0; padding: 0;">Digital October</p>
                  <p style="padding: 0; margin: 5px 0 0;">Moscow, Bersenevskaya Naberezhnaya 6, building 3</p>
                </td>
              </tr>
              <tr>
                <td style="padding-top: 10px; text-align: center;">
                  <img src="http://static-maps.yandex.ru/1.x/?ll=37.609211,55.740625&size=615,250&z=15&l=map&pt=37.609245,55.740588,pm2orgl&lang=en_US" alt=""/>
                </td>
              </tr>
              <tr>
                <td style="padding-top: 10px; text-align: center;"><img src="/img/event/phdays2014/ticket/partners.png" /></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td>
      <img src="/img/event/phdays2014/ticket/footer.png" />
    </td>
  </tr>
  <tr>
    <td style="text-align: center; padding-top: 20px;">
      Details: <a href="http://www.phdays.com" style="color: #1cbbd7;">www.phdays.com</a> | Support: <a href="mailto:support@runet-id.com" style="color: #1cbbd7;">support@runet-id.com</a>
    </td>
  </tr>
</table>
</body>
