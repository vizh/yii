<?php
AutoLoader::Import('library.rocid.user.*');
AutoLoader::Import('library.rocid.event.*');

class EventSectionList extends ApiCommand
{
  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $event = Event::GetById($this->Account->EventId);
    $result = array();
    if (empty($event))
    {
      $this->SendJson($result);
      return;
    }

    $sections = $event->Program;
    foreach ($sections as $section)
    {
      $result[] = $this->Account->DataBuilder()->CreateSection($section);
    }
    $this->SendJson($result);
  }
}