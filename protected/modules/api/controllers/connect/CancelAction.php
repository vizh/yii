<?php
namespace api\controllers\connect;

use api\components\Exception;
use connect\models\forms\CancelCreator;
use connect\models\forms\Response;
use connect\models\Meeting;
use connect\models\MeetingLinkUser;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response as ApiResponse;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Sample;

class CancelAction extends \api\components\Action
{
    /**
     * @ApiAction(
     *     controller="Connect",
     *     title="Отмена встречи",
     *     description="Отменяет встречу. Статус встречи меняется на 'отменена'",
     *     samples={
     *          @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}'
    '{{API_URL}}/connect/cancel?RunetId=678047&MeetingId=2817&Response=%D0%9F%D1%80%D0%B8%D1%87%D0%B8%D0%BD%D0%B0%20%D0%BE%D1%82%D0%BC%D0%B5%D0%BD%D1%8B'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/connect/cancel",
     *          body="",
     *          params={
     *              @Param(title="MeetingId", description="Айди встречи", mandatory="Y"),
     *              @Param(title="RunetId",   description="Runetid создателя встречи", mandatory="Y"),
     *              @Param(title="Response",  description="Причина отмены", mandatory="Y")
     *          },
     *          response=@ApiResponse(body="{'Success': true}")
     *      )
     * )
     */
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