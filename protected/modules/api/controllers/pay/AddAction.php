<?php
namespace api\controllers\pay;

class AddAction extends \api\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $productId = $request->getParam('ProductId');
    $payerRunetId = $request->getParam('PayerRunetId', null);
    if ($payerRunetId === null)
    {
      $payerRunetId = $request->getParam('PayerRocId', null);
    }
    $ownerRunetId = $request->getParam('OwnerRunetId', null);
    if ($ownerRunetId === null)
    {
      $ownerRunetId = $request->getParam('OwnerRocId', null);
    }

    /** @var $product \pay\models\Product */
    $product = \pay\models\Product::model()->byEventId($this->getEvent()->Id)->findByPk($productId);
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
    elseif ($this->getEvent()->Id != $product->EventId)
    {
      throw new \api\components\Exception(402);
    }

      $attributes = $request->getParam('Attributes', []);

    try {
      $orderItem = $product->getManager()->createOrderItem($payer, $owner, null, $attributes);
    } catch (\pay\components\Exception $e) {
      throw new \api\components\Exception(408, [$e->getCode(), $e->getMessage()], $e);
    }

    $collection = \pay\components\OrderItemCollection::createByOrderItems([$orderItem]);
    $result = null;
    foreach ($collection as $item)
    {
      $result = $this->getAccount()->getDataBuilder()->createOrderItem($item);
      break;
    }
    $this->getController()->setResult($result);
  }
}
