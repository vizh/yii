<?php
class DefaultController extends \application\components\controllers\AdminMainController
{
  public function actionSend($step = 0)
  {
    set_time_limit(84600);
    error_reporting(E_ALL & ~E_DEPRECATED);

    $template = 'phdays13-1';
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
    $criteria->addCondition(' ("Participants"."EventId" IN (258) OR "Region"."Id" IN (4925,4503,4773,3761,4481,3503,3251)) AND "Participants"."UserId" NOT IN (SELECT "UserId" FROM "EventParticipant" WHERE "EventId" = 423)');
    */

    // Чтение из файла
    /*
    $arUsers = file(Yii::getPathOfAlias('webroot') . '/files/ext/2013-05-14/users.csv');
    foreach($arUsers as $eml) $emails[$eml] = trim($eml);
//    $emails['v.eroshenko@gmail.com'] = 'v.eroshenko@gmail.com';
    $criteria->with = array(
      'Settings' => array('select' => false)
    );
    $criteria->addInCondition('"t"."Email"', $emails);
    $criteria->distinct = true;
    $criteria->addCondition('NOT "Settings"."UnsubscribeAll"');
    $criteria->addCondition('"t"."Visible"');

//    echo \user\models\User::model()->count($criteria);
//    exit();

    $users = \user\models\User::model()->findAll($criteria);
    */

    // Обычная выборка пользователей [по мероприятиям]
    $criteria->with = array(
      'Participants' => array('together' => true),
      'Participants.Role' => array('together' => true),
      'Settings' => array('select' => false)
    );
    $criteria->addInCondition('"Participants"."EventId"', array(497));
    $criteria->addInCondition('"Participants"."RoleId"', array(1));

    $criteria->addCondition('"t"."CreationTime" > :CreationTime');
    $criteria->params['CreationTime'] = '2013-05-21 00:00:00';
    $criteria->addCondition('"t"."Email" NOT LIKE :Email');
    $criteria->params['Email'] = '%nomail497+%';

    $criteria->distinct = true;
    $criteria->addCondition('NOT "Settings"."UnsubscribeAll"');
    $criteria->addCondition('"t"."Visible"');

    $criteria->addInCondition('"t"."RunetId"', array(12953));

    echo \user\models\User::model()->count($criteria);
    exit();

    $criteria->limit = 500;
    $criteria->order = '"t"."RunetId" ASC';
    $criteria->offset = $step * $criteria->limit;
    $users = \user\models\User::model()->findAll($criteria);

    if (!empty($users))
    {
      foreach ($users as $user)
      {
        /*
        $arPromo = array();
        for($i = 0; $i < 3; $i++) $arPromo[] = $this->getPromo();
        */

        // ПИСЬМО
        $body = $this->renderPartial($template, array('user' => $user), true);
//        $body = $this->renderPartial($template, array('user' => $user, 'regLink' => $this->getRegLink($user), 'waybillLink' => $this->getWaybillLink($user)), true);
//        $body = $this->renderPartial($template, array('user' => $user, 'regLink' => $this->getRegLink($user), 'promo' => $arPromo), true);
//        $body = $this->renderPartial($template, array('user' => $user, 'regLink' => $this->getRegLink($user), 'role' => $user->Participants[0]->Role->Title), true);

        $mail = new \ext\mailer\PHPMailer(false);
        $mail->Mailer = 'mail';
        $mail->ParamOdq = true;
        $mail->ContentType = ($isHTML) ? 'text/html' : 'text/plain';
        $mail->IsHTML($isHTML);
        
        $email = $user->Email;

        if ($j == 300) { sleep(1); $j = 0; }; $j++;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
          continue;
        }

        /*
        if (preg_match("/@ashmanov.com/i", $email))
        {
          print 'is @Ashmanov<br />';
          continue;
        }
        */

        $mail->AddAddress($email);
//        $mail->SetFrom('users@sp-ic.ru', 'СПИК-2013', false);
        $mail->SetFrom('users@runet-id.com', '—RUNET—ID—', false);
        $mail->CharSet = 'utf-8';
        $mail->Subject = '=?UTF-8?B?'. base64_encode('Вы зарегистрированы на форум PHDays III') .'?=';
        $mail->Body = $body;

        $mail->AddAttachment($_SERVER['DOCUMENT_ROOT'] . '/files/ext/2013-05-17/PHDays_rus.doc');
        $mail->AddAttachment($_SERVER['DOCUMENT_ROOT'] . '/files/ext/2013-05-17/PHDays_eng.doc');

//        $mail->Send();

        fwrite($fp, $user->RunetId . ' - '. $email . "\n");
      }
      fwrite($fp, "\n\n\n" . sizeof($users) . "\n\n\n");
      fclose($fp);
//      echo '<html><head><meta http-equiv="REFRESH" content="0; url='.$this->createUrl('/mail/default/send', array('step' => $step+1)).'"></head><body></body></html>';
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

    return 'http://2013.sp-ic.ru/my/'.$runetId.'/'.$hash .'/';
//    return 'http://2013.sp-ic.ru/my/'.$runetId.'/'.$hash .'/?redirect=/my/waybill.php';
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
    $coupon->EventId = 423;
    $coupon->Discount = 1;
    $coupon->ProductId = 733;
    $coupon->Code = $coupon->generateCode();
    $coupon->save();
    return $coupon->Code;
  }

}
