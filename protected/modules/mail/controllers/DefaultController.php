<?php
class DefaultController extends \application\components\controllers\AdminMainController
{
  public function actionSend($step = 0)
  {
    set_time_limit(84600);
    error_reporting(E_ALL & ~E_DEPRECATED);

    $template = 'research13-6';
    $isHTML = false;

    $logPath = \Yii::getPathOfAlias('application').DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR;
    $fp = fopen($logPath.$template.'.log',"a+");
    $j = 0;

    $criteria = new \CDbCriteria();
/*
    // ГеоВыборка
    $criteria->with = array(
        'LinkAddress' => array('together' => true, 'select' => false),
        'LinkAddress.Address' => array('together' => true, 'select' => false),
        'LinkAddress.Address.Region' => array('together' => true, 'select' => false),
//        'LinkAddress.Address.City' => array('together' => true, 'select' => false),

        'Participants' => array('together' => true, 'select' => false),
        'Settings' => array('select' => false),
    );
//    $criteria->addCondition(' ("Participants"."EventId" IN (258) OR "Region"."Id" IN (4925,4503,4773,3761,4481,3503,3251)) AND "Participants"."UserId" NOT IN (SELECT "UserId" FROM "EventParticipant" WHERE "EventId" = 423)');
    $criteria->addCondition('"Region"."Id" IN (4312) AND ( ("Participants"."EventId" = 425 AND "Participants"."RoleId" = 11) OR ("Participants"."EventId" = 422 AND "Participants"."RoleId" = 1) )');
*/

    // Чтение из файла
/*
//    $arUsers = file(Yii::getPathOfAlias('webroot') . '/files/ext/2013-11-26/alley_all.csv');
//    foreach($arUsers as $eml) $emails[$eml] = trim($eml);
    $emails['v.eroshenko@gmail.com'] = 'v.eroshenko@gmail.com';
//    $emails['ilya.chertilov@gmail.com'] = 'ilya.chertilov@gmail.com';
//    $emails['t.ruzhich@rta-moscow.com'] = 't.ruzhich@rta-moscow.com';
//    $emails['grebennikov.sergey@gmail.com'] = 'grebennikov.sergey@gmail.com';
//    $emails['borzov@internetmediaholding.com'] = 'borzov@internetmediaholding.com';
//    $emails['plugotarenko@raec.ru'] = 'plugotarenko@raec.ru';

    $limit = 300;
    $offset = $step * $limit;
    $users = array_slice($emails, $offset, $limit, true);

//    print count($emails); exit();
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

//    $criteria->addInCondition('"Participants"."EventId"', array(773));

    // Beeline
//    $criteria->addInCondition('"Participants"."EventId"', array(837));
//    $criteria->addCondition('("Participants"."UserId" IN (SELECT "UserId" FROM "EventParticipant" WHERE "CreationTime" <= \'2013-12-13 19:00:00\' AND "EventId" = 837 ))');

//    $criteria->addInCondition('"Participants"."RoleId"', array(24));
//    $criteria->addInCondition('"Participants"."PartId"', array(19));

    $criteria->addCondition('
    (
      ("Participants"."UserId" IN
        (SELECT "UserId" FROM "EventParticipant" WHERE
          ("EventId" IN (773) AND "RoleId" = 2)
        )
      )
      OR
      ("Participants"."UserId" IN (SELECT "UserId" FROM "CompetenceResult" WHERE "TestId" = 2))
    )');

//    $criteria->addCondition('"Participants"."UserId" NOT IN (SELECT "UserId" FROM "EventParticipant" WHERE "RoleId" != 24 AND "EventId" = 688)');

    $criteria->distinct = true;
    $criteria->addCondition('NOT "Settings"."UnsubscribeAll"');
    $criteria->addCondition('"t"."Visible"');

    $criteria->addInCondition('"t"."RunetId"', array(12953, 15648, 39948));

    echo \user\models\User::model()->count($criteria);
    exit();

    $criteria->limit = 200;
    $criteria->order = '"t"."RunetId" ASC';
    $criteria->offset = $step * $criteria->limit;
    $users = \user\models\User::model()->findAll($criteria);

    /* Для PK PASS для Яблочников */
//    $event = \event\models\Event::model()->findByPk(837);

    if (!empty($users))
    {
      foreach ($users as $user)
      {

//        print $user->Participants[0]->Role->Title;
//        print $user->Participants[0]->getTicketUrl();
//        exit();

//        /* PK PASS для Яблочников */
//        $pkPass = new \application\components\utility\PKPassGenerator($event, $user, $user->Participants[0]->Role);

//        $arPromo = array();
//        for($i = 0; $i < 2; $i++) $arPromo[] = $this->getPromo();

        // ПИСЬМО

        $body = $this->renderPartial($template, array('user' => $user), true);
//        $body = $this->renderPartial($template, array('user' => $user, 'arPromo' => $arPromo), true);
//        $body = $this->renderPartial($template, array('user' => $user, 'promo' => $this->getPromo()), true);
//        $body = $this->renderPartial($template, array('user' => $user, 'role' => $user->Participants[0]->Role->Title), true);

        $mail = new \ext\mailer\PHPMailer(false);
        $mail->Mailer = 'mail';
        $mail->ParamOdq = true;
        $mail->ContentType = ($isHTML) ? 'text/html' : 'text/plain';
        $mail->IsHTML($isHTML);

        $email = $user->Email;
//        $email = $user;

        if ($j == 200) { sleep(1); $j = 0; }; $j++;

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
//        $mail->SetFrom('info@russiandigitalgames.ru', 'Russian Digital Games 2013', false);
//        $mail->SetFrom('users@runet-id.com', '—RUNET—ID—', false);
        $mail->SetFrom('research@raec.ru', 'Экономика Рунета', false);
//        $mail->SetFrom('event@runet-id.com', 'Design Camp', false);
        $mail->CharSet = 'utf-8';
        $mail->Subject = '=?UTF-8?B?'. base64_encode('Отчет по исследованию Экономика Рунета 2012-2013') .'?=';
        $mail->Body = $body;

//        $mail->AddAttachment($_SERVER['DOCUMENT_ROOT'] . '/files/ext/2013-12-04/beeline_invite_'.$user->RunetId.'.pdf');

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

  private function getPromo()
  {
    $coupon = new \pay\models\Coupon();
    $coupon->EventId = 688;
    $coupon->Discount = '0.1';
//    $coupon->ProductId = 1309;
    $coupon->Code = $coupon->generateCode();
    $coupon->Recipient = 'Выдано оплатившему участнику РИФ-2013 и RIW-2013';
    $coupon->save();
    return $coupon->Code;
  }

}
