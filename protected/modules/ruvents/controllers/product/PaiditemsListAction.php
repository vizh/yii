<?php
namespace ruvents\controllers\product;


class PaiditemsListAction extends \ruvents\components\Action
{
  public function run()
  {
    ini_set("memory_limit", "512M");

    $criteria = new \CDbCriteria();
    $criteria->with = array(
      'Product',
      'Payer',
      'Owner',
      'ChangedOwner',
      'OrderLinks.Order'
    );

    /** @var $paidItems \pay\models\OrderItem[] */
    $paidItems = \pay\models\OrderItem::model()
        ->byEventId($this->getEvent()->Id)->byPaid(true)
        ->findAll($criteria);

    $result = array();
    foreach ($paidItems as $item)
    {
      $result[] = $this->getDataBuilder()->createOrderItem($item);
    }
    echo json_encode(array('OrderItems' => $result));
  }
}