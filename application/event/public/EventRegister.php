<?php
AutoLoader::Import('library.rocid.pay.*');

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
    $product = null;
    if (empty($event) || ($event->FastRole == null && $event->FastProduct == null))
    {
      $this->Send404AndExit();
    }

    $this->view->Event = $event;
    if (!empty($event->FastProduct))
    {
      $product = Product::GetById($event->FastProduct);
      $this->view->Product = $product;
    }

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
