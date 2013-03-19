<?php
namespace pay\controllers\cabinet;

class PayAction extends \pay\components\Action
{
  public function run($eventIdName, $type = null)
  {

    $order = new \pay\models\Order();
    $total = $order->create(\Yii::app()->user->getCurrentUser(), $this->getEvent());

    /** @var $account \pay\models\Account */
    $account = \pay\models\Account::model()->byEventId($this->getEvent()->Id)->find();

    $system = null;
    if ($type == 'paypal')
    {
      $system = new \pay\components\systems\PayPal();
    }
    else
    {
      if ($account->Own)
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
