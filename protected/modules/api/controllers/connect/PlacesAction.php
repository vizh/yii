<?php
namespace api\controllers\connect;

class PlacesAction extends \api\components\Action
{
    public function run()
    {
        $result = [];
        foreach ($this->getEvent()->MeetingPlacesPublic as $place) {
            $result[] = $this->getAccount()->getDataBuilder()->createMeetingPlace($place);
        }
        $this->setResult(['Success' => true, 'Places' => $result]);
    }
}