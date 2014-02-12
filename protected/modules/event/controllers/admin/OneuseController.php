<?php

class OneuseController extends \application\components\controllers\AdminMainController
{
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
      $this->printUserInfo($user);
    }
    echo '</table>';
  }

  public function actionCreators2()
  {
    echo 'closed';
    return;
    $positions = [
      '%Основатель%', '%Co-founder%', '%Президент%', '%Директор%',
      '%Руководитель%', '%PR%', 'Менеджер проектов', '%Маркетинг%',
      '%Marketing%', '%Event%', '%Эвент%'
    ];
    $positions = '\''.implode('\', \'',  $positions ).'\'';

    $exclude = ['%тех%', '%арт%'];
    $exclude = '\''.implode('\', \'',  $exclude ).'\'';

    $criteria = new CDbCriteria();
    $criteria->addCondition('"Employments"."Position" ~~* ANY(array['.$positions.'])');
    $criteria->addCondition('"Employments"."Primary"');
    $criteria->addCondition('"Employments"."Position" !~~* ALL(array['.$exclude.'])');
    $criteria->with = ['Employments' => ['together' => true]];


    $users = \user\models\User::model()->byEventId(425)->findAll($criteria);

    echo sizeof($users);

    $product = \pay\models\Product::model()->findByPk(1421);

    foreach ($users as $user)
    {
      //$item = $product->getManager()->createOrderItem($user, $user);
      //$item->Paid = true;
      //$item->PaidTime = date('Y-m-d H:i:s');
      //$item->save();
    }

//    echo '<table>';
//    foreach ($users as $user)
//    {
//      $this->printUserInfo($user);
//    }
//    echo '</table>';
  }

  public function actionUexproducts()
  {
    return;
    $eventId = 652;

    $criteria = new CDbCriteria();
    $criteria->addCondition('"t"."Controller" = :c1 AND "t"."Action" = :a1');
    $criteria->addCondition('"t"."Controller" = :c2 AND "t"."Action" = :a2', 'OR');
    $criteria->addCondition('"t"."EventId" = :EventId');
    $criteria->params = ['c1' => 'event', 'a1' => 'register', 'c2' => 'user', 'a2' => 'create', 'EventId' => $eventId];

    $model = \ruvents\models\DetailLog::model();

    /** @var \ruvents\models\DetailLog[] $logs */
    $logs = $model->findAll($criteria);

    $usersId = [];

    foreach ($logs as $log)
    {
      $messages = $log->getChangeMessages();

      foreach ($messages as $message)
      {
        if ($message->key == 'Role' && $message->to == 1)
        {
          $usersId[] = $log->UserId;
        }
      }

    }

    $participants = \event\models\Participant::model()
        ->byEventId($eventId)->byRoleId(1)->byPartId(19)
        ->findAll([
          'with' => ['User' => ['together' => true]],
          'order' => '"User"."LastName"'
        ]);
    $count = 0;
    echo '<table>';
    foreach ($participants as $participant)
    {
      if (!in_array($participant->UserId, $usersId))
      {
        $this->printUserInfo($participant->User);
        $count++;
      }
    }
    echo '</table>';

    echo $count;
  }

  /**
   * @param \user\models\User $user
   */
  private function printUserInfo($user)
  {
    $data = [];
    $data[] = $user->RunetId;
    $data[] = $user->getFullName();
    //$data[] = $user->Email;
    if ($user->getEmploymentPrimary() != null)
    {
      $data[] = $user->getEmploymentPrimary()->Company->Name;
      $data[] = $user->getEmploymentPrimary()->Position;
    }
    else
    {
      $data[] = '';
      $data[] = '';
    }
//    if (!empty($user->Participants))
//    {
//      $data[] = $user->Participants[0]->Role->Title;
//    }
//    else
//    {
//      $data[] = 'не участвует';
//    }
    echo '<tr><td>' . implode('</td><td>', $data) . '</td></tr>';
  }

  public function actionPlog()
  {
    return;
    $eventId = 831;

    $sql = 'SELECT ep.* FROM "EventParticipant" ep

LEFT JOIN "EventParticipantLog" epl ON ep."EventId" = epl."EventId" AND ep."UserId" = epl."UserId"

WHERE epl."Id" IS NULL AND ep."EventId" = 831';

    $command = Yii::app()->getDb()->createCommand();
    $result = $command->select('ep.*')->from('EventParticipant ep')
      ->leftJoin('EventParticipantLog epl', 'ep."EventId" = epl."EventId" AND ep."UserId" = epl."UserId"')
      ->where('epl."Id" IS NULL AND ep."EventId" = :EventId')->query(['EventId' => $eventId]);

    foreach ($result as $row)
    {
      $pl = new \event\models\ParticipantLog();
      $pl->EventId = $row['EventId'];
      $pl->PartId = $row['PartId'];
      $pl->UserId = $row['UserId'];
      $pl->RoleId = $row['RoleId'];
      $pl->CreationTime = $row['CreationTime'];
      //$pl->save();
    }

    echo 'Done';

  }
}