<?php

use ruvents\components\Exception;
use ruvents\models\Operator;

class AuthController extends ruvents\components\Controller
{
    public function actionLogin($Login, $Password, $MasterPassword)
    {
        $operator = Operator::model()->findByAttributes([
            'Login' => $Login,
            'Password' => Operator::generatePasswordHash($Password)
        ]);

        if ($operator === null)
            throw new Exception(101);

        $master = Operator::model()->findByAttributes([
            'Password' => Operator::generatePasswordHash($MasterPassword),
            'EventId' => $operator->EventId,
            'Role' => Operator::RoleAdmin
        ]);

        if ($master === null)
            throw new Exception(102);

        $operator->LastLoginTime = date('Y-m-d H:i:s');
        $operator->save();

        $this->renderJson([
            'OperatorId' => $operator->Id,
            'Hash' => $operator->getAuthHash(),
            'EventId' => $operator->EventId
        ]);
    }
}