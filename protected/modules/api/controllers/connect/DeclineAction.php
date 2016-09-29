<?php
namespace api\controllers\connect;

use api\components\Exception;
use connect\models\forms\Response;
use connect\models\MeetingLinkUser;
use user\models\User;

class DeclineAction extends \api\components\Action
{
    public function run()
    {
        $runetId = \Yii::app()->getRequest()->getParam('RunetId', null);
        $user = User::model()->byRunetId($runetId)->find();
        if ($user === null) {
            throw new Exception(202, [$runetId]);
        }

        $meetingId = \Yii::app()->getRequest()->getParam('MeetingId', null);
        $link = MeetingLinkUser::model()->byUser($user)->findByAttributes(['MeetingId' => $meetingId]);
        if (!$link){
            throw new Exception(4001, [$meetingId]);
        }

        try{
            $form = new Response($link);
            $form->Status = MeetingLinkUser::STATUS_DECLINED;
            $form->Response = \Yii::app()->getRequest()->getParam('Response', null);
            $form->updateActiveRecord();
            $this->setSuccessResult();
        }
        catch (\Exception $e){
            $this->setResult(['Success' => false]);
        }
    }
}