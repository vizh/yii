<?php
namespace ruvents\controllers\event;

use user\models\User;

/**
 * @deprecated
 */
class UsersAction extends \ruvents\components\Action
{
    public function run()
    {
        ini_set("memory_limit", "512M");

        $request = \Yii::app()->getRequest();
        $query = $request->getParam('Query', null);
        $pageToken = $request->getParam('PageToken', null);
        $updateTime = $request->getParam('FromUpdateTime', null);

        $model = User::model();
        if (mb_strlen($query, 'utf8') != 0) {
            $model->bySearch($query);
        }

        $criteria = new \CDbCriteria();
        $criteria->select = '"t"."Id"';

        $criteria->addCondition('"Participants"."EventId" = :EventId');
        $criteria->params['EventId'] = $this->getEvent()->Id;

        $offset = 0;
        if ($pageToken !== null) {
            $offset = $this->getController()->parsePageToken($pageToken);
        }
        $criteria->limit = \Yii::app()->params['RuventsMaxResults'];
        $criteria->offset = $offset;

        if ($updateTime === null) {
            $criteria->order = '"t"."Id" ASC';
        } else {
            $criteria->addCondition('"Participants"."UpdateTime" > :UpdateTime');
            $criteria->params['UpdateTime'] = $updateTime;
            $criteria->order = '"t"."Id" ASC';
        }

        $criteria->group = '"t"."Id"';
        //$criteria->distinct = true;

        $criteria->with = [
            'Participants' => ['together' => true, 'select' => false],
            'Settings' => ['together' => true, 'select' => false],
        ];

        $users = $model->findAll($criteria);
        $idList = [];
        foreach ($users as $user) {
            $idList[] = $user->Id;
        }

        $criteria = new \CDbCriteria();
        $criteria->addInCondition('"t"."Id"', $idList);
        $criteria->with = [
            'Employments.Company' => ['on' => 'Employments.Primary'],
            'Participants' => ['on' => '"Participants"."EventId" = :EventId', 'params' => [':EventId' => $this->getEvent()->Id]],
            'Participants.Role',
            'LinkPhones.Phone'
        ];

        $users = User::model()->findAll($criteria);
        /** @var $badges \ruvents\models\Badge[] */
        $badges = \ruvents\models\Badge::model()->byEventId($this->getEvent()->Id)->findAll();
        $badgesCount = [];
        foreach ($badges as $badge) {
            if (!isset($badgesCount[$badge->UserId])) {
                $badgesCount[$badge->UserId] = 0;
            }
            $badgesCount[$badge->UserId]++;
        }

        $result = ['Users' => []];
        foreach ($users as $user) {
            $this->getDataBuilder()->createUser($user);
            $this->getDataBuilder()->buildUserEmployment($user);
            $this->getDataBuilder()->buildUserPhone($user);
            $this->getDataBuilder()->buildUserData($user);
            $buildUser = $this->getDataBuilder()->buildUserEvent($user);
            $buildUser->BadgeCount = isset($badgesCount[$user->Id]) ? $badgesCount[$user->Id] : 0;

            $result['Users'][] = $buildUser;
        }

        if (count($users) == \Yii::app()->params['RuventsMaxResults']) {
            $result['NextPageToken'] = $this->getController()->getPageToken($offset + \Yii::app()->params['RuventsMaxResults']);
        }

        $this->renderJson($result);
    }
}
