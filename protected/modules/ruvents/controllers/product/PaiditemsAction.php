<?php
namespace ruvents\controllers\product;

class PaiditemsAction extends \ruvents\components\Action
{
  public function run()
  {
    //todo:

    throw new \application\components\Exception('Not implement yet');

    $request = \Yii::app()->getRequest();
    $rocId = $request->getParam('RocId', null);

    $event = \event\models\Event::GetById($this->Operator()->EventId);
    if (empty($event))
    {
      throw new \ruvents\components\Exception(301);
    }
    $user = \user\models\User::GetByRocid($rocId);
    if (empty($user))
    {
      throw new \ruvents\components\Exception(202, array($rocId));
    }

    /** @var $paidItems \pay\models\OrderItem[] */
    $paidItems = \pay\models\OrderItem::model()
        ->byOwnerId($user->UserId)
        ->byRedirectId(null)
        ->byRedirectId($user->UserId, false)
        ->byEventId($event->EventId)
        ->byPaid(1)->with(array('Product', 'Payer', 'Owner', 'RedirectUser', 'Orders', 'Orders.OrderJuridical'))->findAll();

    $result = array();
    foreach ($paidItems as $item)
    {
      $result[] = $this->DataBuilder()->CreateOrderItem($item);
    }
    echo json_encode(array('OrderItems' => $result));
  }
}
