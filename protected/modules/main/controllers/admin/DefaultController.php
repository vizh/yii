<?php

class DefaultController extends \application\components\controllers\AdminMainController
{

  public function actionIndex()
  {
    $this->render('index');
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


  public function actionPayinfo()
  {
    $eventId = 425;

    $criteria = new CDbCriteria();
    $criteria->order = '"t"."Id"';

    /** @var \pay\models\Order[] $orders */
    $orders = \pay\models\Order::model()->byEventId($eventId)
        ->byPaid(true)->byJuridical(false)->findAll($criteria);

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

}