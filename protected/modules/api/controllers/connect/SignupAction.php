<?php
namespace api\controllers\connect;

use api\components\Exception;
use connect\models\forms\Signup;
use connect\models\Meeting;
use connect\models\MeetingLinkUser;
use user\models\User;

class SignupAction extends \api\components\Action
{
    public function run()
    {
        $runetId = \Yii::app()->getRequest()->getParam('RunetId', null);
        $user = User::model()->byRunetId($runetId)->find();
        if ($user === null) {
            throw new Exception(202, [$runetId]);
        }

        $meetingId = \Yii::app()->getRequest()->getParam('MeetingId', null);
        $meeting = Meeting::model()->findByPk($meetingId);
        if (!$meeting){
            throw new Exception(4001, [$meetingId]);
        }

        try{
            $form = new Signup();
            $form->UserId = $runetId;
            $form->MeetingId = $meetingId;
            $form->createActiveRecord();
            $this->setSuccessResult();
        }
        catch (\Exception $e){
            $this->setResult(['Success' => false, 'Error' => $e->getMessage()]);
        }
    }
}