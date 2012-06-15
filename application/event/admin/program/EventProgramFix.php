<?php

class EventProgramFix extends AdminCommand
{

  private $userIdList = array();

  /**
   * Основные действия комманды
   * @param int $eventId
   * @return void
   */
  protected function doExecute($eventId = 0)
  {
    $eventId = intval($eventId);
    $userLinksModel = EventProgramUserLink::model()->with('User', 'User.EventUsers');

    $criteria = new CDbCriteria();
    $criteria->condition = 't.EventId = :EventId';
    $criteria->params[':EventId'] = $eventId;

    /** @var $userLinks EventProgramUserLink[] */
    $userLinks = $userLinksModel->findAll($criteria);

    foreach ($userLinks as $link)
    {
      $flag = false;
      foreach ($link->User->EventUsers as $eventUser)
      {
        /** @var $eventUser EventUser */
        if ($eventUser->EventId == $link->EventId)
        {
          if ($eventUser->RoleId == 1 || $eventUser->RoleId == 11)
          {
            $eventUser->RoleId = 3;
            $eventUser->UpdateTime = time();
            $eventUser->save();
          }
          $flag = true;
          break;
        }
      }

      if (! $flag && !in_array($link->UserId, $this->userIdList))
      {
        $eventUser = new EventUser();
        $eventUser->UserId = $link->UserId;
        $eventUser->EventId = $link->EventId;
        $eventUser->RoleId = 3; //Докладчик
        $eventUser->CreationTime = $eventUser->UpdateTime = time();
        $eventUser->save();

        $this->userIdList[] = $link->UserId;
        echo 'Not in event list: ' . $link->User->LastName . ' ' . $link->User->FirstName . '<br>';
      }
    }
  }
}
