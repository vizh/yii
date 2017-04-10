<?php

class PaperlessDeviceController extends \partner\components\Controller
{
    public function actions()
    {
        return [
            'index' => 'partner\controllers\paperlessdevice\IndexAction',
            'create' => 'partner\controllers\paperlessdevice\CreateAction',
            'edit' => 'partner\controllers\paperlessdevice\EditAction',
            'delete' => 'partner\controllers\paperlessdevice\DeleteAction',
        ];
    }
}