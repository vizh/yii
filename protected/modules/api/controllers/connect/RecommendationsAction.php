<?php
namespace api\controllers\connect;

use api\components\Exception;
use user\models\User;

class RecommendationsAction extends \api\components\Action
{
    public function run()
    {
        $runetId = \Yii::app()->getRequest()->getParam('RunetId', null);
        $user = \user\models\User::model()->byRunetId($runetId)->find();
        if ($user === null) {
            throw new Exception(202, [$runetId]);
        }

        $users = User::model()->findAllByPk([572793, 563843, 561735, 456]);
        $result = [];
        foreach ($users as $user) {
            $result[] = $this->getDataBuilder()->createUser($user);
        }
        $this->setResult(['Success' => true, 'Recommendations' => $result]);
        return;

        $participants = $this->getEvent()->Participants;

        $result = [];
        foreach ($participants as $participant) {
            $result[] = $this->getDataBuilder()->createUser($participant->User);
        }
        $this->setResult($result);
    }
}