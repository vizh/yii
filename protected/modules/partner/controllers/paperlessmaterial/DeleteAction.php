<?php
namespace partner\controllers\paperlessmaterial;

use paperless\models\Material as MaterialModel;
use partner\components\Action;

class DeleteAction extends Action
{
    public function run($id)
    {
        $device = MaterialModel::model()->findByPk($id);
        if (!$device){
            throw new \CHttpException(404);
        }

        $device->delete();
    }
} 