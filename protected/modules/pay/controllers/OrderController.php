<?php

class OrderController extends \application\components\controllers\MainController
{
  public $layout = '/layouts/bill';

  public function actionIndex($orderId, $hash = null, $clear = null)
  {
    /** @var $order \pay\models\Order */
    $order = \pay\models\Order::model()->findByPk($orderId);
    if ($order === null || (!\pay\models\OrderType::getIsBank($order->Type)))
      throw new \CHttpException(404);

    $checkHash = $order->checkHash($hash);
    if (!$checkHash && (\Yii::app()->user->getCurrentUser() === null || \Yii::app()->user->getCurrentUser()->Id != $order->PayerId))
    {
      throw new \CHttpException(404);
    }

    if ($clear === null && $order->Deleted)
      throw new \CHttpException(404);

    $this->setPageTitle('Счёт № ' . $order->Number);
    $this->render($order->getViewName(), [
      'order' => $order,
      'billData' => $order->getBillData()->Data,
      'total' => $order->getBillData()->Total,
      'nds' => $order->getBillData()->Nds,
      'withSign' => $clear===null,
      'template' => $order->getViewTemplate()
    ]);
  }
}
