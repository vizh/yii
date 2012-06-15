<?php
AutoLoader::Import('library.rocid.event.*');

class EventInfo extends ApiCommand
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

    $this->Account->DataBuilder()->CreateEvent($event);
    $result = $this->Account->DataBuilder()->BuildEventFullInfo($event);
    $this->SendJson($result);
  }
}