<?php

namespace api\controllers\connect;

use api\components\Action;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;
use nastradamus39\slate\annotations\ApiAction;

class PlacesAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Connect",
     *     title="Места",
     *     description="Места для встреч.",
     *     samples={
     *          @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}'
    '{{API_URL}}/connect/places'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/connect/places",
     *          params={},
     *          response=@Response(body="{'Success': true,'Places': ['{$PLACE}']}")
     *      )
     * )
     */
    public function run()
    {
        $result = [];
        foreach ($this->getEvent()->MeetingPlacesPublic as $place) {
            $result[] = $this->getAccount()->getDataBuilder()->createMeetingPlace($place);
        }
        $this->setResult(['Success' => true, 'Places' => $result]);
    }
}
