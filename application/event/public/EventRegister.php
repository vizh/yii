<?php

class EventRegister extends GeneralCommand
{


  /**
   * Основные действия комманды
   * @param string $idName
   * @return void
   */
  protected function doExecute($idName = '')
  {
    $event = Event::GetEventByIdName($idName);
    if (empty($event) || $event->FastRole == null)
    {
      $this->Send404AndExit();
    }

    $this->view->Name = $event->Name;
    $this->view->IdName = $event->IdName;

    if ($this->LoginUser !== null)
    {
      if (Yii::app()->getRequest()->getIsPostRequest())
      {
        $eventUser = EventUser::GetByUserEventId($this->LoginUser->UserId, $event->EventId);
        if (empty($eventUser))
        {
          $eventUser = new EventUser();
          $eventUser->EventId = $event->EventId;
          $eventUser->UserId = $this->LoginUser->UserId;
          $eventUser->RoleId = $event->FastRole;
          $eventUser->Approve = 0;
          $eventUser->CreationTime = $eventUser->UpdateTime = time();
          $eventUser->save();
        }
        $this->view->SetTemplate('success');
      }
    }
    else
    {
      $this->view->SetTemplate('not-auth');
    }


    echo $this->view;
  }
}
