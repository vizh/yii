<?php
namespace api\controllers\section;

class UpdatedAction extends \api\components\Action
{
  public function run()
  {
    $sections = $this->getEvent()->Sections(array('with' => array('LinkHalls.Hall', 'Attributes')));

    $result = array();
    foreach ($sections as $section)
    {
      $result[] = $this->getAccount()->getDataBuilder()->createSection($section);
    }
    $this->setResult($result);
  }
}
