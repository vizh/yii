<?php

class UserController extends \ruvents\components\Controller
{
    public function actions()
    {
        return [
            'create' => 'ruvents\controllers\user\CreateAction',
            'edit' => 'ruvents\controllers\user\EditAction',
            'editAttribute' => 'ruvents\controllers\user\EditAttributeAction',
            'search' => 'ruvents\controllers\user\SearchAction',
            'auth' => 'ruvents\controllers\user\AuthAction',
            'visit' => 'ruvents\controllers\user\VisitAction',
            'photo' => 'ruvents\controllers\user\PhotoAction'
        ];
    }
}
