<?php
namespace pay\controllers\cabinet;

use pay\components\systems\Uniteller;

class PayAction extends \pay\components\Action
{
  public function run($eventIdName, $type = null)
  {

    $order = new \pay\models\Order();
    $total = $order->create($this->getUser(), $this->getEvent(), \pay\models\OrderType::PaySystem);

    /** @var $account \pay\models\Account */
    $account = \pay\models\Account::model()->byEventId($this->getEvent()->Id)->find();

    $system = null;
    if ($type == 'paypal')
    {
      $system = new \pay\components\systems\PayPal();
    }
    elseif ($type == 'uniteller' && $account->Uniteller)
    {
        if ($account->UnitellerRuvents) {
            $system = new Uniteller('ruvents');
        } elseif ($account->Own) {
            $system = new \pay\components\systems\Uniteller(null, '00000524');
        } else {
            $system = new \pay\components\systems\Uniteller();
        }
    }
    elseif ($type == 'yandexmoney' && $account->PayOnline)
    {
      $system = new \pay\components\systems\PayOnline();
      $system->toYandexMoney = true;
    }
    else
    {
      if ($account->PayOnline)
      {
        $system = new \pay\components\systems\PayOnline();
      }
      else
      {
        $system = new \pay\components\systems\Uniteller();
      }
    }

    $system->processPayment($this->getEvent()->Id, $order->Id, $total);
  }
}
