<?php
AutoLoader::Import('library.rocid.pay.*');
AutoLoader::Import('library.rocid.event.*');

class JuridicalIndex extends AdminCommand
{

  /**
   * @var View
   */
  private $step;

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $this->step = new View();
    $this->step->SetTemplate('step-1');
    if (Yii::app()->getRequest()->getIsPostRequest())
    {
      $step = Registry::GetRequestVar('step');
      switch ($step)
      {
        case 1:
          $this->processStep2();
          break;
        case 2:
          $this->activateOrder();
          break;
      }
    }
    else
    {
      $this->processStep1();
    }

    $this->view->Step = $this->step;

    echo $this->view;
  }

  private function processStep1()
  {
    $criteria = new CDbCriteria();
    $criteria->condition = 'OrderJuridical.OrderId IS NOT NULL AND OrderJuridical.Deleted = :Deleted AND
     Items.Deleted = :Deleted AND Items.Paid = :Paid AND Items.Booked IS NOT NULL AND Items.Booked < :Booked';
    $criteria->params = array(
      ':Deleted' => 0,
      ':Paid' => 0,
      ':Booked' => date('Y-m-d H:i:s', time() + 2 * 24 * 3600)
    );
    $criteria->order = 'Items.Booked';

    /** @var $orders Order[] */
    $orders = Order::model()->with('OrderJuridical', 'Items', 'Payer')->together()->findAll($criteria);

    $list = array();
    foreach ($orders as $order)
    {
      $listItem = array();
      $listItem['order'] = $order;
      $min = '9999-12-31';
      foreach ($order->Items as $item)
      {
        if ($item->Booked < $min)
        {
          $min = $item->Booked;
        }
      }
      $listItem['min'] = $min;
      $list[] = $listItem;
    }

    $this->step->List = $list;
  }

  private function processStep2()
  {
    $orderId = Registry::GetRequestVar('orderId');
    $order = Order::GetById($orderId);
    if (!empty($order) && !empty($order->OrderJuridical))
    {
      $this->step->SetTemplate('step-2');

      $this->step->OrderId = $order->OrderId;
      $this->step->OrderJuridical = $order->OrderJuridical;

      $total = 0;
      foreach ($order->Items as $item)
      {
        if ($item->Deleted == 0)
        {
          $total += $item->PriceDiscount($order->CreationTime);
        }
      }
      $this->step->Total = $total;
    }
    else
    {
      $this->view->Error = 'Не найден счет №' . $orderId;
    }
  }

  private function activateOrder()
  {
    $orderId = Registry::GetRequestVar('orderId');
    $order = Order::GetById($orderId);
    if (!empty($order) && !empty($order->OrderJuridical))
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
    $this->processStep2();
  }
}