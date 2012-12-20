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
}