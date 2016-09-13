<?php
namespace api\controllers\connect;

use api\components\Exception;
use connect\models\forms\Response;
use connect\models\Meeting;

class AcceptAction extends \api\components\Action
{
    public function run()
    {
        $runetId = \Yii::app()->getRequest()->getParam('RunetId', null);
        $user = \user\models\User::model()->byRunetId($runetId)->find();
        if ($user === null) {
            throw new Exception(202, [$runetId]);
        }

        $meetingId = \Yii::app()->getRequest()->getParam('MeetingId', null);
        $meeting = Meeting::model()->byUser($user)->findByPk($meetingId);
        if (!$meeting){
            throw new Exception(4001, [$meetingId]);
        }

        try{
            $form = new Response($meeting);
            $form->Status = Meeting::STATUS_ACCEPTED;
            $form->updateActiveRecord();
            $this->setSuccessResult();
        }
        catch (\Exception $e){
            $this->setResult(['success' => false]);
        }
    }
}