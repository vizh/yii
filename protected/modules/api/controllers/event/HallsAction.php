<?php
namespace api\controllers\event;

use api\components\Action;
use event\models\section\Hall;

class HallsAction extends Action
{
    public function run()
    {
        $fromUpdateTime = \Yii::app()->getRequest()->getParam('FromUpdateTime', null);
        $criteria = new \CDbCriteria();
        $criteria->order = 't."Order"';
        if ($fromUpdateTime !== null) {
            $criteria->condition = 't."UpdateTime" > :UpdateTime';
            $criteria->params = ['UpdateTime' => $fromUpdateTime];
        }

        $halls = Hall::model()->byEventId($this->getEvent()->Id)->findAll($criteria);
        $result = [];
        foreach ($halls as $hall) {
            $result[] = $this->getDataBuilder()->createSectionHall($hall);
        }
        $this->setResult($result);
    }
} 