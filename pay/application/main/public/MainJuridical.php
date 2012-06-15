<?php

class MainJuridical extends PayCommand
{
  protected function preExecute()
  {
    parent::preExecute();

    $titles = Registry::GetWord('titles');
    $this->SetTitle($titles['pay'] . ' - Выставление счета');
  }

  /**
   * Основные действия комманды
   * @param int $eventId
   * @return void
   */
  protected function doExecute($eventId = 0)
  {
    if ($this->LoginUser === null)
    {
      Lib::Redirect(RouteRegistry::GetUrl('main', '', 'index'));
    }
    $eventId = intval($eventId);

    $orderItems = OrderItem::GetByEventId($this->LoginUser->UserId, $eventId);

    $total = 0;
    foreach ($orderItems as $item)
    {
      if ($item->Product->ProductManager()->CheckProduct($item->Owner))
      {
        if ($item->Paid == 0)
        {
          $newItems[] = $item;
          $total += $item->PriceDiscount();
        }
      }
      else
      {
        if ($item->Paid != 1)
        {
          $item->Deleted = 1;
          $item->save();
        }
      }
    }
    
    if (empty($newItems))
    {
      Lib::Redirect(RouteRegistry::GetUrl('main', '', 'index', array('eventId' => $eventId)));
    }

    $data = array();
    if (\Yii::app()->getRequest()->getIsPostRequest())
    {
      $data = Registry::GetRequestVar('data');
      if ($this->validateForm($data))
      {
        Order::CreateOrder($this->LoginUser, $eventId, $data);
        Lib::Redirect(RouteRegistry::GetUrl('main', '', 'index', array('eventId' => $eventId)));
      }
      else
      {
        $this->AddErrorNotice('Необходимо заполнить все поля данных юр. лиц.');
      }
    }

    $this->view->Data = CHtml::encodeArray($data);
    $this->view->EventId = $eventId;
    $this->view->Total = $total;
    $this->view->NewItems = $newItems;

    echo $this->view;
  }

  private function validateForm($data)
  {
    return !empty($data['Name']) && !empty($data['Address']) && !empty($data['INN']) && !empty($data['KPP']) && !empty($data['Phone']) && !empty($data['PostAddress']);
  }
}
