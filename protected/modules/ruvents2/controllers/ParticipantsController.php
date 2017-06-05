<?php

namespace ruvents2\controllers;

use event\models\Role;
use ruvents2\components\Controller;
use ruvents2\components\data\builders\UserBuilder;
use ruvents2\components\Exception;
use ruvents2\models\forms\ParticipantRegisterForm;
use user\models\User;

class ParticipantsController extends Controller
{
    public function actions()
    {
        return [
            'list' => 'ruvents2\controllers\participants\ListAction', // роутится на GET:participants
            'create' => 'ruvents2\controllers\participants\CreateAction', // роутится на POST:participants
            'edit' => 'ruvents2\controllers\participants\EditAction', // роутится на PUT:participants/{runetId}
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

        $this->renderJson($result);
    }

    /**
     * Роутится на PUT:participants
     *
     * @internal int       Id    Идентификатор посетителя
     * @internal int|array Roles Роль, или список ролей попартийно, которые назначить посетителю
     *
     * @throws Exception
     */
    public function actionRegister()
    {
        $params = new ParticipantRegisterForm();

        $user = User::model()
            ->byRunetId($params->Id)
            ->find();

        if ($user === null) {
            throw new Exception(Exception::INVALID_PARTICIPANT_ID, $params->Id);
        }

        if ($params->Role) {
            $this->getEvent()->registerUser($user, Role::model()->findByPk($params->Role));
        }

        $this->renderJson(
            UserBuilder::create()
                ->setEvent($this->getEvent())
                ->setApiAccount($this->getApiAccount())
                ->setUser($user)
                ->build()
        );
    }

    /**
     * Роутится на DELETE:participants/{runetId}
     * @param int $runetId
     * @throws Exception
     */
    public function actionDelete($runetId)
    {
        $user = User::model()->byRunetId($runetId)->find();
        if ($user == null) {
            throw new Exception(Exception::INVALID_PARTICIPANT_ID, $runetId);
        }

        if (count($this->getEvent()->Parts) == 0) {
            $this->getEvent()->unregisterUser($user, 'Запрос через RUVENTS.');
        } else {
            $this->getEvent()->unregisterUserOnAllParts($user, 'Запрос через RUVENTS.');
        }

        $this->renderJson('');
    }
}