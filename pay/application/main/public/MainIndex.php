<?php
AutoLoader::Import('library.rocid.pay.*');

class MainIndex extends PayCommand
{

  /**
   * Основные действия комманды
   * @param int $eventId
   * @return void
   */
  protected function doExecute($eventId = 0)
  {

    if ($this->LoginUser === null)
    {
      $this->view->SetTemplate('no-login');
      echo $this->view;
      return;
    }
    $eventId = intval($eventId);
    $orderItems = OrderItem::GetByEventId($this->LoginUser->UserId, $eventId);

    $newItems = array();
    $paidItems = array();
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
        else
        {
          $paidItems[] = $item;
        }
      }
      else
      {
        if ($item->Paid != 1)
        {
          $item->Deleted = 1;
          $item->save();
        }
        else
        {
          $paidItems[] = $item;
        }
      }
    }

    $this->view->Orders = Order::GetOrdersWithJuridical($this->LoginUser->UserId, $eventId);
    $this->view->EventId = $eventId;
    $this->view->Total = $total;
    $this->view->NewItems = $newItems;
    $this->view->PaidItems = $paidItems;

    echo $this->view;
  }
}