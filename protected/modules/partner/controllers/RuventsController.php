<?php

use \partner\components\Controller;

class RuventsController extends Controller
{
    public function actions()
    {
        return [
            'index' => '\partner\controllers\ruvents\IndexAction',
            'operator' => '\partner\controllers\ruvents\OperatorAction',
            'mobile' => '\partner\controllers\ruvents\MobileAction',
            'csvinfo' => '\partner\controllers\ruvents\CsvinfoAction',
            'userlog' => '\partner\controllers\ruvents\UserlogAction',
            'print' => '\partner\controllers\ruvents\PrintAction'
        ];
    }
}