<?php
namespace api\controllers\iri;

use api\components\Action;
use api\components\Exception;
use iri\models\Role;
use user\models\User;
use iri\models\User as IriUser;

class UserJoinAction extends Action
{
    public function run()
    {
        $request = \Yii::app()->getRequest();

        $runetId = $request->getParam('RunetId');
        $roleId = $request->getParam('RoleId');

        $user = User::model()->byRunetId($runetId)->find();
        if (empty($user)) {
            throw new Exception(202, [$runetId]);
        }

        $role = Role::model()->findByPk($roleId);
        if (empty($role)) {
            throw new Exception(1001, [$roleId]);
        }

        $iriUser = IriUser::model()->byUserId($user->Id)->byRoleId($role->Id)->find();
        if ($iriUser !== null) {
            if (!empty($iriUser->ExitTime)) {
                $iriUser->ExitTime = null;
            } else {
                throw new Exception(1002, [$user->RunetId, $role->Id]);
            }
        } else {
            $iriUser = new IriUser();
            $iriUser->UserId = $user->Id;
            $iriUser->RoleId = $role->Id;
        }
        $iriUser->save();
        $this->setResult(['Success' => true]);
    }
} 