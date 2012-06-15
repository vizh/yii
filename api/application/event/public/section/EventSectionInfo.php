<?php
AutoLoader::Import('library.rocid.event.*');
AutoLoader::Import('library.rocid.user.*');

class EventSectionInfo extends ApiCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $sectionId = Registry::GetRequestVar('SectionId');

    $event = Event::GetById($this->Account->EventId);
    if (empty($event))
    {
      throw new ApiException(301);
    }

    /** @var $section EventProgram */
    $section = EventProgram::model()->findByPk($sectionId);
    if (empty($section))
    {
      throw new ApiException(310, array($sectionId));
    }
    if ($section->EventId != $event->EventId)
    {
      throw new ApiException(311);
    }

    $this->SendJson($this->Account->DataBuilder()->CreateSection($section));
  }
}
