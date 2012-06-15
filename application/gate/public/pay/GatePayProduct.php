<?php
AutoLoader::Import('gate.source.*');
AutoLoader::Import('library.rocid.event.*');

class GatePayProduct extends GateJsonCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $event = Event::GetEventByIdName($this->EventName);

    if (empty($event))
    {
      $this->SendJson(true, 202, 'Не найдено мероприятие с текстовым идентификатором ' . $this->EventName);
    }

    $products = Product::GetByEventId($event->EventId);

    $this->result['products'] = array();
    foreach ($products as $product)
    {
      $this->result['products'][] = array('ProductId' => $product->ProductId, 'Price' => $product->GetPrice(), 'Title' => $product->Title);
    }

    $this->SendJson();
  }
}
