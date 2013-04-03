<?php
class DefaultController extends \application\components\controllers\AdminMainController
{
  public function actionSend($step = 0)
  {
    set_time_limit(84600);
    error_reporting(E_ALL & ~E_DEPRECATED);

    $template = 'rif13-4';
    $isHTML = false;

//    exit();

    $logPath = \Yii::getPathOfAlias('application').DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR;
    $fp = fopen($logPath.$template.'.log',"a+");
    $j = 0;

    $criteria = new \CDbCriteria();
    $criteria->with = array(
      'Participants' => array('together' => true, 'select' => false),
      'Settings' => array('select' => false),
      'LinkEmail.Email'
    );
    $criteria->distinct = true;
    $criteria->addCondition('"Settings"."UnsubscribeAll" = false');

//    $criteria->addInCondition('"Participants"."EventId"', array(422));
//    $criteria->addInCondition('"t"."RunetId"', array(12953, 454));

    echo \user\models\User::model()->count($criteria);
    exit();

    $criteria->limit = 500;
    $criteria->order = '"t"."RunetId"';
    $criteria->offset = $step * $criteria->limit;
    $users = \user\models\User::model()->findAll($criteria);
    if (!empty($users))
    {
      foreach ($users as $user)
      {
        // ПИСЬМО
        $body = $this->renderPartial($template, array('user' => $user, 'regLink' => $this->getRegLink($user)), true);
        $mail = new \ext\mailer\PHPMailer(false);
        $mail->Mailer = 'mail';
        $mail->ParamOdq = true;
        $mail->ContentType = ($isHTML) ? 'text/html' : 'text/plain';
        $mail->IsHTML($isHTML);
        
        if ($user->getContactEmail() !== null)
        {
          $email = $user->getContactEmail()->Email;
        }
        else 
        {
          $email = $user->Email;
        }
        
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
        $mail->SetFrom('info@runet-id.com', 'RUNET-ID:// Календарь', false);
        $mail->CharSet = 'utf-8';
        $mail->Subject = '=?UTF-8?B?'. base64_encode('РИФ-Воронеж 2013: весенний it-прорыв!') .'?=';
        $mail->Body = $body;

//        $mail->AddAttachment($_SERVER['DOCUMENT_ROOT'] . '/files/ext/2013-03-28/newspaper-1.pdf');

//        $mail->Send();

        fwrite($fp, $user->RunetId.'-'.$email."\n");
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
  }

}
