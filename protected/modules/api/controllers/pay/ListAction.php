<?php
namespace api\controllers\pay;

class ListAction extends \api\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $payerRunetId = $request->getParam('PayerRunetId', null);
    if ($payerRunetId === null)
    {
      $payerRunetId = $request->getParam('PayerRocId', null);
    }

    $payer = \user\models\User::model()->byRunetId($payerRunetId)->find();
    if ($payer == null)
    {
      throw new \api\components\Exception(202, array($payerRunetId));
    }
    
    $result = new \stdClass();

    $finder = \pay\components\collection\Finder::create($this->getEvent()->Id, $payer->Id);
    $collections = array_merge([$finder->getUnpaidFreeCollection()], $finder->getPaidOrderCollections(), $finder->getPaidFreeCollections());

    $result->Items = array();
    foreach ($collections as $collection)
    {
      foreach ($collection as $item)
      {
        $result->Items[] = $this->getAccount()->getDataBuilder()->createOrderItem($item);
      }
    }

    /** @var $collections \pay\components\OrderItemCollection[] */
    $collections = array_merge($finder->getUnpaidOrderCollections(), $finder->getPaidOrderCollections());

    $result->Orders = array();
    foreach ($collections as $collection)
    {
      if ($collection->getOrder() == null)
        continue;
      $orderObj = new \stdClass();
      $orderObj->OrderId = $collection->getOrder()->Id;
      $orderObj->CreationTime = $collection->getOrder()->CreationTime;
      $orderObj->Paid = $collection->getOrder()->Paid;
      $orderObj->Url = $collection->getOrder()->getUrl();
      $orderObj->Items = array();
      foreach ($collection as $item)
      {
        $orderObj->Items[] = $this->getAccount()->getDataBuilder()->createOrderItem($item);
      }
      $result->Orders[] = $orderObj;
    }

    $this->getController()->setResult($result);
  }
}
