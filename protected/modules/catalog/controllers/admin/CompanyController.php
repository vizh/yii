<?php

class CompanyController extends \application\components\controllers\AdminMainController
{
    public function actions()
    {
        return [
            'index' => 'catalog\controllers\admin\company\IndexAction',
            'edit' => 'catalog\controllers\admin\company\EditAction'
        ];
    }
}
