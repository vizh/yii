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
    $eventId = 652;
    $orderItems = \pay\models\OrderItem::model()->byEventId($eventId)->byPaid(true)->findAll();

    $usersId = [158851, 158877, 159011, 159012, 159013, 159353];
    foreach ($orderItems as $item)
    {
      if ($item->getPriceDiscount() > 0 && $item->ProductId != 1414)
      {
        $usersId[] = $item->ChangedOwnerId == null ? $item->OwnerId : $item->ChangedOwnerId;
      }
    }
    $usersId = array_unique($usersId);

    $product = \pay\models\Product::model()->findByPk(1435);

//    var_dump($usersId);
//
//    echo count($orderItems);
//
//    exit;

    $addedCount = 0;

    foreach ($usersId as $id)
    {
      $model = \pay\models\OrderItem::model()->byOwnerId($id)->byProductId($product->Id)->byPaid(true);
      $user = \user\models\User::model()->findByPk($id);
      if (!$model->exists() && $user !== null)
      {
        $orderItem = $product->getManager()->createOrderItem($user, $user);
        $orderItem->Paid = true;
        $orderItem->PaidTime = date('Y-m-d H:i:s');
        $orderItem->save();
        $addedCount++;
      }
    }

   echo $addedCount;

  }

  /**
   * @param \user\models\User $user
   */
  private function printUserInfo($user)
  {
    $data = [];
    $data[] = $user->RunetId;
    $data[] = $user->getFullName();
    $data[] = $user->Email;
    if ($user->getEmploymentPrimary() != null)
    {
      //$data[] = $user->getEmploymentPrimary()->Company->Name;
      $data[] = $user->getEmploymentPrimary()->Position;
    }
    else
    {
      //$data[] = '';
      $data[] = '';
    }
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
}