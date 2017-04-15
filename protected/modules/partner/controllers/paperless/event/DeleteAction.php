<?php

namespace partner\controllers\paperless\event;

use application\components\Exception;
use application\models\paperless\Event as EventModel;
use partner\components\Action;

class DeleteAction extends Action
{
    public function run($id)
    {
        $device = EventModel::model()
            ->findByPk($id);

        if ($device === null) {
            throw new Exception(404);
        }

        $device->delete();
    }
}