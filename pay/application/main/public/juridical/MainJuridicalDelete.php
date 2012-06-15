<?php

class MainJuridicalDelete extends PayCommand
{

  /**
   * Основные действия комманды
   * @param int $orderId
   * @return void
   */
  protected function doExecute($orderId = 0)
  {
    if ($this->LoginUser === null)
    {
      Lib::Redirect(RouteRegistry::GetUrl('main', '', 'index'));
    }

    $orderId = intval($orderId);
    $order = Order::GetById($orderId);

    if (empty($order))
    {

    }

    if ($order->PayerId !=  $this->LoginUser->UserId || empty($order->OrderJuridical))
    {
      Lib::Redirect(RouteRegistry::GetUrl('main', '', 'index', array('eventId' => $order->EventId)));
    }

    $order->OrderJuridical->DeleteOrder();

    Lib::Redirect(RouteRegistry::GetUrl('main', '', 'index', array('eventId' => $order->EventId)));
  }
}
