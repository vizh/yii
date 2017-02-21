<?php
namespace api\controllers\connect;

use api\components\Exception;
use connect\models\forms\Response;
use connect\models\MeetingLinkUser;
use user\models\User;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response as ApiResponse;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Sample;

class DeclineAction extends \api\components\Action
{

    /**
     * @ApiAction(
     *     controller="Connect",
     *     title="Отклонение приглашения",
     *     description="Отклоняет приглашение.",
     *     samples={
     *          @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}'
    '{{API_URL}}/connect/decline?RunetId=678047&MeetingId=2817'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/connect/decline",
     *          params={
     *              @Param(title="RunetId",     description="Пользователь", mandatory="Y"),
     *              @Param(title="MeetingId",   description="Id встречи", mandatory="Y")
     *          },
     *          response=@ApiResponse(body="{'Success': true}")
     *      )
     * )
     */
    public function run()
    {
        $user = $this->getRequestedUser();
        $meetingId = $this->getRequestParam('MeetingId', null);

        $link = MeetingLinkUser::model()
            ->byUserId($user->Id)
            ->findByAttributes(['MeetingId' => $meetingId]);
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
            $this->setResult(['Success' => false, 'Error' => $e->getMessage()]);
        }
    }
}