<?php

class OneuseController extends \application\components\controllers\AdminMainController
{
  public function actionIbcfood()
  {
    $criteria = new CDbCriteria();
    $criteria->addCondition('"t"."Id" IN (SELECT "UserId" FROM "EventParticipant" WHERE "EventId" = 688 AND "RoleId" IN (2,3,5,6))');
    $criteria->addCondition('"t"."Id" IN (SELECT "OwnerId" FROM "PayOrderItem" WHERE "ProductId" = 1373 AND "Paid")', 'OR');

    $users = \user\models\User::model()->findAll($criteria);

    /** @var \pay\models\Product[] $products */
    $products = [];
    $products[] = \pay\models\Product::model()->findByPk(1376);
    $products[] = \pay\models\Product::model()->findByPk(1377);

    $count = 0;
    foreach ($users as $user)
    {
      foreach ($products as $product)
      {
        $orderItem = \pay\models\OrderItem::model()
            ->byProductId($product->Id)->byOwnerId($user->Id)->find();
        if ($orderItem == null)
          $orderItem = $product->getManager()->createOrderItem($user, $user);
        if (!$orderItem->Paid)
        {
          $orderItem->activate();
          $count++;
        }
      }
    }

    echo $count;

  }

  public function actionAddRooms()
  {
    echo 'closed';
    return;
    $rooms = [];



    /**
    $rooms[] = [
      'TechnicalNumber' => '',
      'Hotel' => '',
      'Housing' => '',
      'Category' => '',
      'Number' => '',
      'EuroRenovation' => '',
      'RoomCount' => '',
      'PlaceTotal' => '',
      'PlaceBasic' => '',
      'PlaceMore' => '',
      'DescriptionBasic' => '',
      'DescriptionMore' => '',
      'Visible' => '',
      'Price' => '',
    ];
    */


    foreach ($rooms as $room)
    {
      $this->addRoom($room);
    }
  }

  private function addRoom($room)
  {
    $product = new \pay\models\Product();
    $product->ManagerName = 'RoomProductManager';
    $product->Title = 'Участие в объединенной конференции РИФ+КИБ 2014 с проживанием';
    $product->EventId = 789;
    $product->Unit = 'усл.';
    $product->EnableCoupon = false;
    $product->Public = false;
    $product->save();

    $price = new \pay\models\ProductPrice();
    $price->ProductId = $product->Id;
    $price->Price = $room['Price'];
    $price->StartTime = '2014-03-01 09:00:00';
    $price->save();

    foreach ($room as $key => $value)
    {
      $product->getManager()->$key = trim($value);
    }
  }

  public function actionDevconWaitlist()
  {
    $goodUsers = [];

    $orders = \pay\models\Order::model()
      ->byEventId(831)->byBankTransfer(true)->byDeleted(false)->findAll();
    foreach ($orders as $order)
    {
      foreach ($order->ItemLinks as $link)
      {
        $ownerId = $link->OrderItem->ChangedOwnerId == null ? $link->OrderItem->OwnerId : $link->OrderItem->ChangedOwnerId;
        $goodUsers[] = $ownerId;
      }
    }

    $goodUsers = array_unique($goodUsers);

    $criteria = new CDbCriteria();
    $criteria->with = ['Participants' => array('together' => true)];
    $criteria->addNotInCondition('t."Id"', $goodUsers);
    $criteria->addCondition('"Participants"."EventId" = :EventId AND "Participants"."RoleId" = :RoleId');
    $criteria->params['EventId'] = 831;
    $criteria->params['RoleId'] = 24;
    $criteria->order = 't."LastName", t."FirstName"';


    $badUsers = \user\models\User::model()->findAll($criteria);

    echo count($badUsers), '<br>';
    echo '<table>';
    foreach ($badUsers as $user)
    {
      echo '<tr>';
      $this->printTD($user->RunetId);
      $this->printTD($user->getFullName());
      $this->printTD($user->Email);
      echo '</tr>';
    }
    echo '</table>';

//    $event = \event\models\Event::model()->findByPk(831);
//    $role = \event\models\Role::model()->findByPk(64);
//
//    foreach ($badUsers as $user)
//    {
//      $event->registerUser($user, $role, true, 'Перевод в лист ожидания по запросу Натальи Ивановой');
//    }
    echo 'done';
  }

  private function printTD($value)
  {
    echo '<td>', $value, '</td>';
  }
} 