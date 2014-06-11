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

    public function actionDevconinfo()
    {


        $orderItems = \pay\models\OrderItem::model()->byEventId(831)->byPaid(true)->findAll();

        $waitWithPaid = [];
        $baditems = [];
        foreach ($orderItems as $item) {
            $owner = $item->ChangedOwnerId === null ? $item->Owner : $item->ChangedOwner;
            $participant = \event\models\Participant::model()
                ->byEventId(831)->byUserId($owner->Id)->find();

            if ($participant->RoleId != 1) {
                $waitWithPaid[] = $participant->User->RunetId;
                $baditems[] = $item->Id;
            }
        }

        echo count($orderItems);
        echo '<br><br><br>';
        echo count($waitWithPaid);
        echo '<br><br><br>';
        print_r($waitWithPaid);
        echo '<br><br><br>';
        print_r($baditems);
    }

    public function actionDevconinfo2()
    {
        $orders = \pay\models\Order::model()->byEventId(831)->byPaid(true)->findAll();

        foreach ($orders as $order) {
            $total = 0;
            foreach ($order->ItemLinks as $link) {
                $total += $link->OrderItem->getPriceDiscount();
            }

            if (abs($total - $order->Total) > 5) {
                echo sprintf("order: %d diff: %d %d <br>", $order->Id, $order->Total, $total);
            }

        }
    }

    public function actionDevconphones() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, 'http://3ad2a593e0bb46d3a47b2032868a9586.cloudapp.net/api/MaterialVoting/GetUserIDAssignments');
        $result = curl_exec($ch);
        $data = json_decode($result);

        $countAddPhone = 0;
        $countAddExternalId = 0;
        $countBadExtId = 0;

        $countAddCountry = 0;
        $countAddCity = 0;

        foreach ($data as $row) {
            $extUser = \api\models\ExternalUser::model()->byExternalId($row->UserID)->find();
            if ($extUser != null) {
                $user = \user\models\User::model()->findByPk($extUser->UserId);

                /*$row->Phone = trim($row->Phone);
                if ($user->getContactPhone() == null && !empty($row->Phone)) {
                    $user->setContactPhone($row->Phone, \contact\models\PhoneType::Mobile);
                    $countAddPhone++;
                }*/

                $row->Country = trim($row->Country);
                $model = \pay\models\EventUserAdditionalAttribute::model()
                    ->byUserId($user->Id)->byEventId(831)->byName('Country');
                if (!empty($row->Country) && !$model->exists()) {
                    $attribute = new \pay\models\EventUserAdditionalAttribute();
                    $attribute->UserId = $user->Id;
                    $attribute->EventId = 831;
                    $attribute->Name = 'Country';
                    $attribute->Value = $row->Country;
                    $attribute->save();

                    $countAddCountry++;
                }

                $row->City = trim($row->City);
                $model = \pay\models\EventUserAdditionalAttribute::model()
                    ->byUserId($user->Id)->byEventId(831)->byName('City');
                if (!empty($row->City) && !$model->exists()) {
                    $attribute = new \pay\models\EventUserAdditionalAttribute();
                    $attribute->UserId = $user->Id;
                    $attribute->EventId = 831;
                    $attribute->Name = 'City';
                    $attribute->Value = $row->City;
                    $attribute->save();

                    $countAddCity++;
                }


                /*if ($extUser->ShortExternalId === null && !empty($row->WPUserID)) {
                    $extUser->ShortExternalId = trim($row->WPUserID);
                    $extUser->save();
                    $countAddExternalId++;
                }
                elseif (!empty($row->WPUserID) && $extUser->ShortExternalId != $row->WPUserID) {
                    $countBadExtId++;
                }*/
            }
        }

        echo sprintf('Add phones: %d, add extId: %d, bad ext id: %d, add country: %d, add city: %d', $countAddPhone, $countAddExternalId, $countBadExtId, $countAddCountry, $countAddCity);
    }

    public function actionDevconimportproduct()
    {
      $products = [
        'ГК' => 2765,
        'Без проживания' => 2764,
        'Обед 28-29 мая' => 2763,
        'Обед 29 мая' => 2762,
        'Обед 28 мая' => 2761,
        'Анива' => 2760,
        '4 корпус' => 2759,
        'Обед 29.05' => 2762,
        'без проживания' => 2764
      ];


      \Yii::import('ext.PHPExcel.PHPExcel', true);
      $excel = \PHPExcel_IOFactory::load(\Yii::getPathOfAlias('pay.data.DevCon2014_Register').'.xlsx');
      $worksheet = $excel->getSheet(0);

      $columns = [];
      foreach ($worksheet->getRowIterator(2) as $row)
      {
        /** @var $row \PHPExcel_Worksheet_Row */
        $cellIterator = $row->getCellIterator();
        //$cellIterator->setIterateOnlyExistingCells(false);
        foreach ($cellIterator as $cell)
        {
          /** @var $cell \PHPExcel_Cell */
          $value = trim($cell->getValue());
          if (!empty($value))
          {
            $columns[] = $cell->getColumn();
          }
        }
      }
      $columns = array_unique($columns);
      sort($columns, SORT_STRING);

      for ($i = 2; $i <= $worksheet->getHighestRow(); $i++)
      {
        $criteria = new \CDbCriteria();
        $criteria->addCondition('"t"."FirstName" ILIKE :FirtsName');
        $criteria->addCondition('"t"."LastName" ILIKE :LastName');
        $criteria->addCondition('"Role"."Title" = :Role AND "Participants"."EventId" = 831');
        $criteria->with = ['Participants.Role'];
        $criteria->params['FirtsName'] = trim($worksheet->getCell('B'.$i)->getValue());
        $criteria->params['LastName'] = trim($worksheet->getCell('D'.$i)->getValue());
        $criteria->params['Role'] = trim($worksheet->getCell('J'.$i)->getValue());

        $count = \user\models\User::model()->count($criteria);
        if ($count == 0)
        {
          echo 'Не найден: '.implode(', ', $criteria->params).' '.$worksheet->getCell('K'.$i)->getValue().'<br/>';
        }
        elseif ($count > 1)
        {
          $users = \user\models\User::model()->findAll($criteria);
          echo 'Найдено '.$count.': '.implode(', ', $criteria->params);
          foreach ($users as $user)
          {
            echo $user->RunetId.', ';
          }
          echo '<br/>';
        }
        elseif ($count == 1)
        {
          $product = trim($worksheet->getCell('K'.$i));
          if (!array_key_exists($product, $products))
          {
            echo 'Не найден товар: '. $product.'<br/>';
            continue;
          }

          $user = \user\models\User::model()->find($criteria);
          $productId = $products[$product];
          if (!\pay\models\OrderItem::model()->byProductId($productId)->byOwnerId($user->Id)->exists())
          {
            $orderItem = new \pay\models\OrderItem();
            $orderItem->PayerId = $orderItem->OwnerId = $user->Id;
            $orderItem->ProductId = $products[$product];
            $orderItem->save();
            $orderItem->activate();
            echo 'ОК<br/>';
          }
          else
          {
            //echo 'Есть товар<br/>';
          }
        }
      }
    }

    public function actionDevconhalls()
    {
        echo 'closed';
        exit;

        \Yii::import('ext.PHPExcel.PHPExcel', true);
        $excel = \PHPExcel_IOFactory::load(\Yii::getPathOfAlias('pay.data.halls-all').'.xlsx');
        $worksheet = $excel->getSheet(0);

        $max = $worksheet->getHighestRow();
        for ($i = 1; $i <= $max; $i++) {
            $hallId = intval($worksheet->getCell('A'.$i)->getValue());
            $runetId = intval($worksheet->getCell('B'.$i)->getValue());
            $date = date('Y-m-d H:i:s', strtotime($worksheet->getCell('C'.$i)));
            //Yii::app()->getDb()->createCommand()->insert('TmpHallsDevcon', ['HallId' => $hallId, 'RunetId' => $runetId, 'CreationTime' => $date]);
        }

        echo 'done';
    }

    public function actionDevconhallstat()
    {
        $beforeTime = '2014-05-29 15:20:00';
        $startTime = '2014-05-29 16:40:00';
        $endTime = '2014-05-29 18:00:00';

        $halls = [188, 189, 190, 191, 192];

        $lastVisits = [];
        $command = Yii::app()->getDb()->createCommand('SELECT DISTINCT ON ("RunetId") "RunetId","HallId" FROM "TmpHallsDevcon"
            WHERE "CreationTime" BETWEEN :StartTime AND :EndTime ORDER BY "RunetId", "CreationTime" DESC');
        $command->bindValue('StartTime', $beforeTime);
        $command->bindValue('EndTime', $startTime);
        $result = $command->queryAll();
        foreach ($result as $row) {
            $lastVisits[$row['HallId']][] = $row['RunetId'];
        }

        foreach ($halls as $hall) {
            $users = [];

            $command = Yii::app()->getDb()->createCommand('SELECT "RunetId" FROM "TmpHallsDevcon"
            WHERE "HallId" = :HallId AND "CreationTime" BETWEEN :StartTime AND :EndTime');
            $command->bindValue('HallId', $hall);
            $command->bindValue('StartTime', $startTime);
            $command->bindValue('EndTime', $endTime);

            $result = $command->queryAll();
            foreach ($result as $row) {
                $users[] = $row['RunetId'];
            }
            $users = array_unique($users);
            echo $hall . ' - ' . count($users), '<br>';


            $command = Yii::app()->getDb()->createCommand('SELECT "RunetId" FROM "TmpHallsDevcon"
            WHERE "HallId" != :HallId AND "CreationTime" BETWEEN :StartTime AND :EndTime');
            $command->bindValue('HallId', $hall);
            $command->bindValue('StartTime', $startTime);
            $command->bindValue('EndTime', $endTime);

            $badUsers = [];
            $result = $command->queryAll();
            foreach ($result as $row) {
                $badUsers[] = $row['RunetId'];
            }

            $additionalUsers = array_diff(!empty($lastVisits[$hall]) ? $lastVisits[$hall] : [], $badUsers);
            $users = array_merge($users, $additionalUsers);
            $users = array_unique($users);
            echo $hall . ' - ' . count($users), '<br><br>';


        }


        echo 'done';
    }

    public function actionPhdaysfood() {
        $criteria = new CDbCriteria();
        $criteria->addInCondition('t."ProductId"', [1448, 1449, 1450]);
        $orderItems = \pay\models\OrderItem::model()
            ->byEventId(832)->byPaid(true)->findAll($criteria);

        $count = 0;


        $product = \pay\models\Product::model()->findByPk(2753);

        foreach ($orderItems as $item) {
            $owner = $item->ChangedOwnerId == null ? $item->Owner : $item->ChangedOwner;

            $addFood = $item->getPriceDiscount() > 0;
            $addFood = $addFood || ($item->getCouponActivation() != null && $item->getCouponActivation()->Coupon->IsTicket);

            $foodItem =\pay\models\OrderItem::model()->byPayerId($owner->Id)
                ->byProductId($product->Id)->byPaid(true);

            if ($addFood && !$foodItem->exists()) {
                $item = $product->getManager()->createOrderItem($owner, $owner);
                $item->Paid = true;
                $item->PaidTime = date('Y-m-d H:i:s');
                $item->save();

                $count++;
            }
        }

        echo 'Done. Added: ' . $count;

    }

    private function getTotal()
    {

    }

}


/**
 * PH DAYS IMPORT
$criteria = new CDbCriteria();
$criteria->addCondition('t."CreationTime" > :CreationTime');
$criteria->params = ['CreationTime' => '2014-05-15 19:00:00'];
$participants = \event\models\Participant::model()
->byEventId(832)->findAll($criteria);

$result = [];
foreach ($participants as $participant) {
$result[] = $participant->User->RunetId;
}

$result = array_unique($result);
echo implode(',', $result);
 *
 *
 */