<?php
namespace api\controllers\raec;

use api\components\builders\Builder;

class CommissionUsersAction extends \api\components\Action
{
    public function run()
    {
        $commissionId = \Yii::app()->getRequest()->getParam('CommissionId');

        if (!is_array($commissionId)) {
            $commissionId = [intval($commissionId)];
        }
        $criteria = new \CDbCriteria();
        $criteria->addInCondition('"t"."CommissionId"', $commissionId);
        $criteria->addCondition('"t"."ExitTime" IS NULL OR "t"."ExitTime" > NOW()');
        /** @var \commission\models\User $users */
        $users = \commission\models\User::model()->findAll($criteria);

        $builder = new \api\components\builders\Builder(null); //todo: быстрое решение, исправить

        $result = [];
        foreach ($users as $user) {
            $builder->createUser($user->User, [
                Builder::USER_EMPLOYMENT
            ]);

            $result['Users'][] = $builder
                ->buildUserCommission($user->User->Role);
        }

        $this->setResult($result);
    }
}
