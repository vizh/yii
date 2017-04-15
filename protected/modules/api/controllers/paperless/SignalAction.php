<?php

namespace api\controllers\paperless;

use api\components\Exception;
use application\models\paperless\Event;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;
use nastradamus39\slate\annotations\ApiAction;
use application\models\paperless\Device;
use application\models\paperless\DeviceSignal;

class SignalAction extends \api\components\Action
{
    /**
     * @ApiAction(
     *     controller="Paperlessmaterial",
     *     title="Отметка о прикладывания бейджа к устройству",
     *     description="Отметка о прикладывания бейджа к устройству.",
     *     samples={
     *          @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}' '{{API_URL}}/paperless/materials/search'")
     *     },
     *     request=@Request(
     *          method="POST",
     *          url="/paperless/materials/search",
     *          body="",
     *          params={
     *              @Param(title="BadgeUID", mandatory="Y", description="Уникальный UID приложенного RFID-бейджа.")
     *              @Param(title="BadgeTime", mandatory="Y", description="Время прикладывания RFID-бейджа.")
     *              @Param(title="DeviceNumber", mandatory="Y", description="Номер устройства.")
     *              @Param(title="Process", mandatory="N", description="Если передано true, то сигнал сразу же обрабатывается.")
     *          },
     *          response=@Response(body="['{$PAPERLESSMATERIAL}']")
     *     )
     * )
     */
    public function run()
    {
        $device = Device::model()
            ->byEventId($this->getEvent()->Id)
            ->byDeviceNumber($this->getRequestParam('DeviceNumber'))
            ->find();

        // Обнаружено новое устройство
        if ($device === null) {
            $device = new Device();
            $device->DeviceNumber = $this->getRequestParam('DeviceNumber');
            $device->EventId = $this->getEvent()->Id;
            $device->Name = 'Новое устройство';
            $device->Type = (int)$this->getRequestParam('DeviceType', 2);

            if (false === $device->save(true)) {
                throw new Exception($device);
            }
        }

        $signal = new DeviceSignal();
        $signal->EventId = $this->getEvent()->Id;
        $signal->DeviceNumber = $device->Id;
        $signal->BadgeUID = (int)$this->getRequestParam('BadgeUID');
        $signal->BadgeTime = $this->getRequestParam('BadgeTime');

        if (false === $signal->save(true)) {
            throw new Exception($signal);
        }

        // Необходимо сразу обработать событие?
        if ($device->Active && $this->getRequestParamBool('Process', false)) {
            $events = Event::model()
                ->byEventId($this->getEvent()->Id)
                ->byActive()
                ->with('DeviceLinks', 'RoleLinks')
                ->findAll();

            foreach ($events as $event) {
                if (false === $event->process($signal)) {
                    throw new Exception($signal);
                }
            }
        }

        $this->setSuccessResult();
    }
}