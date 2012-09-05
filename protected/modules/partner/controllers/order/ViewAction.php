<?php
namespace partner\controllers\order;

class ViewAction extends \partner\components\Action
{
  public function run()
  {
    $this->getController()->setPageTitle('Управление счетом');

    $request = \Yii::app()->getRequest();
    $orderId = $request->getParam('orderId');

    $order = \pay\models\Order::GetById($orderId);


    if (empty($order) || empty($order->OrderJuridical) || $order->EventId != \Yii::app()->partner->getAccount()->EventId)
    {
      throw new \CHttpException(404);
    }

        if (Yii::app()->request->getIsPostRequest())
        {
          $paid = Registry::GetRequestVar('SetPaid', false);
          if ($paid !== false)
          {
            $payResult = $order->PayOrder();

            if (! empty($payResult['ErrorItems']))
            {
              $this->view->Error = 'Повторно активированы некоторые заказы. Список идентификаторов: ' . implode(', ', $payResult['ErrorItems']);
            }
            else
            {
              $this->view->Result = 'Счет успешно активирован, платежи проставлены! Сумма счета: <strong>' . $payResult['Total'] . '</strong> руб.';
            }
          }
          else
          {
            $order->OrderJuridical->Deleted = 1;
            $order->OrderJuridical->save();
          }
        }

        $this->view->Order = $order;

        echo $this->view->__toString();
  }
}
