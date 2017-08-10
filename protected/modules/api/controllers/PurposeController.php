<?php

use api\components\Controller;

class PurposeController extends Controller
{
    public function actions()
    {
        return [
            'add' => '\api\controllers\purpose\AddAction',
            'delete' => '\api\controllers\purpose\DeleteAction'
        ];
    }
}
