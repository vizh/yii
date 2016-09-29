<?php
namespace api\controllers\connect;

use application\components\helpers\ArrayHelper;
use connect\models\Meeting;
use user\models\User;

class ListAction extends \api\components\Action
{
    public function run()
    {
        $meetings = Meeting::model()->with('UserLinks');

        $runetId = \Yii::app()->getRequest()->getParam('RunetId', null);
        $user = User::model()->byRunetId($runetId)->find();
        if ($user){
            $meetings->byCreator($user);
        }

        $type = \Yii::app()->getRequest()->getParam('Type', null);
        if ($type){
            $meetings->byType($type);
        }

        $meetings = $meetings->findAll();

        $result = [];
        foreach ($meetings as $meeting) {
            $result[] = $this->getAccount()->getDataBuilder()->createMeeting($meeting);
        }
        ArrayHelper::multisort($result, 'UserCount', SORT_DESC);
        $this->setResult(['Success' => true, 'Meetings' => $result]);
    }
}