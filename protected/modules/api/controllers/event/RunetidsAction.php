<?php

namespace api\controllers\event;

use api\components\Action;
use Yii;

class RunetidsAction extends Action
{
    public function run()
    {
        $command = Yii::app()->getDb()->createCommand()
            ->select('User.RunetId')
            ->from('User')
            ->join('EventParticipant', '"EventParticipant"."UserId" = "User"."Id"')
            ->where('"EventParticipant"."EventId" = :eventId', [':eventId' => $this->getEvent()->Id]);

        $result = [];
        $result['RunetIds'] = $command->queryColumn();

        $this->setResult($result);
    }
}
