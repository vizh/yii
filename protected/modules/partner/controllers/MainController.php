<?php

class MainController extends \partner\components\Controller
{
  public function actions()
  {
    return array(
      'index' => 'partner\controllers\main\IndexAction',
    );
  }

  
  public function actionPay()
  {
    ini_set("memory_limit", "512M");

    $this->setPageTitle('Статистика платежей');
    $this->initActiveBottomMenu('pay');
    
    $stat = new \stdClass();
    $event = \event\models\Event::GetById(\Yii::app()->partner->getAccount()->EventId);
    
    // Юридические счета
    $juridicalOrderItemPaidIdList = array();
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.EventId = :EventId AND OrderJuridical.OrderId IS NOT NULL';
    $criteria->params['EventId'] = $event->EventId;
    $criteria->with = array('OrderJuridical', 'Items');
    $stat->Juridical->Orders = \pay\models\Order::model()->count($criteria);
    $criteria->addCondition('OrderJuridical.Paid = 1');
    $orders = \pay\models\Order::model()->findAll($criteria);
    $stat->Juridical->Total = 0;
    $stat->Juridical->OrdersPaid = 0;
    foreach ($orders as $order)
    {
      $stat->Juridical->OrdersPaid++;
      foreach ($order->Items as $orderItem)
      {
        if ($orderItem->Paid == 1)
        {
          $stat->Juridical->Total += $orderItem->PriceDiscount();
          $juridicalOrderItemPaidIdList[] = $orderItem->OrderItemId;
        }
      }
    }
    
    // Физические счета
    $criteria = new \CDbCriteria();
    $criteria->with = array(
      'Product'
    );
    $criteria->condition = 'Product.EventId = :EventId AND t.Paid = 1';
    $criteria->params['EventId'] = $event->EventId;
    $criteria->addNotInCondition('t.OrderItemId', $juridicalOrderItemPaidIdList);
    /** @var $orderItems \pay\models\OrderItem[] */
    $orderItems = \pay\models\OrderItem::model()->findAll($criteria);
    $payerRocidList = array();
    $stat->Individual->Total = 0;
    foreach ($orderItems as $orderItem)
    {
      if (!in_array($orderItem->PayerId, $payerRocidList))
      {
        $payerRocidList[] = $orderItem->PayerId;
      }
      $stat->Individual->Total += $orderItem->PriceDiscount();
    }
    $stat->Individual->Paid = sizeof($payerRocidList);
    unset($payerRocidList);
    
    $this->render('pay', array('stat' => $stat, 'event' => $event));
  }
  
  
  public function initBottomMenu()
  {
    $this->bottomMenu = array(
      'index' => array(
        'Title' => 'Участники',
        'Url' => \Yii::app()->createUrl('/main/index'),
        'Access' => $this->getAccessFilter()->checkAccess('main', 'index')
      ),
      'pay' => array(
        'Title' => 'Фин. статистика',
        'Url' => \Yii::app()->createUrl('/main/pay'),
        'Access' => $this->getAccessFilter()->checkAccess('main', 'pay')
      )
    );
  }
}