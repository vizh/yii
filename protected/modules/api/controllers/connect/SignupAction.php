<?php

namespace api\controllers\connect;

use api\components\Action;
use api\components\Exception;
use connect\models\forms\Signup;
use connect\models\Meeting;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;
use nastradamus39\slate\annotations\ApiAction;

class SignupAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Connect",
     *     title="Присоединиться к встрече",
     *     description="Присоединиться к встрече.",
     *     samples={
     *          @Sample(lang="shell", code="curl -X GET -H 'ApiKey: {{API_KEY}}' -H 'Hash: {{HASH}}'
    '{{API_URL}}/connect/signup?RunetId=678047&MeetingId=2817'")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/connect/signup",
     *          body="",
     *          params={
     *              @Param(title="RunetId", description="Runetid пользователя.", mandatory="Y"),
     *              @Param(title="MeetingId", description="Id встречи.", mandatory="Y")
     *          },
     *          response=@Response(body="{'Success': true}")
     *      )
     * )
     */
    public function run()
    {
        $user = $this->getRequestedUser();
        $meetingId = $this->getRequestParam('MeetingId', null);

        $meeting = Meeting::model()->findByPk($meetingId);
        if (!$meeting) {
            throw new Exception(4001, [$meetingId]);
        }

        try {
            $form = new Signup();
            $form->UserId = $user->RunetId;
            $form->MeetingId = $meetingId;
            $form->createActiveRecord();
            $this->setSuccessResult();
        } catch (\Exception $e) {
            $this->setResult(['Success' => false, 'Error' => $e->getMessage()]);
        }
    }
}
