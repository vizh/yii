<?php
namespace ruvents2\controllers\participants;

use application\components\helpers\ArrayHelper;
use event\models\Participant;
use ruvents2\components\Action;
use user\models\User;

class ListAction extends Action
{
    const MAX_LIMIT = 500;

    public function run($since = null, $limit = null)
    {
        $limit = intval($limit);
        $limit = $limit > 0 ? min($limit, self::MAX_LIMIT) : self::MAX_LIMIT;
        $criteria = $this->getCriteria($since, $limit);

        if ($since == null)
            $since = date('Y-m-d H:i:s');

        $users = User::model()->byEventId($this->getEvent()->Id)->findAll($criteria);
        $result = [];
        foreach ($users as $user) {
            $result[] = $this->getData($user);
        }

        if (($hasMore = count($users) == $limit))
            $since = $users[$limit-1]->UpdateTime;

        $this->renderJson([
            'Participants' => $result,
            'HasMore' => $hasMore,
            'NextSince' => $since
        ]);
    }

    /**
     * @param string $since
     * @param int $limit
     * @return \CDbCriteria
     */
    private function getCriteria($since, $limit)
    {
        $criteria = new \CDbCriteria();
        $criteria->with = [
            'Employments' => ['together' => false],
            'Employments.Company' => ['together' => false],
            'LinkPhones.Phone' => ['together' => false],
            'Badges' => [
                'together' => false,
                'on' => '"Badges"."EventId" = :EventId',
                'params' => ['EventId' => $this->getEvent()->Id]
            ]
        ];
        $criteria->order = 't."UpdateTime"';
        $criteria->limit = $limit;

        if ($since !== null) {
            $since = date('Y-m-d H:i:s', strtotime($since));
            $criteria->addCondition('t."UpdateTime" >= :UpdateTime');
            $criteria->params = ['UpdateTime' => $since];
        }
        return $criteria;
    }

    /**
     * @param User $user
     * @return array
     */
    private function getData($user)
    {
        $data = ArrayHelper::toArray($user, ['user\models\User' => ['Id' => 'RunetId', 'UpdateTime', 'Email']]);

        $employment = $user->getEmploymentPrimary();
        if ($employment !== null) {
            $data['Position'] = $employment->Position;
        }

        foreach (\Yii::app()->params['Languages'] as $lang) {
            $user->setLocale($lang);
            $localeData = ArrayHelper::toArray($user, ['user\models\User' => ['LastName', 'FirstName', 'FatherName']]);
            if ($employment !== null) {
                $employment->Company->setLocale($lang);
                $localeData['Company'] = $employment->Company->Name;
            }
            $data['Locales'][$lang] = $localeData;
        }

        if (!empty($user->PrimaryPhone)) {
            $data['Phone'] = $user->PrimaryPhone;
        } elseif ($user->getContactPhone() !== null) {
            $data['Phone'] = $user->getContactPhone()->__toString();
        }
        $data['Photo'] = 'http://' . RUNETID_HOST . $user->getPhoto()->get200px();

        $statuses = [];
        foreach ($user->Participants as $participant) {
            $statuses[] = [
                'StatusId' => $participant->RoleId,
                'PartId' => $participant->PartId
            ];
        }
        $data['Statuses'] = $statuses;

        $badges = [];
        foreach ($user->Badges as $badge) {
            $badges[] = ArrayHelper::toArray($badge, ['ruvents2\models\Badge' => ['PartId', 'RoleId', 'OperatorId', 'CreationTime']]);
        }
        $data['Badges'] = $badges;

        return $data;
    }
}