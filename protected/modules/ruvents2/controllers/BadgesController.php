<?php
namespace ruvents2\controllers;

use application\components\helpers\ArrayHelper;
use event\models\Part;
use event\models\Participant;
use ruvents2\components\Controller;
use ruvents2\components\data\CDbCriteria;
use ruvents2\components\Exception;
use ruvents2\models\Badge;
use user\models\User;

class BadgesController extends Controller
{
    const MAX_LIMIT = 500;

    public function actionList($since = null, $limit = null)
    {
        $limit = intval($limit);
        $limit = $limit > 0 ? min($limit, self::MAX_LIMIT) : self::MAX_LIMIT;
        $criteria = $this->getCriteria($since, $limit);
        $badges = Badge::model()->byEventId($this->getEvent()->Id)->findAll($criteria);
        $result = [];
        foreach ($badges as $badge) {
            $result[] = ArrayHelper::toArray($badge, [
                'ruvents2\models\Badge' => [
                    'Id',
                    'PartId',
                    'RoleId',
                    'OperatorId',
                    'CreationTime',
                    'UserId' => function ($badge) {
                        /** @var Badge $badge */
                        return $badge->User->RunetId;
                    }
                ]
            ]);
        }

        $nextSince = count($badges) == $limit ? $badges[$limit - 1]->CreationTime : null;
        $hasMore = $nextSince !== null;
        $this->renderJson([
            'Badges' => $result,
            'HasMore' => $hasMore,
            'NextSince' => $nextSince
        ]);
    }

    /**
     * @param string $since
     * @param int $limit
     * @return CDbCriteria
     */
    private function getCriteria($since, $limit)
    {
        $criteria = CDbCriteria::create()
            ->setOrder('t."CreationTime" ASC')
            ->setLimit($limit)
            ->setWith(['User']);

        if ($since !== null) {
            $since = date('Y-m-d H:i:s', strtotime($since));
            $criteria->addConditionWithParams('t."CreationTime" >= :CreationTime', ['CreationTime' => $since]);
        }

        return $criteria;
    }

    public function actionCreate()
    {
        $request = \Yii::app()->getRequest();
        $runetId = $request->getParam('UserId');
        $user = User::model()->byRunetId($runetId)->byEventId($this->getEvent()->Id)->find();
        if ($user === null) {
            throw new Exception(Exception::INVALID_PARTICIPANT_ID, $runetId);
        }

        $part = null;
        $participant = null;
        if (count($this->getEvent()->Parts) > 0) {
            $partId = $request->getParam('PartId');
            $part = $partId !== null ? Part::model()->findByPk($partId) : null;
            if ($partId !== null && ($part == null || $part->EventId != $this->getEvent()->Id)) {
                throw Exception::createInvalidParam('PartId', 'Не найдена часть с ID: '.$partId);
            }
            if ($part !== null) {
                $participant = Participant::model()
                    ->byEventId($this->getEvent()->Id)
                    ->byUserId($user->Id)
                    ->byPartId($part->Id)
                    ->find(
                        CDbCriteria::create()
                            ->setWith(['Role' => ['together' => true]])
                            ->setOrder('"Role"."Priority" DESC')
                    );

                if ($participant == null) {
                    throw new Exception(Exception::INVALID_PART_ID_FOR_BADGE, [$runetId, $partId]);
                }
            }
        } else {
            $participant = $user->Participants[0];
        }

        $badge = new Badge();
        $badge->OperatorId = $this->getOperator()->Id;
        $badge->EventId = $this->getEvent()->Id;
        $badge->UserId = $user->Id;
        $badge->RoleId = $participant->RoleId;
        $badge->PartId = $part !== null ? $part->Id : null;
        $badge->save();

        $this->renderJson(['Id' => $badge->Id]);
    }
}