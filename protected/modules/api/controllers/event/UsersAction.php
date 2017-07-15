<?php

namespace api\controllers\event;

use api\components\Action;
use CDbCriteria;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;
use nastradamus39\slate\annotations\ApiAction;
use user\models\User;
use Yii;

class UsersAction extends Action
{

    /**
     * @ApiAction(
     *     controller="Event",
     *     title="Участники",
     *     description="Список участников мероприятия с заданной ролью.",
     *     samples={
     *          @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}' '{{API_URL}}/event/users?RoleId=1'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/event/users",
     *          params={
     *              @Param(title="RoleId", mandatory="Y", description="Массив идентификаторов ролей")
     *          },
     *          response=@Response(body="{'Users': ['{$USER}'],'TotalCount':1}")
     *     )
     * )
     */
    public function run()
    {
        $request = Yii::app()->getRequest();
        $maxResults = (int)$request->getParam('MaxResults', $this->getMaxResults());
        $maxResults = min($maxResults, $this->getMaxResults());
        $pageToken = $request->getParam('PageToken', null);
        $roles = $request->getParam('RoleId');

        $nextUpdateTime = date('Y-m-d H:i:s');
        $fromUpdateTime = $this->hasRequestParam('FromUpdateTime')
            ? $this->getRequestedDate('FromUpdateTime')
            : null;

        $command = Yii::app()->getDb()->createCommand()
            ->select('EventParticipant.UserId')->from('EventParticipant')
            ->where('"EventParticipant"."EventId" = '.$this->getEvent()->Id);

        if (!empty($roles)) {
            $command->andWhere(['in', 'EventParticipant.RoleId', $roles]);
        }

        $criteria = new CDbCriteria();

        if ($pageToken === null) {
            $criteria->limit = $maxResults;
            $criteria->offset = 0;
        } else {
            $criteria->limit = $maxResults;
            $criteria->offset = $this->getController()->parsePageToken($pageToken);
        }

        if ($fromUpdateTime !== null) {
            $criteria->addCondition('"t"."UpdateTime" > :UpdateTime');
            $criteria->params['UpdateTime'] = $fromUpdateTime;
        }

        $criteria->with = [
            'Participants' => [
                'on' => '"Participants"."EventId" = :EventId',
                'params' => [
                    'EventId' => $this->getEvent()->Id,
                ],
                'together' => false,
            ],
            'Employments.Company' => ['on' => '"Employments"."Primary"', 'together' => false],
            'LinkPhones.Phone' => ['together' => false],
        ];
        $criteria->order = '"t"."LastName" ASC, "t"."FirstName" ASC';
        $criteria->addCondition('"t"."Id" IN ('.$command->getText().')');

        $users = User::model();

        if ($this->hasRequestParam('RunetId')) {
            $users->byRunetId($this->getRequestParam('RunetId'));
        }

        $users = $users->findAll($criteria);

        $result = [
            'Users' => [],
            'TotalCount' => $this->getTotalCount(),
            'NextUpdateTime' => $nextUpdateTime
        ];

        foreach ($users as $user) {
            $result['Users'][] = $this
                ->getDataBuilder()
                ->createUser($user);
        }

        if (count($users) === $maxResults) {
            $result['NextPageToken'] = $this->getController()->getPageToken($criteria->offset + $maxResults);
        }

        $this->setResult($result);
    }

    /**
     * @return mixed
     */
    private function getTotalCount()
    {
        $command = Yii::app()->getDb()->createCommand();
        $command->select('count("Id")');
        $command->from('EventParticipant');
        $command->andWhere('"EventId" = :EventId', [':EventId' => $this->getEvent()->Id]);

        if ($this->hasRequestParam('RoleId')) {
            $command->andWhere(['in', 'EventParticipant.RoleId', $this->getRequestParam('RoleId')]);
        }

        return $command->queryScalar();
    }
}
