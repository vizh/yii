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
//    $criteria->addInCondition('"Participants"."RoleId"', array(3));

/*
    $criteria->addNotInCondition('"Participants"."RoleId"', array(3));
    $criteria->addCondition('"Participants"."UserId" IN (SELECT "UserId" FROM "UserEmployment" WHERE "CompanyId" IN (23,8624,7677,10384,1167,35594,35594,3392,39028,13565) AND ("StartYear" > 2008 OR "StartYear" IS NULL) )');
*/

//    $criteria->addCondition('"t"."Id" IN (SELECT "UserId" FROM "EventParticipant" WHERE "RoleId" = 3 AND "EventId" IN (425,422,800,801,773,681,765,757,578,758,754,730,673,600,411,458))');

    $criteria->distinct = true;
    $criteria->addCondition('NOT "Settings"."UnsubscribeAll"');
    $criteria->addCondition('"t"."Visible"');

    $criteria->addInCondition('"t"."RunetId"', array(12953, 454, 337, 12959));
//    $criteria->addInCondition('"t"."RunetId"', array(168652,30095,37285,19268,147615,45164,17818,13523,106742,16890,21896,30219,41045,14972,45346,16750,54171,85151,55658,83363,13969,15536,81469,1995,44096,117154,98726,80701,127730,40242,14380,54702,87519,149370,30649,54366,1898,106385,40132,149585,156569,24035,39025,144261,29164,30847,48719,30859,130417,18624,13339,16125,39989,29188,52883,143697,154117,29908,55070,82232,1207,36734,22535,17741,946,17679,18261,99748,144279,31364,97977,21337,84507,36688,16909,85620,13721,19216,31484,18521,17159,16360,2550,464,10383,120740,1261,14585,14104,1527,4403,14361,14618,355,143741,84830,144015,11275,41241,99070,149234,28816,42060,104626,40931,10316,116759,14783,171724,169017,85925,16395,32368,366,18158,29662,39983,42775,37034,54544,15276,36512,119382,56083,22743,9206,38055,11183,28480,36975,23995,114621,14865,2146,37446,23887,14045,2535,78938,29607,13898,164430,16343,96612,15969,14177,29318,149481,1357,171703,37024,18864,17180,18558,29632,143687,24012,163030,124473,118040,19649,45065,171508,89400,38394,906,17456,93678,54908,19416,17220,1445,35673,45455,39120,52785,10322,136653,85807,29157,14237,11770,36487,148657,10752,85520,22662,16247,14368,103253,107648,21815,16493,13859,96835,16550,51505,34085,16724,152627,54535,84049,1023,5238,10985,152535,14605,34316,22320,14268,17951,42149,15787,36832,19305,14639,2770,110794,45009,81560,12827,768,117088,14214,42638,103653,34768,12846,14309,8105,91072,51762,15053,114647,14868,42566,18511,19600,35002,1507,86178,50500,17515,1449,15019,10700,1827,17071,21175,17162,45411,39038,51063,20996,11241,16479,13794,17413,51137,2506,372,12945), 'OR');

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

        $mail->Send();

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
