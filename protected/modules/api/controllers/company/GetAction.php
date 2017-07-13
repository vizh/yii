<?php
namespace api\controllers\company;

use api\components\Action;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;
use nastradamus39\slate\annotations\ApiAction;
use user\models\User;

class GetAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Company",
     *     title="Детальная информация",
     *     description="Возвращает подробную информацию о компании. Так же в ответе будет список сотрудников компании (Employments).",
     *     samples={
     *          @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}' '{{API_URL}}/company/get?CompanyId=77529'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/company/get",
     *          body="",
     *          params={
     *              @Param(title="CompanyId", description="Айди компании.", mandatory="Y")
     *          },
     *          response=@Response(body="'{$COMPANY}'")
     *      )
     * )
     */
    public function run()
    {
        $result = $this
            ->getDataBuilder()
            ->createCompany($this->getRequestedCompany());

        $criteria = new \CDbCriteria();
        $criteria->with = [
            'Employments' => ['together' => true],
            'Participants' => ['together' => true]
        ];
        $criteria->addCondition('"Employments"."EndYear" IS NULL AND "Employments"."Primary"');
        $criteria->addCondition('"Employments"."CompanyId" = :CompanyId');
        $criteria->addCondition('"Participants"."EventId" = :EventId');
        $criteria->params['EventId'] = $this->getEvent()->Id;
        $criteria->params['CompanyId'] = $this->getRequestedCompany()->Id;
        $criteria->order = '"t"."LastName", "t"."FirstName"';

        $users = User::model()
            ->byVisible()
            ->findAll($criteria);

        $result->Employments = [];
        foreach ($users as $user) {
            $result->Employments[] = $this->getDataBuilder()->createUser($user);
        }

        $this->setResult($result);
    }
}