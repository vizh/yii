<?php
namespace partner\controllers\order;

class ViewAction extends \partner\components\Action
{
  public $error = false;
  public $result = false;

  public function run($orderId)
  {
    /** @var $order \pay\models\Order */
    $order = \pay\models\Order::model()->findByPk($orderId);
    if ($order === null)
    {
      throw new \CHttpException(404, 'Не найден счет с номером: ' . $orderId);
    }
    if ($order->EventId != \Yii::app()->partner->getEvent()->Id)
    {
      throw new \CHttpException(404, 'Счет с номером ' . $orderId . ' относится к другому мероприятию');
    }

    $this->getController()->setPageTitle('Управление счетом № ' . $order->Number);
    $this->getController()->initActiveBottomMenu('index');

    $request = \Yii::app()->getRequest();
    if ((\pay\models\OrderType::getIsBank($order->Type) || \Yii::app()->partner->getAccount()->getIsAdmin()) && $request->getIsPostRequest())
    {
      $paid = $request->getParam('SetPaid', false);
      if ($paid !== false)
      {
        $payResult = $order->activate();

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
        $order->delete();
      }
    }

    $this->getController()->render('view',
      array(
        'order' => $order
      )
    );
  }
}
