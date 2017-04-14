<?php

namespace api\controllers\paperlessmaterial;

use api\components\Exception;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;
use nastradamus39\slate\annotations\ApiAction;
use paperless\models\Device;
use paperless\models\Event;

class EventAction extends \api\components\Action
{
    /**
     * @ApiAction(
     *     controller="Paperlessmaterial",
     *     title="Список материалов",
     *     description="Список партнёрских материалов Paperless.",
     *     samples={
     *          @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}' '{{API_URL}}/paperless/materials/search'")
     *     },
     *     request=@Request(
     *          method="POST",
     *          url="/paperless/materials/search",
     *          body="",
     *          params={
     *          },
     *          response=@Response(body="['{$PAPERLESSMATERIAL}']")
     *     )
     *
     * )
     */
    public function run()
    {
        $device = Device::model()
            ->byEventId($this->getEvent()->Id)
            ->byDeviceId($this->getRequestParam('DeviceId'))
            ->find();

        if ($device === null) {
            $device = new Device();
            $device->DeviceId = $this->getRequestParam('DeviceId');
            $device->EventId = $this->getEvent()->Id;
            $device->Name = 'Безымянное новое устройство';
            $device->Type = (int)$this->getRequestParam('DeviceType', 2);

            if (false === $device->save(true)) {
                throw new Exception($device);
            }
        }

        $event = new Event();


        $this->getRequestParam('DeviceId');
        $this->getRequestParam('BadgeId');

        $this->setSuccessResult();
    }
}