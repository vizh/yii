<?php
AutoLoader::Import('library.rocid.pay.*');
AutoLoader::Import('library.rocid.event.*');

class PartnerOrderView extends PartnerCommand
{

  /**
   * Основные действия комманды
   * @param int $orderId
   * @return void
   */
  protected function doExecute($orderId = 0)
  {
    $this->SetTitle('Управление счетом');

    $orderId = intval($orderId);
    $order = Order::GetById($orderId);

    if (empty($order) || empty($order->OrderJuridical) || $order->EventId != $this->Account->EventId)
    {
      $this->Send404AndExit();
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
