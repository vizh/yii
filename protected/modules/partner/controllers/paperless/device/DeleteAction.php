<?php

namespace partner\controllers\paperless\device;

use application\components\Exception;
use application\models\paperless\Device as DeviceModel;
use partner\components\Action;

class DeleteAction extends Action
{
    public function run($id)
    {
        $device = DeviceModel::model()
            ->findByPk($id);

        if ($device === null) {
            throw new Exception(404);
        }

        $device->delete();
    }
}