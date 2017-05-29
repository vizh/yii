<?php

namespace partner\controllers\paperless\device;

use application\components\Exception;
use application\models\paperless\Device as DeviceModel;
use application\models\paperless\DeviceSignal;
use partner\components\Action;
use partner\models\forms\paperless\Device;
use Yii;

class EditAction extends Action
{
    public function run($id = null)
    {
        $device = $id === null
            ? new DeviceModel()
            : DeviceModel::model()->findByPk($id);

        if ($device === null) {
            throw new Exception(404);
        }

        $form = new Device($this->getEvent(), $device);

        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $form->fillFromPost();
            $model = $device->getIsNewRecord()
                ? $form->createActiveRecord()
                : $form->updateActiveRecord();

            if ($model !== null && Yii::app()->getRequest()->getParam('apply') === null) {
                $this->getController()->redirect(['deviceIndex']);
            }
        }

        $signals = DeviceSignal::model()
            ->byDeviceNumber($device->Id)
            ->with(['Participant' => ['with' => ['User' => ['with' => ['Employments', 'Settings', 'LinkPhones']]]]])
            ->orderBy(['"t"."Id"' => SORT_DESC])
            ->findAll();

        $this->getController()->render('device/edit', [
            'form' => $form,
            'device' => $device,
            'signals' => $signals
        ]);
    }
}