<?php

namespace api\controllers\invite;

use api\components\Action;
use api\components\Exception;
use event\models\InviteRequest;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\ApiAction;
use user\models\User;
use Yii;

class GetAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Invite",
     *     title="Запросы на участие",
     *     description="Вернет запросы на участие в мероприятии пользователя с заданным RunetId",
     *     request=@Request(
     *          method="GET",
     *          url="/invite/get",
     *          params={
     *               @Param(title="RunetId", mandatory="Y", description="RunetId пользователя")
     *          },
     *          response=@Response(body="{
    'Sender': '{$USER}',
    'Owner': '{$USER}',
    'CreationTime': '2017-02-14 14:12:27',
    'Event': '{$EVENT}',
    'Approved': 0
    }")
     *     )
     * )
     */
    public function run()
    {
        $runetId = Yii::app()->getRequest()->getParam('RunetId', null);
        $user = User::model()->byRunetId($runetId)->find();
        if ($user == null) {
            throw new Exception(202, [$runetId]);
        }

        $request = InviteRequest::model()->byEventId($this->getEvent()->Id)->byOwnerUserId($user->Id)
            ->find();
        if ($request == null) {
            throw new Exception(702, [$user->RunetId]);
        }

        $result = $this->getDataBuilder()->createInviteRequest($request);

        return $this->setResult($result);
    }
}
