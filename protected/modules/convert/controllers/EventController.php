<?php
class EventController extends \convert\components\controllers\Controller
{
  /**
   * Переносит мероприятия 
   */
  public function actionIndex()
  {
    $events = $this->queryAll('SELECT * FROM `Event` ORDER BY `EventId`');
    foreach ($events as $event)
    {
      $newEvent = new \event\models\Event();
      $newEvent->Id = $event['EventId'];
      $newEvent->IdName = $event['IdName'];
      $newEvent->Title = $event['Name'];
      $newEvent->Info  = $event['Info'];
      if (!empty($event['FullInfo']))
      {
        $newEvent->FullInfo = $event['FullInfo'];
      }
      $newEvent->Visible = $event['Visible'] == 'Y' ? true : false;
      if ($event['DateStart'] != '0000-00-00')
      {
        $date = explode('-', $event['DateStart']);
        $newEvent->StartYear = $date[0];
        $newEvent->StartMonth = $date[1];
        $newEvent->StartDay = $date[2];
      }
      
      if ($event['DateEnd'] != '0000-00-00')
      {
        $date = explode('-', $event['DateEnd']);
        $newEvent->EndYear = $date[0];
        $newEvent->EndMonth = $date[1];
        $newEvent->EndDay = $date[2];
      }
      $newEvent->save();
      
      $widgets = array(
        'event\widgets\Header', 
        'event\widgets\About',
        'event\widgets\Comments',
        'event\widgets\Users',
        'event\widgets\Contacts',
        'event\widgets\Location'
      );
      foreach ($widgets as $widget)
      {
        $eventWidget = new \event\models\Widget();
        $eventWidget->EventId = $newEvent->Id;
        $eventWidget->Name = $widget;
        $eventWidget->save();
      }
    }
  }
  
  /** 
   * Переносит атрибуты
   */
  public function actionAttributes()
  {
    $events = $this->queryAll('SELECT * FROM `Event` ORDER BY `EventId`');
    foreach ($events as $event)
    {
      
    }
  }
  
  /**
   * Переносит участников мероприятий 
   */
  public function actionParticipants()
  {
    $participants = $this->queryAll('SELECT * FROM `EventUser` ORDER BY `EventUserId` ASC');
    foreach ($participants as $participant)
    {
      $newParticipant = new \event\models\Participant();
      $newParticipant->Id = $participant['EventUserId'];
      $newParticipant->EventId = $participant['EventId'];
      $newParticipant->UserId = $participant['UserId'];
      $newParticipant->RoleId = $participant['RoleId'];
      
      if (!empty($participant['DayId']))
      {
        $newParticipant->PartId = $participant['DayId'];
      }
      
      if ($participant['CreationTime'] != 0)
      {
        $newParticipant->CreationTime = date('Y-m-d H:i:s', $participant['CreationTime']);
      }
      
      if ($participant['UpdateTime'] != 0)
      {
        $newParticipant->UpdateTime = date('Y-m-d H:i:s', $participant['UpdateTime']);
      }
      $newParticipant->save();
    }
  }
  
  /**
   * Переносит связь с адресами
   */
  public function actionLinkaddress()
  {
    $links = $this->queryAll('SELECT * FROM `Link_Event_ContactAddress` ORDER BY `NMID` ASC');
    foreach ($links as $link)
    {
      $newLink = new \event\models\LinkAddress();
      $newLink->Id = $link['NMID'];
      $newLink->AddressId = $link['AddressId'];
      $newLink->EventId = $link['EventId'];
      $newLink->save();
    }
  }
  
  /** 
   * Перенос дней мероприятий
   */
  public function actionDays()
  {
    $days = $this->queryAll('SELECT * FROM `EventDay` ORDER BY `DayId` ASC');
    foreach ($days as $day)
    {
      $newPart = new \event\models\Part();
      $newPart->Id = $day['DayId'];
      $newPart->EventId = $day['EventId'];
      $newPart->Title = $day['Title'];
      $newPart->Order = $day['Order'];
      $newPart->save();
    }
  }
  
  /**
   * Перенос ролей
   */
  public function actionRoles()
  {
    $roles = $this->queryAll('SELECT * FROM `EventRoles` ORDER BY `RoleId` ASC');
    foreach ($roles as $role)
    {
      $newRole = new \event\models\Role();
      $newRole->Id = $role['RoleId'];
      $newRole->Code = $role['Type'];
      $newRole->Title = $role['Name'];
      $newRole->Priority = $role['Priority'];
      $newRole->save();
    }
  }
  
  /**
   * Перенос Url на сайты 
   * Важно! Переносить только после того, как пересенные Контаты
   */
  public function actionSites()
  {
    $events = $this->queryAll('SELECT * FROM `Event` ORDER BY `EventId`');
    foreach ($events as $event)
    {
      if (!empty($event['Url']))
      {
        $site = new \contact\models\Site();
        $url = $event['Url'];
        if (strpos($url, 'https://'))
        {
          $site->Secure = true;
        }
        $site->Url = str_replace(array('https://', 'http://', 'www.'), '', $url);
        $site->save();
        $linkSite = new \event\models\LinkSite();
        $linkSite->EventId = $event['EventId'];
        $linkSite->SiteId = $site->Id;
        $linkSite->save();
      }
    }
  }
}