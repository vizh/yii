<?php
namespace api\controllers\event;

use api\components\Action;
use event\models\section\Hall;

class HallsAction extends Action
{
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $model = Hall::model()->byEventId($this->getEvent()->Id);

        $fromUpdateTime = $request->getParam('FromUpdateTime');
        if ($fromUpdateTime !== null) {
            $model->byUpdateTime($fromUpdateTime);
        }

        $withDeleted = $request->getParam('WithDeleted', false);
        if (!$withDeleted) {
            $model->byDeleted(false);
        }

        $halls = $model->findAll(['order' => 't."Order"']);
        $result = [];
        foreach ($halls as $hall) {
            $result[] = $this->getDataBuilder()->createSectionHall($hall);
        }
        $this->setResult($result);
    }
} 