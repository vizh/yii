<?php

class MainController extends \partner\components\Controller
{
  public function actionIndex()
  {
    $this->setPageTitle('Партнерский интерфейс');
    $this->initActiveBottomMenu('index');
    
    $stat = new \stdClass();
    $stat->Participants = array();
    
    $event = \event\models\Event::GetById(\Yii::app()->partner->getAccount()->EventId);
    
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