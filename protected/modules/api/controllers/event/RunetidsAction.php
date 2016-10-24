<?php

namespace api\controllers\event;

use api\components\Action;
use Yii;

class RunetidsAction extends Action
{
    public function run()
    {
        $participationData = Yii::app()->getDb()
            ->createCommand('
                SELECT
                  "User"."RunetId",
                  "EventParticipant"."RoleId"
                FROM "EventParticipant"
                  LEFT JOIN "User" ON "User"."Id" = "EventParticipant"."UserId"
                WHERE "EventId" = :EventId;
            ')
            ->bindParam(':EventId', $this->getEvent()->Id)
            ->queryAll();

        $result = [];
        foreach ($participationData as $row)
            $result[$row['RunetId']] = $row['RoleId'];

        $this->setResult($result);
    }
}
