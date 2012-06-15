<?php
AutoLoader::Import('library.rocid.user.*');
AutoLoader::Import('library.rocid.event.*');

class EventList extends ApiCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $year = Registry::GetRequestVar('Year', date('Y'));
    $year = intval($year);

    $events = Event::GetEventsByDates($year.'-01-01', $year.'-12-31');

    $result = array();
    foreach ($events as $event)
    {
      $result[] = $this->Account->DataBuilder()->CreateEvent($event);
    }

    $this->SendJson($result);
  }
}