<?php
AutoLoader::Import('library.texts.*');

class MainJuridicalOrder extends PayCommand
{
  /**
   * Основные действия комманды
   * @param int $orderId
   * @param string $hash
   * @param string $clear
   * @return void
   */
  protected function doExecute($orderId = 0, $hash = '', $clear = '')
  {
    $orderId = intval($orderId);
    $order = Order::GetById($orderId);

    $checkHash = $order->OrderJuridical->CheckHash($hash);
    if ($this->LoginUser === null && !$checkHash)
    {
      Lib::Redirect(RouteRegistry::GetUrl('main', '', 'index'));
    }

    if (empty($order) || empty($order->OrderJuridical)
      || (!$checkHash && $order->PayerId != $this->LoginUser->UserId))
    {
      $this->view->SetTemplate('error');
      echo $this->view;
      return;
    }

    $billOrders = array();
    $total = 0;
    foreach ($order->Items as $item)
    {
      if ($item->Deleted != 0)
      {
        continue;
      }
      $price = $item->PriceDiscount($order->CreationTime);
      if (! isset($billOrders[$item->Product->ProductId.$price]))
      {
        $billOrders[$item->Product->ProductId.$price] = array('Title' => $item->Product->ProductManager()->GetTitle($item), 'Unit' => $item->Product->Unit ,'Count' => 0, 'DiscountPrice' => $price);
      }
      $billOrders[$item->Product->ProductId.$price]['Count'] += 1;
      $total += $price;
    }

    $view = new View();

    $payAccount = PayAccount::GetByEventId($order->EventId);
    if (empty($payAccount) || $payAccount->JuridicalParams == null)
    {
      $view->SetTemplate('bill');
    }
    else
    {
      $view->SetTemplate($payAccount->JuridicalParams);
    }

    $view->OrderId = $order->OrderId;
    $view->CreationTime = $order->CreationTime;
    $view->OrderJuridical = $order->OrderJuridical;
    $view->BillOrders = $billOrders;
    $view->Total = $total;
    $view->NDS = $total - round($total / 1.18, 2, PHP_ROUND_HALF_DOWN);
    //$view->WithSign = $this->LoginUser === null || $this->LoginUser->RocId != 607;// empty($hash);

    $view->WithSign = empty($clear);

    echo $view->__toString();
  }
}