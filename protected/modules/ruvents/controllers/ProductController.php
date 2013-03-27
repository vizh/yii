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

  public function actionPaiditemslist()
  {
    ini_set("memory_limit", "512M");

    /** @var $paidItems \pay\models\OrderItem[] */
    $paidItems = \pay\models\OrderItem::model()
      ->byEventId($this->Operator()->EventId)
      ->byPaid(1)->with(array('Product', 'Orders.OrderJuridical'))->findAll();

    $result = array();
    foreach ($paidItems as $orderItem)
    {
      $userId = $orderItem->RedirectId !== null ? $orderItem->RedirectId : $orderItem->OwnerId;
      if (!isset($result[$userId]))
      {
        $result[$userId] = array();
      }

      $resultItem = new \stdClass();

      $resultItem->OrderItemId = $orderItem->OrderItemId;
      $resultItem->Product = $this->DataBuilder()->CreateProduct($orderItem->Product, $orderItem->PaidTime);

      $resultItem->Paid = $orderItem->Paid == 1;
      $resultItem->PaidTime = $orderItem->PaidTime;
      $resultItem->Booked = $orderItem->Booked;

      if ( in_array($orderItem->ProductId, array(696, 718, 719)))
      {
        $resultItem->PriceDiscount = $orderItem->PriceDiscount();
        $couponActivated = $orderItem->GetCouponActivated();
      }
      else
      {
        $resultItem->PriceDiscount = 0;
        $couponActivated = null;
      }

      if (!empty($couponActivated) && !empty($couponActivated->Coupon))
      {
        $resultItem->Discount = $couponActivated->Coupon->Discount;
        $resultItem->PromoCode = $couponActivated->Coupon->Code;
      }
      else
      {
        $resultItem->Discount = 0;
        $resultItem->PromoCode = '';
      }

      if ($resultItem->Discount == 1)
      {
        $resultItem->PayType = 'promo';
      }
      else
      {
        $resultItem->PayType = 'individual';
        foreach ($orderItem->Orders as $order)
        {
          if (!empty($order->OrderJuridical) && $order->OrderJuridical->Paid == 1)
          {
            $resultItem->PayType = 'juridical';
          }
        }
      }

      $result[$userId][] = $resultItem;
    }

    $newResult = array();
    foreach ($result as $key => $value)
    {
      /** @var $user \user\models\User */
      $user = \user\models\User::model()->findByPk($key);
      if (!empty($user))
      {
        $resultUser = new stdClass();
        $resultUser->RocId = $user->RocId;
        $resultUser->OrderItems = $value;
        $newResult[] = $resultUser;
      }
    }

    echo json_encode(array('Users' => $newResult));
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

    $detailLog = $this->detailLog->createBasic();
    foreach ($orderItems as $item)
    {
      $this->detailLog->addChangeMessage(new \ruvents\models\ChangeMessage('OrderItem', $item->OrderItemId, 0));
      $detailLog->addChangeMessage(new \ruvents\models\ChangeMessage('OrderItem', 0, $item->OrderItemId));
      $item->setRedirectUser($toUser);
    }

    $this->detailLog->UserId = $fromUser->UserId;
    $this->detailLog->save();

    $detailLog->UserId = $toUser->UserId;
    $detailLog->save();

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