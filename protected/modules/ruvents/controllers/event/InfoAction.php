<?php
namespace ruvents\controllers\event;

use \ruvents\components\Action;

class InfoAction extends Action
{
    public function run()
    {
        $this->renderJson([
            'Event' => $this->getDataBuilder()->createEvent()
        ]);
    }
}
