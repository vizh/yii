<?php
namespace api\controllers\section;

class ListAction extends \api\components\Action
{
  public function run()
  {
    $sections = $this->getEvent()->Sections([
      'with' => ['LinkHalls.Hall', 'Attributes'],
      'order' => '"Sections"."Id"'
    ]);

    $result = [];
    foreach ($sections as $section)
    {
      $result[] = $this->getAccount()->getDataBuilder()->createSection($section);
    }
    $this->setResult($result);
  }
}
