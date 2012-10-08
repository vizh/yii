<?php

class MainController extends \partner\components\Controller
{
  public function actionIndex()
  {
    $stat = new \stdClass();
    $stat->Pay = new \stdClass();
    $stat->Pay->Juridical = new \stdClass();
    $stat->Pay->Juridical->Orders = 0;
    $stat->Pay->Juridical->OrdersPaid = 0;
    $stat->Pay->Juridical->Total = 0;
    $stat->Pay->Individual = new \stdClass();
    $stat->Pay->Individual->Paid = 0;
    $stat->Pay->Individual->OrdersPaid = 0;
    $stat->Pay->Individual->Total = 0;

    $stat->Participants = array();
    
    $event = \event\models\Event::GetById(\Yii::app()->partner->getAccount()->EventId);
    /**
    $orders = $this->getOrdersJuridical();
    foreach ($orders as $order)
    {
      $stat->Pay->Juridical->Orders++;
      if ($order->OrderJuridical->Paid == 1)
      {
        $stat->Pay->Juridical->OrdersPaid++;
        $stat->Pay->Juridical->Total += $this->getSumPrice($order->Items);
      }
    }
    
 
    $orderItems = $this->getPaidOrdersItemsIndividual();
    $payerRocidList = array();
    foreach ($orderItems as $orderItem)
    {
      if ($orderItem->Paid == 1)
      {
        if (!in_array($orderItem->PayerId, $payerRocidList))
        {
          $payerRocidList[] = $orderItem->PayerId;
        }
        $stat->Pay->Individual->Total += $orderItem->PriceDiscount();
      }
    }
    $stat->Pay->Individual->Paid = sizeof($payerRocidList);
    unset($payerRocidList);
    */
    
    // Список ролей на мероприятии
    $criteria = new CDbCriteria();
    $criteria->group = 't.RoleId';
    $criteria->condition = 't.EventId = :EventId';
    $criteria->params['EventId'] = \Yii::app()->partner->getAccount()->EventId;
    $criteria->with = array('Role');
    $criteria->select = 't.RoleId';
    $roles = \event\models\Participant::model()->findAll($criteria);
    foreach ($roles as $role)
    {
      $stat->Roles[$role->RoleId] = $role->Role->Name;
    }
    

    // Подсчет участников
    $todayTimestamp  = mktime(0, 0, 0, date('n'), date('j'), date('Y'));
    $mondayTimeStamp = $todayTimestamp - ((date('N')-1) * 86400);
    if (!empty($event->Days))
    {
      //// Мероприятие на несколько дней
      $criteria = new CDbCriteria();
      $criteria->condition = 't.EventId = :EventId';
      $criteria->params['EventId'] = $event->EventId;
      $criteria->group = 't.DayId, t.RoleId';
      $criteria->select = 't.DayId, t.RoleId, Count(*) as CountForCriteria';
      $participants = \event\models\Participant::model()->findAll($criteria);
      foreach ($participants as $participant)
      {
        $stat->Participants[$participant->DayId][$participant->RoleId]->Count = $participant->CountForCriteria;
      }
      
      //// Прирост за неделю
      $criteria->addCondition('t.CreationTime >= :CreationTime');
      $criteria->params['CreationTime'] = $mondayTimeStamp;
      $participants = \event\models\Participant::model()->findAll($criteria);
      foreach ($participants as $participant)
      {
        $stat->Participants[$participant->DayId][$participant->RoleId]->Count = $participant->CountForCriteria;
      }
      
      //// Прирост за сегодня
      $criteria->params['CreationTime'] = $todayTimestamp;
      $participants = \event\models\Participant::model()->findAll($criteria);
      foreach ($participants as $participant)
      {
        $stat->Participants[$participant->DayId][$participant->RoleId]->Count = $participant->CountForCriteria;
      }
    }
    else
    {
      //// Мероприятие на 1 день
      $criteria = new CDbCriteria();
      $criteria->condition = 't.EventId = :EventId';
      $criteria->params['EventId'] = $event->EventId; 
      $criteria->group = 't.RoleId';
      $criteria->select = 't.RoleId, Count(*) as CountForCriteria';
      $participants = \event\models\Participant::model()->findAll($criteria);
      foreach ($participants as $participant)
      {
        $stat->Participants[$participant->RoleId]->Count = $participant->CountForCriteria;
      }
      
      //// Прирост за неделю
      $criteria->addCondition('t.CreationTime >= :CreationTime');
      $criteria->params['CreationTime'] = $mondayTimeStamp;
      $participants = \event\models\Participant::model()->findAll($criteria);
      foreach ($participants as $participant)
      {
        $stat->Participants[$participant->RoleId]->CountWeek = $participant->CountForCriteria;
      }
      
      //// Прирост за сегодня
      $criteria->params['CreationTime'] = $todayTimestamp;
      $participants = \event\models\Participant::model()->findAll($criteria);
      foreach ($participants as $participant)
      {
        $stat->Participants[$participant->RoleId]->CountToday = $participant->CountForCriteria;
      }
    }
    
    $this->render('index',array('stat' => $stat, 'event' => $event));
  }

  /**
   * @param \pay\models\OrderItem[] $items
   * @return int
   */
  private function getSumPrice($items)
  {
    $total = 0;
    foreach ($items as $item)
    {
      if ($item->Paid == 1)
      {
        $total += $item->PriceDiscount();
      }
    }
    return $total;
  }

  private function getEventRoles()
  {
    $criteria = new \CDbCriteria();
    $criteria->select = array('t.RoleId', 't.DayId');
    $criteria->with = array('Role', 'Day');
    $criteria->group  = 't.RoleId, t.DayId';
    $criteria->condition = 't.EventId = :EventId';
    $criteria->params['EventId'] = \Yii::app()->partner->getAccount()->EventId;
    return \event\models\Participant::model()->findAll($criteria);
  }

  
  private function getPaidOrdersItemsIndividual ()
  {
    $criteria = new \CDbCriteria();
    $criteria->with = array(
      'Orders' => array('select' => false, 'together' => true), 
      'Orders.OrderJuridical' => array('select' => false, 'together' => true),
      'Product'
    );
    $criteria->condition = 'OrderJuridical.OrderId IS NULL AND Product.EventId = :EventId AND t.Paid = 1';
    $criteria->params['EventId'] = \Yii::app()->partner->getAccount()->EventId;
    return \pay\models\OrderItem::model()->findAll($criteria);
  }


  /**
   * @return \pay\models\Order[]
   */
  private function getOrdersJuridical()
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.EventId = :EventId AND OrderJuridical.OrderId IS NOT NULL';
    $criteria->params['EventId'] = \Yii::app()->partner->getAccount()->EventId;
    $criteria->with = array('OrderJuridical', 'Items');
    return \pay\models\Order::model()->findAll($criteria);
  }
}