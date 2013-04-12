<?php
namespace partner\controllers\special\rif13;


class BookinfoAction extends \partner\components\Action
{
  public function run()
  {
    $products = \pay\models\Product::model()
        ->byEventId($this->getEvent()->Id)->byManagerName('RoomProductManager')->findAll();
    $idList = array();

    foreach ($products as $product)
    {
      $idList[] = $product->Id;
    }

    $criteria = new \CDbCriteria();
    $criteria->addInCondition('"t"."ProductId"', $idList);
    $criteria->addCondition('"t"."Booked" IS NOT NULL AND "t"."Booked" > :Booked');
    $criteria->params['Booked'] = '2013-04-11 00:00:00';
    $criteria->order = '"t"."Booked"';

    $orderItems = \pay\models\OrderItem::model()
        ->byPaid(false)->byDeleted(false)->findAll($criteria);

    $this->getController()->render('rif13/bookinfo', array('orderItems' => $orderItems));
  }
}