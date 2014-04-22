<?php
use pay\components\admin\Rif;

class Rif14Controller extends CController
{
  private static $hotels = [
    0 => Rif::HOTEL_P,
    1 => Rif::HOTEL_LD
  ];

  public function actionIndex($hotel, $product)
  {
    $hotel = intval($hotel);
    $product = intval($product);
    $food = [
      'breakfast' => [1467, 1470, 1473],
      'lunch' => [1468, 1471, 1474],
      'dinner' => [1469, 1472, 1475],
      'banquet' => 1476,
      'anderson' => [2701, 2702, 2703]
    ];

    $users = Rif::getUsersByHotel();

    $usersInclude = [];
    $usersExclude = [];
    if ($product == 1469)
    {
      if ($hotel == 0)
      {
        echo json_encode([], JSON_UNESCAPED_UNICODE);
        Yii::app()->end();
      }
    }
    elseif(in_array($product, $food['anderson']))
    {
      if ($hotel == 1)
      {
        echo json_encode([], JSON_UNESCAPED_UNICODE);
        Yii::app()->end();
      }
    }
    elseif ($hotel == 1)
    {
      $usersInclude = $users[Rif::HOTEL_LD];
    }
    elseif ($hotel == 0 && in_array($product, $food['breakfast']))
    {
      $usersExclude = array_merge($users[Rif::HOTEL_LD], $users[Rif::HOTEL_N], $users[Rif::HOTEL_S]);
    }
    elseif ($hotel == 0 && $product != $food['banquet'])
    {
      $usersExclude = $users[Rif::HOTEL_LD];
    }

    $criteria = new \CDbCriteria();
    $criteria->with = [
      'Owner',
      'ChangedOwner'
    ];
    $items = \pay\models\OrderItem::model()->byProductId($product)->byPaid(true)->findAll($criteria);

    $result = [];
    foreach ($items as $item)
    {
      $owner = $item->ChangedOwnerId != null ? $item->ChangedOwner : $item->Owner;
      if (!empty($usersInclude) && in_array($owner->RunetId, $usersInclude))
      {
        $result[] = $owner->RunetId;
      }
      elseif (!empty($usersExclude) && !in_array($owner->RunetId, $usersExclude))
      {
        $result[] = $owner->RunetId;
      }
      elseif (empty($usersExclude) && empty($usersInclude))
      {
        $result[] = $owner->RunetId;
      }
    }

    echo json_encode($result, JSON_UNESCAPED_UNICODE);
  }



  private function getUsersIdbyRunetId($runetIdList)
  {
    $command = Yii::app()->getDb()->createCommand();
    $command->select('Id')->from('User');
    $command->where('"RunetId" IN (' . implode(',', $runetIdList) . ')');

    $rows = $command->queryAll();
    $result = [];
    foreach ($rows as $row)
    {
      $result[] = $row['Id'];
    }
    return $result;
  }
} 