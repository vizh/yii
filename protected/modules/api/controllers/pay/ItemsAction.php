<?php
namespace api\controllers\pay;
class ItemsAction extends \api\components\Action
{
  public function run()
  {
    $ownerRunetId = \Yii::app()->request->getParam('OwnerRunetId');
    $owner = \user\models\User::model()->byRunetId($ownerRunetId)->find();
    if ($owner == null)
    {
      throw new \api\components\Exception(202, array($ownerRunetId));
    }
    else if ($this->getAccount()->Event == null)
    {
      throw new \api\components\Exception(301);
    }
    
    $result = new \stdClass();
    $orderItems = \pay\models\OrderItem::model()->byEventId($this->getAccount()->EventId)
        ->byOwnerId($owner->Id)->byBooked(true)
        ->byDeleted(false)->findAll();
    $result->Items = array();
    foreach ($orderItems as $orderItem)
    {
      $result->Items[] = $this->getAccount()->getDataBuilder()->createOrderItem($orderItem);
    }
    $this->getController()->setResult($result);
  }
}
