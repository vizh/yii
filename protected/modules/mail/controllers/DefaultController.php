<?php
class DefaultController extends \application\components\controllers\AdminMainController
{
  public function actionSend($step = 0)
  {
    set_time_limit(84600);
    error_reporting(E_ALL & ~E_DEPRECATED);

    $template = 'premiaruneta13-6';
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

//    $criteria->addInCondition('"Participants"."EventId"', array(652));
//    $criteria->addInCondition('"Participants"."RoleId"', array(1));

/*
    $criteria->addNotInCondition('"Participants"."RoleId"', array(3));
    $criteria->addCondition('"Participants"."UserId" IN (SELECT "UserId" FROM "UserEmployment" WHERE "CompanyId" IN (23,8624,7677,10384,1167,35594,35594,3392,39028,13565) AND ("StartYear" > 2008 OR "StartYear" IS NULL) )');
*/

//    $criteria->addCondition('"t"."Id" IN (SELECT "UserId" FROM "EventParticipant" WHERE "RoleId" = 3 AND "EventId" IN (425,422,800,801,773,681,765,757,578,758,754,730,673,600,411,458))');

    $criteria->distinct = true;
//    $criteria->addCondition('NOT "Settings"."UnsubscribeAll"');
    $criteria->addCondition('"t"."Visible"');

    $criteria->addInCondition('"t"."RunetId"', array(12953));
//    $criteria->addInCondition('"t"."RunetId"', array(172115,172001,1387,30095,13523,30194,2404,163138,86771,51557,113686,1752,83363,82630,55483,8891,1995,107083,14380,30589,54702,1683,41784,30649,54366,1898,10834,96070,29334,108674,118078,12132,108757,39025,49753,144261,12158,48719,18624,51757,13339,55488,39989,29188,13012,154117,84138,127791,55070,44057,42647,31159,609,36734,22535,17741,144911,106920,2346,114098,41688,97977,21337,49718,85620,12953,18521,16360,1521,148755,10383,14585,14104,50864,106936,10000,31913,16182,355,84805,169276,81600,31996,14275,11275,41241,13423,28816,10316,19190,48592,321,14783,14164,110582,85925,49796,1440,32368,93534,115570,1480,37034,36512,119382,169313,56083,14072,97684,38055,14502,17941,114621,14360,32697,13866,32705,19348,85070,2535,29607,107701,144337,37024,18864,171186,32967,20554,9426,143687,12563,118040,33128,13876,45065,147701,89400,13131,35287,18155,166001,84501,906,84577,158947,181486,84203,868,14493,13997,45455,15088,150054,39120,391,43260,136653,85807,29157,14237,10752,575,611,22662,14368,21815,88146,34026,16724,40445,54535,1023,13985,10985,152535,14605,34316,11068,55378,12782,15787,148407,9304,34502,173774,20812,148379,169015,866,768,55060,88267,143184,96300,143492,29984,88277,18470,18511,34950,1507,77779,82259,10700,17071,1196,21175,17162,86757,143323,2506,372,12945));

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
        $mail->Subject = '=?UTF-8?B?'. base64_encode('Не забудьте проголосовать за номинантов') .'?=';
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
