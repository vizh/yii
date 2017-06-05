<?php
namespace ruvents\controllers\visit;

use event\models\section\Hall;

class HallsAction extends \ruvents\components\Action
{
    public function run()
    {
        $halls = Hall::model()
            ->byEventId($this->getEvent()->Id)
            ->byDeleted(false)
            ->findAll();

        $result = [];
        foreach ($halls as $hall) {
            $result[] = $this->getDataBuilder()->createSectionHall($hall);
        }

        $this->renderJson($result);
    }
}