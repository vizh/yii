<?php
namespace partner\controllers\paperlessevent;

use paperless\models\Event as EventModel;
use partner\components\Action;

class DeleteAction extends Action
{
    public function run($id)
    {
        $device = EventModel::model()->findByPk($id);
        if (!$device){
            throw new \CHttpException(404);
        }

        $device->delete();
    }
} 