<?php
namespace api\controllers\iri;

use api\components\Action;
use api\components\Exception;
use application\models\ProfessionalInterest;
use iri\models\Role;
use user\models\User;
use iri\models\User as IriUser;

class ExpertDeleteAction extends Action
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
        if ($iriUser === null || !empty($iriUser->ExitTime)) {
            throw new Exception(1003, [$user->RunetId, $role->Id]);
        }

        $iriUser->ExitTime = date('Y-m-d H:i:s');
        $iriUser->save();
        $this->setResult(['success' => true]);
    }
} 