<?php

class ReceiptController extends \pay\components\Controller
{
  public function actionIndex($eventIdName)
  {
    if ($this->getAccount()->ReceiptLastTime !== null && $this->getAccount()->ReceiptLastTime < date('Y-m-d H:i:s'))
    {
      throw new \CHttpException(404);
    }

    $finder = \pay\components\collection\Finder::create($this->getEvent()->Id, $this->getUser()->Id);
    $collection = $finder->getUnpaidFreeCollection();
    if ($collection->count() == 0)
      $this->redirect($this->createUrl('/pay/cabinet/index'));

    $order = new \pay\models\Order();
    $order->create($this->getUser(), $this->getEvent(), \pay\models\OrderType::Receipt, []);

    $this->redirect(\Yii::app()->createUrl('/pay/order/index', ['orderId' => $order->Id, 'hash' => $order->getHash()]));
  }
}