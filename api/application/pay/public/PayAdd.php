<?php
AutoLoader::Import('library.rocid.pay.*');
AutoLoader::Import('library.rocid.user.*');
AutoLoader::Import('library.rocid.event.*');

class PayAdd extends ApiCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $productId = intval(Registry::GetRequestVar('ProductId', 0));
    $payerRocId = intval(Registry::GetRequestVar('PayerRocId', 0));
    $ownerRocId = intval(Registry::GetRequestVar('OwnerRocId', 0));

    $product = Product::GetById($productId);
    $payer = User::GetByRocid($payerRocId);
    $owner = User::GetByRocid($ownerRocId);
    $event = Event::GetById($this->Account->EventId);
    if (empty($product))
    {
      throw new ApiException(401, array($productId));
    }
    if (empty($payer))
    {
      throw new ApiException(202, array($payerRocId));
    }
    if (empty($owner))
    {
      throw new ApiException(202, array($ownerRocId));
    }
    if (empty($event))
    {
      throw new ApiException(301);
    }
    if ($product->EventId != $event->EventId)
    {
      throw new ApiException(402);
    }
    if (! $product->ProductManager()->CheckProduct($owner))
    {
      throw new ApiException(403);
    }

    $orderItem = OrderItem::GetByAll($productId, $payer->UserId, $owner->UserId);
    if (! empty($orderItem) && $orderItem->Paid == 0)
    {
      throw new ApiException(405);
    }

    $orderItem = $product->ProductManager()->CreateOrderItem($payer, $owner);

    $result = $this->Account->DataBuilder()->CreateOrderItem($orderItem);
    $this->SendJson($result);
  }
}