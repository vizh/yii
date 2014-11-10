<?php

class UserController extends \ruvents\components\Controller
{

    public function actions()
    {
        return [
            'create' => 'ruvents\controllers\user\CreateAction',
            'edit' => 'ruvents\controllers\user\EditAction',
            'search' => 'ruvents\controllers\user\SearchAction',
            'auth' => 'ruvents\controllers\user\AuthAction'
        ];
    }
}
