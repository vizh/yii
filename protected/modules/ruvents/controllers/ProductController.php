<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alaris
 * Date: 8/29/12
 * Time: 6:23 PM
 * To change this template use File | Settings | File Templates.
 */
class ProductController extends \ruvents\components\Controller
{
  public function actionPaiditems()
  {
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

    /** @var $paidItems \pay\models\OrderItem */
    $paidItems = \pay\models\OrderItem::model()
      ->byOwnerId($user->UserId)
      ->byEventId($event->EventId)
      ->byPaid(1)->with(array('Product', 'Payer', 'Owner', 'RedirectUser'))->findAll();

    $result = array();
    foreach ($paidItems as $item)
    {
      $result[] = $this->DataBuilder()->CreateOrderItem($item);
    }
    echo json_encode(array('OrderItems' => $result));
  }

  public function actionChangepaid()
  {
    $request = \Yii::app()->getRequest();
    $fromRocId = $request->getParam('FromRocId', null);
    $toRocId = $request->getParam('ToRocId', null);
    $orderItemId = $request->getParam('OrderItemId', null);

    $event = \event\models\Event::GetById($this->Operator()->EventId);
    if (empty($event))
    {
      throw new \ruvents\components\Exception(301);
    }
    $fromUser = \user\models\User::GetByRocid($fromRocId);
    if (empty($fromUser))
    {
      throw new \ruvents\components\Exception(202, array($fromRocId));
    }
    $toUser = \user\models\User::GetByRocid($toRocId);
    if (empty($toUser))
    {
      throw new \ruvents\components\Exception(202, array($toRocId));
    }
    $orserItem = \pay\models\OrderItem::GetById($orderItemId);
    if (empty($orserItem))
    {
      throw new \ruvents\components\Exception(409);
    }
    if ($orserItem->OwnerId != $fromUser->UserId)
    {
      throw new \ruvents\components\Exception(413);
    }

    $success = $orserItem->setRedirectUser($toUser);

    echo json_encode(array('Success' => $success));
  }

}
