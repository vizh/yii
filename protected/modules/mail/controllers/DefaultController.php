<?php
class DefaultController extends \application\components\controllers\AdminMainController
{
  public function actionSend($step = 0)
  {
    set_time_limit(84600);
    error_reporting(E_ALL & ~E_DEPRECATED);

    $template = 'rif13-13';
    $isHTML = false;

    $arPromo = file($_SERVER['DOCUMENT_ROOT'] . '/files/ext/2013-04-15/promo_1000_rif.csv');

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

    // Обычная выборка пользователей [по мероприятиям]
    $criteria->with = array(
      'Participants' => array('together' => true),
      'Participants.Role' => array('together' => true),
      'Settings' => array('select' => false)
    );
    $criteria->addInCondition('"Participants"."EventId"', array(422));
    $criteria->addInCondition('"Participants"."RoleId"', array(3));

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
      $counter = 0;
      foreach ($users as $user)
      {
        // ПИСЬМО
        $body = $this->renderPartial($template, array('user' => $user, 'regLink' => $this->getRegLink($user), 'promo' => $arPromo[$counter]), true);
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
        $mail->SetFrom('users@rif.ru', 'РИФ+КИБ 2013', false);
        $mail->CharSet = 'utf-8';
        $mail->Subject = '=?UTF-8?B?'. base64_encode('Важная информация для Докладчиков РИФ+КИБ') .'?=';
        $mail->Body = $body;

//        $mail->AddAttachment($_SERVER['DOCUMENT_ROOT'] . '/files/ext/2013-03-28/newspaper-1.pdf');

//        $mail->Send();

        fwrite($fp, $user->RunetId.' - '.$email.' - '.$arPromo[$counter]."\n");
        $counter++;
      }
      fwrite($fp, "\n\n\n" . sizeof($users) . "\n\n\n");
      fclose($fp);
      echo '<html><head><meta http-equiv="REFRESH" content="0; url='.$this->createUrl('/mail/default/send', array('step' => $step+1)).'"></head><body></body></html>';
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
