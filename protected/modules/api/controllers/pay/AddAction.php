<?php
class AddAction extends \api\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $productId = $request->getParam('ProductId');
    $payerRunetId = $request->getParam('PayerRunetId');
    $ownerRunetId = $request->getParam('OwnerRunetId');

    $product = \pay\models\Product::model()->byEventId($this->getAccount()->EventId)->findByPk($productId);
    $payer = \user\models\User::model()->byRunetId($payerRunetId)->find();
    $owner = \user\models\User::model()->byRunetId($ownerRunetId)->find();
    if ($product == null)
    {
      throw new ApiException(401, array($productId));
    }
    else if ($payer == null) 
    {
      throw new ApiException(202, array($payerRunetId));
    }
    else if ($owner == null)
    {
      throw new ApiException(202, array($ownerRunetId));
    }
    else if ($this->getAccount()->Event == null)
    {
      throw new ApiException(301);
    }
    else if (!$product->getManager()->checkProduct($owner))
    {
      throw new ApiException(403);
    }
    
    $orderItem = \pay\models\OrderItem::model()
      ->byPayerId($payer->Id)->byOwnerId($owner->Id)->byProductId($product->Id)->find();
    if ($orderItem !== null && $orderItem->Paid == 0)
    {
      throw new ApiException(405);
    }
    
    $orderItem = $product->getManager()->createOrderItem($payer, $owner);
    $result = $this->getAccount()->getDataBuilder()->createOrderItem($orderItem);
    $this->getController()->setResult($result);
  }
}
