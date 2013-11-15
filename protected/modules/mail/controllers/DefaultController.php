<?php
class DefaultController extends \application\components\controllers\AdminMainController
{
  public function actionSend($step = 0)
  {
    set_time_limit(84600);
    error_reporting(E_ALL & ~E_DEPRECATED);

    $template = 'premiaruneta13-5';
    $isHTML = false;

    $logPath = \Yii::getPathOfAlias('application').DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR;
    $fp = fopen($logPath.$template.'.log',"a+");
    $j = 0;

    $criteria = new \CDbCriteria();


    // ГеоВыборка
/*
    $criteria->with = array(
        'LinkAddress' => array('together' => true, 'select' => false),
        'LinkAddress.Address' => array('together' => true, 'select' => false),
        'LinkAddress.Address.Region' => array('together' => true, 'select' => false),
//        'LinkAddress.Address.City' => array('together' => true, 'select' => false),

        'Participants' => array('together' => true, 'select' => false),
        'Settings' => array('select' => false),
    );
//    $criteria->addCondition(' ("Participants"."EventId" IN (258) OR "Region"."Id" IN (4925,4503,4773,3761,4481,3503,3251)) AND "Participants"."UserId" NOT IN (SELECT "UserId" FROM "EventParticipant" WHERE "EventId" = 423)');
    $criteria->addCondition('"Region"."Id" IN (4312)');
*/

    // Чтение из файла
/*
    $arUsers = file(Yii::getPathOfAlias('webroot') . '/files/ext/2013-11-07/rdgames.csv');
    foreach($arUsers as $eml) $emails[$eml] = trim($eml);
//    $emails['v.eroshenko@gmail.com'] = 'v.eroshenko@gmail.com';
//    $emails['ilya.chertilov@gmail.com'] = 'ilya.chertilov@gmail.com';
//    $emails['t.ruzhich@rta-moscow.com'] = 't.ruzhich@rta-moscow.com';
//    $emails['grebennikov.sergey@gmail.com'] = 'grebennikov.sergey@gmail.com';
//    $emails['borzov@internetmediaholding.com'] = 'borzov@internetmediaholding.com';
//    $emails['plugotarenko@raec.ru'] = 'plugotarenko@raec.ru';

    $limit = 300;
    $offset = $step * $limit;
    $users = array_slice($emails, $offset, $limit, true);

    print count($emails); exit();
*/

    /*
    // C ПОИСКОМ ПО БД
    $criteria->with = array(
      'Settings' => array('select' => false)
    );
    $criteria->addInCondition('"t"."Email"', $emails);
    $criteria->distinct = true;
    $criteria->addCondition('NOT "Settings"."UnsubscribeAll"');
    $criteria->addCondition('"t"."Visible"');

    echo \user\models\User::model()->count($criteria);
    exit();

    $users = \user\models\User::model()->findAll($criteria);
    */

    // Обычная выборка пользователей [по мероприятиям]
    $criteria->with = array(
      'Participants' => array('together' => true),
      'Participants.Role',
      'Settings' => array('select' => false)
    );

//    $criteria->addInCondition('"Participants"."EventId"', array(425));
    $criteria->addInCondition('"Participants"."RoleId"', array(27));

/*
    $criteria->addNotInCondition('"Participants"."RoleId"', array(3));
    $criteria->addCondition('"Participants"."UserId" IN (SELECT "UserId" FROM "UserEmployment" WHERE "CompanyId" IN (23,8624,7677,10384,1167,35594,35594,3392,39028,13565) AND ("StartYear" > 2008 OR "StartYear" IS NULL) )');
*/

//    $criteria->addCondition('"t"."Id" IN (SELECT "UserId" FROM "EventParticipant" WHERE "RoleId" = 27)');

    $criteria->distinct = true;
    $criteria->addCondition('NOT "Settings"."UnsubscribeAll"');
    $criteria->addCondition('"t"."Visible"');

//    $criteria->addInCondition('"t"."RunetId"', array(12953));

    $criteria->addNotInCondition('"t"."RunetId"', array(172115,172001,98808,55266,122337,30194,2404,163138,86771,113686,83363,82630,8891,1995,14380,454,1683,40074,19050,41784,30649,54366,1898,1201,1437,108674,118078,12132,108757,39025,49753,144261,8894,18479,18624,13339,39989,143760,165410,2619,82617,154117,84138,54673,15095,55070,12959,44057,42647,36734,22535,17741,4884,106920,114098,97977,21337,14335,85620,14822,148250,12953,18521,16360,94867,10383,14104,50864,39948,10000,99779,106632,54903,16182,595,84805,169276,130440,31996,11275,41241,37244,114995,13423,28816,10316,19190,50891,48592,321,14783,14164,150038,85925,49796,32368,93534,115570,1480,19280,36512,119382,13568,169313,109267,56083,14072,97684,38055,17941,2337,32632,114621,14360,32697,13866,19348,2535,78938,29607,107701,144337,9734,18864,164181,171186,32967,9426,158844,148927,143687,169709,118040,52777,54408,45065,147701,89400,13131,35287,153145,166001,84501,906,33313,13287,158947,181486,49335,868,14493,14324,97532,13997,45455,337,150054,39120,136653,85807,33695,29157,14237,124252,10752,575,611,21821,14368,21815,450,34026,17261,16724,40445,34130,54535,1023,56303,28317,13985,10985,152535,14605,924,13100,34316,55378,12781,15787,148407,343,34502,173774,148379,169015,866,102968,116543,168567,768,55060,96300,143492,88277,115296,18511,53556,34950,1212,15056,144128,1507,144642,144561,77779,10700,49844,17071,17162,86757,101542,171781,13421,12945,53517));

    echo \user\models\User::model()->count($criteria);
    exit();

    $criteria->limit = 300;
    $criteria->order = '"t"."RunetId" ASC';
    $criteria->offset = $step * $criteria->limit;
    $users = \user\models\User::model()->findAll($criteria);

    /* Для PK PASS для Яблочников */
//    $event = \event\models\Event::model()->findByPk(652);

    if (!empty($users))
    {
      foreach ($users as $user)
      {
//        print $user->Participants[0]->getTicketUrl();
//        exit();

//        /* PK PASS для Яблочников */
//        $pkPass = new \application\components\utility\PKPassGenerator($event, $user, $user->Participants[0]->Role);

//        $arPromo = array();
//        for($i = 0; $i < 2; $i++) $arPromo[] = $this->getPromo();

        // ПИСЬМО
        $body = $this->renderPartial($template, array('user' => $user), true);
//        $body = $this->renderPartial($template, array('user' => $user, 'arPromo' => $arPromo), true);
//        $body = $this->renderPartial($template, array('user' => $user, 'regLink' => $this->getRegLink($user)), true);
//        $body = $this->renderPartial($template, array('user' => $user, 'regLink' => $this->getRegLink($user), 'promo' => $this->getPromo()), true);
//        $body = $this->renderPartial($template, array('user' => $user, 'regLink' => $this->getRegLink($user), 'role' => $user->Participants[0]->Role->Title), true);

        $mail = new \ext\mailer\PHPMailer(false);
        $mail->Mailer = 'mail';
        $mail->ParamOdq = true;
        $mail->ContentType = ($isHTML) ? 'text/html' : 'text/plain';
        $mail->IsHTML($isHTML);

        $email = $user->Email;
//        $email = $user;

        if ($j == 300) { sleep(1); $j = 0; }; $j++;

//        if ($j == 1) continue;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
          continue;
        }

        /*
        if (preg_match("/@ashmanov.com/i", $email))
        {
          print 'is @ashmanov.com<br />';
          continue;
        }
        */

        $mail->AddAddress($email);
//        $mail->SetFrom('ux2013@userexperience.ru', 'Userexperience 2013', false);
        $mail->SetFrom('experts@premiaruneta.ru', 'Премия Рунета 2013', false);
//        $mail->SetFrom('info@russiandigitalgames.ru', 'Russian Digital Games 2013', false);
//        $mail->SetFrom('users@runet-id.com', '—RUNET—ID—', false);
//        $mail->SetFrom('reg@ibcrussia.com', 'IBC Russia 2013', false);
        $mail->CharSet = 'utf-8';
        $mail->Subject = '=?UTF-8?B?'. base64_encode('Приглашение войти в Экспертный Совет и проголосовать за номинантов') .'?=';
        $mail->Body = $body;

//        $mail->AddAttachment($_SERVER['DOCUMENT_ROOT'] . '/files/ext/2013-10-02/marketingparty2013.pdf');

        /* PK PASS для Яблочников */
//        $mail->AddAttachment($pkPass->runAndSave(), 'ticket.pkpass');

//        $mail->Send();

//        fwrite($fp, $email . "\n");
        fwrite($fp, $user->RunetId . ' - '. $email . "\n");
      }
      fwrite($fp, "\n\n\n" . sizeof($users) . "\n\n\n");
      fclose($fp);

      echo '<html><head><meta http-equiv="REFRESH" content="0; url='.$this->createUrl('/mail/default/send', array('step' => $step+1)).'"></head><body></body></html>';
//      echo $this->createUrl('/mail/default/send', array('step' => $step+1));
    }
    else
    {
      echo 'Рассылка ушла!';
    }
  }

  private function getRegLink($user)
  {
    $runetId = $user->RunetId;
    $secret = 'xggMpIQINvHqR0QlZgZa';

   	$hash = substr(md5($runetId.$secret), 0, 16);

//    return 'http://ibcrussia.com/my/'.$runetId.'/'.$hash.'/';
    return 'http://2013.russianinternetweek.ru/my/'.$runetId.'/'.$hash.'/?redirect=/vote/';
//    return 'http://2013.sp-ic.ru/my/'.$runetId.'/'.$hash .'/?redirect=/vote/';
  }

  private function getWaybillLink($user)
  {
    $runetId = $user->RunetId;
    $secret = 'xggMpIQINvHqR0QlZgZa';

   	$hash = substr(md5($runetId.$secret), 0, 16);

//    return 'http://2013.sp-ic.ru/my/'.$runetId.'/'.$hash .'/';
    return 'http://2013.sp-ic.ru/my/'.$runetId.'/'.$hash .'/?redirect=/my/waybill.php';
  }

  private function getPromo()
  {
    $coupon = new \pay\models\Coupon();
    $coupon->EventId = 425;
    $coupon->Discount = '0.25';
    $coupon->ProductId = 1309;
    $coupon->Code = $coupon->generateCode();
    $coupon->Recipient = 'Выдано участнику прошлых мероприятий RIW и РИФ';
    $coupon->save();
    return $coupon->Code;
  }

}
