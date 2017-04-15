<?php
namespace partner\controllers\paperlessdevice;

use application\models\paperless\Device as DeviceModel;
use partner\components\Action;

class DeleteAction extends Action
{
    public function run($id)
    {
        $device = DeviceModel::model()->findByPk($id);
        if (!$device){
            throw new \CHttpException(404);
        }

        $device->delete();
    }
}