<?php

use api\components\Controller;

class UserDocumentController extends Controller
{
    public function actions()
    {
        return [
            'get' => '\api\controllers\userdocument\GetAction',
            'set' => '\api\controllers\userdocument\SetAction',
            'types' => '\api\controllers\userdocument\TypesAction'
        ];
    }
}
