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
        $user = $this->getRequestedUser();
        $meetingId = $this->getRequestParam('MeetingId', null);

        $meeting = Meeting::model()->findByPk($meetingId);
        if (!$meeting){
            throw new Exception(4001, [$meetingId]);
        }

        try{
            $form = new Signup();
            $form->UserId = $user->RunetId;
            $form->MeetingId = $meetingId;
            $form->createActiveRecord();
            $this->setSuccessResult();
        }
        catch (\Exception $e){
            $this->setResult(['Success' => false, 'Error' => $e->getMessage()]);
        }
    }
}