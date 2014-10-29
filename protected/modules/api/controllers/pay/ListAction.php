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

    usort($result->Items, [$this,'sortItems']);

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
      $orderObj->Number = $collection->getOrder()->Number;
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

  /**
   * @param $item1
   * @param $item2
   * @return bool|int
   */
  private function sortItems($item1, $item2)
  {
    $result = strcasecmp($item1->Owner->LastName, $item2->Owner->LastName);
    if ($result == 0) {
        $result = strcasecmp($item1->Owner->FirstName, $item2->Owner->FirstName);
    }
    return $result;
  }
}
