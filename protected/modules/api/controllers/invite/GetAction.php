<?php
namespace api\controllers\invite;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;

class GetAction extends \api\components\Action
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
    $runetId = \Yii::app()->getRequest()->getParam('RunetId', null);
    $user = \user\models\User::model()->byRunetId($runetId)->find();
    if ($user == null)
      throw new \api\components\Exception(202, [$runetId]);

    $request = \event\models\InviteRequest::model()->byEventId($this->getEvent()->Id)->byOwnerUserId($user->Id)->find();
    if ($request == null)
      throw new \api\components\Exception(702, [$user->RunetId]);

    $result = $this->getDataBuilder()->createInviteRequest($request);
    return $this->setResult($result);
  }
} 