<?php

class AccountController extends \application\components\controllers\AdminMainController
{
    public function actions()
    {
        return [
            'edit' => '\pay\controllers\admin\account\EditAction',
            'index' => '\pay\controllers\admin\account\IndexAction',
            'ordertemplate' => '\pay\controllers\admin\account\OrderTemplateAction'
        ];
    }
}
