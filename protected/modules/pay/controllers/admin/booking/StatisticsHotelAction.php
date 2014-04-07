<?php
namespace pay\controllers\admin\booking;


class StatisticsHotelAction extends \CAction
{
  const EventId = 789;
  const ManagerName = 'RoomProductManager';

  public function run($hotel)
  {
    //echo $_SERVER['SERVER_ADDR'];
    //exit;

    $rifConnection = new \CDbConnection('mysql:host=109.234.156.202;dbname=rif2014', 'rif2014', 'eipahgoo9PeetieN');
    $cmd = $rifConnection->createCommand();
    $cmd->select('*')->from('ext_booked_person');
    $result = $cmd->queryAll();
    $usersFullData = [];
    foreach ($result as $row)
    {
      $usersFullData[$row['ownerRunetId']] = $row;
    }

    $cmd = $rifConnection->createCommand();
    $cmd->select('*')->from('ext_booked_person_together');
    $result = $cmd->queryAll();

    $usersTogether = [];
    foreach ($result as $row)
    {
      $usersTogether[$row['ownerRunetId']][] = $row['userName'];
    }

    $criteria = new \CDbCriteria();
    $criteria->with = ['Attributes' => ['together' => true, 'select' => false]];
    $criteria->condition = '"Attributes"."Name" = :Name AND "Attributes"."Value" ilike :Value';
    $criteria->params = ['Name' => 'Hotel', 'Value' => $hotel];
    $products = \pay\models\Product::model()->byEventId(self::EventId)->findAll($criteria);
    $idList = [];
    foreach ($products as $product)
    {
      $idList[] = $product->Id;
    }

    $criteria = new \CDbCriteria();
    $criteria->addInCondition('t."Id"', $idList);
    $criteria->order = 't."Id"';
    $products = \pay\models\Product::model()->findAll($criteria);

    $criteria = new \CDbCriteria();
    $criteria->addInCondition('t."ProductId"', $idList);
    $criteria->addCondition('NOT t."Deleted"');
    $orderItems = \pay\models\OrderItem::model()->findAll($criteria);

    $orderItemsByProduct = [];
    foreach ($orderItems as $item)
    {
      $orderItemsByProduct[$item->ProductId][] = $item;
    }

    $this->getController()->render('statistics/hotel', [
      'products' => $products,
      'orderItemsByProduct' => $orderItemsByProduct,
      'usersFullData' => $usersFullData,
      'usersTogether' => $usersTogether
    ]);
  }
} 