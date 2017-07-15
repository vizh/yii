<?php

namespace api\controllers\raec;

use api\components\Action;
use api\components\builders\Builder;
use commission\models\User;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\ApiAction;
use Yii;

class CommissionUsersAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Raek",
     *     title="Список участников комиссии РАЭК",
     *     description="Список участников комиссии РАЭК.'",
     *     request=@Request(
     *          method="GET",
     *          url="/raec/commissionusers",
     *          params={
     *              @Param(title="CommissionId", mandatory="N", description="Идентификатор комиссий РАЭК.")
     *          },
     *          response=@Response( body="" )
     *     )
     * )
     */
    public function run()
    {
        $commissionId = Yii::app()->getRequest()->getParam('CommissionId');

        if (!is_array($commissionId)) {
            $commissionId = [intval($commissionId)];
        }
        $criteria = new \CDbCriteria();
        $criteria->addInCondition('"t"."CommissionId"', $commissionId);
        $criteria->addCondition('"t"."ExitTime" IS NULL OR "t"."ExitTime" > NOW()');

        $users = User::model()->findAll($criteria);

        $builder = new Builder(null); //todo: быстрое решение, исправить

        $result = [];
        foreach ($users as $user) {
            $builder->createUser($user->User, [
                Builder::USER_PERSON,
                Builder::USER_EMPLOYMENT
            ]);

            $result['Users'][] = $builder
                ->buildUserCommission($user->Role);
        }

        $this->setResult($result);
    }
}
