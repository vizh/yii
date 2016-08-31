<?php
namespace api\controllers\ms;

use api\components\Action;
use api\components\Exception;
use api\models\ExternalUser;
use event\models\Role;

class UpdateRegistrationAction extends Action
{
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $externalId = $request->getParam('ExternalId');
        $roleId = $request->getParam('RoleId');
        $externalUser = ExternalUser::model()->byExternalId($externalId)->byAccountId($this->getAccount()->Id)->find();
        if ($externalUser === null) {
            throw new Exception(3003, array($externalId));
        }
        $role = Role::model()->findByPk($roleId);
        if ($role === null) {
            throw new Exception(3005);
        }
        $this->getEvent()->skipOnRegister = true;
        try {
            if (empty($this->getEvent()->Parts)) {
                $this->getEvent()->registerUser($externalUser->User, $role);
            } else {
                $this->getEvent()->registerUserOnAllParts($externalUser->User, $role);
            }
        } catch (\Exception $e) {
            throw new Exception(100, [$e->getMessage()]);
        }
        $this->setSuccessResult();
    }
}