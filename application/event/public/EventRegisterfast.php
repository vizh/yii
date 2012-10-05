<?php
AutoLoader::Import('library.rocid.event.*');
AutoLoader::Import('library.rocid.user.*');

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
