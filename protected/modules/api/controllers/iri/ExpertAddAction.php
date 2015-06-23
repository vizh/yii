<?php
namespace api\controllers\iri;

use api\components\Action;
use api\components\Exception;
use application\models\ProfessionalInterest;
use iri\models\Role;
use user\models\User;
use iri\models\User as IriUser;

class ExpertAddAction extends Action
{
    public function run()
    {
        $request = \Yii::app()->getRequest();

        $runetId = $request->getParam('RunetId');
        $roleId = $request->getParam('RoleId');
        $profInterestId = $request->getParam('ProfessionalInterestId');

        $user = User::model()->byRunetId($runetId)->find();
        if (empty($user)) {
            throw new Exception(202, [$runetId]);
        }

        $role = Role::model()->findByPk($roleId);
        if (empty($role)) {
            throw new Exception(1001, [$roleId]);
        }


        $criteria = new \CDbCriteria();

        if (!empty($profInterestId)) {
            $profInterest = ProfessionalInterest::model()->findByPk($profInterestId);
            if (empty($profInterest)) {
                throw new Exception(901, [$profInterestId]);
            }
            $criteria->addCondition('"t"."ProfessionalInterestId" = :ProfessionalInterestId');
            $criteria->params['ProfessionalInterestId'] = $profInterest->Id;
        } else {
            $criteria->addCondition('"t"."ProfessionalInterestId" IS NULL');
        }

        $iriUser = IriUser::model()->byUserId($user->Id)->byRoleId($role->Id)->find($criteria);
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
            $iriUser->ProfessionalInterestId = !empty($profInterestId) ? $profInterestId : null;
        }
        $iriUser->save();
        $this->setResult(['Success' => true]);
    }
} 