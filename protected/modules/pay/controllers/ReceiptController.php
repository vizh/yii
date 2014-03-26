<?php

class ReceiptController extends \pay\components\Controller
{
  public function actionIndex($eventIdName)
  {
    if ($this->getAccount()->ReceiptLastTime !== null && $this->getAccount()->ReceiptLastTime < date('Y-m-d H:i:s'))
    {
      throw new \CHttpException(404);
    }

    $order = new \pay\models\Order();
    $unpaidItems = $order->getUnpaidItems($this->getUser(), $this->getEvent());

    if (sizeof($unpaidItems) > 0)
    {
      $order->create($this->getUser(), $this->getEvent(), \pay\models\OrderType::Receipt, []);
      $this->redirect(\Yii::app()->createUrl('/pay/order/index', ['orderId' => $order->Id, 'hash' => $order->getHash()]));
    }

    $this->render('index', []);
  }
}