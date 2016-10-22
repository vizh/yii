<?php
namespace api\controllers\event;

class InfoAction extends \api\components\Action
{
    public function run()
    {
        $this->getDataBuilder()->createEvent($this->getEvent());
        $this->getDataBuilder()->buildEventPlace($this->getEvent());
        $this->getDataBuilder()->buildEventMenu($this->getEvent());
        $this->getDataBuilder()->buildEventStatistics($this->getEvent());
        $result = $this->getDataBuilder()->buildEventFullInfo($this->getEvent());

        $this->setResult($result);
    }
}