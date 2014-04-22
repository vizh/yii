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

  public function actionAdd($runetId, $productId)
  {
    $user = \user\models\User::model()->byRunetId($runetId)->find();
    if ($user == null)
      throw new \ruvents\components\Exception(202,[$runetId]);

    $product = \pay\models\Product::model()->findByPk($productId);
    if ($product == null)
      throw new \ruvents\components\Exception(401,[$productId]);

    $exists = \pay\models\ProductGet::model()->byUserId($user->Id)->byProductId($product->Id)->exists();
    if ($exists)
      throw new \ruvents\components\Exception(420);

    $get = new \pay\models\ProductGet();
    $get->UserId = $user->Id;
    $get->ProductId = $product->Id;
    $get->save();
    $get->refresh();
    echo json_encode(['Success' => true, 'CreationTime' => $get->CreationTime]);
  }

  public function actionList($productId, $fromTime = null)
  {
    $criteria = new \CDbCriteria();
    $criteria->with = ['User'];
    $criteria->order = '"t"."CreationTime" ASC';

    $product = \pay\models\Product::model()->findByPk($productId);
    if ($product == null)
      throw new \ruvents\components\Exception(401,[$productId]);

    $criteria->addCondition('"t"."ProductId" = :ProductId');
    $criteria->params['ProductId'] = $product->Id;

    if (!empty($fromTime))
    {
      $datetime = DateTime::createFromFormat('Y-m-d H:i:s', $fromTime);
      if ($datetime === false)
        throw new \ruvents\components\Exception(321);

      $criteria->addCondition('"t"."CreationTime" >= :Time');
      $criteria->params['Time'] = $datetime->format('Y-m-d H:i:s');
    }

    $gets = \pay\models\ProductGet::model()->findAll($criteria);
    $result = [];
    foreach ($gets as $get)
    {
      $item = new \stdClass();
      $item->UserId = $get->User->RunetId;
      $item->ProductId = $get->ProductId;
      $item->CretionTime = $get->CreationTime;
      $result[] = $item;
    }
    echo json_encode($result);
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

  public function createLog()
  {
    return null;
  }
} 