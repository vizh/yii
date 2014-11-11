<?php

use event\models\Participant;
use pay\models\OrderItem;

class DefaultController extends \application\components\controllers\AdminMainController
{

  public function actionIndex()
  {
    $this->render('index');
  }

  public function actionTest()
  {
    $template = \mail\models\Template::model()->byActive()->bySuccess(false)->find(['order' => '"t"."Id" ASC']);

    var_dump($template);
  }

  public function actionCompetence()
  {
    $criteria = new CDbCriteria();
    $criteria->addCondition('"t"."TestId" = :TestId');
    $criteria->params = ['TestId' => 1];
    /** @var \competence\models\Result[] $results */
    $results = \competence\models\Result::model()->findAll($criteria);

    $users = [];
    foreach ($results as $result)
    {
      $data = $result->getResultByData();
      $question = new \competence\models\tests\mailru2013\C6(null);
      if (array_key_exists(get_class($question), $data))
      {
        $users[] = $result->UserId;
      }
    }


    //echo implode(', ', $users);
  }

  public function actionCompetence2()
  {
    $questionClasses = ['B3_1', 'B3_2', 'B3_3', 'B3_4', 'B3_5', 'B3_6', 'B3_7', 'B3_8', 'B3_9', 'B3_10', 'B3_11', 'B3_12', 'B3_13', 'B3_14', 'B3_15', 'B3_16'];

    $criteria = new CDbCriteria();
    $criteria->addCondition('"t"."TestId" = :TestId');
    $criteria->params = ['TestId' => 2];
    /** @var \competence\models\Result[] $results */
    $results = \competence\models\Result::model()->findAll($criteria);

    $usersId = [];
    foreach ($questionClasses as $class)
    {
      $usersId[$class] = [];
    }

    foreach ($results as $result)
    {
      $data = $result->getResultByData();
      foreach ($questionClasses as $class)
      {
        $full = '\competence\models\tests\runet2013\\'.$class;
        $question = new $full(null);
        if (array_key_exists(get_class($question), $data))
        {
          $usersId[$class][] = $result->UserId;
        }
      }
    }

    foreach ($usersId as $key => $values)
    {
      echo '<strong>'. $key . '</strong>: ' . count(array_unique($values)) . '<br>';
      $criteria = new CDbCriteria();
      $criteria->addInCondition('"t"."Id"', $values);
      $users = \user\models\User::model()->findAll($criteria);
      foreach ($users as $user)
      {
        echo $user->RunetId . ' ' . $user->getFullName() . '<br>';
      }
      echo '<br><br>';
    }


    //echo implode(', ', $users);
  }


  public function actionPayinfo()
  {
    $eventId = 425;

    $criteria = new CDbCriteria();
    $criteria->order = '"t"."Id"';

    /** @var \pay\models\Order[] $orders */
    $orders = \pay\models\Order::model()->byEventId($eventId)
        ->byPaid(true)->byBankTransfer(false)->findAll($criteria);

    $total = 0;
    foreach ($orders as $order)
    {
      $price2 = 0;
      $collection = \pay\components\OrderItemCollection::createByOrder($order);
      foreach ($collection as $item)
      {
        if ($item->getOrderItem()->Paid)
        {
          $price2 += $item->getPriceDiscount();
        }
      }

      $price = $order->getPrice();
      $total += $price;
      echo $order->Id . ': ' . $price . ' ' . $price2 . ' ' . $order->Total . '<br>';
    }

    echo '<br><br><br><br>' . $total;
  }

  public function actionExport()
  {
    return;
    $participants = \event\models\Participant::model()->byEventId(647)->findAll();
    $userIdList = [];
    foreach ($participants as $participant)
    {
      $userIdList[] = $participant->UserId;
    }

    $criteria = new \CDbCriteria();
    $criteria->addCondition('"t"."ExitTime" IS NULL OR "t"."ExitTime" > NOW()');
    /** @var \commission\models\User[] $comissionUsers */
    $comissionUsers = \commission\models\User::model()->findAll($criteria);

    /** @var \user\models\User[] $users */
    $users = [];
    foreach ($comissionUsers as $comissionUser)
    {
      if (!in_array($comissionUser->UserId, $userIdList) && !isset($users[$comissionUser->UserId]))
      {
        $users[$comissionUser->UserId] = $comissionUser->User;
      }
    }

    $event = \event\models\Event::model()->findByPk(647);
    $event->skipOnRegister = true;
    $role = \event\models\Role::model()->findByPk(33);

    foreach ($users as $user)
    {
      $event->registerUser($user, $role);
    }
    echo count($users);
  }

  public function actionProducts()
  {
    echo 0;
    return;
    $runetIds = [166562, 166563, 166564, 166565, 166567, 166568, 166569, 166570, 166572, 166573, 166575, 166577, 166578, 166579, 166580, 166581, 166582, 166583, 166584, 166585, 97432, 166586, 166587, 166588, 166589, 166590, 166592, 166593, 166594, 166595, 166596, 166597, 166598, 166599, 166600, 166601, 166602, 166603, 166604];

    $productIds = [1309, 1387, 1391, 1392];

    $criteria = new CDbCriteria();
    $criteria->addInCondition('"t"."RunetId"', $runetIds);
    $users = \user\models\User::model()->findAll($criteria);

    $criteria = new CDbCriteria();
    $criteria->addInCondition('"t"."Id"', $productIds);
    $products = \pay\models\Product::model()->findAll($criteria);

    $payer = \user\models\User::model()->byRunetId(167351)->find();

    foreach ($users as $user)
    {
      foreach ($products as $product)
      {
        $orderItem = \pay\models\OrderItem::model()
            ->byPayerId($payer->Id)->byOwnerId($user->Id)
            ->byProductId($product->Id)->byDeleted(false);
        if (!$orderItem->exists())
        {
          $product->getManager()->createOrderItem($payer, $user);
        }
      }
    }
  }

    public function actionSoftool()
    {
        $roleLinks = [
            38 => 3068,
            86 => 3069,
            6 => 3070
        ];
        $riwEventId = 889;
        $softoolEventId = 1454;

        $riwParticipantRole = 1;

        $subSelect = 'SELECT "OwnerId" FROM "PayOrderItem" WHERE "ProductId" IN (3068, 3069, 3070)';
        $select = 'SELECT "UserId", "RoleId" FROM "EventParticipant" WHERE "EventId" = :EventId AND "UserId" NOT IN ('.$subSelect.')';

        $command = Yii::app()->getDb()->createCommand($select)->bindValue('EventId', $softoolEventId);

        $users = $command->queryAll();

        foreach ($users as $user) {
            $userId = $user['UserId'];
            $roleId = $user['RoleId'];
            if (!isset($roleLinks[$roleId])) {
                Yii::log(sprintf('НЕ найден товар для RoleId=%s и UserId=%s', $roleId, $userId), CLogger::LEVEL_ERROR);
                continue;
            }
            if (!Participant::model()->byEventId($riwEventId)->byUserId($userId)->exists()) {
                $participant = new Participant();
                $participant->EventId = $riwEventId;
                $participant->UserId = $userId;
                $participant->RoleId = $riwParticipantRole;
                $participant->save();
            }

            $orderItem = new OrderItem();
            $orderItem->PayerId = $userId;
            $orderItem->OwnerId = $userId;
            $orderItem->ProductId = $roleLinks[$roleId];
            $orderItem->Paid = true;
            $orderItem->PaidTime = date('Y-m-d H:i:s');
            $orderItem->save();
        }

        echo 'DONE! Added: '.count($users);
    }

    public function actionPremia()
    {
        $riwEventId = 889;
        $premiaProductId = 3071;

        $subSelect = 'SELECT "OwnerId" FROM "PayOrderItem" WHERE "ProductId" = 3071';

        $subSelectUsers = 'SELECT "Id" FROM "User" WHERE "RunetId" IN (19468,144103,149408,17991,55070,28890,109153,170450,138505,170448,31946,87871,158357,186986,158434,5469,9734,1499,149403,124931,142702,239330,18310,125071,6562,1438,8891,19238,106635,97150,43271,130854,18242,125023,107551,119160,265522,168960,254255,12735,103542,12574,12371,12215,172287,197190,12424,12089,168471,161716,171226,172023,127332,200169,118827,200159,139894,139525,109066,115650,158078,2216,610,50891,28304,131738,37083,95300,47477,55582,123412,124347,16493,86283,29628,17710,130003,15712,371,97684,169000,21309,105522,110845,33313,99779,152535,29106,139406,12131,2889,95102,134978,198667,235535,115275,170965,55266,102931,94952,12615,42208,41634,85583,85611,12781,39474,15095,107296,140871,10418,119287,240863,98728,117868,22727,142496,11409,372,13252,12147,22575,13421,200977,97341,97848,108257,138509,97336,247026,122573,1752,13084,814,156226,40318,7702,14203,15627,832,37064,17995,6229,210077
,169047,10752,14076,167793,172935,30926,127269,107083,34026,52787,209566,231709,16228,123759,14230,156787,106982,97532,117154,131401,149453,131062,169709,15056,15769,85925,185785,168598,130286,142707,137158,14714,403,52720,253964,29892,29344,149273,173618,158478,46419,91940,131825,33483,194195,132815,132155,118241,167815,130941,12663,167816,97558,149561,50891,172787,200891,11056,158435,84203,138370,181419,123389,29666,149397,44314,29334,123252,34462,9686,48523,28304,114995,193905,108112,198978,842,107159,107156,173977,173985,198004,7163,113458,112860,106632,128639,49844,32705,17693,14822,91396,88913,30926,123125,86941,42933,118913,137232,97523,10316,40467,82511,18681,14103,610,188861,10414,200097,33862,22636,198242,609,180506,40007,50424,14917,113640,1480,29609,42964,17776,82583,198235,29716,611,2202,130148,125198,173258)';

        $select = 'SELECT "UserId", "RoleId" FROM "EventParticipant" WHERE

        "EventId" = :EventId AND ("RoleId" = :RoleId OR "UserId" IN ('.$subSelectUsers.') )

        AND "UserId" NOT IN ('.$subSelect.')';

        $command = Yii::app()->getDb()->createCommand($select)->bindValue('EventId', $riwEventId)->bindValue('RoleId', 3);

        $users = $command->queryAll();

        foreach ($users as $user) {
            $userId = $user['UserId'];


            $orderItem = new OrderItem();
            $orderItem->PayerId = $userId;
            $orderItem->OwnerId = $userId;
            $orderItem->ProductId = $premiaProductId;
            $orderItem->Paid = true;
            $orderItem->PaidTime = date('Y-m-d H:i:s');
            $orderItem->save();
        }

        echo 'DONE! Added: '.count($users);
    }
}