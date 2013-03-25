<?php
class DefaultController extends \application\components\controllers\AdminMainController
{
  public function actionSend($step = 0)
  {
    set_time_limit(84600);
    error_reporting(E_ALL & ~E_DEPRECATED);

    $template = 'failoverconf13';

    exit();
    
    $isHTML = false;
    $logPath =  \Yii::getPathOfAlias('application').DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR;
    $fp = fopen($logPath.$template.'.log',"a+");
    $j = 0;
    
    $criteria = new \CDbCriteria();
    
    $criteria->with = array('User.Settings');
//    $criteria->condition = '"User"."RunetId" = 12953';

    $criteria->addInCondition('"t"."RoleId"', array(1,24));
    $criteria->addInCondition('"t"."EventId"', array(195,246));

    $criteria->addCondition('"Settings"."UnsubscribeAll" = false');

    $criteria->limit = 100;
    $criteria->order = '"User"."RunetId"';
    $criteria->offset = $step * $criteria->limit;
//    $participants = \event\models\Participant::model()->byEventId(422)->findAll($criteria);
    $participants = \event\models\Participant::model()->findAll($criteria);
    if (!empty($participants))
    {
      $userIdList = array();
      foreach ($participants as $participant)
      {
        $userIdList[] = $participant->UserId;
      }
      $criteria = new \CDbCriteria();
      $criteria->addInCondition('"t"."Id"', $userIdList);
      $criteria->with = array('LinkEmail.Email');
      $users = \user\models\User::model()->findAll($criteria);

//      print \user\models\User::model()->count($criteria);
//      exit();

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

        if (preg_match("/@ashmanov.com/i", $email))
        {
          print 'is @Ashmanov<br />';
          continue;
        }

        $mail->AddAddress($email);
        $mail->SetFrom('calendar@runet-id.com', 'RUNET-ID:// Календарь', false);
        $mail->CharSet = 'utf-8';
        $mail->Subject = '=?UTF-8?B?'. base64_encode('FailOver Conference. Как защитить сайт от «падений»') .'?=';
        $mail->Body = $body;
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
    $secret = 'vyeavbdanfivabfdeypwgruqe'; // common

    $timestamp = time();
    $runetid = $user->RunetId;

    $hash = substr(md5($runetid . $secret . $timestamp), 0, 8); 
    return 'http://2013.russianinternetforum.ru/'.$runetid.'/'.$hash;
  }

}
