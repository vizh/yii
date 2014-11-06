<?php

class OrderController extends \application\components\controllers\AdminMainController
{
    public function actions()
    {
        return [
            'index' => '\pay\controllers\admin\order\IndexAction',
            'view' => '\pay\controllers\admin\order\ViewAction',
            'print' => '\pay\controllers\admin\order\PrintAction',
            'payers' => '\pay\controllers\admin\order\PayersAction',
            'writingout' => '\pay\controllers\admin\order\WritingOutAction',
        ];
    }

}