<?php

namespace partner\controllers\paperless\material;

use application\components\Exception;
use application\models\paperless\Material as MaterialModel;
use partner\components\Action;

class DeleteAction extends Action
{
    public function run($id)
    {
        $device = MaterialModel::model()
            ->findByPk($id);

        if ($device === null) {
            throw new Exception(404);
        }

        $device->delete();
    }
}