<?php

class MainTest extends PayCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $criteria = new CDbCriteria();
    //$criteria->limit = 2;

    //$products = Product::model()->with('Event')->findAll($criteria);
    //$items = OrderItem::model()->with('Product')->findAll($criteria);
    $orders = Order::model()->findAll();

    foreach ($orders as $order)
    {
      echo $order->CreationTime;
    }
    echo sizeof($orders);
  }
}
