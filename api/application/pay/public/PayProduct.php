<?php
AutoLoader::Import('library.rocid.pay.*');
AutoLoader::Import('library.rocid.user.*');
AutoLoader::Import('library.rocid.event.*');

class PayProduct extends ApiCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $event = Event::GetById($this->Account->EventId);

    if (empty($event))
    {
      throw new ApiException(301);
    }

    $products = Product::GetByEventId($event->EventId);

    $result = array();
    foreach ($products as $product)
    {
      $result[] = $this->Account->DataBuilder()->CreateProduct($product);
    }

    $this->SendJson($result);
  }
}
