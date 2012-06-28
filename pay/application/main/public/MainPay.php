<?php
AutoLoader::Import('library.rocid.pay.systems.*');

class MainPay extends PayCommand
{

  /**
   * Основные действия комманды
   * @param int $eventId
   * @param string $type
   * @return void
   */
  protected function doExecute($eventId = 0, $type = '')
  {
    if ($this->LoginUser === null)
    {
      Lib::Redirect(RouteRegistry::GetUrl('main', '', 'index'));
    }
    $eventId = intval($eventId);

    $data = Order::CreateOrder($this->LoginUser, $eventId);



    if ($type != 'paypal')
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
    }
    else
    {
      $system = new PayPalSystem();
    }
    $system->ProcessPayment($eventId, $data['OrderId'], $data['Total']);
  }
}