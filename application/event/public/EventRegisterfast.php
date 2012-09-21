<?php
AutoLoader::Import('library.rocid.event.*');
AutoLoader::Import('library.rocid.user.*');

class EventRegisterfast extends GeneralCommand
{
  protected function doExecute($code = '') 
  {
    $params = Event::ParseRegisterCode($code);
    
    if (!empty($params))
    {
      $user  = User::GetByRocid($params['RocId']);
      $role  = EventRoles::GetById($params['RoleId']);
      $event = Event::GetById($params['EventId']);
      if ($user == null 
        || $role == null || $event == null)
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
      
      $identity = new FastAuthIdentity($user->RocId);
      $identity->authenticate();
      if ($identity->errorCode == CUserIdentity::ERROR_NONE)
      {
        Yii::app()->user->login($identity, $identity->GetExpire());
        $this->view->Event = $event;
        $this->view->Role = $role;
        echo $this->view();
        return;
      }
    }
    $this->Send404AndExit();
  }
}
