<?php


class BadgeController extends ruvents\components\Controller
{

    public function actions()
    {
        return [
            'list' => 'ruvents\controllers\badge\ListAction',
            'create' => 'ruvents\controllers\badge\CreateAction'
        ];
    }
}