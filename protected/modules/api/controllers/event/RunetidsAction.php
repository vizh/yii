<?php

namespace api\controllers\event;

use api\components\Action;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;
use nastradamus39\slate\annotations\ApiAction;
use Yii;

class RunetidsAction extends Action
{

    /**
     * @ApiAction(
     *     controller="Event",
     *     title="RunetId участников мероприятия",
     *     description="Список RunetId,Ролей участников мерроприятия.",
     *     samples={
     *          @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}'
    '{{API_URL}}/event/runetids'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/event/runetids",
     *          response=@Response(body="{'308': 1,'311': 24,'314': 24}"))
     * )
     */
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
        foreach ($participationData as $row) {
            $result[$row['RunetId']] = $row['RoleId'];
        }

        $this->setResult($result);
    }
}
