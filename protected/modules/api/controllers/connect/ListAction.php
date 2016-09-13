<?php
namespace api\controllers\connect;

use api\components\Exception;
use connect\models\forms\Meeting;

class ListAction extends \api\components\Action
{
    public function run()
    {
        $runetId = \Yii::app()->getRequest()->getParam('RunetId', null);
        $user = \user\models\User::model()->byRunetId($runetId)->find();
        if ($user === null) {
            throw new Exception(202, [$runetId]);
        }

        $meetings = Meeting::model()->byCreator($user)->findAll();

        $result = [];
        foreach ($meetings as $meeting) {
            $result[] = $this->getAccount()->getDataBuilder()->createMeeting($meeting);
        }
        $this->setResult($result);
    }
}