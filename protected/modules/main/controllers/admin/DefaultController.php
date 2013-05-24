<?php

class DefaultController extends \application\components\controllers\AdminMainController
{

  public function actionIndex()
  {
    $this->render('index');
  }


  public function actionPayinfo()
  {
//    $eventId = 431;
//
//    $criteria = new CDbCriteria();
//    $criteria->order = '"t"."Id"';
//
//    /** @var \pay\models\Order[] $orders */
//    $orders = \pay\models\Order::model()->byEventId($eventId)
//        ->byPaid(true)->byJuridical(true)->findAll($criteria);
//
//    $total = 0;
//    foreach ($orders as $order)
//    {
//      $price2 = 0;
//      foreach ($order->ItemLinks as $link)
//      {
//        if ($link->OrderItem->Paid)
//        {
//          $price2 += $link->OrderItem->getPriceDiscount();
//        }
//      }
//
//      $price = $order->getPrice();
//      $total += $price;
//      echo $order->Id . ': ' . $price . ' ' . $price2 . ' ' . $order->Total . '<br>';
//    }
//
//    echo '<br><br><br><br>' . $total;
  }

}