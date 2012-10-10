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

  public function actionChangepaid()
  {
    $request = \Yii::app()->getRequest();
    $fromRocId = $request->getParam('FromRocId', null);
    $toRocId = $request->getParam('ToRocId', null);
    $orderItemIdList = $request->getParam('orderItemIdList', '');
    $orderItemIdList = explode(',', $orderItemIdList);

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

    $criteria = new CDbCriteria();
    $criteria->addInCondition('t.OrderItemId', $orderItemIdList);

    /** @var $orderItems \pay\models\OrderItem[] */
    $orderItems = \pay\models\OrderItem::model()->findAll($criteria);

    if (empty($orderItems))
    {
      throw new \ruvents\components\Exception(409, array(implode(',', $orderItemIdList)));
    }
    if ( sizeof($orderItems) < sizeof($orderItemIdList))
    {
      $errorId = array();
      foreach ($orderItemIdList as $id)
      {
        $flag = true;
        foreach($orderItems as $item)
        {
          if ($item->OrderItemId == $id)
          {
            $flag = false;
            break;
          }
        }
        if ($flag)
        {
          $errorId[] = $id;
        }
      }
      throw new \ruvents\components\Exception(409, array(implode(',', $errorId)));
    }
    $this->checkOwned($orderItems, $fromUser);

    $this->checkProducts($orderItems, $toUser);

    foreach ($orderItems as $item)
    {
      $item->setRedirectUser($toUser);
    }

    echo json_encode(array('Success' => true));
  }

  /**
   * @param \pay\models\OrderItem[] $orderItems
   * @param \user\models\User $user
   * @throws ruvents\components\Exception
   * @return void
   */
  private function checkOwned($orderItems, $user)
  {
    $errorId = array();
    foreach ($orderItems as $item)
    {
      if ((!empty($item->RedirectId) && $item->RedirectId != $user->UserId) ||
        (empty($item->RedirectId) && $item->OwnerId != $user->UserId))
      {
        $errorId[] = $item->OrderItemId;
      }
    }
    if (!empty($errorId))
    {
      throw new \ruvents\components\Exception(413, array(implode(',', $errorId)));
    }
  }

  /**
   * @param \pay\models\OrderItem[] $orderItems
   * @param \user\models\User $user
   * @throws ruvents\components\Exception
   * @return void
   */
  private function checkProducts($orderItems, $user)
  {
    $errorId = array();
    foreach ($orderItems as $item)
    {
      if (!$item->Product->ProductManager()->CheckProduct($user, $item->GetParamValues()))
      {
        $errorId[] = $item->OrderItemId;
      }
    }
    if (!empty($errorId))
    {
      throw new \ruvents\components\Exception(414, array(implode(',', $errorId)));
    }
  }

}