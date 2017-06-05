<?php

class OrderjuridicaltemplateController extends \application\components\controllers\AdminMainController
{
    public function actions()
    {
        return [
            'index' => '\pay\controllers\admin\orderjuridicaltemplate\IndexAction',
            'edit' => '\pay\controllers\admin\orderjuridicaltemplate\EditAction',
        ];
    }
} 