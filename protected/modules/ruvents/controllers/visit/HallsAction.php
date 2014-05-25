<?php
namespace ruvents\controllers\visit;

class HallsAction extends \ruvents\components\Action
{
  public function run()
  {
    $halls = \event\models\section\Hall::model()->byEventId($this->getEvent()->Id)->findAll();
    $result = [];
    foreach ($halls as $hall)
    {
        $result[] = $this->getDataBuilder()->createSectionHall($hall);
    }
    $this->renderJson($result);
  }
} 