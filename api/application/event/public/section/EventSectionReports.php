<?php
AutoLoader::Import('library.rocid.event.*');
AutoLoader::Import('library.rocid.user.*');

class EventSectionReports extends ApiCommand
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
    $section = EventProgram::model()->with(array(
      'UserLinks',
      'UserLinks.User',
      'UserLinks.User.Employments.Company' => array('on' => 'Employments.Primary = :Primary', 'params' => array(':Primary' => 1)),
      'UserLinks.Role',
      'UserLinks.Report'))->findByPk($sectionId);
    if (empty($section))
    {
      throw new ApiException(310, array($sectionId));
    }
    if ($section->EventId != $event->EventId)
    {
      throw new ApiException(311);
    }

    $result = array();
    foreach ($section->UserLinks as $link)
    {
      $result[] = $this->Account->DataBuilder()->CreateReport($link);
    }

    $this->SendJson($result);
  }
}