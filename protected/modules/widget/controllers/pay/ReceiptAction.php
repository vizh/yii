<?php
namespace widget\controllers\pay;

class ReceiptAction extends \widget\components\pay\Action
{
  public function run()
  {
    if ($this->getAccount()->ReceiptLastTime !== null && $this->getAccount()->ReceiptLastTime < date('Y-m-d H:i:s')) {
      $this->getController()->redirect(['/widget/pay/cabinet']);
    }

    $finder = \pay\components\collection\Finder::create($this->getEvent()->Id, $this->getUser()->Id);
    $collection = $finder->getUnpaidFreeCollection();
    if ($collection->count() == 0)
      $this->getController()->redirect(['/widget/pay/cabinet']);

    $order = new \pay\models\Order();
    $order->create($this->getUser(), $this->getEvent(), \pay\models\OrderType::Receipt, []);
    $this->getController()->redirect(['/widget/pay/cabinet']);
  }
}