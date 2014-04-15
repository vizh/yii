<?php
namespace pay\controllers\admin\booking;


class StatisticsHotelAction extends \CAction
{
  const EventId = 789;
  const ManagerName = 'RoomProductManager';

  public function run($hotel)
  {

    $cmd = \BookingController::getRifDb()->createCommand();
    $cmd->select('*')->from('ext_booked_person');
    $result = $cmd->queryAll();
    $usersFullData = [];
    foreach ($result as $row)
    {
      $usersFullData[$row['ownerRunetId']] = $row;
    }

    $cmd = \BookingController::getRifDb()->createCommand();
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

    $criteria = new \CDbCriteria();
    $criteria->addInCondition('t."ProductId"', $idList);
    $criteria->addCondition('NOT t."Deleted" OR t."Paid"');
    $partnerBookings = \pay\models\RoomPartnerBooking::model()->findAll($criteria);

    $partnerBookingsByProduct = [];
    foreach ($partnerBookings as $booking)
    {
      $partnerBookingsByProduct[$booking->ProductId][] = $booking;
    }

    $this->getController()->render('statistics/hotel', [
      'products' => $products,
      'orderItemsByProduct' => $orderItemsByProduct,
      'usersFullData' => $usersFullData,
      'usersTogether' => $usersTogether,
      'partnerBookingsByProduct' => $partnerBookingsByProduct
    ]);
  }
} 