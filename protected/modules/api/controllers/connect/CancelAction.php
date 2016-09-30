<?php
namespace api\controllers\connect;

use api\components\Exception;
use connect\models\forms\CancelCreator;
use connect\models\forms\Response;
use connect\models\Meeting;
use connect\models\MeetingLinkUser;

class CancelAction extends \api\components\Action
{
    public function run()
    {
        $user = $this->getRequestedUser();
        $meetingId = $this->getRequestParam('MeetingId', null);

        $meeting = Meeting::model()->byCreatorId($user->Id)->findByPk($meetingId);
        if ($meeting){
            try{
                $form = new CancelCreator($meeting);
                $form->Status = Meeting::STATUS_CANCELLED;
                $form->Response = \Yii::app()->getRequest()->getParam('Response', null);
                $form->updateActiveRecord();
                $this->setSuccessResult();
            }
            catch (\Exception $e){
                $this->setResult(['Success' => false, 'Error' => $e]);
            }
            return;
        }

        $meeting = Meeting::model()->byUserId($user->Id)->findByPk($meetingId);
        if ($meeting){
            try{
                $form = new Response($meeting->UserLinks[0]);
                $form->Status = MeetingLinkUser::STATUS_CANCELLED;
                $form->Response = \Yii::app()->getRequest()->getParam('Response', null);
                $form->updateActiveRecord();
                $this->setSuccessResult();
            }
            catch (\Exception $e){
                $this->setResult(['Success' => false, 'Error' => $e]);
            }
            return;
        }

        if (!$meeting){
            throw new Exception(4001, [$meeting]);
        }
    }
}