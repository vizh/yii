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
    
    $result = new \stdClass();
    $orderItems = \pay\models\OrderItem::model()->byEventId($this->getEvent()->Id)
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
