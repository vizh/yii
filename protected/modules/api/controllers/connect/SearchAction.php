<?php
namespace api\controllers\connect;

use user\models\User;

class RecommendationsAction extends \api\components\Action
{
    public function run()
    {
        $users = User::model()->findAllByPk([572793, 563843, 561735, 456]);
        $result = [];
        foreach ($users as $user) {
            $result[] = $this->getDataBuilder()->createUser($user);
        }
        $this->setResult($result);
        return;

        $participants = $this->getEvent()->Participants;

        $result = [];
        foreach ($participants as $participant) {
            $result[] = $this->getDataBuilder()->createUser($participant->User);
        }
        $this->setResult($result);
    }
}