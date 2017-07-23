<?php

namespace api\controllers\raec;

use api\components\Action;
use api\components\builders\Builder;
use raec\models\Commission;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\ApiAction;
use Yii;

class CommissionListAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Raek",
     *     title="Список комиссий РАЭК",
     *     description="Список комиссий РАЭК.'",
     *     request=@Request(
     *          method="GET",
     *          url="/raec/commissionlist",
     *          params={
     *              @Param(title="CommissionIdList", mandatory="N", description="Идентификаторы комиссий РАЭК."),
     *              @Param(title="Purpose Id", mandatory="Y", description="Идентификатор цели посещения мероприятия.")
     *          },
     *          response=@Response( body="{'Commissions':[]}" )
     *     )
     * )
     */
    public function run()
    {
        $commissionIdList = Yii::app()->getRequest()->getParam('CommissionIdList');

        $criteria = new \CDbCriteria();
        $criteria->addCondition('NOT "t"."Deleted"');
        if (!empty($commissionIdList)) {
            $criteria->addInCondition('"t"."Id"', $commissionIdList);
        }

        $commisions = Commission::model()->findAll($criteria);

        $builder = new Builder(null); //todo: быстрое решение, исправить

        $result = [];
        foreach ($commisions as $commision) {
            $builder->createCommision($commision);
            $result['Commissions'][] = $builder->buildComissionProjects($commision);
        }

        $this->setResult($result);
    }
}
