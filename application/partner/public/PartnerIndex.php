<?php
AutoLoader::Import('library.rocid.event.*');
AutoLoader::Import('library.rocid.pay.*');

class PartnerIndex extends PartnerCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $stat = new stdClass();
    $stat->Pay = new stdClass();
    $stat->Pay->Juridical = new stdClass();
    $stat->Pay->Juridical->Orders = 0;
    $stat->Pay->Juridical->OrdersPaid = 0;
    $stat->Pay->Juridical->Total = 0;
    $stat->Pay->Individual = new stdClass();
    $stat->Pay->Individual->Orders = 0;
    $stat->Pay->Individual->OrdersPaid = 0;
    $stat->Pay->Individual->Total = 0;
    
    $event = Event::GetById($this->Account->EventId);
    
    $orders = $this->getOrders();
    foreach ($orders as $order)
    {
      if ($order->OrderJuridical != null)
      {
        $stat->Pay->Juridical->Orders++;
        if ($order->OrderJuridical->Paid == 1)
        {
          $stat->Pay->Juridical->OrdersPaid++;
          $stat->Pay->Juridical->Total += $this->getSumPrice($order->Items);
        }
      }
      else
      {
        $stat->Pay->Individual->Orders++;
        foreach ($order->Items as $orderItem)
        {
          if ($orderItem->Paid)
          {
            $stat->Pay->Individual->OrdersPaid++;
            $stat->Pay->Individual->Total += $this->getSumPrice($order->Items);
            break;
          }
        }
      }
    }
    
    
    $roles = $this->getEventRoles();
    if (!empty($event->Days))
    {
      foreach ($event->Days as $day)
      {
        $stat->Participants[$day->DayId] = new stdClass();
        $stat->Participants[$day->DayId]->Title = $day->Title;
      }
    }
    
    foreach ($roles as $role)
    {
      if (!empty($event->Days))
      {
        $stat->Participants[$role->DayId]->Roles[$role->RoleId] = new stdClass();
        $stat->Participants[$role->DayId]->Roles[$role->RoleId]->RoleName = $role->Role->Name;
        $stat->Participants[$role->DayId]->Roles[$role->RoleId]->Count = $this->getCountParticipants($role->RoleId, $role->DayId);
      }
      else
      {
        $stat->Participants[$role->RoleId] = new stdClass();
        $stat->Participants[$role->RoleId]->RoleName = $role->Role->Name;
        $stat->Participants[$role->RoleId]->Count = $this->getCountParticipants($role->RoleId);
      }
    }
    
    $this->view->Event = $event;
    $this->view->Stat = $stat;
    echo $this->view;
  }
  
  
  private function getCountParticipants ($roleId, $dayId = null)
  {
    $criteria = new CDbCriteria();
    $criteria->condition = 't.EventId = :EventId AND t.RoleId = :RoleId';
    $criteria->params['EventId'] = $this->Account->EventId;
    $criteria->params['RoleId'] = $roleId;
    if ($dayId != null)
    {
      $criteria->addCondition('t.DayId = :DayId');
      $criteria->params['DayId'] = $dayId;
    }
    return EventUser::model()->count($criteria);
  }


  private function getSumPrice($items)
  {
    $total = 0;
    foreach ($items as $item)
    {
      $total += $item->PriceDiscount();
    }
    return $total;
  }
  
  
  private function getEventRoles ()
  {
    $criteria = new CDbCriteria();
    $criteria->select = array('t.RoleId', 't.DayId');
    $criteria->with = array('EventRole', 'Day');
    $criteria->group  = 't.RoleId, t.DayId';
    $criteria->condition = 't.EventId = :EventId';
    $criteria->params['EventId'] = $this->Account->EventId;
    return EventUser::model()->findAll($criteria);
  }


  private function getOrders()
  {
    $criteria = new CDbCriteria();
    $criteria->condition = 't.EventId = :EventId';
    $criteria->params['EventId'] = $this->Account->EventId;
    $criteria->with = array('OrderJuridical', 'Items');
    return Order::model()->findAll($criteria);
  }
}
