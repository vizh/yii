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
        curl_setopt($ch, CURLOPT_URL, 'http://www.msdevcon.ru/api/MaterialVoting/GetUserIDAssignments');
        $result = curl_exec($ch);
        $data = json_decode($result);

        $countAddPhone = 0;
        $countAddExternalId = 0;

        foreach ($data as $row) {
            $extUser = \api\models\ExternalUser::model()->byExternalId($row->UserID)->find();
            if ($extUser != null) {
                $user = \user\models\User::model()->findByPk($extUser->UserId);

                $row->Phone = trim($row->Phone);
                if ($user->getContactPhone() == null && !empty($row->Phone)) {
                    $user->setContactPhone($row->Phone, \contact\models\PhoneType::Mobile);
                    $countAddPhone++;
                }

                if ($extUser->ShortExternalId === null && !empty($row->WPUserID)) {
                    $extUser->ShortExternalId = trim($row->WPUserID);
                    $extUser->save();
                    $countAddExternalId++;
                }
            }
        }

        echo sprintf('Add phones: %d, add extId: %d', $countAddPhone, $countAddExternalId);
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