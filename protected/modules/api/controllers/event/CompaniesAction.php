<?php

namespace api\controllers\event;

use api\components\Action;
use company\models\Company;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response as ApiResponse;
use nastradamus39\slate\annotations\Action\Sample;
use nastradamus39\slate\annotations\ApiAction;
use Yii;

class CompaniesAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Event",
     *     title="Компании",
     *     description="Выбираются все компании, сотрудники которых учавствуют в мероприятии.",
     *     samples={
     *          @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}'
    '{{API_URL}}/event/companies'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/event/сompanies",
     *          params={},
     *          response=@ApiResponse(body="{'77529': '{$COMPANY}'}")
     *      )
     * )
     */
    public function run()
    {
        $command = Yii::app()->getDb()->createCommand();
        $command->select = '"count"("UserEmployment"."Id") as "CountParticipants", "UserEmployment"."CompanyId"';
        $command->from('UserEmployment');
        $command->leftJoin(
            'EventParticipant',
            '"UserEmployment"."UserId" = "EventParticipant"."UserId"'
        );
        $command->leftJoin(
            'User',
            '"UserEmployment"."UserId" = "User"."Id"'
        );
        $command->andWhere(
            '"EventParticipant"."EventId" = :EventId AND "UserEmployment"."Primary" AND "UserEmployment"."EndYear" IS NULL AND "User"."Visible"',
            ['EventId' => $this->getEvent()->Id]
        );
        $command->group('CompanyId');
        $command->limit(Yii::app()->params['ApiMaxTop']);
        $command->order('CountParticipants DESC');

        $commandResult = $command->queryAll();
        $result = [];
        $counts = [];
        foreach ($commandResult as $row) {
            $counts[$row['CompanyId']] = $row['CountParticipants'];
            $result[$row['CompanyId']] = null;
        }

        $companiesId = array_keys($counts);

        $criteria = new \CDbCriteria();
        $criteria->addInCondition('"t"."Id"', $companiesId);
        $companies = Company::model()->findAll($criteria);

        foreach ($companies as $company) {
            $resultCompany = $this->getDataBuilder()->createCompany($company);
            $resultCompany->CountParticipants = $counts[$company->Id];
            $result[$company->Id] = $resultCompany;
        }

        $this->setResult($result);
    }
}
