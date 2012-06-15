<?php
AutoLoader::Import('library.rocid.activity.*');
AutoLoader::Import('library.rocid.activity.userchanges.*');

class ActivityOutput
{
  private static $Types = array('users', 'events', 'media', 'companies');

  const TypeUser = 'users';
  const TypeEvent = 'events';
  const TypeMadia = 'media';
  const TypeCompany = 'companies';

  /**
   * @static
   * @param int $userId
   * @param int $count
   * @param array $types
   * @return string
   */
  public static function GetHtml($userId, $count, $types)
  {
    $mainView = new View();
    $mainView->SetTemplate('main', 'core', 'activity', '', 'public');
    $mainViewContainer = new ViewContainer();
    if (in_array(self::TypeUser, $types))
    {
      $interestPersons = UserInterestPerson::GetInterestPersons($userId);
      $ids = array();
      foreach($interestPersons as $person)
      {
        $ids[] = $person->InterestUserId;
      }
      $changes = UserChanges::GetLastChanges($ids, $count);
      if (! empty($changes))
      {
        $curDate =date('Y-m-d', $changes[0]->CreationTime);
        $dayView = new View();
        $dayView->SetTemplate('day', 'core', 'activity', '', 'public');
        $dayView->Date = getdate($changes[0]->CreationTime);
        $dayViewContainer = new ViewContainer();
        foreach ($changes as $change)
        {
          if ($curDate != date('Y-m-d', $change->CreationTime))
          {
            if (!$dayViewContainer->IsEmpty())
            {
              $dayView->DayLines = $dayViewContainer;
              $mainViewContainer->AddView($dayView);
            }
            $curDate =date('Y-m-d', $change->CreationTime);
            $dayView = new View();
            $dayView->SetTemplate('day', 'core', 'activity', '', 'public');
            $dayView->Date = getdate($change->CreationTime);
            $dayViewContainer = new ViewContainer();
          }
          $action = $change->GetAction();
          $action->SetUser($change->User);
          $dayViewContainer->AddView($action->GetView());
        }
        if (! $dayViewContainer->IsEmpty())
        {
          $dayView->DayLines = $dayViewContainer;
          $mainViewContainer->AddView($dayView);
        }
        $mainView->Days = $mainViewContainer;
      }
      else
      {
        $empty = new View();
        $empty->SetTemplate('empty', 'core', 'activity', '', 'public');
        $mainView->Days = $empty;
      }
    }

    return $mainView;
  }
}
