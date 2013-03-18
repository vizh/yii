<?php
namespace pay\controllers\cabinet;

class IndexAction extends \pay\components\Action
{
  public function run($eventIdName)
  {
    if (\Yii::app()->user->isGuest)
    {
      $this->getController()->redirect(
        $this->getController()->createUrl('/event/view/index', array('idName' => $eventIdName))
      );
    }

    /** @var $event \event\models\Event */
    $event = \event\models\Event::model()->byIdName($eventIdName)->find();
    if ($event == null)
    {
      throw new \CHttpException(404);
    }

    $orderItems = \pay\models\OrderItem::getFreeItems(\Yii::app()->user->CurrentUser()->Id, $event->Id);
    $order = array();
    $paidItems = array();
    $recentPaidItems = array();
    if (!empty($orderItems))
    {
      foreach ($orderItems as $orderItem)
      {
        if ($orderItem->Paid == 0)
        {
          if (!$orderItem->Product->ProductManager()->CheckProduct($orderItem->Owner, $orderItem->getParamsArray()))
          {
            $orderItem->Deleted = 1;
            $orderItem->save();
            continue;
          }
          if (!isset($order[$orderItem->ProductId]))
          {
            $order[$orderItem->ProductId]->Product = \pay\models\Product::GetById($orderItem->ProductId);
          }

          $coupon = \pay\models\Coupon::GetByUser($orderItem->Owner->UserId, $this->event->EventId);
          $item = new \stdClass();
          $item->OrderItem = $orderItem;
          $item->Coupon = $coupon;
          $order[$orderItem->ProductId]->Items[] = $item;
        }
        else
        {
          if ($orderItem->PaidTime > date('Y-m-d H:i:s', time() - 10*60*60))
          {
            $recentPaidItems[] = $orderItem;
          }
          else
          {
            $paidItems[] = $orderItem;
          }
        }
      }
    }
    $this->getController()->render('index', array(
      'order' => $order,
      'event' => $event,
      'juridicalOrders' => array(),//\pay\models\Order::GetOrdersWithJuridical(\Yii::app()->user->getId(), $this->event->EventId),
      'paidItems' => $paidItems,
      'recentPaidItems' => $recentPaidItems
    ));
  }
}


/*
 *

    $request = \Yii::app()->getRequest();
    if ($request->getParam('action') !== null)
    {
      switch ($request->getParam('action'))
      {
        case 'deleteOrderItem':
          $orderItem = \pay\models\OrderItem::model()->findByPk($request->getParam('orderItemId'));
          if ($orderItem->PayerId == \Yii::app()->user->getId()
              && $orderItem->Paid == 0)
          {
            $orderItem->Deleted = 1;
            $orderItem->save();
          }
          break;

        case 'deleteOrderJuridical':
          $order = \pay\models\Order::GetById($request->getParam('orderId'));
          if ($order->PayerId == \Yii::app()->user->getId()
              && $order->OrderJuridical !== null)
          {
            $order->OrderJuridical->DeleteOrder();
          }
      }

      $this->redirect(
        $this->createUrl('/runetid2/pay/orderitems', array('eventId' => $this->event->EventId))
      );
    }
 */
