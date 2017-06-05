<?php

use partner\components\Controller;

class OrderController extends Controller
{
    public function actions()
    {
        return [
            'index' => '\partner\controllers\order\IndexAction',
            'create' => '\partner\controllers\order\CreateAction',
            'view' => '\partner\controllers\order\ViewAction',
            'edit' => '\partner\controllers\order\EditAction',
            'delete' => '\partner\controllers\order\DeleteAction',
            'activate' => '\partner\controllers\order\ActivateAction'
        ];
    }
}