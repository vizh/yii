<?php

class OneuseController extends \application\components\controllers\AdminMainController
{
  public function actionClearphdays()
  {
    $eventId = 497;

    $command = \Yii::app()->getDb()->createCommand()
        ->select('EventParticipant.UserId')->from('EventParticipant')
        ->where('"EventParticipant"."EventId" = '.$eventId);

    $criteria = new \CDbCriteria();
    $criteria->addCondition('"t"."Id" IN ('.$command->getText().')');
    $criteria->limit = 200;

    $users = \user\models\User::model()->findAll($criteria);


    $counterExist = 0;
    $counterDelete = 0;
    foreach ($users as $user)
    {
      $flag = false;
      foreach ($user->Participants as $participant)
      {
        if ($participant->EventId == $eventId)
        {
          $participant->delete();
        }
        else
        {
          $flag = true;
        }
      }
      if (!$flag)
      {
        $user->Visible = false;
        $user->save();
        $counterDelete++;
      }
      else
      {
        $counterExist++;
      }
    }

    echo 'Оставлено: ' . $counterExist . ' Удалено: ' . $counterDelete;

  }

  public function actionCreators()
  {
    return;
    /** @var \event\models\Event[] $events */
    $events = \event\models\Event::model()->findAll('"t"."External"');

    $emails = [];
    $runetIds = [];
    foreach ($events as $event)
    {
      if (isset($event->ContactPerson))
      {
        $contact = unserialize($event->ContactPerson);
        if (isset($contact['Email']))
        {
          $emails[] = $contact['Email'];
        }
        if (isset($contact['RunetId']))
        {
          $runetIds[] = $contact['RunetId'];
        }
      }
    }

    $criteria = new CDbCriteria();
    $criteria->addInCondition('"t"."RunetId"', $runetIds);
    $criteria->addInCondition('"t"."Email"', $emails, 'OR');
    $criteria->addCondition('"t"."Email" != \'alaris.nik@gmail.com\'');
    $criteria->with = [
      'Participants' => ['together' => true, 'on' => '"Participants"."EventId" = 425']
    ];
    $criteria->order = '"t"."RunetId"';
    $users = \user\models\User::model()->findAll($criteria);

    echo '<table>';
    foreach ($users as $user)
    {
      $data = [];
      $data[] = $user->RunetId;
      $data[] = $user->getFullName();
      $data[] = $user->Email;
      if (!empty($user->Participants))
      {
        $data[] = $user->Participants[0]->Role->Title;
      }
      else
      {
        $data[] = 'не участвует';
      }
      echo '<tr><td>' . implode('</td><td>', $data) . '</td></tr>';
    }
    echo '</table>';
  }
}