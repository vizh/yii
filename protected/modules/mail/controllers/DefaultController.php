<?php
class DefaultController extends \application\components\controllers\AdminMainController
{
  public function actionSend($step = 0)
  {
    set_time_limit(84600);
    error_reporting(E_ALL & ~E_DEPRECATED);

    $isHTML = false;
    $logPath =  \Yii::getPathOfAlias('application').DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR;    
    $fp = fopen($logPath.'rif203.log',"a+");
    $j = 0;
    
    $criteria = new \CDbCriteria();
    
    $criteria->with = array('User');
    $criteria->condition = '"User"."RunetId" = 321';
    $criteria->limit = 1;
    
    $criteria->addInCondition('"t"."RoleId"', array(1,24));
    $criteria->limit = 100;
    $criteria->offset = $step * $criteria->limit;
    $participants = \event\models\Participant::model()->byEventId(422)->findAll($criteria);
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
      foreach ($users as $user)
      {
        // ПИСЬМО
        $body = $this->renderPartial('send', array('user' => $user, 'regLink' => $this->getRegLink($user)), true);
        $mail = new \ext\mailer\PHPMailer(false);
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
        fwrite($fp, $user->RunetId.'-'.$email."\n");
   
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
          continue;
        }
        $mail->AddAddress($email);
        $mail->SetFrom('users@rif.ru', 'РИФ+КИБ 2013', false);
        $mail->CharSet = 'utf-8';
        $mail->Subject = '=?UTF-8?B?'. base64_encode('#rif2013 прибывает по расписанию!') .'?=';
        $mail->Body = $body;
        $mail->Send();
        exit();
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
