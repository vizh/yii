<?php
namespace ruvents2\controllers;

use ruvents2\components\Controller;

class ParticipantsController extends Controller
{
    public function actions()
    {
        return [
            'list' => 'ruvents2\controllers\participants\ListAction' // роутится на GET:participants
        ];
    }

    public function actionFields()
    {
        $result = [];
        $result['LastName'] = ['type' => 'string', 'required' => true, 'hasLocales' => true];
        $result['FirstName'] = ['type' => 'string', 'required' => true, 'hasLocales' => true];
        $result['FatherName'] = ['type' => 'string', 'required' => false, 'hasLocales' => true];
        $result['Company'] = ['type' => 'string', 'required' => false, 'hasLocales' => true];

        $result['Position'] = ['type' => 'string', 'required' => false, 'hasLocales' => false];
        $result['Email'] = ['type' => 'string', 'required' => true, 'hasLocales' => false];
        $result['Phone'] = ['type' => 'string', 'required' => false, 'hasLocales' => false];
        $result['Photo'] = ['type' => 'string', 'required' => false, 'hasLocales' => false];
        $result['ExternalId'] = ['type' => 'string', 'required' => false, 'hasLocales' => false];

        $this->renderJson($result);
    }
}