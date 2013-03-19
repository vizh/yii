<?php
namespace api\controllers\pay;

class AddAction extends \api\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $productId = $request->getParam('ProductId');
    $payerRunetId = $request->getParam('PayerRunetId');
    $ownerRunetId = $request->getParam('OwnerRunetId');

    /** @var $product \pay\models\Product */
    $product = \pay\models\Product::model()->byEventId($this->getAccount()->EventId)->findByPk($productId);
    $payer = \user\models\User::model()->byRunetId($payerRunetId)->find();
    $owner = \user\models\User::model()->byRunetId($ownerRunetId)->find();
    if ($product == null)
    {
      throw new \api\components\Exception(401, array($productId));
    }
    elseif ($payer == null)
    {
      throw new \api\components\Exception(202, array($payerRunetId));
    }
    elseif ($owner == null)
    {
      throw new \api\components\Exception(202, array($ownerRunetId));
    }
    elseif ($this->getAccount()->Event == null)
    {
      throw new \api\components\Exception(301);
    }
    elseif ($this->getAccount()->EventId != $product->EventId)
    {
      throw new \api\components\Exception(402);
    }
    
    $orderItem = $product->getManager()->createOrderItem($payer, $owner);
    $result = $this->getAccount()->getDataBuilder()->createOrderItem($orderItem);
    $this->getController()->setResult($result);
  }
}
