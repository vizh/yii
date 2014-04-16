<?php
namespace pay\controllers\admin\booking;

class FoodAction extends \CAction
{
  public function run()
  {
    $dates = ['2014-04-23', '2014-04-24', '2014-04-25'];
    $food = [
      'breakfast' => [1467, 1470, 1473],
      'lunch' => [1468, 1471, 1474],
      'dinner' => [1469, 1472, 1475],
      'banquet' => 1476,
      'anderson' => [2701, 2702, 2703]
    ];

    $all = array_merge($food['breakfast'], $food['lunch'], $food['dinner']);

    $users = \pay\components\admin\Rif::getUsersByHotel();

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