<?php
namespace pay\controllers\admin\booking;

class FoodAction extends \CAction
{
  public function run()
  {
    $this->prepareUsers();

    $dates = ['2014-04-23', '2014-04-24', '2014-04-25'];
    $food = [
      'breakfast' => [1467, 1470, 1473],
      'lunch' => [1468, 1471, 1474],
      'dinner' => [1469, 1472, 1475],
      'banquet' => 1476,
      'anderson' => [2701, 2702, 2703]
    ];

    $all = array_merge($food['breakfast'], $food['lunch'], $food['dinner']);

    $users = $this->getUsersByHotel();

    $usersFood = [];
    $usersFood['breakfastP'] = $this->getFoodUsers($food['breakfast'], array_merge($users['ЛЕСНЫЕ ДАЛИ'], $users['НАЗАРЬЕВО'], $users['СОСНЫ']), true);
    $usersFood['breakfastN'] = $this->getFoodUsers($food['breakfast'], $users['НАЗАРЬЕВО']);
    $usersFood['breakfastS'] = $this->getFoodUsers($food['breakfast'], $users['СОСНЫ']);
    $usersFood['allOtherP'] = $this->getFoodUsers(array_merge($food['lunch'], $food['dinner']), $users['ЛЕСНЫЕ ДАЛИ'], true);
    $usersFood['allLD'] = $this->getFoodUsers($all, $users['ЛЕСНЫЕ ДАЛИ']);
    $usersFood['banquetP'] = $this->getFoodUsers([$food['banquet']], [], true);
    $usersFood['anderson'] = $this->getFoodUsers($food['anderson'], [], true);


    $this->getController()->render('food', [
      'dates' => $dates,
      'food' => $food,
      'usersFood' => $usersFood
    ]);
  }

  private function prepareUsers()
  {
    $cmd = \BookingController::getRifDb()->createCommand();
    $cmd->select('*')->from('ext_booked_person_together')->where('userRunetId IS NULL');
    $result = $cmd->queryAll();

    foreach ($result as $row)
    {
      $row['userName'] = trim($row['userName']);
      $user = \user\models\User::model()
        ->byEventId(\BookingController::EventId)->bySearch($row['userName'])->find();
      if ($user == null)
      {
        $parts = explode(' ', $row['userName']);
        if (count($parts) == 3)
        {
          $user = \user\models\User::model()
            ->byEventId(\BookingController::EventId)->bySearch($parts[0] . ' ' . $parts[1])->find();
        }
      }

      if ($user != null)
      {
        \BookingController::getRifDb()->createCommand()->update('ext_booked_person_together', ['userRunetId' => $user->RunetId], 'id = :id', ['id' => $row['id']]);
      }
    }
  }

  private function getUsersByHotel()
  {
    $criteria = new \CDbCriteria();
    $criteria->with = ['Product' => ['together' => true]];
    $criteria->addCondition('"Product"."ManagerName" = :ManagerName');
    $criteria->params = ['ManagerName' => 'RoomProductManager'];
    $criteria->order = 't."PaidTime"';
    $roomItems = \pay\models\OrderItem::model()
      ->byEventId(\BookingController::EventId)->byPaid(true)->findAll($criteria);

    $cmd = \BookingController::getRifDb()->createCommand();
    $cmd->select('*')->from('ext_booked_person_together')->where('userRunetId IS NOT NULL');
    $result = $cmd->queryAll();

    $usersTogether = [];
    foreach ($result as $row)
    {
      $usersTogether[$row['ownerRunetId']][] = $row['userRunetId'];
    }

    $users = [];
    $owners = [];
    foreach ($roomItems as $item)
    {
      $owner = $item->ChangedOwnerId != null ? $item->ChangedOwner : $item->Owner;
      $users[$item->Product->getManager()->Hotel][] = $owner->RunetId;
      $owners[] = $owner->RunetId;
    }

    foreach ($roomItems as $item)
    {
      $owner = $item->ChangedOwnerId != null ? $item->ChangedOwner : $item->Owner;
      if (empty($usersTogether[$owner->RunetId]))
        continue;
      foreach ($usersTogether[$owner->RunetId] as $runetId)
      {
        if (in_array($runetId, $owners))
          continue;

        $users[$item->Product->getManager()->Hotel][] = $runetId;
        $owners[] = $runetId;
      }
    }
    return $users;
  }

  private function getFoodUsers($products, $users, $useNot = false)
  {
    $criteria = new \CDbCriteria();
    $criteria->with = [
      'Owner' => ['together' => true],
      'ChangedOwner' => ['together' => true]
    ];
    if (!$useNot)
    {
      $criteria->addCondition('t."ChangedOwnerId" IS NULL');
      $criteria->addInCondition('"Owner"."RunetId"', $users);
      $criteria->addInCondition('"ChangedOwner"."RunetId"', $users, 'OR');
    }
    else
    {
      $criteria->addNotInCondition('"Owner"."RunetId"', $users);
      //$criteria->addNotInCondition('"ChangedOwner"."RunetId"', $users);

      //var_dump($criteria);
    }
    $criteria->addInCondition('t."ProductId"', $products);


    $foodItems = \pay\models\OrderItem::model()->byPaid(true)->findAll($criteria);

    $result = [];
    foreach ($foodItems as $item)
    {
      $owner = $item->ChangedOwnerId != null ? $item->ChangedOwner : $item->Owner;
      $result[$item->ProductId][] = $owner->RunetId;
    }
    return $result;
  }
}