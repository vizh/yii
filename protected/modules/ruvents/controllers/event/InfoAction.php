<?php
namespace ruvents\controllers\event;

class InfoAction extends \ruvents\components\Action
{
  public function run()
  {
    $this->renderJson([
      'Event' => $this->getDataBuilder()->createEvent()
    ]);
  }
}
