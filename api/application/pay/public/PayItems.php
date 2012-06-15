<?php
AutoLoader::Import('library.rocid.pay.*');
AutoLoader::Import('library.rocid.user.*');
AutoLoader::Import('library.rocid.event.*');

class PayItems extends ApiCommand
{
  /**
   * @throws ApiException
   */
  protected function doExecute()
  {
    $ownerRocId = intval(Registry::GetRequestVar('OwnerRocId', 0));

    $owner = User::GetByRocid($ownerRocId);
    $event = Event::GetById($this->Account->EventId);
    if (empty($owner))
    {
      throw new ApiException(202, array($ownerRocId));
    }
    if (empty($event))
    {
      throw new ApiException(301);
    }

    $result = new stdClass();
    $orderItems = OrderItem::GetByOwnerAndEventId($owner->UserId, $event->EventId);
    $result->Items = array();
    foreach ($orderItems as $item)
    {
      $result->Items[] = $this->Account->DataBuilder()->CreateOrderItem($item);
    }

    $this->SendJson($result);
  }
}
