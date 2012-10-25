<?php
AutoLoader::Import('library.rocid.event.*');

class EventInfo extends ApiCommand
{

  /**
   * Основные действия комманды
   * @throws ApiException
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
    $this->Account->DataBuilder()->BuildEventMenu($event);
    $this->Account->DataBuilder()->BuildEventPlace($event);
    $result = $this->Account->DataBuilder()->BuildEventFullInfo($event);
    $this->SendJson($result);
  }
}