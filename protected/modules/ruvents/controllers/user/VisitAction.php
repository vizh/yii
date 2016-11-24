<?php
namespace ruvents\controllers\user;

use ruvents\components\Action;
use ruvents\components\Exception;
use ruvents\models\Visit;
use user\models\User;

/**
 * Class VisitAction
 * @package ruvents\controllers\user
 *
 */
class VisitAction extends Action
{
    /**
     * Отметка пользователя о посещении зоны мониторинга меропрития
     * @throws Exception
     */
    public function run()
    {
        $request = \Yii::app()->getRequest();

        $id = $request->getParam('RunetId', null);
        $mark = $request->getParam('MarkId', null);
        $date = $request->getParam('Date', date('Y-m-d H:i:s'));

        if (empty($id)) {
            throw new Exception(900, 'RunetId');
        }

        if (empty($mark)) {
            throw new Exception(900, 'MarkId');
        }

        $user = User::model()
            ->byRunetId($id)
            ->find();

        if ($user === null) {
            throw new Exception(202, $id);
        }

        Visit::insertOne([
            'UserId' => $user->Id,
            'EventId' => $this->getEvent()->Id,
            'MarkId' => $mark,
            'CreationTime' => $date
        ]);

        echo json_encode(['Success' => true]);
    }
}
