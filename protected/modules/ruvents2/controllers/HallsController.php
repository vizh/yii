<?php
namespace ruvents2\controllers;

use application\components\helpers\ArrayHelper;
use event\models\section\Hall;
use event\models\section\UserVisit;
use ruvents2\components\Controller;
use ruvents2\components\data\CDbCriteria;
use ruvents2\components\Exception;
use user\models\User;

class HallsController extends Controller
{
    const MAX_LIMIT = 200;

    /**
     * Список отметок о посещение залов
     * @param int $id
     * @param int $since
     * @param int $limit
     * @throws \application\components\Exception
     */
    public function actionChecks($id, $since = null, $limit = null)
    {
        $limit = intval($limit);
        $limit = $limit > 0 ? min($limit, self::MAX_LIMIT) : self::MAX_LIMIT;
        $criteria = $this->getCheckCriteria($since, $limit);
        $result = [];

        $checks = UserVisit::model()->byEventId($this->getEvent()->Id)->byHallId($id)->with(['User'])->findAll($criteria);
        foreach ($checks as $check) {
            $result[] = $this->getCheckData($check);
        }

        $nextSince = count($checks) == $limit ? $checks[$limit - 1]->CreationTime : null;
        $hasMore = $nextSince !== null;
        $this->renderJson([
            'Checks' => $result,
            'HasMore' => $hasMore,
            'NextSince' => $nextSince
        ]);
    }

    /**
     * Выдача товара
     * @param int $id
     * @throws Exception
     * @throws \application\components\Exception
     */
    public function actionCheck($id)
    {
        $request = \Yii::app()->getRequest();
        $runetId = $request->getParam('UserId');
        $user = User::model()->byRunetId($runetId)->find();
        if ($user === null) {
            throw new Exception(Exception::INVALID_PARTICIPANT_ID, $runetId);
        }

        $time = $request->getParam('CheckTime');
        if ($time === null) {
            throw new Exception(Exception::INVALID_PARAM, ['CheckTime', $time]);
        }

        $hall = Hall::model()->byEventId($this->getEvent()->Id)->findByPk($id);
        if ($hall === null) {
            throw new Exception(Exception::INVALID_HALL_ID, $id);
        }

        $check = new UserVisit();
        $check->OperatorId = $this->getOperator()->Id;
        $check->UserId = $user->Id;
        $check->VisitTime = $time;
        $check->HallId = $hall->Id;
        $check->save();
        $check->refresh();
        $this->renderJson(['Id' => $check->Id, 'CreationTime' => $check->CreationTime]);
    }

    /**
     * @param string $since
     * @param int $limit
     * @return CDbCriteria
     */
    private function getCheckCriteria($since, $limit)
    {
        $criteria = CDbCriteria::create()
            ->setOrder('t."CreationTime"')
            ->setLimit($limit);

        if ($since !== null) {
            $since = date('Y-m-d H:i:s', strtotime($since));
            $criteria->addConditionWithParams('t."CreationTime" >= :CreationTime', ['CreationTime' => $since]);
        }

        return $criteria;
    }

    /**
     * @param UserVisit $check
     * @return array
     */
    private function getCheckData(UserVisit $check)
    {
        $data = ArrayHelper::toArray($check, [
            'event\models\section\UserVisit' => [
                'Id',
                'CheckTime' => 'VisitTime',
                'CreationTime'
            ]
        ]);
        $data['UserId'] = $check->User->RunetId;
        return $data;
    }
}