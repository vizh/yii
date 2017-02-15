<?php
namespace api\controllers\connect;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Param;

class PlacesAction extends \api\components\Action
{

    /**
     * @ApiAction(
     *     controller="Connect",
     *     title="Места",
     *     description="Места для встреч.",
     *     request=@Request(
     *          method="GET",
     *          url="/connect/places",
     *          body="",
     *          params={},
     *          response=@Response(body="{'Success': true,'Places': ['Объект PLACE']}")
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