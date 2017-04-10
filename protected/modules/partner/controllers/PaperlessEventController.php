<?php

class PaperlessEventController extends \partner\components\Controller
{
    public function actions()
    {
        return [
            'index' => 'partner\controllers\paperlessevent\IndexAction',
            'create' => 'partner\controllers\paperlessevent\CreateAction',
            'edit' => 'partner\controllers\paperlessevent\EditAction',
            'delete' => 'partner\controllers\paperlessevent\DeleteAction',
        ];
    }
}