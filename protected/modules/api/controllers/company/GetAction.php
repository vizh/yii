<?php
namespace api\controllers\company;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Sample;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;

use api\components\Action;

class GetAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Company",
     *     title="Детально",
     *     description="Возвращает подробную информацию о компании. Так же в ответе будет список сотрудников компании (Employments).",
     *     samples={
     *          @Sample(lang="php", code="")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/company/get",
     *          body="",
     *          params={ @Param(title="CompanyId", description="Айди компании.", mandatory="Y")},
     *          response=@Response(body="'{$COMPANY}'")
     *      )
     * )
     */
    public function run()
    {
        $companyId = \Yii::app()->getRequest()->getParam('CompanyId', null);

        $company = \company\models\Company::model()->findByPk($companyId);
        if ($company === null) {
            throw new \api\components\Exception(241, [$companyId]);
        }
        $result = $this->getDataBuilder()->createCompany($company);

        if ($this->getAccount()->EventId !== null) {
            $criteria = new \CDbCriteria();
            $criteria->with = [
                'Employments' => ['together' => true],
                'Participants' => ['together' => true]
            ];
            $criteria->addCondition('"Employments"."EndYear" IS NULL AND "Employments"."Primary"');
            $criteria->addCondition('"Employments"."CompanyId" = :CompanyId');
            $criteria->addCondition('"Participants"."EventId" = :EventId');
            $criteria->params['EventId'] = $this->getEvent()->Id;
            $criteria->params['CompanyId'] = $company->Id;
            $criteria->order = '"t"."LastName", "t"."FirstName"';

            $users = \user\models\User::model()->byVisible(true)->findAll($criteria);
            $result->Employments = [];
            foreach ($users as $user) {
                $result->Employments[] = $this->getDataBuilder()->createUser($user);
            }
        }

        $this->setResult($result);
    }
}