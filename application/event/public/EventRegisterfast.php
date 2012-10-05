<?php
AutoLoader::Import('library.rocid.event.*');
AutoLoader::Import('library.rocid.user.*');

// TODO: Только для мероприятия 357, потом удалить
AutoLoader::Import('library.mail.*');



class EventRegisterfast extends GeneralCommand
{
  protected function doExecute($eventId = null, $rocId = null, $roleId = null, $code = null) 
  {
    $event = Event::GetById($eventId);
    if ($event !== null
      && $event->getRegistrationSecret($rocId, $roleId) == $code)
    {
      $role  = EventRoles::GetById($roleId);
      $user  = User::GetByRocid($rocId);
      if ($role == null || $user == null)
      {
        $this->Send404AndExit();
      }
      
      $register = $event->RegisterUser($user, $role);
      if ($register == null)
      {
        $eventUser = EventUser::model()->byEventId($event->EventId)->byUserId($user->UserId)->find();
        if ($role->Priority > $eventUser->EventRole->Priority)
        {
          $eventUser->RoleId = $role->RoleId;
          $eventUser->save();
        }
      }
      else {
        // TODO: Только для мероприятия 357, потом удалить
        if ($eventId == 357)
        {
          if (($email = $user->GetEmail()) !== null)
          {
            $view = new View();

            $view->SetTemplate('mail-event357');
            $secret = 'dfgdsl;jHKLJdv;lFlJe34n;ssf1';
            $view->Name = $user->GetFullName();
            $view->Link = 'http://invite.rocid.ru/?ROCID='.$user->RocId.'&KEY='.substr(md5($rocId.$secret), 0, 16);

            $mail = new PHPMailer(false);
            $mail->AddAddress($email->Email);
            $mail->SetFrom('info@russianinternetweek.ru', 'Премия «Облака 2012»', false);
            $mail->CharSet = 'utf-8';
            $mail->Subject = '=?UTF-8?B?'. base64_encode('Премия «Облака 2012»') .'?=';
            $mail->IsHTML(false);
            $mail->ContentType = 'text/plain';
            $mail->Body = $view;
            $mail->Send();
          }
        }
      }
      
      if (Yii::app()->user->isGuest
        || Yii::app()->user->getId() !== $user->UserId)
      {
        $identity = new FastAuthIdentity($user->RocId);
        $identity->authenticate();
        if ($identity->errorCode == CUserIdentity::ERROR_NONE)
        {
          Yii::app()->user->login($identity, $identity->GetExpire()); 
          Lib::Redirect(
            RouteRegistry::GetUrl('event', '', 'registerfast', array('eventId' => $eventId, 'rocId' => $rocId, 'roleId' => $roleId, 'code' => $code))
          );
        }
      }
      $this->view->Event = $event;
      $this->view->Role = $role;
      echo $this->view;
    }
    else
    {
      $this->Send404AndExit();
    }
  }
}
