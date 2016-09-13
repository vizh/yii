<?php
namespace api\controllers\connect;

class RecommendationsAction extends \api\components\Action
{
    public function run()
    {
        $participants = $this->getEvent()->Participants;

        $result = [];
        foreach ($participants as $participant) {
            $result[] = $this->getDataBuilder()->createUser($participant->User);
        }
        $this->setResult($result);
    }
}