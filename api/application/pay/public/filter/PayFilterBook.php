<?php
AutoLoader::Import('library.rocid.pay.*');
AutoLoader::Import('library.rocid.user.*');
AutoLoader::Import('library.rocid.event.*');

class PayFilterBook extends ApiCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $manager = Registry::GetRequestVar('Manager');
    $params = Registry::GetRequestVar('Params', array());
    $bookTime = Registry::GetRequestVar('BookTime', null);
    $payerRocId = intval(Registry::GetRequestVar('PayerRocId', 0));
    $ownerRocId = intval(Registry::GetRequestVar('OwnerRocId', 0));

    $product = Product::GetByManager($manager, $this->Account->EventId);
    if (!empty($product))
    {
      $product = $product->ProductManager()->GetFilterProduct($params);
    }
    if (empty($product))
    {
      throw new ApiException(420);
    }

    $payer = User::GetByRocid($payerRocId);
    $owner = User::GetByRocid($ownerRocId);
    $event = Event::GetById($this->Account->EventId);
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

    $orderItem = $product->ProductManager()->CreateOrderItem($payer, $owner, $bookTime, $params);

    $result = $this->Account->DataBuilder()->CreateOrderItem($orderItem);
    $this->SendJson($result);
  }
}
