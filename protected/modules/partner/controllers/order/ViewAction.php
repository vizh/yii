<?php
namespace partner\controllers\order;

class ViewAction extends \partner\components\Action
{
  public $error = false;
  public $result = false;

  public function run()
  {

    $request = \Yii::app()->getRequest();
    $orderId = $request->getParam('orderId');
    $order = \pay\models\Order::GetById($orderId);
    if (empty($order) || empty($order->OrderJuridical) || $order->EventId != \Yii::app()->partner->getAccount()->EventId)
    {
      throw new \CHttpException(404);
    }
    $this->getController()->setPageTitle('Управление счетом № ' . $orderId);
    $this->getController()->initBottomMenu($order->OrderJuridical->Paid == 1 ? 'active':'inactive');

    if ($request->getIsPostRequest())
    {
      $paid = $request->getParam('SetPaid', false);
      if ($paid !== false)
      {
        $payResult = $order->PayOrder();

        if (! empty($payResult['ErrorItems']))
        {
          $this->error = 'Повторно активированы некоторые заказы. Список идентификаторов: ' . implode(', ', $payResult['ErrorItems']);
        }
        else
        {
          $this->result = 'Счет успешно активирован, платежи проставлены! Сумма счета: <strong>' . $payResult['Total'] . '</strong> руб.';
        }
      }
      else
      {
        $order->OrderJuridical->Deleted = 1;
        $order->OrderJuridical->save();
      }
    }

    $this->getController()->render('view',
      array(
        'order' => $order
      )
    );
  }
}
