<?php

class ImportController extends \application\components\controllers\AdminMainController
{
    public function actions()
    {
        return [
            'index' => '\pay\controllers\admin\import\IndexAction',
            'result' => '\pay\controllers\admin\import\ResultAction',
            'pay' => '\pay\controllers\admin\import\PayAction',
            'edit' => '\pay\controllers\admin\import\EditAction',
        ];
    }

}