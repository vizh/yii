<?php
namespace api\controllers\invite;

use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\ApiAction;

class RequestAction extends \api\components\Action
{
    /**
     * @ApiAction(
     *     controller="Invite",
     *     title="Создание приглашения",
     *     description="Создает приглашение на участие в мероприятии пользователя RunetId",
     *     request=@Request(
     *          method="GET",
     *          url="/invite/request",
     *          params={
     *               @Param(title="RunetId", mandatory="Y", description="RunetId пользователя")
     *          },
     *          response=@Response(body="{'Success':true}")
     *     )
     * )
     */
    public function run()
    {
        $runetId = \Yii::app()->getRequest()->getParam('RunetId', null);
        $user = \user\models\User::model()->byRunetId($runetId)->find();
        if ($user == null) {
            throw new \api\components\Exception(202, [$runetId]);
        }

        $request = \event\models\InviteRequest::model()->byEventId($this->getEvent()->Id)->byOwnerUserId($user->Id)->find();
        if ($request !== null) {
            throw new \api\components\Exception(701, [$user->RunetId]);
        }

        $request = new \event\models\InviteRequest();
        $request->SenderUserId = $request->OwnerUserId = $user->Id;
        $request->EventId = $this->getEvent()->Id;
        $request->save();
        $this->setSuccessResult();
    }
}