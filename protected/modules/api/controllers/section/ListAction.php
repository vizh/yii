<?php
namespace api\controllers\section;

class ListAction extends \api\components\Action
{
  public function run()
  {
    if ($this->getAccount()->Event === null)
    {
      throw new \api\components\Exception(301);
    }

    $result = array();

    /** @var $sections \event\models\section\Section[] */
    $sections = $this->getAccount()->Event->Sections(array('with' => array('LinkHalls.Hall', 'Attributes')));
    foreach ($sections as $section)
    {
      $result[] = $this->getAccount()->getDataBuilder()->createSection($section);
    }
    $this->setResult($result);
  }
}
