<?php
AutoLoader::Import('library.rocid.pay.systems.*');

class MainPay extends PayCommand
{

  /**
   * Основные действия комманды
   * @param int $eventId
   * @return void
   */
  protected function doExecute($eventId = 0)
  {
    if ($this->LoginUser === null)
    {
      Lib::Redirect(RouteRegistry::GetUrl('main', '', 'index'));
    }
    $eventId = intval($eventId);

    $data = Order::CreateOrder($this->LoginUser, $eventId);

    if ($_SERVER['REMOTE_ADDR'] == '82.142.129.35' || $_SERVER['REMOTE_ADDR'] == '127.0.0.1')
    {
      $account = PayAccount::GetByEventId($eventId);
      if (!empty($account))
      {
        $className = $account->System . SystemRouter::Suffix;
        $system = new $className();
      }
      else
      {
        $system = new PayOnlineSystem();
      }
      $system->ProcessPayment($eventId, $data['OrderId'], $data['Total']);
    }
    else
    {
      $system = new PayOnlineSystem();
      $system->ProcessPayment($eventId, $data['OrderId'], $data['Total']);
    }
  }
}