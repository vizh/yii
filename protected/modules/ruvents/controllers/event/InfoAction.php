<?php
namespace ruvents\controllers\event;

use ruvents\components\Action;
use ruvents\models\Operator;

class InfoAction extends Action
{
    public function run()
    {
        $this->renderJson([
            'Event' => $this->getEvent(),
            'Settings' => $this->getEvent()->RuventsSettings,
            'Operators' => Operator::model()
                ->byEventId($this->getEvent()->Id)
                ->findAll()
        ]);
    }
}
