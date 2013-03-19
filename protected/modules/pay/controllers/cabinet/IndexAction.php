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

    $orderItems = \pay\models\OrderItem::getFreeItems(\Yii::app()->user->CurrentUser()->Id, $this->getController()->getEvent()->Id);
    $unpaidItems = array();
    $paidItems = array();
    $recentPaidItems = array();
    //$products = array();

    foreach ($orderItems as $orderItem)
    {
      if (!$orderItem->Paid)
      {
        if ($orderItem->Product->getManager()->checkProduct($orderItem->Owner))
        {
          $unpaidItems[$orderItem->Product->Id][] = $orderItem;
          //$products[$orderItem->Product->Id] = $orderItem->Product;
        }
        else
        {
          $orderItem->delete();
        }
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

    $this->getController()->render('index', array(
      //'products' => $products,
      'unpaidItems' => $unpaidItems,
      'paidItems' => $paidItems,
      'recentPaidItems' => $recentPaidItems,
      'juridicalOrders' => array(),//\pay\models\Order::GetOrdersWithJuridical(\Yii::app()->user->getId(), $this->event->EventId),
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
