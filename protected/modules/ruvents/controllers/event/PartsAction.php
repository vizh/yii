<?php
namespace ruvents\controllers\event;

use event\models\Part;

class PartsAction extends \ruvents\components\Action
{
  public function run()
  {
    $event = $this->getEvent();
    $parts = Part::model()->byEventId($event->Id)->findAll();
    $response = [];

    foreach ($parts as $part)
      $response[] = $this->getDataBuilder()->createPart($part);

    $this->renderJson([
      'Parts' => $response
    ]);
  }
}
