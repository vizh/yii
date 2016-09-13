<?php
namespace api\controllers\connect;

use api\components\Exception;

class RecommendationsAction extends \api\components\Action
{
    public function run()
    {
        $runetId = \Yii::app()->getRequest()->getParam('RunetId', null);
        $user = \user\models\User::model()->byRunetId($runetId)->find();
        if ($user === null) {
            throw new Exception(202, [$runetId]);
        }

        $participants = $this->getEvent()->Participants;

        $result = [];
        foreach ($participants as $participant) {
            $result[] = $this->getDataBuilder()->createUser($participant->User);
        }
        $this->setResult($result);
    }
}