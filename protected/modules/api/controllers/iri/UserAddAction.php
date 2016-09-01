<?php
namespace api\controllers\iri;

use api\components\Action;
use api\components\Exception;
use application\models\ProfessionalInterest;
use iri\models\Role;
use user\models\User;
use iri\models\User as IriUser;

class UserAddAction extends Action
{
    public function run()
    {
        $request = \Yii::app()->getRequest();

        $runetId = $request->getParam('RunetId');
        $roleId = $request->getParam('RoleId');
        $type = $request->getParam('Type');
        $profInterestId = $request->getParam('ProfessionalInterestId');

        $user = User::model()->byRunetId($runetId)->find();
        if (empty($user)) {
            throw new Exception(202, [$runetId]);
        }

        $role = Role::model()->findByPk($roleId);
        if (empty($role)) {
            throw new Exception(1001, [$roleId]);
        }

        if (empty($type)) {
            throw new Exception(1004);
        }

        $profInterest = null;
        if (!empty($profInterestId)) {
            $profInterest = ProfessionalInterest::model()->findByPk($profInterestId);
            if (empty($profInterest)) {
                throw new Exception(901, [$profInterestId]);
            }
        }

        $iriUser = IriUser::model()
            ->byUserId($user->Id)
            ->byType($type)
            ->byRoleId($role->Id)
            ->byProfessionalInterestId($profInterest !== null ? $profInterest->Id : null)
            ->find();

        if ($iriUser === null) {
            $iriUser = new IriUser();
            $iriUser->UserId = $user->Id;
            $iriUser->RoleId = $role->Id;
            if ($profInterest !== null) {
                $iriUser->ProfessionalInterestId = $profInterest->Id;
            }
            $iriUser->Type = $type;
        } else {
            if (!empty($iriUser->ExitTime)) {
                $iriUser->ExitTime = null;
            } else {
                throw new Exception(1002, [$user->RunetId, $role->Id]);
            }
        }
        $iriUser->save();
        $this->setSuccessResult();
    }
}