<?php

class PaperlessMaterialController extends \partner\components\Controller
{
    public function actions()
    {
        return [
            'index' => 'partner\controllers\paperlessmaterial\IndexAction',
            'create' => 'partner\controllers\paperlessmaterial\CreateAction',
            'edit' => 'partner\controllers\paperlessmaterial\EditAction',
            'delete' => 'partner\controllers\paperlessmaterial\DeleteAction',
        ];
    }
}