<?php

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

}