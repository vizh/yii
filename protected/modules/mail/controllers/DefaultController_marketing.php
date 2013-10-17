<?php
class DefaultController extends \application\components\controllers\AdminMainController
{
  public function actionSend($step = 0)
  {
    set_time_limit(84600);
    error_reporting(E_ALL & ~E_DEPRECATED);

    $template = 'marketing13-html-2';
    $isHTML = true;

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
    $criteria->addCondition('"Region"."Id" NOT IN (4312)');
    */


    // Чтение из файла
/*
    $arUsers = file(Yii::getPathOfAlias('webroot') . '/files/ext/2013-10-16/alley.csv');
    foreach($arUsers as $eml) $emails[$eml] = trim($eml);
//    $emails['v.eroshenko@gmail.com'] = 'v.eroshenko@gmail.com';
//    $emails['borzov@internetmediaholding.com'] = 'borzov@internetmediaholding.com';
    $users = $emails;

//    print count($users); exit();
*/

//    $arUsers = file(Yii::getPathOfAlias('webroot') . '/files/ext/2013-10-17/marketing.csv');
    $arUsers = array(
      'Татьяна;Ружич;t.ruzhich@rta-moscow.com',
      'Ерошенко;Виталий;v.eroshenko@gmail.com',
      'Sergey;Grebennikov;grebennikov@raec.ru',
      'Екатерина;ВОРОБЬЕВА;vorobieva@raec.ru',
    );
    $users = $arUsers;
//    print count($users); exit();


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
    /*
    $criteria->with = array(
      'Participants' => array('together' => true),
      'Participants.Role',
      'Settings' => array('select' => false)
    );

    $criteria->addInCondition('"Participants"."EventId"', array(763));
//    $criteria->addInCondition('"Participants"."RoleId"', array(1));
*/
    /*
        $criteria->addCondition('"Participants"."CreationTime" > :CreationTime');
        $criteria->params['CreationTime'] = '2013-09-13 18:00:00';

        $criteria->addCondition('"t"."Email" NOT LIKE :Email');
        $criteria->params['Email'] = '%nomail497+%';
    */
/*
    $criteria->distinct = true;
    $criteria->addCondition('NOT "Settings"."UnsubscribeAll"');
    $criteria->addCondition('"t"."Visible"');
*/
//    $criteria->addCondition('"Participants"."UserId" NOT IN (SELECT "UserId" FROM "EventParticipant" WHERE "EventId" IN (425))');

/*
    $criteria->addCondition('"Participants"."UserId" IN (SELECT "UserId" FROM "UserEmployment" WHERE
      "Position" LIKE \'%директор по маркетингу%\' OR
      "Position" LIKE \'%brand manager%\' OR
      "Position" LIKE \'%бренд менеджер%\' OR
      "Position" LIKE \'%маркетинг менеджер%\' OR
      "Position" LIKE \'%marketing manager%\' OR
      "Position" LIKE \'%заместитель директора по маркетингу%\' OR
      "Position" LIKE \'%CMO%\' OR
      "Position" LIKE \'%digital директор%\' OR
      "Position" LIKE \'%digital manager%\' OR
      "Position" LIKE \'%Chief Marketing Officer%\'
      GROUP BY "UserId")
    ');
*/

//    $criteria->addInCondition('"t"."RunetId"', array(12953, 12959, 112087));
/*
    echo \user\models\User::model()->count($criteria);
    exit();

    $criteria->limit = 400;
    $criteria->order = '"t"."RunetId" ASC';
    $criteria->offset = $step * $criteria->limit;
    $users = \user\models\User::model()->findAll($criteria);
*/
    /* Для PK PASS для Яблочников */
//    $event = \event\models\Event::model()->findByPk(763);

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

        $usr = explode(';', $user);

        // ПИСЬМО
        $body = $this->renderPartial($template, array('user' => $usr), true);
//        $body = $this->renderPartial($template, array('user' => $user), true);
//        $body = $this->renderPartial($template, array('user' => $user, 'arPromo' => $arPromo), true);
//        $body = $this->renderPartial($template, array('user' => $user, 'regLink' => $this->getRegLink($user)), true);
//        $body = $this->renderPartial($template, array('user' => $user, 'regLink' => $this->getRegLink($user), 'promo' => $this->getPromo()), true);
//        $body = $this->renderPartial($template, array('user' => $user, 'regLink' => $this->getRegLink($user), 'role' => $user->Participants[0]->Role->Title), true);

        $mail = new \ext\mailer\PHPMailer(false);
        $mail->Mailer = 'mail';
        $mail->ParamOdq = true;
        $mail->ContentType = ($isHTML) ? 'text/html' : 'text/plain';
        $mail->IsHTML($isHTML);

//        $email = $user->Email;
//        $email = $user;
        $email = trim($usr[2]);

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
//        $mail->SetFrom('info@therunet.com', 'Редакция theRunet', false);
//        $mail->SetFrom('users@russianinternetweek.ru', 'RIW 2013', false);
//        $mail->SetFrom('users@russianinternetweek.ru', 'Премия Облака 2013', false);
//        $mail->SetFrom('narod@premiaruneta.ru', 'Народное голосование Премии Рунета', false);
        $mail->SetFrom('users@runet-id.com', '—RUNET—ID—', false);
        $mail->CharSet = 'utf-8';
        $mail->Subject = '=?UTF-8?B?'. base64_encode('Ваш Путевой лист на закрытую вечеринку для маркетинг директоров') .'?=';
        $mail->Body = $body;

//        $mail->AddAttachment($_SERVER['DOCUMENT_ROOT'] . '/files/ext/2013-10-02/marketingparty2013.pdf');

        /* PK PASS для Яблочников */
//        $mail->AddAttachment($pkPass->runAndSave(), 'ticket.pkpass');

//        $mail->Send();

        fwrite($fp, $email . "\n");
//        fwrite($fp, $user->RunetId . ' - '. $email . "\n");
      }
      fwrite($fp, "\n\n\n" . sizeof($users) . "\n\n\n");
      fclose($fp);

//      echo '<html><head><meta http-equiv="REFRESH" content="0; url='.$this->createUrl('/mail/default/send', array('step' => $step+1)).'"></head><body></body></html>';
      echo $this->createUrl('/mail/default/send', array('step' => $step+1));
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
    return 'http://2013.russianinternetweek.ru/my/'.$runetId.'/'.$hash.'/';
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
