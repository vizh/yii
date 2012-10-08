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


    switch ($type){
      case 'paypal':
        $system = new PayPalSystem();
        break;
      case 'uniteller':
        if ($eventId != 215 && $eventId != 248)
        {
          return;
        }
        $system = new UnitellerSystem();
        break;
      default:
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

    $system->ProcessPayment($eventId, $data['OrderId'], $data['Total']);
  }
}