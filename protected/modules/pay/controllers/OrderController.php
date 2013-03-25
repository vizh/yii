<?php


class OrderController extends \application\components\controllers\MainController
{
  public function actionIndex($orderId, $hash = null, $clear = null)
  {
    /** @var $order \pay\models\Order */
    $order = \pay\models\Order::model()->findByPk($orderId);
    if ($order === null || !$order->Juridical)
    {
      throw new \CHttpException(404);
    }

    $checkHash = $order->checkHash($hash);
    if (!$checkHash && (\Yii::app()->user->getCurrentUser() === null || \Yii::app()->user->getCurrentUser()->Id != $order->PayerId))
    {
      throw new \CHttpException(404);
    }

    $billData = array();
    $total = 0;
    foreach ($order->ItemLinks as $link)
    {
      $item = $link->OrderItem;
      $price = $item->getPriceDiscount($order->CreationTime);
      if (! isset($billData[$item->Product->Id.$price]))
      {
        $billData[$item->Product->Id.$price] = array(
          'Title' => $item->Product->getManager()->GetTitle($item),
          'Unit' => $item->Product->Unit,
          'Count' => 0,
          'DiscountPrice' => $price,
          'ProductId' => $item->Product->Id
        );
      }
      $billData[$item->Product->Id.$price]['Count'] += 1;
      $total += $price;
    }

    /** @var $account \pay\models\Account */
    $account = \pay\models\Account::model()->byEventId($order->EventId)->find();
    $viewName = $account->OrderTemplateName !== null ? $account->OrderTemplateName : 'bill';

    $this->renderPartial('bills/'.$viewName, array(
      'order' => $order,
      'billData' => $billData,
      'total' => $total,
      'nds' => $total - round($total / 1.18, 2, PHP_ROUND_HALF_DOWN),
      'withSign' => $clear===null
    ));
  }
}
