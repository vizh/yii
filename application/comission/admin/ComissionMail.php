<?php
AutoLoader::Import('comission.source.*');
AutoLoader::Import('library.mail.*');
 
class ComissionMail extends AdminCommand
{
  const MailTemplate = 'vote-7';
  const MailHeader = 'РАЭК: ГОЛОСОВАНИЕ ПО ОТРАСЛЕВОМУ СОГЛАШЕНИЮ';
  const ComissionId = 4;
  const VoteId = 7;

  /**
   * @var View
   */
  private $mail;

  /**
   * @var ComissionVote
   */
  private $vote;

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $this->vote = ComissionVote::GetById(self::VoteId);

    set_time_limit(0);
    $criteria = new CDbCriteria();
    $criteria->with = array('User.Settings' => array('together' => true, 'select' => false));

    $criteria->condition = 't.ComissionId = :ComissionId AND t.ExitTime is NULL AND Settings.Visible = :Visible';// AND Settings.ProjNews = :ProjNews';
    $criteria->params = array(':ComissionId' => self::ComissionId, ':Visible' => '1');//, ':ProjNews' => '1');
    $criteria->addNotInCondition('t.RoleId', array(5));

    $model = ComissionUser::model()->with(array('User', 'User.Emails'));

    /* Шаблон сообщений */
    $this->mail = new View();
    $this->mail->SetTemplate(self::MailTemplate);

    $fp = fopen(self::MailTemplate.'.log',"a+");

    //Заменять на соответствующую модель
    //$userModel = User::model()->with(array('Emails', 'Settings' => array('select' => false, 'together' => true)));



    echo $model->count($criteria);
    return;

    $users = $model->findAll($criteria);


    // TEST
    //$user = User::GetByRocid(35287);
    //$users[] = (object)array('User' => $user);

    $j=0;
    foreach ($users as $user)
    {
//      if ($user->User->RocId != 35287)
//      {
//        continue;
//      }
//      echo $user->User->RocId;
      $this->sendMail($user->User);
      if ($j == 200) { sleep(3); $j = 0; }; $j++;
      fwrite($fp, "{$user->User->RocId}\n");
    }
    fwrite($fp, "\n\n\n" . sizeof($users) . "\n\n\n");

    echo 'All send!!!';
  }

  /**
   * @param User $user
   * @return void
   */
  private function sendMail($user)
  {
    $this->mail->FirstName = $user->FirstName;
    $this->mail->FatherName = $user->FatherName;
    $this->mail->RocId = $user->RocId;

//    if (!empty($user->EventUsers) && $user->EventUsers[0]->RoleId != 1)
//    {
//      return;
//    }

    $this->mail->VoteLink = $this->getVoteLink($user);

    $mail = new PHPMailer(false);
    $mail->ParamOdq = false;
    $mail->ContentType = 'text/plain';
    $mail->IsHTML(false);
    $email = !empty($user->Emails) ? $user->Emails[0]->Email : $user->Email;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      return;
    }
    $mail->AddAddress($email);
    $mail->SetFrom('levova@raec.ru', 'Ирина ЛЕВОВА', false);
    $mail->CharSet = 'utf-8';
    $mail->Subject = '=?UTF-8?B?'. base64_encode(self::MailHeader) .'?=';
    $mail->Body = $this->mail;
    //$mail->Send();

    //echo $this->mail;
  }



  /**
   * @param User $user
   * @return string
   */
  private function getVoteLink($user)
  {
    return RouteRegistry::GetUrl('comission', 'vote', 'process', array('id' => $this->vote->VoteId, 'rocid' => $user->RocId, 'hash' => $this->vote->GetHash($user->RocId)));
  }
}
