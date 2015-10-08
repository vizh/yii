<?php
namespace ruvents\controllers\event;

use \ruvents\components\Action;

class InfoAction extends Action
{
    public function run()
    {
        $this->getDataBuilder()->createEvent();
        $event = $this->getDataBuilder()->buildEventSettings();
        $this->renderJson(['Event' => $event]);
    }
}
