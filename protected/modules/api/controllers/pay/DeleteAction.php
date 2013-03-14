<?php
namespace api\controllers\pay;
class DeleteAction extends \api\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $orderItemId = $request->getParam('OrderItemId');
    $payerRunetId = $request->getParam('PayerRunetId');
    
    $orderItem = \pay\models\OrderItem::model()->findByPk($orderItemId);
    $payer = \user\models\User::model()->byRunetId($payerRunetId)->find();
    
    if ($orderItem == null)
    {
      throw new \api\components\Exception(409);
    }
    else if ($payer == null)
    {
      throw new \api\components\Exception(202, array($payerRunetId));
    }
    else if ($orderItem->PayerId != $payer->Id)
    {
      throw new \api\components\Exception(410);
    }
    else if ($this->getAccount()->Event == null)
    {
      throw new \api\components\Exception(301);
    }
    else if ($orderItem->Product->EventId != $event->Id)
    {
      throw new \api\components\Exception(402);
    }
    else if ($orderItem->Paid == 1)
    {
      throw new \api\components\Exception(411);
    }
    
    if (!$orderItem->delete())
    {
      throw new \api\components\Exception(412);
    }
    $this->getController()->setResult(array('Success' => true));
  }
}
