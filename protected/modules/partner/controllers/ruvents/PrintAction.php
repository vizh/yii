<?php
namespace partner\controllers\ruvents;

use partner\components\Action;
use ruvents\models\Operator;

class PrintAction extends Action
{
    public function run()
    {
        $event = $this->getEvent();
        $operators = Operator::model()->byEventId($event->Id)->findAll(['order' => '"Role" DESC, "Id"']);
        $this->getController()->render('print', [
            'operators' => $operators,
            'account' => $this->getRuventsAccount()
        ]);
    }
} 