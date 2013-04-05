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
    $orderItems = \pay\models\OrderItem::model()
        ->byOwnerId($owner->Id)->byChangedOwnerId($owner->Id, false)
        ->byEventId($this->getEvent()->Id)->byPaid(true)
        ->findAll();
    $result->Items = array();
    foreach ($orderItems as $orderItem)
    {
      $result->Items[] = $this->getAccount()->getDataBuilder()->createOrderItem($orderItem);
    }
    $this->getController()->setResult($result);
  }
}
