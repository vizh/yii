<?php
namespace api\controllers\event;

use api\components\builders\Builder;

class UsersAction extends \api\components\Action
{
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $maxResults = (int)$request->getParam('MaxResults', $this->getMaxResults());
        $maxResults = min($maxResults, $this->getMaxResults());
        $pageToken = $request->getParam('PageToken', null);
        $roles = $request->getParam('RoleId');

        $command = \Yii::app()->getDb()->createCommand()
            ->select('EventParticipant.UserId')->from('EventParticipant')
            ->where('"EventParticipant"."EventId" = '.$this->getEvent()->Id);
        if (!empty($roles)) {
            $command->andWhere(['in', 'EventParticipant.RoleId', $roles]);
        }

        $criteria = new \CDbCriteria();
        if ($pageToken === null) {
            $criteria->limit = $maxResults;
            $criteria->offset = 0;
        } else {
            $criteria->limit = $maxResults;
            $criteria->offset = $this->getController()->parsePageToken($pageToken);
        }

        $criteria->with = [
            'Participants' => [
                'on' => '"Participants"."EventId" = :EventId',
                'params' => [
                    'EventId' => $this->getEvent()->Id
                ],
                'together' => false
            ],
            'Employments.Company' => ['on' => '"Employments"."Primary"', 'together' => false],
            'LinkPhones.Phone' => ['together' => false]
        ];
        $criteria->order = '"t"."LastName" ASC, "t"."FirstName" ASC';

        $criteria->addCondition('"t"."Id" IN ('.$command->getText().')');

        $users = \user\models\User::model()->findAll($criteria);
        $totalCount = \user\models\User::model()->count($criteria);

        $result = [];
        $result['Users'] = [];

        // Определим какие данные будут в результате
        $builders = [
            Builder::USER_EVENT,
            Builder::USER_EMPLOYMENT,
            Builder::USER_ATTRIBUTES
        ];

        // Не совсем понятно почему, но ок..
        if ($this->getAccount()->Role !== 'mobile')
            $builders[] = Builder::USER_CONTACTS;

        $result['TotalCount'] = $totalCount;

        foreach ($users as $user) {
            $result['Users'][] = $this
                ->getDataBuilder()
                ->createUser($user, $builders);
        }

        if (count($users) === $maxResults) {
            $result['NextPageToken'] = $this->getController()->getPageToken($criteria->offset + $maxResults);
        }

        $this->setResult($result);
    }
}