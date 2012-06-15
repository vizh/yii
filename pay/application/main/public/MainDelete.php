<?php

class MainDelete extends PayCommand
{
  /**
   * Основные действия комманды
   * @param int $orderItemId
   * @return void
   */
  protected function doExecute($orderItemId = 0)
  {
    $orderItem = OrderItem::GetById($orderItemId);
    if ($this->LoginUser === null || $orderItem === null)
    {
      Lib::Redirect(RouteRegistry::GetUrl('main', '', 'index'));
    }

    if ($orderItem->PayerId === $this->LoginUser->UserId)
    {
      $orderItem->Deleted = 1;
      $orderItem->save();
    }

    Lib::Redirect(RouteRegistry::GetUrl('main', '', 'index', array('eventId' => $orderItem->Product->EventId)));
  }
}