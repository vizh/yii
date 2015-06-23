<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 23.06.2015
 * Time: 16:03
 */

namespace api\controllers\iri;

use api\components\Action;
use api\components\Exception;
use iri\models\Role;
use user\models\User;
use iri\models\User as IriUser;

class UserExitAction extends Action
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
        if ($iriUser === null || !empty($iriUser->ExitTime)) {
            throw new Exception(1003, [$user->RunetId, $role->Id]);
        }

        $iriUser->ExitTime = date('Y-m-d H:i:s');
        $iriUser->save();
        $this->setResult(['success' => true]);
    }
} 