<?php
class DefaultController extends \application\components\controllers\AdminMainController
{
  public function actionSend($step = 0)
  {
    set_time_limit(84600);
    error_reporting(E_ALL & ~E_DEPRECATED);

    $template = 'rif13-17';
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
        'LinkAddress.Address.City' => array('together' => true, 'select' => false),

        'Participants' => array('together' => true, 'select' => false),
        'Settings' => array('select' => false),
    );
    $criteria->addCondition('"Participants"."EventId" IN (128,218,339) OR "City"."Id" IN (3538,3354,4210,4238,5242,4650,5005)');
    */

    // Чтение из файла
    $arUsers = file(Yii::getPathOfAlias('webroot') . '/files/ext/2013-05-14/users.csv');

    foreach($arUsers as $eml)
    {
      $emails[$eml] = trim($eml);
    }

    $emails['v.eroshenko@gmail.com'] = 'v.eroshenko@gmail.com';

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

    /*
    // Обычная выборка пользователей [по мероприятиям]
    $criteria->with = array(
      'Participants' => array('together' => true),
      'Participants.Role' => array('together' => true),
      'Settings' => array('select' => false)
    );
    $criteria->addInCondition('"Participants"."EventId"', array(422));
    $criteria->addInCondition('"Participants"."RoleId"', array(24));

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
    */
    if (!empty($users))
    {
      foreach ($users as $user)
      {
        // ПИСЬМО
        $body = $this->renderPartial($template, array('user' => $user), true);
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
        $mail->SetFrom('users@runet-id.com', '—RUNET—ID—', false);
        $mail->CharSet = 'utf-8';
        $mail->Subject = '=?UTF-8?B?'. base64_encode('Первая ежегодная стартап-конференция Startuo Village в России!') .'?=';
        $mail->Body = $body;

//        $mail->AddAttachment($_SERVER['DOCUMENT_ROOT'] . '/files/ext/2013-03-28/newspaper-1.pdf');

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
    $secret = 'vyeavbdanfivabfdeypwgruqe';

   	$hash = substr(md5($runetId.$secret), 0, 16);

    return 'http://2013.russianinternetforum.ru/my/'.$runetId.'/'.$hash .'/';
//    return 'http://2013.russianinternetforum.ru/my/'.$runetId.'/'.$hash .'/?redirect=/my/payment1.php';
  }

}
