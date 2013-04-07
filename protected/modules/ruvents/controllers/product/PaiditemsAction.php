<?php
namespace ruvents\controllers\product;

class PaiditemsAction extends \ruvents\components\Action
{
  public function run()
  {
    $request = \Yii::app()->getRequest();
    $runetId = $request->getParam('RunetId', null);

    $event = $this->getEvent();
    $user = \user\models\User::model()->byRunetId($runetId);
    if ($user === null)
    {
      throw new \ruvents\components\Exception(202, array($runetId));
    }

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
        ->byOwnerId($user->Id)->byChangedOwnerId($user->Id, false)
        ->byEventId($event->Id)->byPaid(true)->findAll($criteria);

    $result = array();
    foreach ($paidItems as $item)
    {
      $result[] = $this->getDataBuilder()->createOrderItem($item);
    }
    echo json_encode(array('OrderItems' => $result));
  }
}
