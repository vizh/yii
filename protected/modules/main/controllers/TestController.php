<?php
class TestController extends \CController
{
  public function actionIndex()
  {
    $order = \pay\models\Order::model()->findByPk(14911);
    $order->activate();
  }
}
